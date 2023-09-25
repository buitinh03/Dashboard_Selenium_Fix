# Dashboard_Selenium_Fix
-Giới thiệu:
+ Web dùng để hiển thị sản phẩm của các sản phẩm của các sàn thương mại sau khi crawl giá
-Tính năng: 
    + Hiển thị tất cả các sản phẩm từ các sàn thuốc sỉ, lẻ lớn với giao diện dễ nhìn, dễ hiểu
    + Thống kê tổng số lượng sản phẩm
    + Xem chi tiết từng sản phẩm hiển thị thành phần, công dụng, chỉ định, đơn vị sản xuất,...
    + Hiển thị biểu đồ biến động giá qua các tháng
    + Tạo, cập nhật, tìm kiếm sp theo mã chuẩn hóa, sp tương tự có cùng mã chuẩn háo do người dùng đặt
    + Tìm kiếm sản phẩm theo tên, theo từ khóa, theo thời gian,...
    + Quản lí tài khoản sử dụng: thêm người dùng, sửa tài khoản, phân quyền
-Source backend:
    + File Auto-Auto_daily: dùng để chạy code theo ngày đã đặt lịch
    + Product_link: dùng để chạy link của sản phẩm được tìm kiếm và cập nhật giá mới nhất tại thời điểm 
    + Tesseract_ocr – canvas.png: dùng để chuuển đổi từ hình ảnh sang kiểu chữ để lấy giá (của web thuốc sĩ)
    + Scaping_log.log: khi chạy code có lỗi gì thì sẽ được in ra file này 
    + Env : biến môi trường 
    + Thuvien.txt : dùng để dowload các thư viện cần thiết để chạy Source code 
- Dashboard:
    1. Folder classes: chứa các file (customer.php, login.php, register.php):
        - file customer.php: Sẽ thực hiện truy vấn dữ liệu với Database cho người dùng gồm các chức năng:
            + Xoá tài khoản người dùng dựa trên id người dùng.
            + Hiển thị tất cả tài khoản người dùng(chỉ admin mới xem được)
            + Lấy thông tin tài khoản người dùng dựa trên mã người dùng.
            + Cập nhật lại thông tin và tài khoản người dùng(Chỉ admin mới có quyền cập nhật).
            + Chức năng check email người dùng khi người dùng quên mật khẩu và muốn lấy lại mật khẩu.
            + Thay đổi mật khẩu: Người dùng sẽ được thay đổi mật khẩu mới khi nhập đúng email.
        - file login.php: Checker đăng nhập 
            + Sau khi nhập Email đăng nhập và mật khẩu sau đó bấm đăng nhập sẽ check xem Email và mật khẩu người dùng đã chính xác hay chưa.
        - file register.php: Thực hiện chức năng đăng ký tài khoản mới với 2 quyền là Nhân viên và ADMIN.
    2. Folder css: Chứa các file css của website:
        - file dashboard.css: Chứa các style css của file inc/deshboad.php 
        - file detail.css: Chứa các style css của file product_detail.php
        - file index.css: Chứa các style css của file index.php
        - file login.css: Chứa các style css của file login.php và file register.php
        - file product_detail.css: Chứa các style css của file product_detail.php
        - file quenmatkhau.css: Chứa các style css của file new_password.php
        - file search_css.css: Chứa các style css của file search.php 
        - file style_detail.css: 
    3. Folder format: Chứa file format.php
            + Có chức năng: Checker ký tự, giới hạn ký tự hiển thị..v.v..
    4. Folder images: Chứa các file hình ảnh của trang website
    5. Folder inc: Chứa các file(deshboad.php, footer.php, header.php):
        - file deshboad.php: Chứa Đồng hồ, thanh tìm kiếm, tổng sản phẩm và chức năng đăng xuất..v.v..
        - file footer.php: Chứa footer của website
        - file header.php: Chứa header của website
    6. Folder js: Chứa các file Javascript của website:
        - file hiiddenpassword.js: Thực hiện chức năng hiện thị mật khẩu và ẩn mật khẩu.
        - index.js: Thực hiện chức năng sáng tối
        - jquery.min.js: Không thực hiện chức năng nào.
        - login.js: Hiển thị Form điện Email xác minh của người dùng.
        - loginmessaege.js: Thông báo cho người dùng sau khi xác nhận Email.
        - messege.js: Chứa các thông báo 
        - orders.js: Không quan tâm
        - time.js: Biến đếm thời gian ngày, tháng, năm, giờ, phút, giây.
    7. Folder lib: Chứa file Session: Thực hiện chức năng Checker đăng nhập, phiên đăng nhập, đăng xuất của người dùng...v.v..
    8. canvas.png: hình ảnh giá của sàn thuocsi.vn, cần dùng để chuyển đổi từ hình ảnh sang dạng text để lấy giá
    9. connect.php: chứa tất cả các câu lệnh sql, dùng để select, update dữ liệu từ database và các function trong connect.php là trung tâm liên kết để các file khác kết nối đến database
	10. db_config.php: được coi là file chứa biến môi trường, chứa tất cả các biến có thể sửa đổi thường xuyên
	11. edit_user.php: chứa giao diện của trang chỉnh sửa tài khoản của web, sau khi người dùng nhập dữ liệu và nhấn nút xác nhận thì dữ liệu sẽ được chuyển sang file customer.php trong folder class để xử lý và hiển thị lại trong báo trong trang edit_user.php
	12. index.php: chứa bảng hiển thị sản phẩm, chứa listdown hiển thị tất cả sản phẩm, bán sỉ hoặc bán lẻ, hoặc hiển thị sản phẩm theo từng sàn. trong file còn chứa danh sách số trang và bộ lọc để sắp xếp sản phẩm theo thời gian hoặc theo giá lệch.
	13. login.php: giao diện trang đăng nhập gồm các chức năng:
		. Ẩn hiện mật khẩu nhờ javascript của js/hiddenpassword.js
		. Chứa link dẫn đến file new_password.php khi quên mật khẩu
		. Sau khi nhập tài khoản và mật khẩu và nhấp vào button đăng nhập thì dữ liệu sẽ được gửi về class/login.php để kiểm tra và xử lý. Nếu tài khoản và mật khẩu đều đúng thì sẽ chuyển sang trang index.php. nếu không đúng sẽ báo lỗi về trang login.php
    14. new_password.php: dùng để đặt lại mật khẩu khi user quên mật khẩu. 
    15. product_detail.php: giao diện trang chi tiết sản phẩm chứa thông tin của sản phẩm đã chọn, table hiển thị giá qua từng tháng trong năm và biểu đồ so sánh giá theo tháng. và hiển thị sản phẩm liên quan đến mã chuẩn hóa.
    16. register.php: giao diện trang đăng kí. 
    17. search.php: hiển thị sản phẩm theo từ khóa tìm kiếm. có thể thêm sửa xóa mã chuyển hóa tại đây. và biểu đồ so sánh giá của 10 sản phẩm trong 1 trang. chứa tính năng cập nhật sản phẩm theo từ khóa tìm kiếm
    18. style.css: chứa css của trang index.php, search.php
    19. view_user.php: giao diện của quản lý tài khoản, hiển thị tất cả các tài khoản đã tạo. Có thể thực hiện sửa, và xóa tài khoản.


    

