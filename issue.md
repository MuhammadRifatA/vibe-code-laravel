# Project Setup: Laravel 12 dengan Breeze, Sanctum, dan PostgreSQL

## Objective
Membangun fondasi project baru menggunakan Laravel 12 di dalam direktori ini dengan otentikasi dan konfigurasi database yang disyaratkan.

## Spesifikasi Teknis
- **Framework**: Laravel 12
- **Database**: PostgreSQL
- **Authentication/API**: Laravel Sanctum
- **Starter Kit / Auth Scaffold**: Laravel Breeze

## Langkah-langkah Implementasi (High-Level)

Silakan implementasikan tugas berikut secara berurutan:

### 1. Inisialisasi Project Laravel 12
- Buat project Laravel 12 baru tepat di dalam direktori saat ini (tanpa membuat sub-direktori baru).
- Atur file dan folder bawaan agar sesuai dengan struktur standar Laravel.

### 2. Konfigurasi Database PostgreSQL
- Ubah konfigurasi driver database bawaan pada project menjadi PostgreSQL.
- Perbarui file environment (`.env`) dengan parameter koneksi PostgreSQL yang sesuai (host, port, database, username, password).

### 3. Setup Laravel Sanctum
- Install dependensi Laravel Sanctum melalui Composer.
- Publikasikan konfigurasi Sanctum beserta file migrasinya.
- Pastikan model `User` menggunakan trait yang diperlukan (`HasApiTokens`) agar siap digunakan untuk autentikasi API.

### 4. Setup Laravel Breeze
- Install paket Laravel Breeze melalui Composer.
- Lakukan proses instalasi Breeze (pilih stack default atau yang disepakati, misalnya Blade/React/Vue).
- Lakukan instalasi dependency frontend (npm) dan build asset-nya.

### 5. Finalisasi & Migrasi
- Jalankan migrasi ke database PostgreSQL (`php artisan migrate`) untuk memastikan koneksi berhasil dan seluruh tabel bawaan (termasuk users dan personal_access_tokens) terbentuk.
- Lakukan basic sanity check untuk memastikan fitur autentikasi bawaan Breeze (Login/Register) berjalan lancar.
