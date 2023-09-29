from selenium.common.exceptions import NoSuchElementException, TimeoutException
from selenium import webdriver
import chromedriver_autoinstaller
from selenium.webdriver.common.by import By
import psycopg2
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import datetime
import sys
import os
import codecs
import logging  
from dotenv import load_dotenv
from PIL import Image
import pytesseract
load_dotenv()
# pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'  # Điều chỉnh đường dẫn dựa trên cài đặt của bạn
pytesseract.pytesseract.tesseract_cmd = os.getenv('TESSERACT_CMD')
# Thiết lập hệ thống ghi log
log_directory = os.getenv('LOG_DIRECTORY')

log_filename = os.path.join(log_directory, 'scraping_log.log')

# Tạo thư mục chứa tệp log nếu nó không tồn tại
os.makedirs(os.path.dirname(log_filename), exist_ok=True)

# Tạo một đối tượng FileHandler để ghi log vào tệp
file_handler = logging.FileHandler(log_filename, mode="w", encoding=None, delay=False)

# Thiết lập hệ thống ghi log
logging.basicConfig(filename=log_filename, level=logging.INFO)

# Kiểm tra và thiết lập mã hóa cho sys.stdout và sys.stderr
if sys.stdout.encoding != 'utf-8':
    sys.stdout = codecs.getwriter('utf-8')(sys.stdout.buffer, 'strict')
    sys.stderr = codecs.getwriter('utf-8')(sys.stderr.buffer, 'strict')

# Tự động cài đặt ChromeDriver
chromedriver_autoinstaller.install()
chrome_options = webdriver.ChromeOptions()
chrome_options.add_argument("--headless")
chrome_options.add_argument("--window-size=1920x1080")
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
            link TEXT primary key,
            nguon TEXT DEFAULT 2
        )
    ''')
    connection.commit()

driver.get(url)
try:
    wait = WebDriverWait(driver, 3)
    click_login = wait.until(EC.element_to_be_clickable(
        (By.CSS_SELECTOR, ".MuiGrid-root:nth-child(1) > .styles_link__t2Gkc > .MuiTypography-root")))
    click_login.click()

    username_input = wait.until(
        EC.visibility_of_element_located((By.CSS_SELECTOR, ".MuiFormControl-root:nth-child(1) .MuiInputBase-input")))
    password_input = wait.until(
        EC.visibility_of_element_located((By.CSS_SELECTOR, "input.MuiInputBase-inputAdornedEnd")))

    username_input.send_keys(os.getenv('USERNAMET'))
    password_input.send_keys(os.getenv('PASSWORD'))

    login_button = wait.until(
        EC.element_to_be_clickable((By.CSS_SELECTOR, ".styles_btn_login__jK984 > .MuiButton-label")))
    login_button.click()

    wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, ".styles_root__yHa_F > .styles_tab_panel__NAwAa")))
except (NoSuchElementException, TimeoutException) as e:
    logging.info("Đăng nhập thành công")
    logging.info("Vui lòng đợi, sản phẩm đang tiến hành load")
    connection.commit()


def extract_product_info():
    product_name_element = wait.until(
        EC.presence_of_element_located((By.CSS_SELECTOR, "p.MuiTypography-root.styles_typographyTitle__RTV69.MuiTypography-body1")))
    product_name = product_name_element.text
    return product_name


def check_product_exist(cursor, product_name):
    cursor.execute("SELECT EXISTS(SELECT 1 FROM thuocsi_vn WHERE title = %s)", (product_name,))
    return cursor.fetchone()[0]


# List các link sản phẩm

product_links = sys.argv[1:]

for link in product_links:
    try:
        ngay = datetime.datetime.now()
        link = link.replace("/loading", "")
        driver.get(link)
        ten = ""
        price = ""
        img_url = ""
        nha_san_xuat = ""
        nuoc_san_xuat = ""
        tphl = "Không đề cập"
        thong_tin_san_pham = "Không đề cập"
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
            button_element = driver.find_element(By.CLASS_NAME, 'MuiButtonBase-root.openImg')
            img_element = button_element.find_element(By.CSS_SELECTOR, 'img[q="100"]')
            img_url = img_element.get_attribute('src')
        except NoSuchElementException:
            img_url = "Không đề cập"

        try:
            element = driver.find_element(By.CSS_SELECTOR,
                                          "p.MuiTypography-root.styles_typographyTitle__RTV69.MuiTypography-body1")
            ten = element.text
        except NoSuchElementException:
            ten = "Không đề cập"

        # Trích xuất giá từ thẻ canvas
        try:
            canvas = driver.find_element(By.XPATH, "//canvas[@class='styles_canvasPrice__vw932']")
            canvas.screenshot("canvas.png")
            image = Image.open("canvas.png")
            price = pytesseract.image_to_string(image).strip()
            price = price.replace('.', '').replace('d', '')
        except NoSuchElementException:
            price = "Không đề cập"

        try:
            div_elementt = driver.find_element(By.CLASS_NAME, "styles_content__aW6Pn")
            thong_tin_san_pham = div_elementt.text
        except NoSuchElementException:
            thong_tin_san_pham = "Không đề cập"
        if thong_tin_san_pham == "":
            thong_tin_san_pham = "Không đề cập"

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
            tt = driver.find_elements(By.CSS_SELECTOR, "div.styles_rightContent__u_m01")
            tphl = []  # Create an empty list to store the text of each element

            for element in tt:
                tphl.append(element.text.replace("Thành phần", "").strip().replace("\n", " "))
        except NoSuchElementException:
            tphl = ["Không đề cập"]
        if all(not item.strip() for item in tphl):
            tphl = ["Không đề cập"]

        current_month = datetime.datetime.now().month
        logging.info(f"Link : {link}")
        logging.info(f"Gia : {price}")
        with connection.cursor() as cursor:
            cursor.execute(f'''
                INSERT INTO thuocsi_vn (title, giamoi, ngaymoi, month_{current_month}, photo, nha_san_xuat,
                nuoc_san_xuat, hamluong_thanhphan, thong_tin_san_pham, link, nguon, giacu, ngaycu)
                VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, NULL, NULL)
                ON CONFLICT (link) DO UPDATE
                    SET month_{current_month} = excluded.month_{current_month},
                    title = excluded.title,
                    thong_tin_san_pham = excluded.thong_tin_san_pham,
                    nha_san_xuat = excluded.nha_san_xuat,
                    nuoc_san_xuat = excluded.nuoc_san_xuat,
                    hamluong_thanhphan = excluded.hamluong_thanhphan,
                    photo = excluded.photo,
                    giacu = thuocsi_vn.giamoi,
                    ngaycu = thuocsi_vn.ngaymoi,
                    giamoi='{price}',
                    ngaymoi='{ngay}';
            ''', (
                product_name, price, ngay, price, img_url, nha_san_xuat, nuoc_san_xuat, tphl, thong_tin_san_pham, link, 'thuocsi.vn'))
            connection.commit()
    except Exception as e:
        logging.error(f"Loi khi scraping san pham: {str(e)}")
driver.quit()
