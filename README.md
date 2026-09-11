# Formulir Disiplin Positif (Laravel)

## Cara install

1. Buat project Laravel baru (kosong), lalu **timpa/copy** file-file dari paket ini ke dalamnya:
   ```
   composer create-project laravel/laravel disiplin-positif
   ```
   Lalu copy folder `app/`, `database/`, `routes/`, `resources/views/`, dan `bootstrap/app.php` dari paket ini ke project barumu (timpa yang sudah ada).

2. Install Laravel Breeze untuk fitur login/register siap pakai:
   ```
   composer require laravel/breeze --dev
   php artisan breeze:install blade
   npm install && npm run build
   ```

3. Atur `.env` (koneksi database MySQL/SQLite), lalu jalankan migrasi + seeder:
   ```
   php artisan migrate --seed
   ```

4. Login dengan akun contoh:
   - **Admin**: admin@sekolah.test / password
   - **Guru**: guru@sekolah.test / password

5. Jalankan server:
   ```
   php artisan serve
   ```

## Struktur inti

- `app/Models/` — User, SchoolClass, Student, Category, DisciplineRecord
- `app/Http/Controllers/` — DisciplineRecordController (formulir inti),
  StudentController (data master, admin), ReportController (rekap poin)
- `app/Http/Middleware/EnsureRole.php` — pembatasan akses `role:admin` / `role:guru`
- `routes/web.php` — semua route + middleware role
- `database/migrations/` — skema: classes, students, categories, discipline_records,
  serta tambahan kolom role & class_id ke tabel users

## Catatan desain

Guru hanya bisa melihat & mencatat siswa di kelasnya sendiri (`class_id`).
Ini dicek secara **eksplisit di controller** (bukan lewat Eloquent global scope)
agar mudah diaudit — lihat komentar di `DisciplineRecordController.php`.
