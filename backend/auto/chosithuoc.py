import scrapy
import psycopg2
import datetime
import os
from dotenv import load_dotenv 
import sys
import codecs
from scrapy.crawler import CrawlerProcess
import logging

# cấu hỉnh file log
logging.basicConfig(filename='scraping_log.log', level=logging.INFO)

load_dotenv()

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
                nguon TEXT DEFAULT 2
            )
            '''
            self.cursor.execute(query)
            self.connection.commit()

        def check_product_exist(self, product_name):
            query = "SELECT EXISTS (SELECT 1 FROM thuocsi_vn WHERE title = %s)"
            self.cursor.execute(query, (product_name,))
            return self.cursor.fetchone()[0]

        def start_requests(self):
            categories = {
                'hoa-my-pham': 74,
                'thuoc-tan-duoc': 341,
                'thuoc-xuong-khop': 31,
                'thuoc-giam-can': 9,
                'thuoc-bo-than': 24,
                'thuc-pham-chuc-nang': 134,
                'thuc-pham-cao-cap': 16,
                'thiet-bi-y-te': 36,
                'thuoc-khong-ke-don': 6,
            }

            for category, num_pages in categories.items():
                for page_number in range(1, num_pages + 1):
                    category_url = f'https://chosithuoc.com/{category}-trang-{page_number}/'
                    yield scrapy.Request(url=category_url, callback=self.parse_page,
                                        meta={'page_number': page_number, 'category': category})

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
            if giacu_text == 'Liên hệ':
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
                if self.check_product_exist(data['name']):
                    query = f'''
                        UPDATE thuocsi_vn
                        SET month_{current_month} = %s, thong_tin_san_pham = %s, nha_san_xuat = %s, nuoc_san_xuat = %s,
                            hamluong_thanhphan = %s, photo = %s, link = %s, giacu = giamoi, ngaycu = ngaymoi, giamoi = %s, ngaymoi = %s, nguon=%s 
                        WHERE title = %s;
                    '''
                    values = (
                    data[f'month_{current_month}'], data['thong_tin'], data['nha_san_xuat'], data['nuoc_san_xuat'],
                    data['hamluong_thanhphan'], data['img_url'], data['link'], data['giamoi'], ngay_moi,'chosithuoc.com',
                    data['name'])
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

    process.crawl(LaptopSpider)
    process.start()


if __name__ == '__main__':
    run_spider()
