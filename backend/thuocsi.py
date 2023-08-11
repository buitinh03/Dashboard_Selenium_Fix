from selenium.common.exceptions import NoSuchElementException, TimeoutException
from selenium import webdriver
import chromedriver_autoinstaller
from selenium.webdriver.common.by import By
import psycopg2
from bs4 import BeautifulSoup
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from flask import Flask, request, redirect
import datetime
import subprocess
import codecs
import sys
import os
from dotenv import load_dotenv

# Load environment variables from .env file
load_dotenv()



# Set console encoding to UTF-8
if sys.stdout.encoding != 'utf-8':
    sys.stdout = codecs.getwriter('utf-8')(sys.stdout.buffer, 'strict')
    sys.stderr = codecs.getwriter('utf-8')(sys.stderr.buffer, 'strict')

app = Flask(__name__)


@app.route("/run-python", methods=['POST'])
def run_python():
    pre_url = request.referrer
    cur_path = request.headers['Referer']
    cur_scheme = request.scheme
    pre_full_url = cur_scheme + "://" + pre_url + cur_path
    numstart = request.form.get('numstart')
    numend = request.form.get('numend')
    bd = numstart
    kt = numend

    chromedriver_autoinstaller.install()
    chrome_options = webdriver.ChromeOptions()
    chrome_options.add_argument("--headless")
    chrome_options.add_argument("--window-size=1920x1080")
    driver = webdriver.Chrome(options=chrome_options)
    url = "https://thuocsi.vn/products"

    connection = psycopg2.connect(
        # host="localhost",
        # database="thuocsi_selenium",
        # user="postgres",
        # password="abcd@1234"
        host=os.getenv("DB_HOST"),
        database=os.getenv("DB_NAME"),
        user=os.getenv("DB_USER"),
        password=os.getenv("DB_PASSWORD") 
    )

    with connection.cursor() as cursor:
        cursor.execute('''
            CREATE TABLE IF NOT EXISTS thuocsi_vn (
                title TEXT,
                price TEXT,
                sales_in_last_24_hours INTEGER,
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
                nha_san_xuat TEXT,
                nuoc_san_xuat TEXT,			
                photo TEXT,
                hamluong_thanhphan TEXT,
                thong_tin_san_pham TEXT,
                link TEXT,
                ngay timestamp 

            )
        ''')
        connection.commit()

    # Mở đường dẫn URL
    driver.get(url)
    try:
        wait = WebDriverWait(driver, 10)
        click_login = wait.until(EC.element_to_be_clickable(
            (By.CSS_SELECTOR, ".MuiGrid-root:nth-child(1) > .styles_link__t2Gkc > .MuiTypography-root")))
        click_login.click()

        username_input = wait.until(
            EC.visibility_of_element_located(
                (By.CSS_SELECTOR, ".MuiFormControl-root:nth-child(1) .MuiInputBase-input")))
        password_input = wait.until(
            EC.visibility_of_element_located((By.CSS_SELECTOR, "input.MuiInputBase-inputAdornedEnd")))

        username_input.send_keys("0898861325")
        password_input.send_keys("giahuy1234")

        login_button = wait.until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, ".styles_btn_register__zCg7F > .MuiButton-label")))
        login_button.click()

        wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, ".styles_root__yHa_F > .styles_tab_panel__NAwAa")))
    except (NoSuchElementException, TimeoutException) as e:
        print("Đăng nhập thành công ")
        print("Sản phẩm đang được load ")
        connection.commit()

    def extract_product_info(html):
        soup = BeautifulSoup(html, 'html.parser')

        manufacturer = ""
        country_of_origin = ""
        sales_in_last_24_hours = ""
        product_info = ""

        # Find the manufacturer info and extract data if available
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

        sales_element = soup.find('p', class_='MuiTypography-root styles_nameDescNumber__JUiEI MuiTypography-body1')
        if sales_element:
            sales_in_last_24_hours = sales_element.text.strip().replace('.', '')

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

        return manufacturer, country_of_origin, tphl, product_info, sales_in_last_24_hours, product_name

    # num_pages_to_scrape = 1
    link = []
    for page_num in range(int(bd), int(kt) + 1):
        url = f"https://thuocsi.vn/products?page={page_num}"
        driver.get(url)
        l = driver.find_elements(By.CSS_SELECTOR,
                                 ".style_product_grid_wrapper__lYnBj > .MuiGrid-root > div span > .styles_mobile_rootBase__8z7PQ")
        for i in l:
            lin = i.get_attribute('href')
            link.append(lin)

    def check_product_exist(cursor, product_name):
        cursor.execute("SELECT EXISTS(SELECT 1 FROM thuocsi_vn WHERE title = %s)", (product_name,))
        return cursor.fetchone()[0]

    # Thêm các sản phẩm vào cơ sở dữ liệu với giá mới lưu vào 12 tháng gần nhất
    for a in link:
        try:
            ngay1 = datetime.datetime.now()
            ngay = ngay1.replace(microsecond=0)
            a = a.replace("/loading", "")
            driver.get(a)
            ten = ""
            gia = None
            gia_sales = ""
            anh = ""
            nha_san_xuat = ""
            nuoc_san_xuat = ""
            tphl = ""
            product_info = ""
            sales_in_last_24_hours = ""
            product_name = ""
            try:
                html = driver.page_source
                nha_san_xuat, nuoc_san_xuat, tphl, product_info, sales_in_last_24_hours, product_name = extract_product_info(
                    html)
            except NoSuchElementException:
                pass

            try:
                ten = driver.find_element(By.CSS_SELECTOR, 'p.titleProduct,p.styles_last_breadcrumb__c7IQm').text
            except NoSuchElementException:
                ten = "N/A"

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
                gia_sales = "N/A"

            if gia is None:
                gia = gia_sales

            try:
                anh = driver.find_element(By.CSS_SELECTOR, 'img.styles_imageMain__UQ9fH').get_attribute('src')
            except NoSuchElementException:
                anh = "N/A"

            with connection.cursor() as cursor:
                if check_product_exist(cursor, product_name):
                    cursor.execute('''
                            UPDATE thuocsi_vn
                            SET photo = %s, nha_san_xuat = %s, nuoc_san_xuat = %s, thong_tin_san_pham= %s, 
                                    hamluong_thanhphan = %s,
                                sales_in_last_24_hours = %s, month_12 = month_11, month_11 = month_10, month_10 = month_9,
                                month_9 = month_8, month_8 = month_7, month_7 = month_6, month_6 = month_5,
                                month_5 = month_4, month_4 = month_3, month_3 = month_2, month_2 = month_1, month_1 = %s,ngay = %s
                            WHERE title = %s;
                        ''', (
                        anh, nha_san_xuat, nuoc_san_xuat, product_info, tphl, sales_in_last_24_hours, gia_sales,ngay,
                        product_name ))
                else:
                    cursor.execute('''
                                    INSERT INTO thuocsi_vn (title, price, photo, nha_san_xuat, nuoc_san_xuat, thong_tin_san_pham, 
                                        hamluong_thanhphan, sales_in_last_24_hours, month_1, link,ngay)
                                    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);
                                ''', (
                        product_name, gia, anh, nha_san_xuat, nuoc_san_xuat, product_info, tphl, sales_in_last_24_hours,
                        gia_sales, a, ngay))
                connection.commit()
        except Exception as e:
            pass

    connection.close()
    driver.quit()
    # host_url=request.host_url
    # return redirect(host_url)
    # return 'Bạn đã cào thành công'
    # return redirect(cur_path)
    return '''<script>window.history.back();</script>'''


if __name__ == '__main__':
    app.run(host='0.0.0.0')
