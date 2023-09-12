from selenium.common.exceptions import NoSuchElementException, ElementNotInteractableException, TimeoutException
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
import sys
import codecs
def caogia(trangnt):
    if sys.stdout.encoding != 'utf-8':
        sys.stdout = codecs.getwriter('utf-8')(sys.stdout.buffer, 'strict')
        sys.stderr = codecs.getwriter('utf-8')(sys.stderr.buffer, 'strict')

    chromedriver_autoinstaller.install()
    chrome_options = webdriver.ChromeOptions()
    # chrome_options.add_argument("--headless")
    # chrome_options.add_argument("--window-size=1920x1080")
    driver = webdriver.Chrome(options=chrome_options)
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
    a = trangnt
    a ='https://www.nhathuocankhang.com/thuoc-bo-va-vitamin/magne-b6-corbiere'

    def check_product_exist(cursor, product_name):
            cursor.execute("SELECT EXISTS(SELECT 1 FROM thuocsi_vn WHERE title = %s)", (product_name,))
            return cursor.fetchone()[0]

    driver.get(a)
    sleep(1)
    try:
        try:
            ten = driver.find_element(By.CSS_SELECTOR, "h1.detail-title").text

            try:
                gia_sales_element = driver.find_element(By.CSS_SELECTOR, ".list-price-tracking:nth-child(3) b")
            except NoSuchElementException:
                try:
                    gia_sales_element = driver.find_element(By.CSS_SELECTOR, ".list-price-tracking:nth-child(2) b")
                except NoSuchElementException:
                    try:
                        gia_sales_element = driver.find_element(By.CSS_SELECTOR, ".box-price b")
                    except NoSuchElementException:
                        gia_sales_element = 0

            if gia_sales_element:
                gia_sales_text = gia_sales_element.text.replace("₫", "").replace(".", "").replace(" ", "")
                gia_sales = int(gia_sales_text)
            else:
                gia_sales = 0
        except NoSuchElementException:
            gia_sales = 0
        nha_san_xuat = driver.find_element(By.CSS_SELECTOR, ".des-infor > li:nth-child(4)").text
        if "Hãng sản xuất" in nha_san_xuat:
            nha_san_xuat = nha_san_xuat.replace("Hãng sản xuất", "").strip()
        elif "Nơi sản xuất" in nha_san_xuat:
            nha_san_xuat = nha_san_xuat.replace("Nơi sản xuất", "").strip()
        else:
            nha_san_xuat_alt = driver.find_element(By.CSS_SELECTOR, ".des-infor > li:nth-child(5)").text
            if "Hãng sản xuất" in nha_san_xuat_alt:
                nha_san_xuat = nha_san_xuat_alt.replace("Hãng sản xuất", "").strip()
            elif "Nơi sản xuất" in nha_san_xuat_alt:
                nha_san_xuat = nha_san_xuat_alt.replace("Nơi sản xuất", "").strip()
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
                        hamluong_thanhphan = %s, photo = %s, link = %s,
                        giacu = giamoi, ngaycu = ngaymoi, giamoi = %s, ngaymoi = %s, nguon = %s
                    WHERE title = %s;
                ''', (
                    gia_sales, thong_tin_san_pham, nha_san_xuat, nuoc_san_xuat, thanhphan_hamluong, photo, a,
                    gia_sales, ngay, 'ankhang.com', ten))
            else:
                cursor.execute(f'''
                    INSERT INTO thuocsi_vn (title, giamoi, ngaymoi, month_{current_month}, photo, nha_san_xuat,
                    nuoc_san_xuat, hamluong_thanhphan, thong_tin_san_pham, link, nguon)
                    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);
                ''', (
                    ten, gia_sales, ngay, gia_sales, photo, nha_san_xuat, nuoc_san_xuat,
                    thanhphan_hamluong, thong_tin_san_pham, a, 'ankhang.com'))
                connection.commit()
    except Exception as e:
        print("Lỗi khi scraping sản phẩm:", str(e))

    driver.quit()
caogia(sys.argv[1])
