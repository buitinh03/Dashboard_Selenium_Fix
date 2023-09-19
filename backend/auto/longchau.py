import sys
import logging
try: 

    from selenium.common.exceptions import NoSuchElementException,ElementNotInteractableException,TimeoutException
    from selenium import webdriver
    import chromedriver_autoinstaller
    from selenium.webdriver.common.by import By
    import psycopg2
    from selenium.webdriver.support.ui import WebDriverWait
    import datetime
    from dotenv import load_dotenv
    from time import sleep
    from selenium.webdriver.support import expected_conditions as EC
    import os

    import codecs

    # from decouple import config

    if sys.stdout.encoding != 'utf-8':
        sys.stdout = codecs.getwriter('utf-8')(sys.stdout.buffer, 'strict')
        sys.stderr = codecs.getwriter('utf-8')(sys.stderr.buffer, 'strict')
    # Thiết lập hệ thống ghi log
    log_directory = os.getenv('LOG_DIRECTORY')

    log_filename = os.path.join(log_directory, 'scraping_log.log')

    # Tạo thư mục chứa tệp log nếu nó không tồn tại
    os.makedirs(os.path.dirname(log_filename), exist_ok=True)

    # Tạo một đối tượng FileHandler để ghi log vào tệp
    file_handler = logging.FileHandler(log_filename, mode="w", encoding=None, delay=False)

    # Thiết lập hệ thống ghi log
    logging.basicConfig(filename=log_filename, level=logging.INFO)

    chromedriver_autoinstaller.install()
    chrome_options = webdriver.ChromeOptions()
    chrome_options.add_argument("--headless")
    chrome_options.add_argument("--window-size=1920x1080")
    driver = webdriver.Chrome(options=chrome_options)
    url = "https://www.nhathuocankhang.com/"
    load_dotenv()
    try:
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
                    link TEXT primary key,
                    nguon TEXT DEFAULT 'longchau.vn'
                )
            ''')

        link_lists = [
            'trang-thiet-bi-y-te',
            'thuc-pham-chuc-nang',
            'duoc-my-pham',
            'cham-soc-ca-nhan',
            'thuoc/thuoc-thay-the',
            'thuoc/thuoc-chong-ung-thu',
            'thuoc/he-tiet-nieu-sinh-duc',
            'thuoc/di-ung-and-he-mien-dich',
            'thuoc/thuoc-dung-ngoai',
            'thuoc/he-co-xuong',
            'thuoc/vitamin-and-khoang-chat',
            'thuoc/he-tim-mach-and-tao-mau',
            'thuoc/thuoc-khang-sinh-duong-toan-than',
            'thuoc/he-than-kinh-trung-uong',
            'thuoc/he-tieu-hoa-and-gan-mat',
            'thuoc/hormon-noi-tiet-to',
            'thuoc/he-ho-hap',
            'thuoc/he-noi-tiet-and-chuyen-hoa',
            'thuoc/san-pham-dinh-duong',
            'thuoc/thuoc-giai-doc-khu-doc-va-ho-tro-cai-nghien',
            'thuoc/thuoc-da-lieu',
            'thuoc/thuoc-ngua-thai',
            'thuoc/mat',
            'cham-soc-ca-nhan/thiet-bi-lam-dep',
            'thuoc/tai-and-mieng-hong',
            'thuoc/thuoc-gay-me-gay-te-che-pham-dung-trong-phau-thuat-va-cham-soc-vet-thuong',
            'thuoc/dung-dich-tiem-tinh-mach-and-cac-loai-dung-dich-vo-trung-khac',
            'thuoc/san-pham-cham-soc-da-and-cham-soc-ca-nhan',
            'thuoc/chua-phan-loai',
            'thuoc/cac-san-pham-tri-lieu-khac',
            'thuoc/thuc-pham-bo-sung-and-cac-san-pham-ho-tro-suc-khoe',
            'thuoc/mieng-dan-cao-xoa-dau',
        ]
        wait = WebDriverWait(driver, 1)


        def extract_product_info():
            product_name_element = wait.until(
                EC.presence_of_element_located(
                    (By.CSS_SELECTOR, "h1.css-18o6y07")))
            product_name = product_name_element.text

            return product_name

        def check_product_exist(cursor, product_name):
            cursor.execute("SELECT EXISTS(SELECT 1 FROM thuocsi_vn WHERE title = %s)", (product_name,))
            return cursor.fetchone()[0]


        base_url = "https://nhathuoclongchau.com.vn"
        all_links = []

        for link_list in link_lists:
            full_url = f"{base_url}/{link_list}"
            driver.get(full_url)

            try:
                active_button = WebDriverWait(driver, 1).until(
                    EC.presence_of_element_located((By.CSS_SELECTOR, ".btn-wrapper > .active")))
                active_button.click()
            except (ElementNotInteractableException, NoSuchElementException, TimeoutException):
                pass

            while True:
                try:
                    view_more_button = WebDriverWait(driver, 0.5).until(
                        EC.presence_of_element_located((By.CSS_SELECTOR, "button.justify-center:nth-child(2)")))
                    if view_more_button.is_displayed():
                        view_more_button.click()
                        sleep(1)
                    else:
                        break
                except (NoSuchElementException, TimeoutException, ElementNotInteractableException):
                    break

            link_elements = driver.find_elements(By.CSS_SELECTOR, ".relative > .product-card > a")
            links = [link.get_attribute('href') for link in link_elements]
            all_links.extend(links)

            for a in all_links:
                driver.get(a)
                sleep(1)
                try:
                    product_name = ""

                    try:
                        html = driver.page_source
                        product_name = extract_product_info()
                    except NoSuchElementException:
                        pass

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

                    with connection.cursor() as cursor:
                        cursor.execute(f'''
                            INSERT INTO thuocsi_vn (title, giamoi, ngaymoi, month_{current_month}, photo, nha_san_xuat,
                            nuoc_san_xuat, hamluong_thanhphan, thong_tin_san_pham, link, nguon, giacu, ngaycu)
                            VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, NULL, NULL)
                            ON CONFLICT (link) DO UPDATE
                                SET month_{current_month} = excluded.month_{current_month},
                                thong_tin_san_pham = excluded.thong_tin_san_pham,
                                nha_san_xuat = excluded.nha_san_xuat,
                                nuoc_san_xuat = excluded.nuoc_san_xuat,
                                hamluong_thanhphan = excluded.hamluong_thanhphan,
                                photo = excluded.photo,
                                giacu = thuocsi_vn.giamoi,
                            ngaycu = thuocsi_vn.ngaymoi,
                            giamoi='{gia_sales}',
                            ngaymoi='{ngay}';
                        ''', (
                            product_name, gia_sales, ngay, gia_sales, photo, nha_san_xuat, nuoc_san_xuat, hamluong_thanhphan, thong_tin_san_pham, a, 'longchau.vn'))
                        connection.commit()

                except Exception as e:
                    logging.error(f"Error scraping product: {str(e)}")
            
            driver.quit()
        
    except Exception as e:
        logging.error(f"Unhandled Exception: {str(e)}")
except Exception as e:
    sys.stderr.write(str(e)+'\n')
    sys.exit(1)
