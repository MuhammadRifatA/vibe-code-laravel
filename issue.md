# Rencana Implementasi: Fitur Registrasi API User

Dokumen ini berisi spesifikasi teknis dan panduan langkah demi langkah (implementasi) untuk membuat fitur registrasi user baru melalui REST API. Silakan ikuti instruksi berikut secara berurutan.

## 1. Spesifikasi Database & Migration

Kita membutuhkan tabel `users` dengan struktur sebagai berikut:
- `id`: integer, auto increment, primary key
- `name`: varchar(255), not null
- `email`: varchar(255), not null, unique
- `password`: varchar(255), not null (**Wajib** di-hash dengan standar bcrypt)
- Timestamps: `created_at` dan `updated_at` (default Laravel)

**Tugas Anda:**
- Laravel secara default biasanya sudah menyediakan migration untuk tabel `users`. Buka folder `database/migrations/` dan temukan file `...create_users_table.php`.
- Pastikan di dalam method `up()` struktur kolom sesuai dengan kebutuhan. Jika belum ada, buat migration baru menggunakan perintah:
  `php artisan make:migration create_users_table`
- Jalankan perintah `php artisan migrate`

## 2. Model: `app/Models/User.php`

**Tugas Anda:**
- Buka file `app/Models/User.php` (atau buat jika belum ada menggunakan `php artisan make:model User`).
- Pastikan property `$fillable` memiliki field yang diizinkan untuk mass assignment: `['name', 'email', 'password']`.
- Pastikan bahwa password akan dienkripsi / di-hash saat data disimpan ke database. Anda dapat menggunakan *mutators* atau cast bawaan Laravel.

## 3. Form Request Validation: `app/Http/Requests/StoreUserRequest.php`

**Tugas Anda:**
- Buat file form request dengan perintah:
  `php artisan make:request StoreUserRequest`
- Dalam file `StoreUserRequest.php`:
  1. Ubah method `authorize()` menjadi me-return `true` (jika user diizinkan mengakses tanpa token login sebelumnya).
  2. Di method `rules()`, tambahkan aturan (rules) validasi dasar:
     - `name`: `required|string|max:255`
     - `email`: `required|string|email|max:255|unique:users`
     - `password`: `required|string`
  3. Khusus untuk error pada bagian "email unik" (unique:users), tangani / overriding method `failedValidation` di dalam **StoreUserRequest** untuk mengembalikan format JSON error secara spesifik jika gagal validasi, agar response sesuai permintaan di bawah:
     ```json
     {
         "error": "Email sudah terdaftar"
     }
     ```

## 4. Controller: `app/Http/Controllers/UserController.php`

**Tugas Anda:**
- Buat Controller dengan menjalankan:
  `php artisan make:controller UserController`
- Dalam controller ini, buat sebuah method bernama `store` yang menerima injeksi dependensi tipe dari `StoreUserRequest`:
  `public function store(StoreUserRequest $request)`
- Alur Logika Eksekusi di dalam method `store`:
  1. Ambil data yang lolos validasi (misal via `$request->validated()`).
  2. Lakukan hash secara manual menggunakan `Hash::make()` (apabila belum di tangani oleh mutator Model di poin 2).
  3. Simpan data ke dalam database dengan `User::create([...])`.
  4. Return response JSON berhasil:
     ```json
     {
         "data": "Ok"
     }
     ```

## 5. Routing API: `routes/api.php`

**Tugas Anda:**
- Buka file `routes/api.php` (Catatan: perhatikan folder `routes/` dengan huruf kecil).
- Import / "use" class `UserController` di bagian atas file.
- Definisikan endpoint POST baru seperti di bawah ini, yang mengarah ke method `store`:
  `Route::post('/user', [UserController::class, 'store']);`

---

## Ringkasan Spesifikasi Endpoint API target

**Endpoint:**
`POST /api/user`

**Request Body:**
```json
{
    "name"  : "Ahamad",
    "email" : "ahamad@gmail.com",
    "password" : "password"
}
```

**Response Body (Sukses 200/201):**
```json
{
    "data"  : "Ok"
}
```

**Response Body (Error 400/422):**
```json
{
    "error" : "Email sudah terdaftar"
}
```

## Struktur Folder Terlibat

Pastikan semua file yang Anda kerjakan atau Anda buat ditempatkan sesuai struktur di bawah ini:

```
app/
├── Http/
│   ├── Controllers/
│   │   └── UserController.php
│   └── Requests/
│       └── StoreUserRequest.php
├── Models/
│   └── User.php
└── routes/
    └── api.php
```

*(Pekerja, selesaikan instruksi satu per satu secara runut agar rapi.)*
