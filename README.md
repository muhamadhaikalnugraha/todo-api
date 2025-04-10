Berikut dokumentasi lengkap untuk menjalankan aplikasi dalam format `README.md`:

```markdown
# To-Do List API with Laravel

Backend API untuk aplikasi To-Do List dengan fitur autentikasi JWT dan manajemen checklist.

## Teknologi Utama
- Laravel 10
- JWT Authentication
- MySQL
- REST API

## Persyaratan Sistem
- PHP 8.1+
- Composer
- MySQL 8+
- Redis (opsional untuk cache)

## Instalasi

### 1. Clone Repositori
```bash
git clone https://github.com/username/todo-api.git
cd todo-api
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Konfigurasi Environment
Salin file `.env.example` ke `.env`:
```bash
cp .env.example .env
```

Isi konfigurasi database di `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_api
DB_USERNAME=root
DB_PASSWORD=

JWT_SECRET=your_jwt_secret_here
```

### 4. Generate Key dan JWT Secret
```bash
php artisan key:generate
php artisan jwt:secret
```

### 5. Jalankan Migrasi Database
```bash
php artisan migrate --seed
```

### 6. Jalankan Server
```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

## API Documentation

**Base URL**: `http://localhost:8000/api`

### Autentikasi

| Endpoint | Method | Deskripsi         | Request Body                             |
|----------|--------|-------------------|------------------------------------------|
| /login   | POST   | Login pengguna    | `{"username":"", "password":""}`         |
| /register| POST   | Registrasi baru   | `{"username":"", "email":"", "password":""}` |

### Checklist Endpoints

| Endpoint                          | Method | Deskripsi                     | Header               |
|-----------------------------------|--------|-------------------------------|----------------------|
| /checklist                        | GET    | Get semua checklist           | Bearer Token         |
| /checklist                        | POST   | Buat checklist baru           | Bearer Token         |
| /checklist/{checklistId}          | DELETE | Hapus checklist               | Bearer Token         |

### Checklist Items Endpoints

| Endpoint                                          | Method | Deskripsi                     |
|---------------------------------------------------|--------|-------------------------------|
| /checklist/{checklistId}/item                     | GET    | Get semua item                |
| /checklist/{checklistId}/item                     | POST   | Buat item baru                |
| /checklist/{checklistId}/item/{itemId}/status     | PUT    | Update status item            |
| /checklist/{checklistId}/item/{itemId}/rename     | PUT    | Ubah nama item                |
| /checklist/{checklistId}/item/{itemId}            | DELETE | Hapus item                    |

## Contoh Penggunaan API

### 1. Registrasi User
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"username": "testuser", "email": "test@example.com", "password": "password123"}'
```

### 2. Login dan Dapatkan Token
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"username": "testuser", "password": "password123"}'
```

Respon:
```json
{
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
}
```

### 3. Buat Checklist (Dengan Token)
```bash
curl -X POST http://localhost:8000/api/checklist \
  -H "Authorization: Bearer your_token_here" \
  -H "Content-Type: application/json" \
  -d '{"name": "Checklist Harian"}'
```

## Environment Variables
| Variable      | Deskripsi                     |
|---------------|-------------------------------|
| JWT_SECRET    | Secret key untuk JWT          |
| DB_*          | Konfigurasi database          |
| APP_DEBUG     | Mode debug (true/false)       |

## Deployment
Untuk environment production:
1. Set `APP_ENV=production` di `.env`
2. Nonaktifkan debug mode: `APP_DEBUG=false`
3. Optimasi aplikasi:
```bash
php artisan optimize
php artisan config:cache
php artisan route:cache
```
