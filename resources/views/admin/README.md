# Admin views

Giao diện quản trị (admin) dựa trên phong cách frontend chothuexuong/IndusRent: màu #263548, #4b8606, layout sidebar + top bar.

## Cấu trúc hiện tại

- `admin/layouts/app.blade.php` — Layout chung (sidebar trái, top bar, content)
- `admin/partials/sidebar.blade.php` — Menu: Dashboard, Tin đăng, Tin tức, Liên hệ, Nội dung yêu cầu, Cài đặt
- `admin/partials/header.blade.php` — Thanh trên: tiêu đề trang, link "Xem trang chủ", user
- `admin/dashboard.blade.php` — Dashboard (thống kê nhanh, hoạt động gần đây)
- `admin/tin-dang/index.blade.php`, `admin/tin-dang/create.blade.php` — Quản lý tin đăng BĐS
- `admin/tin-tuc/index.blade.php`, `admin/tin-tuc/create.blade.php` — Quản lý tin tức
- `admin/lien-he/index.blade.php` — Danh sách liên hệ (từ form Liên hệ frontend)
- `admin/noi-dung-yeu-cau/index.blade.php` — Danh sách nội dung yêu cầu
- `admin/cai-dat/index.blade.php` — Cài đặt hệ thống (placeholder)

## CSS

- `public/css/admin.css` — Style riêng cho admin (sidebar, table, card, button), đồng bộ màu với frontend.

## Routes (prefix `/admin`)

| URL | Trang |
|-----|--------|
| `/admin` | Dashboard |
| `/admin/tin-dang` | Danh sách tin đăng |
| `/admin/tin-dang/tao` | Thêm tin đăng |
| `/admin/tin-tuc` | Danh sách tin tức |
| `/admin/tin-tuc/tao` | Thêm tin tức |
| `/admin/lien-he` | Danh sách liên hệ |
| `/admin/noi-dung-yeu-cau` | Danh sách nội dung yêu cầu |
| `/admin/cai-dat` | Cài đặt |

Hiện chưa bật middleware auth; khi có đăng nhập admin, bọc nhóm route bằng `middleware(['auth'])` hoặc middleware role admin.
