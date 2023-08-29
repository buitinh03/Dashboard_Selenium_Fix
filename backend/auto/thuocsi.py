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
import json
import codecs

def caogia(trangnt):
    if sys.stdout.encoding != 'utf-8':
        sys.stdout = codecs.getwriter('utf-8')(sys.stdout.buffer, 'strict')
        sys.stderr = codecs.getwriter('utf-8')(sys.stderr.buffer, 'strict')

    chromedriver_autoinstaller.install()
    chrome_options = webdriver.ChromeOptions()
    # chrome_options.add_argument("--headless")
    chrome_options.add_argument("--window-size=1920x1080")
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
            CREATE TABLE IF NOT EXISTS thuocsi_vn90 (
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

        username_input.send_keys("0332790644")
        password_input.send_keys("abc")

        login_button = wait.until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, ".styles_btn_register__zCg7F > .MuiButton-label")))
        login_button.click()

        wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, ".styles_root__yHa_F > .styles_tab_panel__NAwAa")))
    except (NoSuchElementException, TimeoutException) as e:
        print("Đăng nhập thành công ")
        print("Vui lòng đợi, sản phẩm đang tiến hành load")
        connection.commit()


    def extract_product_info(html):
        soup = BeautifulSoup(html, 'html.parser')

        manufacturer = ""
        country_of_origin = ""
        product_info = ""

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


    
    path_data_mapping = {
                        "3": "M46.75 344.5C24.4167 329.5 8.91667 307.167 0.25 277.5L51.75 256.5C56.75 275.167 65.0833 289.333 76.75 299C88.75 309 103.25 314 120.25 314C137.583 314 152.583 308.667 165.25 298C177.917 287.333 184.25 273.833 184.25 257.5C184.25 241.167 177.583 227.667 164.25 217C151.583 206.667 134.917 201.5 114.25 201.5H84.25V150.5H111.75C128.75 150.5 143.083 146 154.75 137C166.083 128 171.75 115.333 171.75 99C171.75 84.6667 166.583 73.3333 156.25 65C145.583 56.3333 132.417 52 116.75 52C101.083 52 88.5833 56.1667 79.25 64.5C69.9167 72.8333 63.25 83.1667 59.25 95.5L8.75 74.5C15.75 55.1667 28.4167 38 46.75 23C65.0833 8 88.4167 0.5 116.75 0.5C137.417 0.5 156.583 4.66667 174.25 13C190.25 20.6667 203.25 32 213.25 47C222.917 61.6667 227.75 77.8333 227.75 95.5C227.75 113.833 223.25 129.5 214.25 142.5C205.583 154.833 194.583 164.667 181.25 172V174.5C197.583 181.167 211.583 192.167 223.25 207.5C234.25 221.833 239.75 239.333 239.75 260C239.75 281 234.583 299.333 224.25 315C213.25 332 198.917 344.833 181.25 353.5C163.25 362.5 142.917 367 120.25 367C93.5833 367 69.0833 359.5 46.75 344.5Z",
                        "0": "M143.75 367C114.75 367 89.5833 359 68.25 343C46.9167 327 30.25 305.167 18.25 277.5C6.25 249.5 0.25 218.333 0.25 184C0.25 149.667 6.25 118.5 18.25 90.5C30.25 62.1667 46.9167 40.1667 68.25 24.5C89.5833 8.5 114.75 0.5 143.75 0.5C172.083 0.5 197.25 8.5 219.25 24.5C240.917 40.1667 257.75 62.1667 269.75 90.5C281.75 118.5 287.75 149.667 287.75 184C287.75 218.333 281.75 249.5 269.75 277.5C257.75 305.5 240.917 327.333 219.25 343C197.25 359 172.083 367 143.75 367ZM143.75 315C161.75 315 177.417 309.333 190.75 298C204.083 286.667 214.25 271 221.25 251C228.25 231 231.75 208.667 231.75 184C231.75 159 228.25 136.5 221.25 116.5C214.25 96.5 204.083 80.8333 190.75 69.5C177.75 58.5 162.083 53 143.75 53C125.083 53 109.583 58.5 97.25 69.5C84.25 81.1667 74.25 96.8333 67.25 116.5C60.25 136.5 56.75 159 56.75 184C56.75 208.667 60.25 231 67.25 251C74.25 270.667 84.25 286.333 97.25 298C109.917 309.333 125.417 315 143.75 315Z",
                        "5": "M121.25 358C103.917 358 86.9167 354.5 70.25 347.5C53.5833 340.5 39.0833 330 26.75 316C14.0833 301.667 5.25 284.167 0.25 263.5L49.75 244C54.75 262.667 63.25 277.833 75.25 289.5C86.9167 300.833 102.083 306.5 120.75 306.5C140.083 306.5 156.083 300.333 168.75 288C181.75 275.333 188.25 259.333 188.25 240C188.25 220.333 182.083 204.167 169.75 191.5C157.417 178.833 141.25 172.5 121.25 172.5C109.917 172.5 99.4167 175 89.75 180C79.4167 185.667 71.4167 192.333 65.75 200L11.75 176L32.75 0H221.75V50H78.25L64.75 144L67.75 144.5C86.4167 129.833 107.75 122.5 131.75 122.5C151.75 122.5 170.25 127.5 187.25 137.5C204.583 147.833 218.25 161.667 228.25 179C238.25 196.333 243.25 216.5 243.25 239.5C243.25 262.5 238.083 282.833 227.75 300.5C217.083 318.833 202.417 333 183.75 343C165.417 353 144.583 358 121.25 358Z",
                        "6": "M123.25 368C99.5833 368 78.25 362.5 59.25 351.5C40.25 340.5 25.75 325.833 15.75 307.5C5.41667 288.5 0.25 268.833 0.25 248.5C0.25 228.833 4.25 209.667 12.25 191C20.5833 171.333 32.25 151 47.25 130L135.75 0.5L178.75 30.5L99.25 143L101.25 145C111.25 139.333 123.083 136.5 136.75 136.5C155.417 136.5 172.75 141.333 188.75 151C205.75 161.333 219.25 175 229.25 192C239.583 209.667 244.75 229 244.75 250C244.75 271 239.083 290.833 227.75 309.5C216.75 327.5 201.917 341.833 183.25 352.5C164.917 362.833 144.917 368 123.25 368ZM156.25 308.5C166.917 302.5 175.25 294.5 181.25 284.5C187.25 274.5 190.25 263.167 190.25 250.5C190.25 237.5 187.25 226 181.25 216C175.25 206 166.917 198 156.25 192C146.25 186.333 135.083 183.5 122.75 183.5C110.417 183.5 99.25 186.333 89.25 192C78.5833 198 70.25 206 64.25 216C58.25 226 55.25 237.5 55.25 250.5C55.25 263.167 58.25 274.5 64.25 284.5C70.25 294.5 78.5833 302.5 89.25 308.5C99.25 314.167 110.417 317 122.75 317C135.083 317 146.25 314.167 156.25 308.5Z",
                        "1": "M85.5 74L28 115L0 72.5L101.5 0H141V350H85.5V74Z",
                        "7": "M17 332.5L171.5 53.5L170.5 52H0V0H232V55L64.5 358L17 332.5Z",
                        "9": "M66.25 338.5L146.25 226L144.25 224C134.25 229.667 122.25 232.5 108.25 232.5C90.25 232.5 73.0833 227.5 56.75 217.5C39.75 207.167 26.0833 193.667 15.75 177C5.41667 160.333 0.25 141 0.25 119C0.25 97.3333 5.75 77.5 16.75 59.5C27.75 41.5 42.5833 27.1667 61.25 16.5C79.9167 5.83333 100.083 0.5 121.75 0.5C146.083 0.5 167.417 6 185.75 17C204.75 28.3333 219.25 43.1667 229.25 61.5C239.583 80.5 244.75 100.167 244.75 120.5C244.75 139.5 240.583 158.667 232.25 178C224.25 196.667 212.583 216.833 197.25 238.5L109.25 368L66.25 338.5ZM122.75 185.5C134.417 185.5 145.583 182.5 156.25 176.5C166.917 170.5 175.25 162.5 181.25 152.5C187.25 142.5 190.25 131.167 190.25 118.5C190.25 105.833 187.25 94.5 181.25 84.5C175.25 74.5 166.917 66.5 156.25 60.5C146.25 54.8333 135.083 52 122.75 52C110.417 52 99.25 54.8333 89.25 60.5C78.5833 66.5 70.25 74.5 64.25 84.5C58.25 94.5 55.25 105.833 55.25 118.5C55.25 131.167 58.25 142.5 64.25 152.5C70.25 162.5 78.5833 170.5 89.25 176.5C99.9167 182.5 111.083 185.5 122.75 185.5Z",
                        "4": "M165.25 280H0.25V237L160.75 0H219.75V228.5H264.25V280H219.75V350H165.25V280ZM165.25 228.5V81H162.25L62.25 228.5H165.25Z",
                        "8": "M123 367C99 367 77.8333 362.5 59.5 353.5C41.1667 344.5 26.6667 331.833 16 315.5C5.33333 299.167 0 281.333 0 262C0 242.667 5.16667 225.667 15.5 211C25.8333 196 39.5 184.167 56.5 175.5V173C44.1667 165.333 33.5 154.667 24.5 141C16.1667 128.333 12 114.333 12 99C12 80 16.6667 63.1667 26 48.5C35.3333 33.8333 48.6667 22.1667 66 13.5C83.3333 4.83333 102.333 0.5 123 0.5C143.333 0.5 162.167 4.83333 179.5 13.5C196.5 21.8333 209.667 33.5 219 48.5C228.667 63.8333 233.5 80.6667 233.5 99C233.5 113.333 229.333 127.333 221 141C212.667 154.667 202.167 165.333 189.5 173V175.5C205.167 183.5 218.5 195.333 229.5 211C240.167 226.333 245.5 243.333 245.5 262C245.5 281.333 240.167 299.167 229.5 315.5C218.833 331.833 204.167 344.5 185.5 353.5C167.167 362.5 146.333 367 123 367ZM123 151C139 151 152.333 146.333 163 137C173.667 127.667 179 115.5 179 100.5C179 85.1667 173.667 73.1667 163 64.5C152.333 55.8333 139 51.5 123 51.5C106.333 51.5 92.6667 55.8333 82 64.5C71.3333 73.1667 66 85.1667 66 100.5C66 115.5 71.3333 127.667 82 137C92.6667 146.333 106.333 151 123 151ZM170.5 299.5C183.167 288.5 189.5 274.5 189.5 257.5C189.5 240.833 183.167 227.167 170.5 216.5C158.167 206.167 142.333 201 123 201C103.667 201 87.6667 206.167 75 216.5C62.3333 226.833 56 240.5 56 257.5C56 274.833 62.3333 288.833 75 299.5C87.6667 310.167 103.667 315.5 123 315.5C142.667 315.5 158.5 310.167 170.5 299.5Z",
                        "2": "M1.75 307C64.4167 244.667 107.083 201.167 129.75 176.5C145.417 160.5 155.75 147.833 160.75 138.5C166.083 128.833 168.75 117.167 168.75 103.5C168.75 89.8333 163.583 78 153.25 68C142.583 58 128.417 53 110.75 53C94.0833 53 80.9167 57.6667 71.25 67C61.25 76.3333 54.25 87.3333 50.25 100L0.75 79.5C4.08333 67.1667 10.5833 55 20.25 43C29.5833 31 42.0833 21 57.75 13C73.75 4.66667 91.75 0.5 111.75 0.5C133.417 0.5 153.083 5.16667 170.75 14.5C187.417 23.1667 200.583 35.5 210.25 51.5C219.917 67.1667 224.75 84 224.75 102C224.75 138.667 206.083 175.667 168.75 213L118.25 264L74.75 307.5L75.25 309H228.75V359H1.75V307Z",
                        ".": "M66 130C47.3333 130 31.6667 123.667 19 111C6.33333 98.3333 0 83 0 65C0 47 6.33333 31.6667 19 19C31.6667 6.33333 47.3333 0 66 0C84 0 99.3333 6.33333 112 19C124.667 31.6667 131 47 131 65C131 83 124.667 98.3333 112 111C99.3333 123.667 84 130 66 130Z",
                        "đ": "M592 142H528V733H425V663H419C405 685.667 382.667 706 352 724C323.333 740.667 289.667 749 251 749C202.333 749 159.667 737.333 123 714C85 690 55 657 33 615C11 573 0 525.333 0 472C0 418.667 11 371 33 329C55 287 85 254 123 230C161 206 203.667 194 251 194C289.667 194 323.333 202.333 352 219C382.667 237 405 257.667 419 281H425L419 212V142H269V61H419V0H528V61H592V142ZM344 626C369.333 610 389 589.333 403 564C417.667 537.333 425 506.667 425 472C425 437.333 417.667 406.667 403 380C389 354.667 369.333 334 344 318C320.667 303.333 295 296 267 296C239 296 213.333 303.333 190 318C164.667 334 145 354.667 131 380C116.333 406.667 109 437.333 109 472C109 506.667 116.333 537.333 131 564C145 589.333 164.667 610 190 626C213.333 640.667 239 648 267 648C295 648 320.667 640.667 344 626Z"
                        }

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
        cursor.execute("SELECT EXISTS(SELECT 1 FROM thuocsi_vn90 WHERE title = %s)", (product_name,))
        return cursor.fetchone()[0]


    # Thêm các sản phẩm vào cơ sở dữ liệu với giá mới lưu vào tháng hiện tại
    for a in link:
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
            # sales_in_last_24_hours = ""
            product_name = ""
            nguon = "thuocsi.vn"

            try:
                html = driver.page_source
                nha_san_xuat, nuoc_san_xuat, tphl, thong_tin_san_pham, product_name = extract_product_info(
                    html)
            except NoSuchElementException:
                pass

            try:
                ten = driver.find_element(By.CSS_SELECTOR, 'p.titleProduct,p.styles_last_breadcrumb__c7IQm').text
            except NoSuchElementException:
                ten = ""

            try:
                driver.implicitly_wait(1)

                container = driver.find_element(By.CSS_SELECTOR,
                                                ".styles_deal_price__HiSOK")
                matched_chars = []

                svg_elements = container.find_elements(By.TAG_NAME, 'svg')

                for svg in svg_elements:
                    path_elements = svg.find_elements(By.TAG_NAME, 'path')

                    for path in path_elements:
                        d = path.get_attribute('d')
                        if d:
                            matched_char = None
                            for char, path_data in path_data_mapping.items():
                                if d == path_data:
                                    matched_char = char
                                    break

                            if matched_char:
                                matched_chars.append(matched_char)

                if matched_chars:
                    matched_text = ''.join(matched_chars)
                    if 'Ä' in matched_text:
                        price = matched_text.replace('Ä‘', '').replace('.', '')
            except NoSuchElementException:
                price = ""

            try:
                anh = driver.find_element(By.CSS_SELECTOR, 'img.styles_imageMain__UQ9fH').get_attribute('src')
            except NoSuchElementException:
                anh = "Không đề cập"

            current_month = datetime.datetime.now().month

            with connection.cursor() as cursor:
                if check_product_exist(cursor, product_name):

                    cursor.execute(f'''
                        UPDATE thuocsi_vn90
                        SET photo = %s, nha_san_xuat = %s, nuoc_san_xuat = %s, thong_tin_san_pham = %s, hamluong_thanhphan = %s,
                            month_{current_month} = %s, link = %s,
                            giacu = giamoi, ngaycu = ngaymoi, giamoi = %s, ngaymoi = %s
                        WHERE title = %s;
                    ''', (
                        anh, nha_san_xuat, nuoc_san_xuat, thong_tin_san_pham, tphl, price, a,
                        price, ngay, product_name))
                else:
                    cursor.execute(f'''
                        INSERT INTO thuocsi_vn90 (title, giamoi, ngaymoi, photo, nha_san_xuat, nuoc_san_xuat, 
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