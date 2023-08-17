from selenium.common.exceptions import NoSuchElementException, ElementNotInteractableException
from selenium import webdriver
import chromedriver_autoinstaller
from selenium.webdriver.common.by import By
import psycopg2
import datetime
from dotenv import load_dotenv
from time import sleep
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import os

chromedriver_autoinstaller.install()
chrome_options = webdriver.ChromeOptions()
# chrome_options.add_argument("--headless")
chrome_options.add_argument("--window-size=1920x1080")
driver = webdriver.Chrome(options=chrome_options)
url = "https://www.nhathuocankhang.com/"
load_dotenv()

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
            link TEXT,
            nguon TEXT DEFAULT 'an_khang'
        )
    ''')

link_lists = [
    "https://www.nhathuocankhang.com/thuoc-bo-va-vitamin",
    "https://www.nhathuocankhang.com/giam-dau-ha-sot-khang-viem"
]


for url in link_lists:
    driver.get(url)
    sleep(1)
    try:
        active_button = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.CSS_SELECTOR, ".btn-wrapper > .active")))
        active_button.click()
        
    except ElementNotInteractableException:
        pass
    sleep(2)
    while True:
        try:
            view_more_button = driver.find_element(By.CSS_SELECTOR, ".view-more > a")
            if view_more_button.is_displayed():
                view_more_button.click()
                sleep(2)
            else:
                break
        except NoSuchElementException:
            break

    l = driver.find_elements(By.CSS_SELECTOR, "ul.listing-prod > li a")
    link = [i.get_attribute('href') for i in l]

    def check_product_exist(cursor, product_name):
        cursor.execute("SELECT EXISTS(SELECT 1 FROM thuocsi_vn WHERE title = %s)", (product_name,))
        return cursor.fetchone()[0]

    for a in link:
        driver.get(a)
        sleep(2)
        try:
            ten = driver.find_element(By.CSS_SELECTOR, "h1").text
            gia_sales_element = driver.find_element(By.CSS_SELECTOR, ".list-price-tracking:nth-child(2) b")
            gia_sales_text = gia_sales_element.text.replace("₫", "").replace(".", "").replace(" ", "")
            gia_sales = int(gia_sales_text)

            # Cào thông tin về nhà sản xuất
            nha_san_xuat = driver.find_element(By.CSS_SELECTOR, ".des-infor > li:nth-child(4)").text
            if "Hãng sản xuất" in nha_san_xuat:
                nha_san_xuat = nha_san_xuat.replace("Hãng sản xuất", "").strip()
            else:
                nha_san_xuat_alt = driver.find_element(By.CSS_SELECTOR, ".des-infor > li:nth-child(5)").text
                if "Hãng sản xuất" in nha_san_xuat_alt:
                    nha_san_xuat = nha_san_xuat_alt.replace("Hãng sản xuất", "").strip()
                else:
                    nha_san_xuat = "Không đề cập"

            nuoc_san_xuat = driver.find_element(By.CSS_SELECTOR, ".des-infor > li:nth-child(5)").text
            if "Nơi sản xuất" in nuoc_san_xuat:
                nuoc_san_xuat = nuoc_san_xuat.replace("Nơi sản xuất", "").strip()
            else:
                nuoc_san_xuat_alt = driver.find_element(By.CSS_SELECTOR, ".des-infor > li:nth-child(6)").text
                if "Nơi sản xuất" in nuoc_san_xuat_alt:
                    nuoc_san_xuat = nuoc_san_xuat_alt.replace("Nơi sản xuất", "").strip()
                else:
                    nuoc_san_xuat = "Không đề cập"

            thanhphan_hamluong = driver.find_element(By.CSS_SELECTOR, ".des-infor > li:nth-child(2)").text
            thanhphan_hamluong = thanhphan_hamluong.replace("Thành phần chính", "").strip()
            thong_tin_san_pham = driver.find_element(By.CSS_SELECTOR, ".des-infor > li:nth-child(1)").text
            thong_tin_san_pham = thong_tin_san_pham.replace("Công dụng", "").strip()
            photo = driver.find_element(By.CSS_SELECTOR, ".active > .item-img > img").get_attribute("src")
            ngay = datetime.datetime.now().date()
            current_month = datetime.datetime.now().month

            with connection.cursor() as cursor:
                if check_product_exist(cursor, ten):
                    cursor.execute(f'''
                        UPDATE thuocsi_vn
                        SET month_{current_month} = %s, thong_tin_san_pham = %s, nha_san_xuat = %s, nuoc_san_xuat = %s,
                            hamluong_thanhphan = %s, photo = %s, link = %s, giacu = %s, ngaycu = %s, giamoi = %s, ngaymoi = %s, nguon = %s
                        WHERE title = %s;
                    ''', (
                        gia_sales, thong_tin_san_pham, nha_san_xuat, nuoc_san_xuat, thanhphan_hamluong, photo, a,
                        gia_sales, ngay, gia_sales, ngay, 'nhathuocankhang.com', ten ))
                else:
                    cursor.execute(f'''
                        INSERT INTO thuocsi_vn (title, giacu, ngaycu, giamoi, ngaymoi, month_{current_month}, photo, nha_san_xuat,
                        nuoc_san_xuat, hamluong_thanhphan, thong_tin_san_pham, link, nguon)
                        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);
                    ''', (
                        ten, gia_sales, ngay, gia_sales, ngay, gia_sales, photo, nha_san_xuat, nuoc_san_xuat,
                        thanhphan_hamluong, thong_tin_san_pham, a, 'nhathuocankhang.com'))
                    connection.commit()
        except Exception as e:
            print("Lỗi khi scraping sản phẩm:", str(e))

driver.quit()