import scrapy
import psycopg2
import datetime
import os
from dotenv import load_dotenv
import logging
from scrapy.crawler import CrawlerProcess

load_dotenv()

class LaptopSpider(scrapy.Spider):
    name = "chosithuoc"

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        self.host = os.environ.get('DB_HOST')
        self.port = os.environ.get('DB_PORT')
        self.database = os.environ.get('DB_NAME')
        self.user = os.environ.get('DB_USER')
        self.password = os.environ.get('DB_PASSWORD')
        self.conn_str = f"host='{self.host}' port='{self.port}' dbname='{self.database}' user='{self.user}' password='{self.password}'"

    def start_requests(self):
        conn_str = f"host='{self.host}' port='{self.port}' dbname='{self.database}' user='{self.user}' password='{self.password}'"
        with psycopg2.connect(conn_str) as connection:
            with connection.cursor() as cursor:
                self.create_table(cursor)
                sql_query = "SELECT link FROM thuocsi_vn WHERE masp IS NOT NULL AND nguon LIKE '%chosithuoc%'"
                cursor.execute(sql_query)
                links = cursor.fetchall()

                for link in links:
                    url = link[0]
                    yield scrapy.Request(url=url, callback=self.parse_detail, meta={'link': url})

    def create_table(self, cursor):
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
            link TEXT PRIMARY KEY,
            nguon TEXT DEFAULT 2
        )
        '''
        cursor.execute(query)

    def check_product_exist(self, cursor, product_name):
        query = "SELECT EXISTS (SELECT 1 FROM thuocsi_vn WHERE title = %s)"
        cursor.execute(query, (product_name,))
        return cursor.fetchone()[0]

    def parse_detail(self, response):
        link = response.meta.get('link')
        name = response.css('h1.title::text').get()
        gia = response.css('.gia::text').get()
        number = response.css('.masp_hover_masp::text').getall()
        number = ' '.join(value.strip() for value in number if value.strip())
        img_url = response.css('.img a img::attr(src)').get()

        # Trích xuất thông tin từ trang chi tiết sản phẩm
        detail_url = response.url

        if name and gia and number and img_url:
            giacu_text = response.meta.get('gia')
            if giacu_text is None:
                giacu = '0'
            elif giacu_text == '' or giacu_text == 'Liên hệ':
                giacu = '0'
            else:
                giacu = giacu_text.replace('đ', '').replace(',', '')

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
                'link': link,
            }

            try:
                with psycopg2.connect(self.conn_str) as connection:
                    with connection.cursor() as cursor:
                        if self.check_product_exist(cursor, data['name']):
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

                        cursor.execute(query, values)
                        connection.commit()
            except psycopg2.Error as e:
                logging.error(f"Lỗi khi scraping sản phẩm: {str(e)}")

            yield data

def run_spider():
    process = CrawlerProcess(settings={
        # Your custom settings here
    })

    process.crawl(LaptopSpider)
    process.start()

if __name__ == '__main__':
    run_spider()
