# IndusRent Platform

Nền tảng Laravel chạy bằng Docker. Tài liệu này hướng dẫn **build** (Docker) và làm việc với **GitHub**.

---

## Yêu cầu

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/) (v2 trở lên)

---

## Build & Chạy với Docker

### Lần đầu (tạo project Laravel + khởi động)

```bash
# Clone repo (nếu chưa có code)
git clone <url-repo> IndusRent_Platform
cd IndusRent_Platform

# Build image và chạy tất cả service
docker compose up -d --build
```

- **Lần chạy đầu:** container sẽ tự tạo dự án Laravel trong thư mục hiện tại (nếu chưa có `artisan`).
- **App:** http://localhost:8000  
- **MySQL:** port host `3308` (trong mạng Docker dùng hostname `db`, port `3306`).

### Các lệnh thường dùng

```bash
# Chạy lại (sau khi đã build)
docker compose up -d

# Dừng
docker compose down

# Xem log app
docker compose logs -f app

# Vào shell trong container app
docker compose exec -it app bash
```

### Trong container app

```bash
# Ví dụ: chạy migration, tạo key, install dependency
php artisan migrate
php artisan key:generate
composer install
```

---

## GitHub

### Clone repository

```bash
git clone https://github.com/<org-hoặc-user>/IndusRent_Platform.git
cd IndusRent_Platform
```

### Đẩy code lên GitHub

```bash
# Thêm remote (nếu chưa có)
git remote add origin https://github.com/<org-hoặc-user>/IndusRent_Platform.git

# Branch main
git checkout -b main   # hoặc git checkout main
git add .
git commit -m "Mô tả thay đổi"
git push -u origin main
```

### Tạo repo mới trên GitHub

1. Vào [GitHub](https://github.com) → **New repository**.
2. Đặt tên (ví dụ: `IndusRent_Platform`), chọn public/private, **không** tạo README/.gitignore (vì đã có trong project).
3. Chạy trên máy local (trong thư mục project):

```bash
git init
git add .
git commit -m "Initial commit"
git branch -M main
git remote add origin https://github.com/<username>/IndusRent_Platform.git
git push -u origin main
```

### Cấu trúc thư mục liên quan Docker

| Thư mục/File      | Mô tả |
|-------------------|--------|
| `Dockerfile`      | Build image PHP + Composer cho app |
| `docker-compose.yml` | Định nghĩa services `app` (Laravel) và `db` (MySQL) |
| `docker/entrypoint.sh` | Script tạo Laravel lần đầu và chạy `artisan serve` |

---

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
