from scrapy.crawler import CrawlerProcess
from chosithuoc import LaptopSpider  # Thay đổi thành đường dẫn đến spider của bạn

def run_spider():
    process = CrawlerProcess(settings={
        
    })

    process.crawl(LaptopSpider)
    process.start()

if __name__ == '__main__':
    run_spider()