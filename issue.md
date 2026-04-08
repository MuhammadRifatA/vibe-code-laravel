# Rencana Implementasi: Fitur GET User Current

Dokumen ini berisi spesifikasi teknis untuk membuat fitur pengambilan data user yang sedang login melalui REST API. Harap ikuti instruksi berikut secara berurutan.

## 1. Middleware: `AuthenticateSession` (Opsional tapi Disarankan)

Karena kita menggunakan tabel session custom, kita butuh cara untuk memverifikasi token dari header `Authorization: Bearer <token>`.

**Tugas Anda:**
- Buat middleware baru atau tambahkan logika pengecekan di controller:
  1. Ambil token dari header `Authorization`.
  2. Cari record di tabel `session` (model `Session`) yang memiliki token tersebut.
  3. Jika ditemukan, ambil data user terkait (`id_user`).
  4. Jika tidak ditemukan, kembalikan error `Unauthorize`.

## 2. Controller API: `UserController`

Tambahkan method `current` pada class `app/Http/Controllers/UserController.php`.

**Spesifikasi Endpoint:**
- **Path:** `GET /api/user/current`
- **Header:** `Authorization: Bearer <token>` (Token diambil dari tabel session).

**Logika Implementasi:**
1. Tangkap token dari header.
2. Cari record session di database.
3. **Respon Error (Jika token tidak valid/tidak ada):**
   ```json
   {
       "error" : "Unauthorize"
   }
   ```
4. **Respon Sukses (Jika valid):**
   Ambil data user (`id`, `name`, `email`, `created_at`) dan kembalikan:
   ```json
   {
       "data" : {
           "id": 1,
           "name": "ahmad",
           "email": "ahmad@gmail.com",
           "created_at": "timestamp"
       }
   }
   ```

## 3. Routing API

Tambahkan *endpoint* GET pada file `routes/api.php`.

```php
Route::get('/user/current', [UserController::class, 'current']);
```

---

## Ringkasan Spesifikasi Endpoint

**Endpoint:**
`GET /api/user/current`

**Headers:**
`Authorization: Bearer <token>`

**Response Body (Success):**
```json
{
    "data"  : {
        "id": 1,
        "name": "ahmad",
        "email": "ahmad@gmail.com",
        "created_at": "timestamp"
    }
}
```

**Response Body (Error):**
```json
{
    "error" : "Unauthorize"
}
```

**Catatan Pekerja:**
- Gunakan model `Session` untuk mencari token.
- Gunakan relasi atau query manual ke model `User`.
- Pastikan format JSON sesuai dengan spek di atas.
