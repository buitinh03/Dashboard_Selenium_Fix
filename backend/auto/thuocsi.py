from selenium.common.exceptions import NoSuchElementException, TimeoutException
from selenium import webdriver
import chromedriver_autoinstaller
from selenium.webdriver.common.by import By
import psycopg2
from bs4 import BeautifulSoup
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import datetime
from dotenv import load_dotenv
import os
import sys
import codecs

def caogia(trangnt):
    if sys.stdout.encoding != 'utf-8':
        sys.stdout = codecs.getwriter('utf-8')(sys.stdout.buffer, 'strict')
        sys.stderr = codecs.getwriter('utf-8')(sys.stderr.buffer, 'strict')

    chromedriver_autoinstaller.install()
    chrome_options = webdriver.ChromeOptions()
    #chrome_options.add_argument("--headless")
    chrome_options.add_argument("--window-size=5120x2880")
    driver = webdriver.Chrome(options=chrome_options)
    url = "https://thuocsi.vn/products"
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
            CREATE TABLE IF NOT EXISTS thuocsi_vn30 (
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

        username_input.send_keys("0903119308")
        password_input.send_keys("123")

        login_button = wait.until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, ".styles_btn_register__zCg7F > .MuiButton-label")))
        login_button.click()

        wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, ".styles_root__yHa_F > .styles_tab_panel__NAwAa")))
    except (NoSuchElementException, TimeoutException) as e:
        print("Đăng nhập thành công ")
        print("Vui lòng đợi, sản phẩm đang tiến hành load")
        connection.commit()


    def extract_product_info():

        product_name_element = wait.until(
            EC.presence_of_element_located((By.CSS_SELECTOR, "p.MuiTypography-root.styles_typographyTitle__RTV69.MuiTypography-body1")))
        product_name = product_name_element.text

        return product_name

    if(int(trangnt)!=0):
        trangbt=int(trangnt)
        num_pages_to_scrape = (trangbt + 9)
    else :
        trangbt=1
        num_pages_to_scrape = 1000
    link = []

    for page_num in range(trangbt, num_pages_to_scrape + 1):
        url = f"https://thuocsi.vn/products?page={page_num}"
        driver.get(url)

        html = driver.page_source
        soup = BeautifulSoup(html, 'html.parser')

        search_info_div = soup.find("div", class_="style_search_result__5jWKu")

        if search_info_div and "0 sản phẩm tìm kiếm" in search_info_div.get_text():
            break
        l = driver.find_elements(By.CSS_SELECTOR,
                                ".style_product_grid_wrapper__lYnBj > .MuiGrid-root > div span > .styles_mobile_rootBase__8z7PQ")
        for i in l:
            lin = i.get_attribute('href')
            link.append(lin)


    def check_product_exist(cursor, product_name):
        cursor.execute("SELECT EXISTS(SELECT 1 FROM thuocsi_vn30 WHERE title = %s)", (product_name,))
        return cursor.fetchone()[0]


    for a in link:
        # wait = WebDriverWait(driver, 1)
        try:
            ngay = datetime.datetime.now()
            a = a.replace("/loading", "")
            driver.get(a)
            ten = ""
            price = ""
            anh = ""
            nha_san_xuat = ""
            nuoc_san_xuat = ""
            tphl = ""
            thong_tin_san_pham = ""
            product_name = ""
            nguon = "thuocsi.vn"

            try:
                html = driver.page_source
                product_name = extract_product_info()
            except NoSuchElementException:
                pass

            try:
                button = driver.find_element(By.CSS_SELECTOR, ".MuiButtonBase-root.styles_understand__4QQn9")
                button.click()
            except NoSuchElementException:
                pass
            try:
                wait.until(EC.presence_of_element_located(
                    (By.CSS_SELECTOR, "p.MuiTypography-root.styles_typographyTitle__RTV69.MuiTypography-body1")))
            except NoSuchElementException:
                pass

            try:
                button_element = driver.find_element(By.CLASS_NAME, 'MuiButtonBase-root.openImg')
                img_element = button_element.find_element(By.CSS_SELECTOR, 'img[q="100"]')
                img_url = img_element.get_attribute('src')
            except NoSuchElementException:
                anh = "Không đề cập"

            try:
                element = driver.find_element(By.CSS_SELECTOR,
                                            "p.MuiTypography-root.styles_typographyTitle__RTV69.MuiTypography-body1")
                ten = element.text
            except NoSuchElementException:
                ten = "Không đề cập"

            try:
                price_element = driver.find_element(By.CSS_SELECTOR,
                                                    ".MuiTypography-root.styles_price__uDwZz.MuiTypography-body1")
                price = price_element.text
            except NoSuchElementException:
                price = "0"

            try:
                div_element = driver.find_element(By.CLASS_NAME, "styles_content__aW6Pn")

                thong_tin_san_pham = div_element.text
            except NoSuchElementException:
                pass

            try:
                div_element = driver.find_element(By.XPATH, "//div[p[contains(text(), 'Nước sản xuất:')]]")

                nuoc_element = div_element.find_element(By.XPATH,
                                                        ".//p[contains(text(), 'Nước sản xuất:')]/following-sibling::p")
                nuoc_san_xuat = nuoc_element.text.strip()

            except NoSuchElementException:
                nuoc_san_xuat = "Không đề cập"
            try:
                div_element = driver.find_element(By.XPATH, "//div[p[contains(text(), 'Nhà sản xuất:')]]")

                nsx_element = div_element.find_element(By.XPATH,
                                                        ".//p[contains(text(), 'Nhà sản xuất:')]/following-sibling::p")
                nha_san_xuat = nsx_element.text.strip()
            except NoSuchElementException:
                nha_san_xuat = "Không đề cập"

            try:
                div_element = driver.find_element(By.XPATH, "//div[p[contains(text(), 'Thành phần')]]")

                ingredient_elements = div_element.find_elements(By.CLASS_NAME, "styles_groupIngredient__rOY1E")

                for ingredient_element in ingredient_elements:
                    ingredient_name_element = ingredient_element.find_element(By.CLASS_NAME, "styles_ingredient__Qgn8x")
                    ingredient_name = ingredient_name_element.text.strip()

                    # Trích xuất hàm lượng
                    ingredient_volume_element = ingredient_element.find_element(By.CLASS_NAME,
                                                                                "styles_ingredientVolume__HGQOW")
                    ingredient_volume = ingredient_volume_element.text.strip()

                    # Gộp thành thành phần hàm lượng
                    tphl = f"{ingredient_name}: {ingredient_volume}"
            except NoSuchElementException:
                tphl = "Không đề cập"

            current_month = datetime.datetime.now().month

            with connection.cursor() as cursor:
                if check_product_exist(cursor, product_name):

                    cursor.execute(f'''
                        UPDATE thuocsi_vn30
                        SET photo = %s, nha_san_xuat = %s, nuoc_san_xuat = %s, thong_tin_san_pham = %s, hamluong_thanhphan = %s,
                            month_{current_month} = %s, link = %s,
                            giacu = giamoi, ngaycu = ngaymoi, giamoi = %s, ngaymoi = %s
                        WHERE title = %s;
                    ''', (
                        anh, nha_san_xuat, nuoc_san_xuat, thong_tin_san_pham, tphl, price, a,
                        price, ngay, product_name))
                else:
                    cursor.execute(f'''
                        INSERT INTO thuocsi_vn30 (title, giamoi, ngaymoi, photo, nha_san_xuat, nuoc_san_xuat, 
                        thong_tin_san_pham, hamluong_thanhphan, month_{current_month}, link,nguon)
                        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s);
                    ''', (
                        product_name, price, ngay, anh, nha_san_xuat, nuoc_san_xuat, thong_tin_san_pham, tphl
                        , price, a, nguon))
                connection.commit()
        except Exception as e:
            print("Lỗi khi scraping sản phẩm:", str(e))

    connection.close()
    driver.quit()
caogia(sys.argv[1])