# Docker Setup Guide

## Prerequisites

-   Docker Desktop installed and running
-   Docker Compose installed (included with Docker Desktop)

## Setup Instructions

### 1. Buat file .env

```bash
cp .env.example .env
```

### 2. Update konfigurasi database di .env

```env
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/database/database.sqlite

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 3. Build dan jalankan container

```bash
docker-compose up -d --build
```

### 4. Install dependencies

```bash
# Install Composer dependencies
docker-compose exec app composer install

# Create SQLite database file
docker-compose exec app touch database/database.sqlite

# Generate application key
docker-compose exec app php artisan key:generate

# Run migrations
docker-compose exec app php artisan migrate

# Run seeders (optional)
docker-compose exec app php artisan db:seed
```

### 5. Set permissions (jika diperlukan)

```bash
docker-compose exec app chown -R www-data:www-data /var/www/storage
docker-compose exec app chmod -R 775 /var/www/storage
docker-compose exec app chmod -R 775 /var/www/bootstrap/cache
```

## Perintah Berguna

### Melihat logs

```bash
docker-compose logs -f app
docker-compose logs -f nginx
```

### Menjalankan Artisan commands

```bash
docker-compose exec app php artisan [command]
```

### Masuk ke container

```bash
docker-compose exec app bash
```

### Stop containers

```bash
docker-compose down
```

### Restart containers

```bash
docker-compose restart
```

### Rebuild containers

```bash
docker-compose down
docker-compose up -d --build
```

## Akses Aplikasi

-   **Aplikasi Laravel**: http://localhost:8000
-   **Vite Dev Server**: http://localhost:5173
-   **SQLite Database**: database/database.sqlite
-   **Redis**: localhost:6379

## Troubleshooting

### Permission issues

```bash
docker-compose exec app chown -R www-data:www-data /var/www
docker-compose exec app chmod -R 775 /var/www/storage /var/www/bootstrap/cache
```

### Clear cache

```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear
```

### Database tidak bisa diakses

Pastikan file SQLite sudah dibuat dan memiliki permission yang benar:

```bash
docker-compose exec app ls -la database/database.sqlite
docker-compose exec app chmod 664 database/database.sqlite
```

### Port sudah digunakan

Jika port 8000 atau 6379 sudah digunakan, ubah di `docker-compose.yml`:

```yaml
ports:
    - "8080:80" # Ubah 8000 ke 8080
```
