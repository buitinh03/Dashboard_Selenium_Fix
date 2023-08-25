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
def caogia(trangnt):
    # Set up UTF-8 encoding
    if sys.stdout.encoding != 'utf-8':
        sys.stdout = codecs.getwriter('utf-8')(sys.stdout.buffer, 'strict')
        sys.stderr = codecs.getwriter('utf-8')(sys.stderr.buffer, 'strict')

    # Install and set up ChromeDriver
    chromedriver_autoinstaller.install()
    chrome_options = webdriver.ChromeOptions()
    # chrome_options.add_argument("--headless")
    chrome_options.add_argument("--window-size=1920x1080")
    driver = webdriver.Chrome(options=chrome_options)
    load_dotenv()

    # Connect to PostgreSQL database
    connection = psycopg2.connect(
        host=os.getenv("DB_HOST"),
        database=os.getenv("DB_NAME"),
        user=os.getenv("DB_USER"),
        password=os.getenv("DB_PASSWORD")
    )

    # Create or update the database table
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

    # Navigate to the target URL
    url = "https://thuocsi.pharex.vn/products"
    driver.get(url)

    try:
        wait = WebDriverWait(driver, 10)

        # Log in
        click_login = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, "button.btn-secondary")))
        click_login.click()

        username_input = wait.until(
            EC.visibility_of_element_located((By.NAME, "username")))
        password_input = wait.until(
            EC.visibility_of_element_located((By.NAME, "password")))

        username_input.send_keys("eie39861@zbock.com")
        password_input.send_keys("trungdc123")

        login_button = wait.until(EC.element_to_be_clickable((By.CLASS_NAME, "btn-gradient")))
        login_button.click()
        wait.until(EC.url_to_be("https://thuocsi.pharex.vn/san-pham"))

        print("Đăng nhập thành công")
        time.sleep(3)
    except (NoSuchElementException, TimeoutException) as e:
        print("Đăng nhập thất bại hoặc sản phẩm đang tiến hành load")

    # Function to check if a product exists in the database
    def check_product_exist(cursor, product_name):
        cursor.execute("SELECT EXISTS(SELECT 1 FROM thuocsi_vn WHERE title = %s)", (product_name,))
        return cursor.fetchone()[0]


    if(int(trangnt)!=0):
        trangbt=int(trangnt)
        num_pages_to_scrape = (trangbt + 1)
    else :
        trangbt=1
        num_pages_to_scrape = 1000
    link = []

    # Scraping product links
    for page_num in range(trangbt, num_pages_to_scrape + 1):
        url = f"https://thuocsi.pharex.vn/products?page={page_num}"
        driver.get(url)

        ll = WebDriverWait(driver, 10).until(
            EC.presence_of_all_elements_located((By.CLASS_NAME, "text-decoration-none"))
        )

        for i in ll:
            lin = i.get_attribute('href')
            link.append(lin)

    for a in link:
        driver.get(a)
        try:
            WebDriverWait(driver, 15).until(
                EC.presence_of_element_located((By.CSS_SELECTOR, "h1.h3"))
            )
            ten = driver.find_element(By.CSS_SELECTOR, "h1.h3").text

            try:
                gia_element = driver.find_element(By.CSS_SELECTOR,
                                                '.product-card__old-price span')
                gia = gia_element.text
                gia = gia.replace('.', '').replace('đ', '')
                if gia.strip():
                    gia = int(gia)
                else:
                    gia = 0

            except NoSuchElementException:
                gia = None

            try:
                gia_sales_element = driver.find_element(By.CSS_SELECTOR,
                                                        '.product__price-group.mb-1 span')
                gia_sales = gia_sales_element.text
                gia_sales = gia_sales.replace('.', '').replace('đ', '')
                gia_sales = int(gia_sales)

            except NoSuchElementException:
                gia_sales = "0"
            if gia is None:
                gia = gia_sales

            try:
                nha_san_xuat_element = driver.find_element(By.XPATH, "//div[@class='text-capitalize']/a")
                nha_san_xuat = nha_san_xuat_element.text
            except NoSuchElementException:
                nha_san_xuat = 'Không đề cập'

            img_element = driver.find_element(By.CSS_SELECTOR, ".product-img-magnifier img")
            img_url = img_element.get_attribute("src")

            product_info_element = driver.find_element(By.CLASS_NAME, "MuiTypography-root")
            thong_tin_san_pham = product_info_element.text

            ingredient_name = ""
            ingredient_amount = ""

            table_rows = driver.find_elements(By.XPATH, "//table[@class='table table-bordered table-sm']/tbody/tr")

            tphl_list = []
            # cleaned_tphl_list = [tphl_list.replace("{", "").replace("}", "") for item in tphl_list]

            for row in table_rows:
                cells = row.find_elements(By.TAG_NAME, "td")
                if len(cells) == 2:
                    ingredient_name = cells[0].find_element(By.TAG_NAME, "a").text
                    ingredient_amount = cells[1].text
                    tphl = ingredient_name + "  " + ingredient_amount
                    tphl_list.append(tphl)

            table_element = driver.find_element(By.CLASS_NAME, "table-bordered")
            rows = table_element.find_elements(By.TAG_NAME, "tr")

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
                        gia_sales, thong_tin_san_pham, nha_san_xuat, 'Không đề cập', tphl_list, img_url, a,
                        gia_sales, ngay, 'thuocsi.pharex.vn', ten))
                else:
                    cursor.execute(f'''
                                    INSERT INTO thuocsi_vn (title, giamoi, ngaymoi, month_{current_month}, photo, nha_san_xuat,
                                    nuoc_san_xuat, hamluong_thanhphan, thong_tin_san_pham, link, nguon)
                                    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);
                                ''', (
                        ten, gia_sales, ngay, gia_sales, img_url, nha_san_xuat, 'Không đề cập',
                        tphl_list, thong_tin_san_pham, a, 'thuocsi.pharex.vn'))
                    connection.commit()

        except (NoSuchElementException, TimeoutException) as e:
            print("Cào sản phẩm thất bại")

    driver.quit()
caogia(sys.argv[1])