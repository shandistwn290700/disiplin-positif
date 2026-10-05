# Formulir Disiplin Positif (Laravel)

Aplikasi pencatatan disiplin siswa: guru mencatat perilaku baik & pelanggaran, poin dihitung otomatis,
admin memantau rekap, membuat surat pemanggilan orang tua, dan mengekspor laporan (Excel/PDF).

Repo ini sudah berisi project Laravel 12 yang lengkap (termasuk fitur login Breeze) — **tidak perlu**
`composer create-project` atau menyalin folder ke project baru.

## Kebutuhan

- **PHP 8.2 atau lebih baru** (XAMPP versi PHP 8.2+), dengan ekstensi `gd`, `zip`, `mbstring`,
  `fileinfo`, `pdo_mysql` aktif. Di XAMPP, buka `php.ini` lalu hapus tanda `;` di depan
  `extension=gd` dan `extension=zip` bila masih dikomentari.
- **Composer**
- **MySQL / MariaDB** (bawaan XAMPP)
- Node.js **tidak diperlukan** — tampilan memakai Tailwind via CDN, jadi tidak perlu `npm run build`.

## Cara install

1. Clone repo ini, lalu masuk ke foldernya:
   ```
   git clone <url-repo> disiplin-positif
   cd disiplin-positif
   ```

2. Buat database kosong bernama `disiplin_positif` (misalnya lewat phpMyAdmin).
   Nama database, user, dan password bisa diubah di `.env` (lihat langkah 3).

3. Jalankan setup (install dependensi, buat `.env`, generate key, migrasi, dan `storage:link`):
   ```
   composer setup
   ```
   Kalau koneksi database di `.env` belum sesuai, setup akan gagal di tahap migrasi —
   sesuaikan `DB_*` di `.env`, lalu jalankan `php artisan migrate`.

4. Isi data awal (kelas, kategori, identitas sekolah, dan akun contoh) — cukup **sekali saja**:
   ```
   php artisan db:seed
   ```

5. Jalankan server:
   ```
   php artisan serve
   ```
   Buka http://127.0.0.1:8000

6. Login dengan akun contoh (akan diminta mengganti password saat login pertama):
   - **Admin**: admin@sekolah.test / password
   - **Guru**: guru@sekolah.test / password

<details>
<summary>Setup manual (tanpa <code>composer setup</code>)</summary>

```
composer install
copy .env.example .env        # Linux/macOS: cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```
</details>

## Struktur inti

- `app/Models/` — User, SchoolClass, Student, Category, DisciplineRecord, SummonLetter, SiteSetting
- `app/Http/Controllers/` — DisciplineRecordController (formulir inti),
  StudentController (data master), ReportController (rekap poin),
  SummonLetterController (surat pemanggilan), SiteSettingController (pengaturan tampilan & identitas sekolah)
- `app/Http/Middleware/EnsureRole.php` — pembatasan akses `role:admin` / `role:guru`
- `app/Http/Middleware/ForcePasswordChange.php` — wajib ganti password sebelum mengakses halaman lain
- `routes/web.php` — semua route + middleware role
- `database/migrations/` — skema: classes, students, categories, discipline_records, summon_letters,
  site_settings, serta tambahan kolom role & class_id ke tabel users
- `resources/views/partials/theme.blade.php` — gaya tampilan bersama (warna, tombol, form, tabel, badge)

## Catatan desain

Guru hanya bisa melihat & mencatat siswa di kelasnya sendiri (`class_id`).
Ini dicek secara **eksplisit di controller** (bukan lewat Eloquent global scope)
agar mudah diaudit — lihat komentar di `DisciplineRecordController.php`.
