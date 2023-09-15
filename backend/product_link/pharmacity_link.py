from selenium.common.exceptions import NoSuchElementException, TimeoutException
from selenium import webdriver
import chromedriver_autoinstaller
from selenium.webdriver.common.by import By
import psycopg2
import datetime
from dotenv import load_dotenv
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import os
import re
import sys
import codecs
from bs4 import BeautifulSoup
import logging

if sys.stdout.encoding != 'utf-8':
    sys.stdout = codecs.getwriter('utf-8')(sys.stdout.buffer, 'strict')
    sys.stderr = codecs.getwriter('utf-8')(sys.stderr.buffer, 'strict')

logging.basicConfig(filename='scraping_log.log', level=logging.INFO)

chromedriver_autoinstaller.install()
chrome_options = webdriver.ChromeOptions()
chrome_options.add_argument("--headless")
chrome_options.add_argument("--window-size=5120x2880")
driver = webdriver.Chrome(options=chrome_options)
url = "https://www.pharmacity.vn/"
load_dotenv()

try:
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
                link TEXT primary key,
                nguon TEXT DEFAULT 'pharmacity.vn'
            )
        ''')

        wait = WebDriverWait(driver, 1)


    def extract_product_info():
        product_name_element = wait.until(
            EC.presence_of_element_located((By.CSS_SELECTOR, ".ProductContent_product-title__Li_7c")))
        product_name = product_name_element.text
        return product_name

    def check_product_exist(cursor, ten):
        cursor.execute("SELECT EXISTS(SELECT 1 FROM thuocsi_vn WHERE title = %s)", (ten,))
        return cursor.fetchone()[0]
    # link = ['https://www.pharmacity.vn/acegoi-3g-30-goi.html']
    link = sys.argv[1:]
    for a in link:

        driver.get(a)
        try:
            product_name = ""
            nsx = 'Không đề cập'
            nuoc_san_xuat = 'Không đề cập'
            tt = 'Không đề cập'
            nha_san_xuat = "Không đề cập"
            tp_element = "Không đề cập"

            try:
                html = driver.page_source
                product_name = extract_product_info()
            except NoSuchElementException:
                pass

            html = driver.page_source
            soup = BeautifulSoup(html, 'html.parser')

            WebDriverWait(driver, 10).until(
                EC.presence_of_element_located((By.CSS_SELECTOR, ".ProductContent_product-title__Li_7c"))
            )
            try:
                ten = driver.find_element(By.CSS_SELECTOR, ".ProductContent_product-title__Li_7c").text
            except NoSuchElementException:
                ten = 'Không đề cập'
            try:
                gia = driver.find_element(By.CSS_SELECTOR, ".ProductPrice_price__tztxw").text
                gia = gia.replace('.', '').replace('đ', '')
            except NoSuchElementException:
                gia = '0'

            try:
                tt_element = WebDriverWait(driver, 10).until(
                    EC.presence_of_element_located((By.CSS_SELECTOR, ".ProductContent_description__tGOQ1"))
                )
                tt = tt_element.text
                first_paragraph = driver.find_element(By.CSS_SELECTOR,
                                                        ".ProductContent_description__tGOQ1 > p:nth-child(1)").text
                tt = tt.replace(first_paragraph, '').strip()
            except NoSuchElementException:
                tt = 'Không đề cập'

            if tt is None or tt.strip() == "":
                tt = "Không đề cập"


            try:
                tp_element = driver.find_element(By.CSS_SELECTOR,
                                                    ".ProductContent_description__tGOQ1 > p:nth-child(1)")
                tp_element = tp_element.text.replace('Hoạt chất', '').replace('Hoạt tính', '')

            except NoSuchElementException:
                tp_element = 'Không đề cập'

            if tp_element == '':
                tp_element = 'Không đề cập'

            if tt == 'Không đề cập':
                tt = tp_element
                tp_element = 'Không đề cập'

            if tp_element == 'Không đề cập' and tt == '':
                tt = tp_element

            try:
                img_element = driver.find_element(By.CSS_SELECTOR, "img.ProductThumbnailCarousel_product-img__YsmdM")
                img_url = img_element.get_attribute("src")
            except NoSuchElementException:
                img_url = 'Không đề cập'

            try:
                nsx_selector = '.ProductContent_description__tGOQ1 > p'
                nsx_elements = driver.find_elements(By.CSS_SELECTOR, nsx_selector)

                for element in nsx_elements:
                    if "Nơi sản xuất:" in element.text:
                        nsx = element.text.split('Nơi sản xuất:')[1].strip()
                        match = re.search(r'\((.*?)\)', nsx)
                        if match:
                            nuoc_san_xuat = match.group(1)
                        else:
                            nuoc_san_xuat = 'Không đề cập'
                        break
            except NoSuchElementException:
                nuoc_san_xuat = 'Không đề cập'

            # print(f"Nước sản xuất: {nuoc_san_xuat}")
            # print(f"Giá: {gia}")
            # print(f"Tên: {ten}")
            # print(f"Thông tin: {tt}")
            # print(f"Thành phần: {tp_element}")
            # print(f"Img: {img_url}")
            print(f"Link :{a}")

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
                        nuoc_san_xuat = excluded.nuoc_san_xuat,
                        hamluong_thanhphan = excluded.hamluong_thanhphan,
                        photo = excluded.photo,
                        giacu = thuocsi_vn.giamoi,
                        ngaycu = thuocsi_vn.ngaymoi,
                        giamoi='{gia}',
                        ngaymoi='{ngay}';
                ''', (
                    product_name, gia, ngay, gia, img_url, nsx, nuoc_san_xuat, tp_element, tt, a, 'pharmacity.vn'))
                connection.commit()

        except (NoSuchElementException, TimeoutException) as e:
                logging.error(f"Lỗi khi scraping sản phẩm: {str(e)}")
    driver.quit()
except Exception as e:
    logging.error(f"Unhandled Exception: {str(e)}")


