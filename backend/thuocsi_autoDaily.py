from selenium.common.exceptions import NoSuchElementException, TimeoutException
from selenium import webdriver
import chromedriver_autoinstaller
from selenium.webdriver.common.by import By
import psycopg2
from bs4 import BeautifulSoup
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import datetime
import sys
import codecs
import os
from dotenv import load_dotenv
# from flask import Flask, request, redirect

# Load environment variables from .env file
load_dotenv()


if sys.stdout.encoding != 'utf-8':
    sys.stdout = codecs.getwriter('utf-8')(sys.stdout.buffer, 'strict')
    sys.stderr = codecs.getwriter('utf-8')(sys.stderr.buffer, 'strict')
    
# app = Flask(__name__)


# @app.route("/run-python", methods=['POST'])
# def run_python():
#     pre_url = request.referrer
#     cur_path = request.headers['Referer']
#     cur_scheme = request.scheme
#     pre_full_url = cur_scheme + "://" + pre_url + cur_path
#     numstart = request.form.get('numstart')
#     numend = request.form.get('numend')
#     bd = numstart
#     kt = numend
    
    
# Tự động cài đặt ChromeDriver phù hợp với phiên bản Chrome đã cài đặt
    chromedriver_autoinstaller.install()
    chrome_options = webdriver.ChromeOptions()
    # chrome_options.add_argument("--headless")
    # chrome_options.add_argument("--window-size=1920x1080")
    driver = webdriver.Chrome(options=chrome_options)
    url = "https://thuocsi.vn/products"

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
            ngaycu date,
            giamoi TEXT,
            ngaymoi date,
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
            nguon TEXT DEFAULT 2
        )
        ''')
        connection.commit()

    # Đăng nhập vào trang web
    driver.get(url)
    try:
        wait = WebDriverWait(driver, 10)
        click_login = wait.until(EC.element_to_be_clickable(
            (By.CSS_SELECTOR, ".MuiGrid-root:nth-child(1) > .styles_link__t2Gkc > .MuiTypography-root")))
        click_login.click()

        username_input = wait.until(
            EC.visibility_of_element_located((By.CSS_SELECTOR, ".MuiFormControl-root:nth-child(1) .MuiInputBase-input")))
        password_input = wait.until(
            EC.visibility_of_element_located((By.CSS_SELECTOR, "input.MuiInputBase-inputAdornedEnd")))

        username_input.send_keys("0332790644")
        password_input.send_keys("abc")

        login_button = wait.until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, ".styles_btn_register__zCg7F > .MuiButton-label")))
        login_button.click()

        wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, ".styles_root__yHa_F > .styles_tab_panel__NAwAa")))
    except (NoSuchElementException, TimeoutException) as e:
        print("Đăng nhập thành công ")
        connection.commit()


    def extract_product_info(html):
        soup = BeautifulSoup(html, 'html.parser')

        manufacturer = ""
        country_of_origin = ""
        product_info = ""
        # sales_in_last_24_hours = ""

        # Tìm thông tin nhà sản xuất và trích xuất dữ liệu nếu có
        manufacturer_info = soup.find('div', class_='styles_warpper____CUU')
        if manufacturer_info:
            manufacturer_element = manufacturer_info.find('a', class_='styles_manufactureInfoLink__0pU6d')
            if manufacturer_element:
                manufacturer = manufacturer_element.text

        country_of_origin_info = soup.find('div', class_='styles_warpper__a1pGy')
        if country_of_origin_info:
            country_of_origin_element = country_of_origin_info.find('p',
                                                                    class_='MuiTypography-root styles_manufactureInfoLink__NlYlw MuiTypography-body1')
            if country_of_origin_element:
                country_of_origin = country_of_origin_element.text

        product_info_element = soup.find('div', class_='styles_content__L0lSp')
        if product_info_element:
            product_info = product_info_element.text.strip()

        # sales_element = soup.find('p', class_='MuiTypography-root styles_nameDescNumber__JUiEI MuiTypography-body1')
        # if sales_element:
        #     sales_in_last_24_hours = sales_element.text.strip()

        product_name_element = wait.until(
            EC.presence_of_element_located((By.CSS_SELECTOR, 'p.titleProduct,p.styles_last_breadcrumb__c7IQm')))
        product_name = product_name_element.text

        masp = driver.find_element(By.CSS_SELECTOR, ".styles_root__yHa_F > .styles_tab_panel__NAwAa")
        ma = masp.get_attribute("id")

        tp = 'button#' + ma[:-3] + "T-2"
        try:
            thanhphan_button = driver.find_element(By.CSS_SELECTOR, tp)
            thanhphan_button.click()
            tp = driver.find_element(By.CSS_SELECTOR, "a.styles_ingredient__YBVN8")
            tp = tp.text
        except NoSuchElementException:
            tp = ""
        try:
            hamluong = driver.find_element(By.CSS_SELECTOR, ".styles_ingredientList___k512 div:nth-child(2)")
            hl = hamluong.text
        except NoSuchElementException:
            hl = ""

        delimiter = '.........'

        if tp and hl:
            tphl = tp + delimiter + hl
        elif tp:
            tphl = tp
        elif hl:
            tphl = hl
        else:
            tphl = ""

        product_info_element = soup.find('div', class_='styles_content__L0lSp')
        if product_info_element:
            product_info = product_info_element.text.strip()

        return manufacturer, country_of_origin, tphl, product_info, product_name


    num_pages_to_scrape = 1
    link = []
    for page_num in range(1, num_pages_to_scrape + 1):
        url = f"https://thuocsi.vn/products?page={page_num}"
        driver.get(url)
    # num_pages_to_scrape = 1000
    # link = []

    # for page_num in range(1, num_pages_to_scrape + 1):
    #     url = f"https://thuocsi.vn/products?page={page_num}"
    #     driver.get(url)

    #     html = driver.page_source
    #     soup = BeautifulSoup(html, 'html.parser')

    #     search_info_div = soup.find("div", class_="style_search_result__5jWKu")

    #     if search_info_div and "0 sản phẩm tìm kiếm" in search_info_div.get_text():
    #         break
        l = driver.find_elements(By.CSS_SELECTOR,
                                ".style_product_grid_wrapper__lYnBj > .MuiGrid-root > div span > .styles_mobile_rootBase__8z7PQ")
        for i in l:
            lin = i.get_attribute('href')
            link.append(lin)


    def check_product_exist(cursor, product_name):
        cursor.execute("SELECT EXISTS(SELECT 1 FROM thuocsi_vn WHERE title = %s)", (product_name,))
        return cursor.fetchone()[0]

    # Thêm các sản phẩm vào cơ sở dữ liệu với giá mới lưu vào tháng hiện tại
    for a in link:
        try:
            ngay = datetime.datetime.now()
            a = a.replace("/loading", "")
            driver.get(a)
            ten = ""
            gia = ""
            anh = ""
            nha_san_xuat = ""
            nuoc_san_xuat = ""
            tphl = ""
            thong_tin_san_pham = ""
            product_name = ""
            nguon="thuocsi.vn"


            try:
                html = driver.page_source
                nha_san_xuat, nuoc_san_xuat, tphl, thong_tin_san_pham, product_name = extract_product_info(
                    html)
            except NoSuchElementException:
                pass

            try:
                product_name = driver.find_element(By.CSS_SELECTOR, 'p.titleProduct,p.styles_last_breadcrumb__c7IQm').text
            except NoSuchElementException:
                product_name = ""

            try:
                gia_element = driver.find_element(By.CSS_SELECTOR,
                                                'div.styles_old_price__n6fx5,span.styles_old_price__n6fx5')
                gia = gia_element.text
                gia = gia.replace('.', '').replace('đ', '')
                gia = int(gia)

            except NoSuchElementException:
                gia = None

            try:
                gia_sales_element = driver.find_element(By.CSS_SELECTOR,
                                                        'div.styles_deal_price__HiSOK,span.styles_deal_price__HiSOK')
                gia_sales = gia_sales_element.text
                gia_sales = gia_sales.replace('.', '').replace('đ', '')
                gia_sales = int(gia_sales)

            except NoSuchElementException:
                gia_sales = "0"

            if gia is None:
                gia = gia_sales
            try:
                anh = driver.find_element(By.CSS_SELECTOR, 'img.styles_imageMain__UQ9fH').get_attribute('src')
            except NoSuchElementException:
                anh = ""

            # Lấy tháng hiện tại (từ 1 đến 12) và lưu vào biến current_month
            current_month = datetime.datetime.now().month

            with connection.cursor() as cursor:
                if check_product_exist(cursor, product_name):
                    # Sản phẩm đã tồn tại, cập nhật thông tin của nó
                    cursor.execute(f'''
                                UPDATE thuocsi_vn
                                SET photo = %s, nha_san_xuat = %s, nuoc_san_xuat = %s, thong_tin_san_pham = %s, hamluong_thanhphan = %s,
                                     month_{current_month} = %s, link = %s,
                                    giacu = giamoi, ngaycu = ngaymoi, giamoi = %s, ngaymoi = %s
                                WHERE title = %s;
                            ''', (
                    anh, nha_san_xuat, nuoc_san_xuat, thong_tin_san_pham, tphl, gia_sales, a, gia_sales,
                    ngay, product_name))
                else:
                    cursor.execute(f'''
                               INSERT INTO thuocsi_vn (title, giamoi, ngaymoi, photo, nha_san_xuat, nuoc_san_xuat, 
                            thong_tin_san_pham, hamluong_thanhphan, month_{current_month}, link, nguon)
                            VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);
                        ''', (
                    product_name, gia_sales, ngay, anh, nha_san_xuat, nuoc_san_xuat, thong_tin_san_pham, tphl
                    , gia_sales, a,nguon))
                connection.commit()
        except Exception as e:
            print("Lỗi khi scraping sản phẩm:", str(e))

    connection.close()
    driver.quit()
#     return '''<script>window.history.back();</script>'''
# if __name__ == '__main__':
#     app.run(host='0.0.0.0')