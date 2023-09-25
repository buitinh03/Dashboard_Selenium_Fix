import sys
import logging
import scrapy
import psycopg2
import datetime
import os
from dotenv import load_dotenv 

import codecs
from scrapy.crawler import CrawlerProcess

load_dotenv()
# Thiết lập hệ thống ghi log
log_directory = os.getenv('LOG_DIRECTORY')

log_filename = os.path.join(log_directory, 'scraping_log.log')

# Tạo thư mục chứa tệp log nếu nó không tồn tại
os.makedirs(os.path.dirname(log_filename), exist_ok=True)

# Tạo một đối tượng FileHandler để ghi log vào tệp
file_handler = logging.FileHandler(log_filename, mode="w", encoding=None, delay=False)

# Thiết lập hệ thống ghi log
logging.basicConfig(filename=log_filename, level=logging.INFO)


if sys.stdout.encoding != 'utf-8':
    sys.stdout = codecs.getwriter('utf-8')(sys.stdout.buffer, 'strict')
    sys.stderr = codecs.getwriter('utf-8')(sys.stderr.buffer, 'strict')

class LaptopSpider(scrapy.Spider):
    try:
        name = "chosithuoc"
        host = os.environ.get('DB_HOST')
        port = os.environ.get('DB_PORT')
        database = os.environ.get('DB_NAME')
        user = os.environ.get('DB_USER')
        password = os.environ.get('DB_PASSWORD')

        conn_str = f"host='{host}' port='{port}' dbname='{database}' user='{user}' password='{password}'"
        connection = psycopg2.connect(conn_str)
        cursor = connection.cursor()

        def create_table(self):
            query = '''
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
                nguon TEXT DEFAULT 'chosithuoc.com'
            )
            '''
            self.cursor.execute(query)
            self.connection.commit()
        logging.info(f"Đăng nhập thành công CHOSITHUOC")


        def start_requests(self):
            categories = {
                'hoa-my-pham': 80,
                'thuoc-tan-duoc': 350,
                'thuoc-xuong-khop': 40,
                'thuoc-giam-can': 20,
                'thuoc-bo-than': 30,
                'thuc-pham-chuc-nang': 140,
                'thuc-pham-cao-cap': 20,
                'thiet-bi-y-te': 40,
                'thuoc-khong-ke-don': 10,
            }

            for category, num_pages in categories.items():
                for page_number in range(1, num_pages + 1):
                    category_url = f'https://chosithuoc.com/{category}-trang-{page_number}/'
                    yield scrapy.Request(url=category_url, callback=self.parse_page,
                                        meta={'page_number': page_number, 'category': category})

        def check_product_exist(self, product_link):
            query = "SELECT EXISTS (SELECT 1 FROM thuocsi_vn WHERE link = %s)"
            self.cursor.execute(query, (product_link,))
            return self.cursor.fetchone()[0]

        def parse_page(self, response):
            if response.status == 200:
                info_divs = response.css('.itemsanpham')

                for info_div in info_divs:
                    name = info_div.css('.tieude a::text').get()
                    gia = info_div.css('.gia::text').get()
                    number = info_div.css('.masp_hover_masp::text').getall()
                    number = ' '.join(value.strip() for value in number if value.strip())
                    img_url = info_div.css('.img a img::attr(src)').get()

                    # Trích xuất thông tin từ trang chi tiết sản phẩm
                    detail_url = info_div.css('.tieude a::attr(href)').get()

                    # Kiểm tra trạng thái của trang chi tiết trước khi tạo yêu cầu mới
                    if detail_url:
                        yield scrapy.Request(url=detail_url, callback=self.parse_detail,
                                            meta={'name': name, 'gia': gia, 'number': number, 'img_url': img_url})

            # Xác định trang tiếp theo và tạo yêu cầu để duyệt qua các trang khác
            next_page = response.css('ul.pagination a[rel="next"]::attr(href)').get()
            if next_page:
                yield scrapy.Request(url=next_page, callback=self.parse_page,
                                    meta={'page_number': response.meta['page_number'] + 1, 'category': response.meta['category']})

        def parse_detail(self, response):
            name = response.meta.get('name')
            giacu_text = response.meta.get('gia')
            if giacu_text == '' or giacu_text == 'Liên hệ':
                giacu = '0'
            else:
                giacu = giacu_text.replace('đ', '').replace(',', '')

            img_url = response.meta.get('img_url')
            ngay_moi = datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S')

            thanh_phan_xpath = '//h2[contains(., "Thành phần")]/following-sibling::ul[1]/li//text()'
            hamluong_thanhphan = response.xpath(thanh_phan_xpath).getall()
            hamluong_thanhphan = ' '.join(tp.strip() for tp in hamluong_thanhphan if tp.strip() and tp.strip() != '…………………………………………………………………')
            hamluong_thanhphan = hamluong_thanhphan.replace('…………………………………………………………………', '').replace('.............................', '').replace('….', '').replace('.................', '').replace('……………………………………','.....')

            nha_san_xuat = response.css('td:contains("Thương hiệu") + td a::text').get()
            if nha_san_xuat:
                nha_san_xuat = nha_san_xuat.strip().replace(";", "").replace("\n", "").replace("\t", "").replace("\r", "")
            else:
                nha_san_xuat = 'Không đề cập'

            nuoc_san_xuat = response.css('td:contains("Xuất xứ") + td a::text').get()
            if nuoc_san_xuat:
                nuoc_san_xuat = nuoc_san_xuat.strip().replace(";", "").replace("\n", "").replace("\t", "").replace("\r", "")
            else:
                nuoc_san_xuat = 'Không đề cập'

            thong_tin = response.css('div.row_noidung li::text').getall()
            thong_tin = [item.strip().replace(";", "").replace("\n", "").replace("\t", "").replace("\r", "").replace("……………………………………", "")
                                for item in thong_tin]
            thong_tin = '; '.join(item for item in thong_tin if item) or 'Không đề cập'

            current_month = datetime.datetime.now().month

            data = {
                'name': name.strip() if name else None,
                'giamoi': giacu.strip() if giacu else None,
                f'month_{current_month}': giacu.strip() if giacu else None,
                'thong_tin': thong_tin if thong_tin else 'Không đề cập',
                'nha_san_xuat': nha_san_xuat if nha_san_xuat else 'Không đề cập',
                'nuoc_san_xuat': nuoc_san_xuat if nuoc_san_xuat else 'Không đề cập',
                'hamluong_thanhphan': hamluong_thanhphan if hamluong_thanhphan else 'Không đề cập',
                'img_url': img_url.strip() if img_url else None,
                'link': response.url,
            }

            try:
                if self.check_product_exist(data['link']):
                    query = f'''
                        UPDATE thuocsi_vn
                        SET month_{current_month} = %s, thong_tin_san_pham = %s, nha_san_xuat = %s, nuoc_san_xuat = %s,
                            hamluong_thanhphan = %s, photo = %s, title = %s, giacu = giamoi, ngaycu = ngaymoi, giamoi = %s, ngaymoi = %s, nguon = %s 
                        WHERE link = %s;
                    '''
                    values = (
                    data[f'month_{current_month}'], data['thong_tin'], data['nha_san_xuat'], data['nuoc_san_xuat'],
                    data['hamluong_thanhphan'], data['img_url'], data['name'], data['giamoi'], ngay_moi,'chosithuoc.com',
                    data['link'])
                else:
                    query = f'''
                        INSERT INTO thuocsi_vn (title, giamoi, month_{current_month}, thong_tin_san_pham, nha_san_xuat,
                        nuoc_san_xuat, hamluong_thanhphan, ngaymoi, photo, link, nguon)
                        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);
                    '''
                    values = (data['name'], data['giamoi'], giacu.strip(), data['thong_tin'], data['nha_san_xuat'],
                            data['nuoc_san_xuat'], data['hamluong_thanhphan'], ngay_moi, data['img_url'], data['link'], 'chosithuoc.com')

                self.cursor.execute(query, values)
                self.connection.commit()
            except psycopg2.Error as e:
                self.connection.rollback()
                logging.error(f"Lỗi khi scraping sản phẩm: {str(e)}")

                yield data
    except Exception as e:
        logging.error(f"Unhandled Exception: {str(e)}")

def run_spider():
    process = CrawlerProcess(settings={
        
    })
    spider = LaptopSpider()
    spider.create_table()

    process.crawl(LaptopSpider)
    process.start()


if __name__ == '__main__':
    run_spider()
