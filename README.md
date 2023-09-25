# Dashboard_Selenium_Fix
-Source backend:
+ Auto : chứa các file python để cào giá các sàn chuyên buôn bán sản phẩm về thuốc.
+ Auto_daily.py: dùng để chạy Auto các file python trong Folder Auto.
+ Product_link: dùng để chạy link của sản phẩm được tìm kiếm và cập nhật giá mới nhất tại thời điểm .
+ Tesseract_ocr – canvas.png: dùng để chuyển đổi từ hình ảnh sang dạng Text để lấy giá (dùng trong file thuocsi.py).
+ Scraping_log.log: khi chạy các File python cào giá có lỗi gì thì sẽ được in vào file này và sẽ được reset mỗi lần khi chạy file python.
+ .env : biến môi trường ( chứa thông tin của database, các đường dẫn để dẫn đến các file, folder). 
+ Thuvien.txt : chứa các thư viện cần thiết để chạy file python
