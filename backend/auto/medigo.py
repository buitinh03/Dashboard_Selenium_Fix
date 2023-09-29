import sys
import logging

from selenium.common.exceptions import WebDriverException, NoSuchElementException, TimeoutException
from selenium import webdriver
import chromedriver_autoinstaller
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import psycopg2
import datetime
from dotenv import load_dotenv
import os
import time
from bs4 import BeautifulSoup

import codecs

load_dotenv()

if sys.stdout.encoding != 'utf-8':
    sys.stdout = codecs.getwriter('utf-8')(sys.stdout.buffer, 'strict')
    sys.stderr = codecs.getwriter('utf-8')(sys.stderr.buffer, 'strict')

# Thiết lập hệ thống ghi log
log_directory = os.getenv('LOG_DIRECTORY')

log_filename = os.path.join(log_directory, 'scraping_log.log')

# Tạo thư mục chứa tệp log nếu nó không tồn tại
os.makedirs(os.path.dirname(log_filename), exist_ok=True)

# Tạo một đối tượng FileHandler để ghi log vào tệp
file_handler = logging.FileHandler(log_filename, mode="w", encoding=None, delay=False)

# Thiết lập hệ thống ghi log
logging.basicConfig(filename=log_filename, level=logging.INFO)

# Khởi tạo trình duyệt Chrome
chromedriver_autoinstaller.install()
chrome_options = webdriver.ChromeOptions()
# chrome_options.add_argument("--headless")
chrome_options.add_argument("--window-size=1920x1080")
driver = webdriver.Chrome(options=chrome_options)

# URL của trang web
base_url = "https://www.medigoapp.com/danh-muc/san-pham"

