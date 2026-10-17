HƯỚNG DẪN CHẠY WEBSITE BÁN GIÀY

1. Giải nén thư mục shopgiay vào:
   C:\xampp\htdocs\

2. Mở XAMPP:
   - Start Apache
   - Start MySQL

3. Mở phpMyAdmin:
   http://localhost/phpmyadmin

4. Chọn Import -> chọn database.sql -> Go.
   Database được tạo là:
   quan_ly_ban_giay

5. Mở website:
   http://localhost/shopgiay/

6. Tài khoản quản trị:
   Email: admin@shoestore.local
   Mật khẩu: 123456

7. Trang quản trị:
   http://localhost/shopgiay/admin/

CHỨC NĂNG:
- Trang chủ + danh mục + sản phẩm
- Đăng ký
- Đăng nhập / đăng xuất
- Mật khẩu được hash bằng password_hash()
- MySQL + PDO
- Giỏ hàng
- Thanh toán / tạo đơn hàng
- Trừ tồn kho
- Quản trị sản phẩm
- Thêm/sửa sản phẩm bằng URL ảnh Internet
- Quản lý đơn hàng cơ bản

ẢNH:
Các sản phẩm mẫu đang dùng ảnh từ Unsplash qua URL Internet. Bạn có thể thay URL ảnh trong trang quản trị hoặc trực tiếp trong bảng products.


CHỨC NĂNG QUẢN TRỊ BỔ SUNG:
- Xóa sản phẩm từ trang admin bằng nút Xóa (có hộp xác nhận).
- Không cho xóa sản phẩm đã xuất hiện trong đơn hàng để giữ lịch sử mua hàng.
- Cập nhật trạng thái đơn hàng: Chờ xác nhận, Đã xác nhận, Đang giao, Hoàn thành, Đã hủy.
