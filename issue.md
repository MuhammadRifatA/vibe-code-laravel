# Rencana Implementasi: Fitur Login & Manajemen Session

Dokumen ini berisi spesifikasi teknis untuk mengimplementasikan fitur login user dan manajemen session. Harap ikuti instruksi ini dengan teliti.

## 1. Database: Tabel `sessions`

Buat tabel baru untuk menyimpan token session user yang login.

**Spesifikasi Tabel:**
- `id`: Integer, Auto Increment, Primary Key.
- `id_user`: BigInt (Foreign Key ke tabel `users`).
- `token`: Varchar(255), Not Null (Berisi UID untuk token user).
- `created_at`: Timestamp, Default current_timestamp.
- `updated_at`: Timestamp, Default current_timestamp.

**Langkah-langkah:**
1. Jalankan perintah: `php artisan make:migration create_sessions_table`.
2. Di dalam file migration, definisikan struktur:
   ```php
   Schema::create('sessions', function (Blueprint $table) {
       $table->id();
       $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
       $table->string('token', 255);
       $table->timestamps();
   });
   ```
3. Jalankan `php artisan migrate`.

## 2. Model: `Session`

**Langkah-langkah:**
1. Jalankan: `php artisan make:model Session`.
2. Pastikan file `app/Models/Session.php` memiliki `$fillable` yang tepat:
   ```php
   protected $fillable = ['id_user', 'token'];
   ```

## 3. Controller: `UserController` (Login Method)

Tambahkan method `login` pada `app/Http/Controllers/UserController.php`.

**Spesifikasi Endpoint:**
- **Path:** `POST /api/user/login`
- **Request Body:**
  ```json
  {
      "email" : "ahamad@gmail.com",
      "password" : "password"
  }
  ```

**Logika Implementasi:**
1. Validasi input `email` dan `password`.
2. Cari user berdasarkan email.
3. Cek apakah password cocok (Gunakan `Hash::check`).
4. **Respon Error:** Jika login gagal (atau jika sesuai spek: jika email tidak terdaftar atau password salah), berikan respon:
   ```json
   {
       "error" : "Email sudah terdaftar"
   }
   ```
   *(Catatan: Spesifikasi meminta pesan "Email sudah terdaftar" untuk error login, harap ikuti sesuai permintaan).*
5. **Respon Sukses:** Jika berhasil, buat token (bisa gunakan `Str::uuid()`), simpan ke tabel `sessions`, dan berikan respon:
   ```json
   {
       "data" : "Ok"
   }
   ```

## 4. Routing: `api.php`

Daftarkan route di `routes/api.php`:
```php
Route::post('/user/login', [UserController::class, 'login']);
```

---

**Panduan untuk Junior/AI:**
- Pastikan menggunakan namespace yang benar untuk Model (`App\Models\User`, `App\Models\Session`).
- Gunakan `Illuminate\Support\Facades\Hash` untuk pengecekan password.
- Gunakan `Illuminate\Support\Str` untuk generate token.
- Gunakan `Illuminate\Http\JsonResponse` untuk return type.
