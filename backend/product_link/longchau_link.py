from selenium.common.exceptions import NoSuchElementException
from selenium import webdriver
import chromedriver_autoinstaller
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import WebDriverWait
import psycopg2
import datetime
from dotenv import load_dotenv
from time import sleep
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
                nguon TEXT DEFAULT 'longchau.vn'
            )
        ''')

    def check_product_exist(cursor, product_name):
            cursor.execute("SELECT EXISTS(SELECT 1 FROM thuocsi_vn WHERE title = %s)", (product_name,))
            return cursor.fetchone()[0]
    a = trangnt
    a ='https://nhathuoclongchau.com.vn/thuc-pham-chuc-nang/vien-uong-ho-tro-tang-cuong-tuan-hoan-mau-nao-memoren-1200-max-kingphar-30-v.html'
    driver.get(a)
    sleep(1)
    try:
        try:
            ten = driver.find_element(By.CSS_SELECTOR, "h1.css-18o6y07").text

            try:
                gia_sales_element = driver.find_element(By.CSS_SELECTOR, "span.text-heading1")
            except NoSuchElementException:
                gia_sales_element = 0
            if gia_sales_element:
                gia_sales_text = gia_sales_element.text.replace("đ", "").replace(".", "").replace(" ", "")
                gia_sales = int(gia_sales_text)
            else:
                gia_sales = 0
        except NoSuchElementException:
            gia_sales = 0
        try:
            nha_san_xuat = driver.find_element(By.CSS_SELECTOR, "tr.content-container:nth-child(7)").text
            if "Nhà sản xuất" in nha_san_xuat:
                nha_san_xuat = nha_san_xuat.replace("Nhà sản xuất", "").strip()
            else:
                nha_san_xuat_alt = driver.find_element(By.CSS_SELECTOR, "tr.content-container:nth-child(8)").text
                if "Nhà sản xuất" in nha_san_xuat_alt:
                    nha_san_xuat = nha_san_xuat_alt.replace("Nhà sản xuất", "").strip()
                else:
                    nha_san_xuat_alt = driver.find_element(By.CSS_SELECTOR,
                                                        "tr.content-container:nth-child(9)").text
                    if "Nhà sản xuất" in nha_san_xuat_alt:
                        nha_san_xuat = nha_san_xuat_alt.replace("Nhà sản xuất", "").strip()
                    else:
                        nha_san_xuat = "Không đề cập"
        except NoSuchElementException:
            nha_san_xuat = "Không đề cập"
        try:
            nuoc_san_xuat = driver.find_element(By.CSS_SELECTOR, "tr.content-container:nth-child(6)").text
            if "Xuất xứ thương hiệu" in nuoc_san_xuat:
                nuoc_san_xuat = nuoc_san_xuat.replace("Xuất xứ thương hiệu", "").strip()
            else:
                nuoc_san_xuat_alt = driver.find_element(By.CSS_SELECTOR, "tr.content-container:nth-child(7)").text
                if "Xuất xứ thương hiệu" in nuoc_san_xuat_alt:
                    nuoc_san_xuat = nuoc_san_xuat_alt.replace("Xuất xứ thương hiệu", "").strip()
                else:
                    nuoc_san_xuat_alt = driver.find_element(By.CSS_SELECTOR,
                                                            "tr.content-container:nth-child(8)").text
                    if "Xuất xứ thương hiệu" in nuoc_san_xuat_alt:
                        nuoc_san_xuat = nuoc_san_xuat_alt.replace("Xuất xứ thương hiệu", "").strip()
                    else:
                        nuoc_san_xuat = "không đề cập"
        except NoSuchElementException:
            nuoc_san_xuat = "không đề cập"
        try:
            hamluong_thanhphan = driver.find_element(By.CSS_SELECTOR, "tr.content-container:nth-child(4)").text
            if "Thành phần" in hamluong_thanhphan:
                hamluong_thanhphan = hamluong_thanhphan.replace("Thành phần", "").strip()
            else:
                hamluong_thanhphan_alt = driver.find_element(By.CSS_SELECTOR,
                                                            "tr.content-container:nth-child(5)").text
                if "Thành phần" in hamluong_thanhphan_alt:
                    hamluong_thanhphan = hamluong_thanhphan_alt.replace("Thành phần", "").strip()
                else:
                    hamluong_thanhphan = "không đề cập"
        except NoSuchElementException:
            hamluong_thanhphan = "không đề cập"
        try:
            thong_tin_san_pham = driver.find_element(By.CSS_SELECTOR, ".text-gray-10 > p:nth-child(1)").text
        except NoSuchElementException:
            thong_tin_san_pham = "Không đề cập"
        try:
            photo = driver.find_element(By.CSS_SELECTOR, ".swiper-slide-active .h-full > source").get_attribute(
                "srcset")
        except NoSuchElementException:
            photo = ""
        ngay = datetime.datetime.now().date()
        current_month = datetime.datetime.now().month
        print(f"gia:{gia_sales}")
        with connection.cursor() as cursor:
            if check_product_exist(cursor, ten):
                cursor.execute(f'''
                    UPDATE thuocsi_vn
                    SET month_{current_month} = %s, thong_tin_san_pham = %s, nha_san_xuat = %s, nuoc_san_xuat = %s,
                        hamluong_thanhphan = %s, photo = %s, link = %s,
                        giacu = giamoi, ngaycu = ngaymoi, giamoi = %s, ngaymoi = %s, nguon = %s
                    WHERE title = %s;
                ''', (
                    gia_sales, thong_tin_san_pham, nha_san_xuat, nuoc_san_xuat, hamluong_thanhphan, photo, a,
                    gia_sales, ngay, 'longchau.vn', ten))
            else:
                cursor.execute(f'''
                    INSERT INTO thuocsi_vn (title, giamoi, ngaymoi, month_{current_month}, photo, nha_san_xuat,
                    nuoc_san_xuat, hamluong_thanhphan, thong_tin_san_pham, link, nguon)
                    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);
                ''', (
                    ten, gia_sales, ngay, gia_sales, photo, nha_san_xuat, nuoc_san_xuat,
                    hamluong_thanhphan, thong_tin_san_pham, a, 'longchau.vn'))
                connection.commit()
    except Exception as e:
        print("Lỗi khi scraping sản phẩm:", str(e))

    driver.quit()
caogia(sys.argv[1])