try:
    # Kết nối đến cơ sở dữ liệu PostgreSQL
    connection = psycopg2.connect(
        host=os.getenv("DB_HOST"),
        database=os.getenv("DB_NAME"),
        user=os.getenv("DB_USER"),
        password=os.getenv("DB_PASSWORD")
    )

    with connection.cursor() as cursor:
        cursor.execute('''
            CREATE TABLE IF NOT EXISTS thuocsi_vn (
                title TEXT,
                giacu TEXT,
                ngaycu DATE,
                giamoi TEXT,
                ngaymoi DATE,
                month_1 TEXT,
                month_2 TEXT,
                month_3 TEXT,
                month_4 TEXT,
                month_5 TEXT,
                month_6 TEXT,
                month_7 TEXT,
                month_8 TEXT,
                month_9 TEXT,
                month_10 TEXT,
                month_11 TEXT,
                month_12 TEXT,
                photo TEXT,
                nha_san_xuat TEXT,
                nuoc_san_xuat TEXT,
                hamluong_thanhphan TEXT,
                thong_tin_san_pham TEXT,
                link TEXT PRIMARY KEY,
                nguon TEXT DEFAULT ''
            )
        ''')
        wait = WebDriverWait(driver, 1)

    # Mở trang web
    driver.get(base_url)
    logging.info(f"Đăng nhập thành công MEDIGOAPP")
    num_pages_to_scrape = 1000
    all_product_links = []

    for page_num in range(1, num_pages_to_scrape + 1):
        url = f"{base_url}?page={page_num}"
        try:
            driver.get(url)
            html = driver.page_source
            soup = BeautifulSoup(html, 'html.parser')
            search_info_div = soup.find("h6", class_="mb-4")
            if search_info_div and "Không tìm thấy sản phẩm" in search_info_div.get_text():
                break
        except WebDriverException as e:
            pass

        link_elements = driver.find_elements(By.CSS_SELECTOR, ".grid-products:nth-child(2) .custom-link")
        links = [link.get_attribute('href') for link in link_elements]

        all_product_links.extend(links)
    
    def extract_product_info():
        product_name_element = wait.until(
            EC.presence_of_element_located((By.CSS_SELECTOR, "h1.product-name")))
        product_name = product_name_element.text
        return product_name

    def check_product_exist(cursor, product_name):
        cursor.execute("SELECT EXISTS(SELECT 1 FROM thuocsi_vn WHERE title = %s)", (product_name,))
        return cursor.fetchone()[0]

    for a in all_product_links:
        driver.get(a)

        try:
            button_element = driver.find_element(By.CSS_SELECTOR, "button.ml-2:nth-child(1)")
            button_element.click()
            time.sleep(1)
        except NoSuchElementException:
            pass

        try:
            button_xemthem = WebDriverWait(driver, 10).until(
                EC.element_to_be_clickable((By.CSS_SELECTOR, ".cursor-pointer > strong"))
            )
            driver.execute_script("arguments[0].click();", button_xemthem)
            time.sleep(0.5)

            product_name = ""

            try:
                html = driver.page_source
                product_name = extract_product_info()
            except NoSuchElementException:
                pass

            ten = driver.find_element(By.CSS_SELECTOR, "h1.product-name").text
            try:
                gia_sales_element = driver.find_element(By.CSS_SELECTOR, ".price > span")
                gia_sales_text = gia_sales_element.text.replace("đ", "").replace(".", "").replace(" ", "")
            except NoSuchElementException:
                try:
                    gia_sales_element_alt = driver.find_element(By.CSS_SELECTOR, "div.txt-pink:nth-child(2)")
                    gia_sales_text = gia_sales_element_alt.text.replace("đ", "").replace(".", "").replace(" ", "")
                except NoSuchElementException:
                    gia_sales_text = ""

            if gia_sales_text.isdigit():
                gia_sales = int(gia_sales_text)
            else:
                gia_sales = 0

            try:
                thong_tin_san_pham_element = driver.find_element(By.CSS_SELECTOR, "p:nth-child(4) > .html-in-cms > div")
                thong_tin_san_pham = thong_tin_san_pham_element.text
            except NoSuchElementException:
                thong_tin_san_pham = "Không đề cập"

            try:
                hamluong_thanhphan_element = driver.find_element(By.CSS_SELECTOR, "p:nth-child(2) > .html-in-cms > div")
                hamluong_thanhphan = hamluong_thanhphan_element.text
            except NoSuchElementException:
                hamluong_thanhphan = "Không đề cập"

            try:
                nha_san_xuat_element = driver.find_element(By.CSS_SELECTOR, "tr.mb-2:nth-child(5)")
                if "Thương hiệu:" in nha_san_xuat_element.text:
                    nha_san_xuat = nha_san_xuat_element.text.replace("Thương hiệu:", "").strip()
                else:
                    raise NoSuchElementException("Không tìm thấy 'Thương hiệu:' trong tr.mb-2:nth-child(5)")
            except NoSuchElementException:
                nha_san_xuat = "Không đề cập"

            try:
                nuoc_san_xuat_element = driver.find_element(By.CSS_SELECTOR, "tr.mb-2:nth-child(7)")
                if "Nước sản xuất:" in nuoc_san_xuat_element.text:
                    nuoc_san_xuat = nuoc_san_xuat_element.text.replace("Nước sản xuất:", "").strip()
                else:
                    raise NoSuchElementException("Không tìm thấy 'Nước sản xuất:' trong tr.mb-2:nth-child(7)")
            except NoSuchElementException:
                try:
                    nuoc_san_xuat_alt_element = driver.find_element(By.CSS_SELECTOR, "tbody > .d-flex:nth-child(4)")
                    if "Nước sản xuất:" in nuoc_san_xuat_alt_element.text:
                        nuoc_san_xuat = nuoc_san_xuat_alt_element.text.replace("Nước sản xuất:", "").strip()
                    else:
                        raise NoSuchElementException(
                            "Không tìm thấy 'Nước sản xuất:' trong tbody > .d-flex:nth-child(4)")
                except NoSuchElementException:
                    nuoc_san_xuat = "Không đề cập"

            photo = driver.find_element(By.CSS_SELECTOR,
                                        ".col-5 .custom-image-magnifiers > .img-fluid").get_attribute(
                "src")

            ngay = datetime.datetime.now().date()
            current_month = datetime.datetime.now().month

            with connection.cursor() as cursor:
                cursor.execute(f'''
                    INSERT INTO thuocsi_vn (title, giamoi, ngaymoi, month_{current_month}, photo, nha_san_xuat,
                    nuoc_san_xuat, hamluong_thanhphan, thong_tin_san_pham, link, nguon, giacu, ngaycu)
                    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, NULL, NULL)
                    ON CONFLICT (link) DO UPDATE
                        SET month_{current_month} = excluded.month_{current_month},
                        thong_tin_san_pham = excluded.thong_tin_san_pham,
                        nha_san_xuat = excluded.nha_san_xuat,
                        title = excluded.title,
                        nuoc_san_xuat = excluded.nuoc_san_xuat,
                        hamluong_thanhphan = excluded.hamluong_thanhphan,
                        photo = excluded.photo,
                        giacu = thuocsi_vn.giamoi,
                        ngaycu = thuocsi_vn.ngaymoi,
                        giamoi='{gia_sales}',
                        ngaymoi='{ngay}';
                ''', (
                    product_name, gia_sales, ngay, gia_sales, photo, nha_san_xuat, nuoc_san_xuat, hamluong_thanhphan,
                    thong_tin_san_pham, a, 'medigoapp.com'))
                connection.commit()

        except Exception as e:
            logging.error(f"Error scraping product: {str(e)}")

except Exception as e:
    logging.error(f"Unhandled Exception: {str(e)}")
