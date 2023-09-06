from selenium.common.exceptions import NoSuchElementException, TimeoutException
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

# Khởi tạo trình duyệt Chrome
chromedriver_autoinstaller.install()
chrome_options = webdriver.ChromeOptions()
# chrome_options.add_argument("--headless")
chrome_options.add_argument("--window-size=1920x1080")
driver = webdriver.Chrome(options=chrome_options)

# URL của trang web
base_url = "https://www.medigoapp.com/danh-muc/san-pham"

# Tải biến môi trường từ file .env
load_dotenv()

# Kết nối đến cơ sở dữ liệu PostgreSQL
connection = psycopg2.connect(
    host=os.getenv("DB_HOST"),
    database=os.getenv("DB_NAME"),
    user=os.getenv("DB_USER"),
    password=os.getenv("DB_PASSWORD")
)

# Tạo bảng nếu chưa tồn tại
with connection.cursor() as cursor:
    cursor.execute('''
        CREATE TABLE IF NOT EXISTS goapp (
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
            nguon TEXT DEFAULT ''
        )
    ''')

# Mở trang web
driver.get(base_url)

# Lấy danh sách các link sản phẩm từ nhiều trang
num_pages_to_scrape = 1
all_product_links = []

for page_num in range(1, num_pages_to_scrape + 1):
    url = f"{base_url}?page={page_num}"
    driver.get(url)
    
    # Lấy danh sách các liên kết sản phẩm trên trang hiện tại
    link_elements = driver.find_elements(By.CSS_SELECTOR, ".grid-products:nth-child(2) .custom-link")
    links = [link.get_attribute('href') for link in link_elements]
    
    all_product_links.extend(links)

def check_product_exist(cursor, product_name):
    cursor.execute("SELECT EXISTS(SELECT 1 FROM goapp WHERE title = %s)", (product_name,))
    return cursor.fetchone()[0]

# Duyệt qua từng sản phẩm
for a in all_product_links:
    driver.get(a)
    try:
            button_element = driver.find_element(By.CSS_SELECTOR, "button.ml-2:nth-child(1)")
            button_element.click()
            time.sleep(1)
            
            # Tiếp tục cào dữ liệu từ trang mới được mở ra sau khi nhấp nút
    except NoSuchElementException:
            pass
    
    try:
        # Nhấp vào nút "Xem thêm"
        button_xemthem = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, ".cursor-pointer > strong"))
        )
        driver.execute_script("arguments[0].click();", button_xemthem)
        time.sleep(2)
        
        # Lấy thông tin sản phẩm
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
            thong_tin_san_pham = "Không dề cập"

        import re

        import re

        try:
            hamluong_thanhphan_element = driver.find_element(By.CSS_SELECTOR, "p:nth-child(2) > .html-in-cms > div")
            hamluong_thanhphan = hamluong_thanhphan_element.text

            # Loại bỏ dấu "-" ở đầu chuỗi
            # hamluong_thanhphan = re.sub(r'^-*\s*', '', hamluong_thanhphan)

            # # Loại bỏ các chuỗi "Mỗi viên chứa:" hoặc "Mỗi viên nén bao phim chứa:"
            # hamluong_thanhphan = re.sub(r'(Mỗi viên chứa:|Mỗi viên nén bao phim chứa:|Điều trị các nhiễm khuẩn do vi khuẩn nhạy cảm, bao gồm:)', '', hamluong_thanhphan).strip()
        except NoSuchElementException:
            hamluong_thanhphan = "không đề cập"



        try:
            nha_san_xuat_element = driver.find_element(By.CSS_SELECTOR, "tr.mb-2:nth-child(5)")
            if "Thương hiệu:" in nha_san_xuat_element.text:
                nha_san_xuat = nha_san_xuat_element.text.replace("Thương hiệu:", "").strip()
            else:
                raise NoSuchElementException("Không tìm thấy 'Thương hiệu:' trong tr.mb-2:nth-child(5)")
        except NoSuchElementException:
            # try:
            #     nha_san_xuat_alt_element = driver.find_element(By.CSS_SELECTOR, "tbody > .d-flex:nth-child(4)")
            #     if "Thương hiệu:" in nha_san_xuat_alt_element.text:
            #         nha_san_xuat = nha_san_xuat_alt_element.text.replace("Thương hiệu:", "").strip()
            #     else:
            #         raise NoSuchElementException("Không tìm thấy 'Thương hiệu:' trong tbody > .d-flex:nth-child(4)")
        # except NoSuchElementException:
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
                    raise NoSuchElementException("Không tìm thấy 'Nước sản xuất:' trong tbody > .d-flex:nth-child(4)")
            except NoSuchElementException:
                nuoc_san_xuat = "Không đề cập"


        photo = driver.find_element(By.CSS_SELECTOR, ".col-5 .custom-image-magnifiers > .img-fluid").get_attribute("srcset")
        
        ngay = datetime.datetime.now().date()
        current_month = datetime.datetime.now().month

        with connection.cursor() as cursor:
            if check_product_exist(cursor, ten):
                cursor.execute(f'''
                    UPDATE goapp
                    SET month_{current_month} = %s, thong_tin_san_pham = %s, nha_san_xuat = %s, nuoc_san_xuat = %s,
                        hamluong_thanhphan = %s, photo = %s, link = %s,
                        giacu = giamoi, ngaycu = ngaymoi, giamoi = %s, ngaymoi = %s, nguon = %s
                    WHERE title = %s;
                ''', (
                    gia_sales, thong_tin_san_pham, nha_san_xuat, nuoc_san_xuat, hamluong_thanhphan, photo, a,
                    gia_sales, ngay, 'longchau.vn', ten))
            else:
                cursor.execute(f'''
                    INSERT INTO goapp (title, giamoi, ngaymoi, month_{current_month}, photo, nha_san_xuat,
                    nuoc_san_xuat, hamluong_thanhphan, thong_tin_san_pham, link, nguon)
                    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);
                ''', (
                    ten, gia_sales, ngay, gia_sales, photo, nha_san_xuat, nuoc_san_xuat,
                    hamluong_thanhphan, thong_tin_san_pham, a, 'longchau.vn'))
                connection.commit()

    except Exception as e:
        print("Lỗi khi scraping sản phẩm:", str(e))

# Đóng trình duyệt
driver.quit()
