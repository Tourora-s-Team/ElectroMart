# ElectroMart

## 🧩 Kiến trúc thư mục theo mô hình MVC
```
📦ElectroMart
┣ 📂app
┃ ┣ 📂controllers → Chứa controller xử lý logic nghiệp vụ
┃ ┃ ┣ 📂client → Controller cho frontend (user)
┃ ┃ ┣ 📂server → Controller cho backend (admin/server)
┃ ┃ ┗ 📜example.php → Controller ví dụ
┃ ┣ 📂models → Các lớp Model tương tác với CSDL
┃ ┗ 📂views → Giao diện người dùng (HTML/PHP)
┣ 📂config
┃ ┗ 📜database.php → File cấu hình kết nối database
┣ 📂core
┃ ┗ 📜router.php → Lớp định tuyến: map URL → controller
┣ 📂public
┃ ┣ 📂css → File CSS tĩnh
┃ ┣ 📂images → Hình ảnh sử dụng trong web
┃ ┣ 📂js → File JavaScript
┃ ┗ 📜index.php → Entry point (Front Controller)
┣ 📂routes
┃ ┗ 📜example.php → File định nghĩa route (vd: web.php, api.php)
┗ 📜readme.md → Tài liệu giới thiệu dự án
```
## 💡 Ghi chú

- Dự án sử dụng mô hình MVC: Model - View - Controller.
- Tách biệt `public/` giúp bảo mật, chỉ expose phần cần thiết cho web server.
- `core/router.php` và `routes/` giúp ứng dụng mở rộng quy mô dễ dàng.
