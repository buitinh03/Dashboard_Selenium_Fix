from scrapy.crawler import CrawlerProcess
from chosithuoc import LaptopSpider  

def run_spider():
    process = CrawlerProcess(settings={
        
    })

    process.crawl(LaptopSpider)
    process.start()

if __name__ == '__main__':
    run_spider()