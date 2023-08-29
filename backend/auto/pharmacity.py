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
import sys
import codecs
import time
from bs4 import BeautifulSoup

def caogia(trangnt):
    if sys.stdout.encoding != 'utf-8':
        sys.stdout = codecs.getwriter('utf-8')(sys.stdout.buffer, 'strict')
        sys.stderr = codecs.getwriter('utf-8')(sys.stderr.buffer, 'strict')

    chromedriver_autoinstaller.install()
    chrome_options = webdriver.ChromeOptions()
    chrome_options.add_argument("--headless")
    chrome_options.add_argument("--window-size=5120x2880")
    driver = webdriver.Chrome(options=chrome_options)
    url = "https://www.pharmacity.vn/"
    load_dotenv()

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
                nguon TEXT DEFAULT 'pharmacity.vn'
            )
        ''')


    def scroll_to_bottom():
        last_height = driver.execute_script("return document.body.scrollHeight")
        while True:
            driver.execute_script("window.scrollBy(0, 800);")  # Cuộn 400px mỗi lần
            time.sleep(1)  # Chờ 0.5 giây sau mỗi cuộn
            new_height = driver.execute_script("return document.body.scrollHeight")
            if new_height == last_height:
                break
            last_height = new_height


    def check_product_exist(cursor, product_name):
        cursor.execute("SELECT EXISTS(SELECT 1 FROM thuocsi_vn WHERE title = %s)", (product_name,))
        return cursor.fetchone()[0]


    link_lists = [
        "duoc-pham",
        "cham-soc-ca-nhan",
        "cham-soc-suc-khoe",
        "san-pham-tien-loi",
        "thuc-pham-chuc-nang",
        "me-va-be",
        "cham-soc-sac-dep",
        "thiet-bi-y-te-2",
    ]
    base_url = "https://www.pharmacity.vn/"
    link = []
    if(int(trangnt)!=0):
        dem=int(trangnt)
        ktdem=dem+1
    else: 
        dem=0
        ktdem=len(link_lists)
    while(dem<ktdem):
        if(dem<len(link_lists)):
            full_url = f"{base_url}/{link_lists[dem]}"
            driver.get(full_url)
            

            num_pages_to_scrape = 1
            for page_num in range(1, num_pages_to_scrape + 1):
                url = f"{base_url}/{link_lists[dem]}?page={page_num}"
                driver.get(url)
                html = driver.page_source
                soup = BeautifulSoup(html, 'html.parser')

                error_div = soup.find("div", class_="CategoryNotFound_not-found__F7hgP")

                if error_div and "Bộ lọc" in error_div.get_text():
                    span_element = error_div.find("span")
                    if span_element and "Bộ lọc" in span_element.get_text():
                        print("Lỗi tìm kiếm: Bộ lọc")
                        break

                else:
                    ll = WebDriverWait(driver, 10).until(
                        EC.presence_of_all_elements_located((By.CLASS_NAME, "ProductItem_product-item__Scx6a"))
                    )

                    for i in ll:
                        lin = i.get_attribute('href')
                        link.append(lin)
        dem=dem+1
    for a in link:
        driver.get(a)
        try:

            html = driver.page_source
            soup = BeautifulSoup(html, 'html.parser')

            WebDriverWait(driver, 10).until(
                EC.presence_of_element_located((By.CSS_SELECTOR, ".ProductContent_product-title__Li_7c"))
            )
            try:
                ten = driver.find_element(By.CSS_SELECTOR, ".ProductContent_product-title__Li_7c").text
            except NoSuchElementException:
                ten = 'Không đề cập'
            print(f"Tên: {ten}")
            try:
                gia = driver.find_element(By.CSS_SELECTOR,".ProductPrice_price__tztxw").text
                gia = gia.replace('.', '').replace('đ', '')
            except NoSuchElementException:
                gia = '0'
            print(f"Giá: {gia}")
            try:
                tt = driver.find_element(By.CSS_SELECTOR, ".ProductContent_description__tGOQ1").text
            except NoSuchElementException:
                tt = 'Không đề cập'
            print(f"Thông tin: {tt}")
            print(f"Link: {a}")

            try:
                img_element = driver.find_element(By.CSS_SELECTOR, ".ProductThumbnailCarousel_product-img__YsmdM img")
                img_url = img_element.get_attribute("src")
            except NoSuchElementException:
                img_url = 'Không đề cập'
            print(f"Img: {img_url}")
            # try:
            #     xem_them_button = driver.find_element(By.XPATH, "//button[contains(text(), 'Xem thêm')]")
            #     driver.execute_script("arguments[0].click();", xem_them_button)
            #
            #     page_source = driver.page_source
            #     soup = BeautifulSoup(page_source, "html.parser")
            #
            #     manufacturer = 'Không đề cập'
            #
            #     # Tìm thông tin nhà sản xuất
            #     manufacturer_elements = soup.find_all("p", string=lambda
            #         text: "Nhà sản xuất" in text or "Nơi sản xuất" in text or "Tên nhà sản xuất" in text)
            #     if manufacturer_elements:
            #         manufacturer = manufacturer_elements[-1].find_next_sibling(text=True, recursive=False).strip()
            #
            # except NoSuchElementException:
            #     pass
            thong_tin_san_pham = "Không đề cập"
            nha_san_xuat = "Không đề cập"
            nuoc_san_xuat = "Không đề cập"
            hamluong_thanhphan = "Không đề cập"
            # try:
            #     thanh_phan_element = soup.find("strong", text="Thành phần")
            #     if thanh_phan_element:
            #         br_element = thanh_phan_element.find_next("br")
            #         if br_element:
            #             thanh_phan = br_element.find_next_sibling(text=True).strip()
            #         print("Không tìm thấy thông tin Thành phần")
            # except NoSuchElementException:
            #     thanh_phan = 'Không đề cập'
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
                        gia, thong_tin_san_pham, nha_san_xuat,nuoc_san_xuat, hamluong_thanhphan, img_url, a, gia, ngay,
                        'pharmacity.vn', ten))
                else:
                    cursor.execute(f'''
                                    INSERT INTO thuocsi_vn (title, giamoi, ngaymoi, month_{current_month}, photo, nha_san_xuat,
                                    nuoc_san_xuat, hamluong_thanhphan, thong_tin_san_pham, link, nguon)
                                    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);
                                ''', (
                        ten, gia, ngay, gia, img_url, nha_san_xuat, nuoc_san_xuat,
                        hamluong_thanhphan, thong_tin_san_pham, a, 'pharmacity.vn'))
                    connection.commit()

        except (NoSuchElementException, TimeoutException) as e:
            print("Cào sản phẩm thất bại")

    driver.quit()
caogia(sys.argv[1])
