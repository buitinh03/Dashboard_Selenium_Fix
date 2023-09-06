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

def caogia(trangnt):
    if sys.stdout.encoding != 'utf-8':
        sys.stdout = codecs.getwriter('utf-8')(sys.stdout.buffer, 'strict')
        sys.stderr = codecs.getwriter('utf-8')(sys.stderr.buffer, 'strict')

    chromedriver_autoinstaller.install()
    chrome_options = webdriver.ChromeOptions()
   # chrome_options.add_argument("--headless")
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

        wait = WebDriverWait(driver, 1)


    def extract_product_info():
        product_name_element = wait.until(
            EC.presence_of_element_located((By.CSS_SELECTOR, ".ProductContent_product-title__Li_7c")))
        product_name = product_name_element.text
        return product_name


    link_lists = [
        "duoc-pham",#174,29,60,28,42,30,54,5
        "cham-soc-ca-nhan",
        "cham-soc-suc-khoe",
        "san-pham-tien-loi",
        "thuc-pham-chuc-nang",
        "me-va-be",
        "cham-soc-sac-dep",
        "thiet-bi-y-te-2",
    ]
    numpages=[174,29,60,28,42,30,54,5]
    base_url = "https://www.pharmacity.vn/"
    link = []
    if(int(trangnt)!=0):
        if(int(trangnt)<174):
            trangchay=link_lists[0]
            dem=int(trangnt)
            ktdem=dem+9
        else: 
            if(int(trangnt)<(174+29)):
                trangchay=link_lists[1]
                dem=int(trangnt)-147
                ktdem=dem+9
            else: 
                if(int(trangnt)<(174+29+60)):
                    trangchay=link_lists[2]
                    dem=int(trangnt)-147-29
                    ktdem=dem+9
                else:
                    if(int(trangnt)<(174+29+60+28)):
                        trangchay=link_lists[3]
                        dem=int(trangnt)-(174+29+60)
                        ktdem=dem+9
                    else: 
                        if(int(trangnt)<(174+29+60+28+42)):
                            trangchay=link_lists[4]
                            dem=int(trangnt)-(174+29+60+28)
                            ktdem=dem+9
                        else: 
                            if(int(trangnt)<(174+29+60+28+42+30)):
                                trangchay=link_lists[5]
                                dem=int(trangnt)-(174+29+60+28+42)
                                ktdem=dem+9
                            else:
                                if(int(trangnt)<(174+29+60+28+42+30+54)):
                                    trangchay=link_lists[6]
                                    dem=int(trangnt)-(174+29+60+28+42+30)
                                    ktdem=dem+9
                                else: 
                                    if(int(trangnt)<(174+29+60+28+42+30+54+5)):
                                        trangchay=link_lists[7]
                                        dem=int(trangnt)-(174+29+60+28+42+30+54)
                                        ktdem=dem+9

        full_url = f"{base_url}/{trangchay}"
        driver.get(full_url)
        num_pages_to_scrape = ktdem
        for page_num in range(dem, num_pages_to_scrape + 1):
            url = f"{base_url}/{trangchay}?page={page_num}"
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
    else: 
        for url_suffix in link_lists:
            full_url = f"{base_url}/{url_suffix}"
            driver.get(full_url)

            num_pages_to_scrape = 1000
            for page_num in range(1, num_pages_to_scrape + 1):
                url = f"{base_url}/{url_suffix}?page={page_num}"
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

    def check_product_exist(cursor, ten):
        cursor.execute("SELECT EXISTS(SELECT 1 FROM thuocsi_vn WHERE title = %s)", (ten,))
        return cursor.fetchone()[0]


    for a in link:
        driver.get(a)
        try:
            product_name = ""
            nsx = 'Không đề cập'
            nuoc_san_xuat = 'Không đề cập'
            thong_tin_san_pham = "Không đề cập"
            nha_san_xuat = "Không đề cập"
            hamluong_thanhphan = "Không đề cập"

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
                gia = driver.find_element(By.CSS_SELECTOR,".ProductPrice_price__tztxw").text
                gia = gia.replace('.', '').replace('đ', '')
            except NoSuchElementException:
                gia = '0'
            try:
                tt = driver.find_element(By.CSS_SELECTOR, ".ProductContent_description__tGOQ1").text
                tt = tt.replace(
                    driver.find_element(By.CSS_SELECTOR, ".ProductContent_description__tGOQ1 > p:nth-child(1)").text, '').strip()
            except NoSuchElementException:
                tt = 'Không đề cập'

            try:
                tp_element = driver.find_element(By.CSS_SELECTOR,
                                                ".ProductContent_description__tGOQ1 > p:nth-child(1)")
                tp_element = tp_element.text.replace('Hoạt chất', '').replace('Hoạt tính', '')

            except NoSuchElementException:
                tp_element = 'Không đề cập'

            try:
                img_element = driver.find_element(By.CSS_SELECTOR, ".ProductThumbnailCarousel_product-img__YsmdM img")
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

            print(f"Nước sản xuất: {nuoc_san_xuat}")
            print(f"Giá: {gia}")
            print(f"Tên: {ten}")
            print(f"Thông tin: {tt}")
            print(f"Thành phần: {tp_element}")
            print(f"Img: {img_url}")
            print(f"Link :{a}")

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
                        gia, tt, nsx, nuoc_san_xuat, tp_element, img_url, a, gia, ngay, 'pharmacity.vn', ten))
                else:
                    cursor.execute(f'''
                                            INSERT INTO thuocsi_vn (title, giamoi, ngaymoi, month_{current_month}, photo, nha_san_xuat,
                                            nuoc_san_xuat, hamluong_thanhphan, thong_tin_san_pham, link, nguon)
                                            VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);
                                        ''', (
                        ten, gia, ngay, gia, img_url, nsx, nuoc_san_xuat, tp_element, tt, a, 'pharmacity.vn'))
                    connection.commit()

        except (NoSuchElementException, TimeoutException) as e:
            print("Cào sản phẩm thất bại")

    driver.quit()
caogia(sys.argv[1])