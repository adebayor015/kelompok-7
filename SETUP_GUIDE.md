# PANDUAN SETUP PROJECT KRFSM

Ikuti langkah-langkah berikut untuk menjalankan project KRFSM di komputer Anda.

## Prasyarat
- PHP 8.3+
- Composer
- MySQL / MariaDB
- Git

## Langkah-langkah Setup

### 1. Clone Repository
```bash
git clone <URL_REPOSITORY>
cd kelompok-7
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Setup File Environment
```bash
cp .env.example .env
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Konfigurasi Database di File `.env`
Buka file `.env` dan sesuaikan:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=krfsm
DB_USERNAME=root
DB_PASSWORD=
```

**Pastikan:**
- Database `krfsm` sudah dibuat di MySQL
- Username dan password sesuai dengan setup MySQL Anda

### 6. Jalankan Migration & Seeding
```bash
php artisan migrate:fresh --seed
```

Ini akan:
- ✅ Membuat semua table di database
- ✅ Mengisi data topik (Matematika, IPA, IPS, Sains, Bahasa Indonesia, Bahasa Inggris, Sejarah, PPKN)
- ✅ Membuat user dummy untuk testing
- ✅ Mengisi materi dan soal contoh

### 7. Jalankan Development Server
```bash
php artisan serve
```

Server akan berjalan di `http://localhost:8000`

### 8. User Login Dummy (untuk Testing)
- **Admin:**
  - Email: `admin@krfsm.com`
  - Password: `admin123`

- **User:**
  - Email: `kukuh@krfsm.com`, `farel@krfsm.com`, `reza@krfsm.com`, dll
  - Password: `user123`

## Struktur Topik

Berikut topik yang tersedia:
- Matematika (`/topik/matematika`)
- IPA (`/topik/ipa`)
- IPS (`/topik/ips`)
- Sains (`/topik/sains`)
- Bahasa Indonesia (`/topik/bahasa-indonesia`)
- Bahasa Inggris (`/topik/bahasa-inggris`)
- Sejarah (`/topik/sejarah`)
- PPKN (`/topik/ppkn`)

## Troubleshooting

### Error: "Unknown column 'best' in 'field list'"
✅ Sudah diperbaiki - gunakan `is_best` bukan `best` di model Answer

### Error: "Unknown column 'slug' in 'topics' table"
✅ Sudah diperbaiki - migrasi topics sudah include kolom `slug`

### Error: 404 Not Found pada topik
- Pastikan Anda mengakses dengan slug yang benar
- Contoh: `/topik/ips` (bukan `/topik/IPS`)
- Jalankan `php artisan migrate:fresh --seed` ulang jika data belum tersimpan

## Perintah Berguna

```bash
# Buka database shell
php artisan tinker

# Reset database dan refill seed
php artisan migrate:fresh --seed

# Lihat tabel database
php artisan db:table <nama_tabel>

# Generate model baru
php artisan make:model <NamaModel> -m

# Generate migration baru
php artisan make:migration create_<nama_table>

# Jalankan test
php artisan test
```

## Catatan Penting

1. **Jangan commit file berikut ke git:**
   - `.env` (file konfigurasi local)
   - `vendor/` (folder dependencies)
   - `storage/logs/`
   - `bootstrap/cache/`

2. **Setiap ada perubahan database:**
   - Buat migration baru: `php artisan make:migration <nama>`
   - Commit migration ke git
   - Teman tinggal jalankan: `php artisan migrate`

3. **Setiap clone project baru:**
   - Jalankan: `composer install`
   - Copy `.env.example` → `.env`
   - Generate key: `php artisan key:generate`
   - Setup database di `.env`
   - Jalankan: `php artisan migrate:fresh --seed`

---

Jika ada pertanyaan, silakan bertanya! 🎓
