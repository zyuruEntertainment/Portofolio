# Deploy Laravel dengan MySQL

Aplikasi ini menggunakan MySQL atau MariaDB dengan InnoDB sebagai satu-satunya backend database. Database baru memang dimulai kosong; record dari database SQLite lama sengaja tidak dipindahkan. File SQLite lama tetap menjadi backup lokal dan bukan bagian deployment.

## Persyaratan hosting

- PHP 8.3 atau lebih baru dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `tokenizer`, `xml`, `ctype`, `filter`, `hash`, dan `session`.
- MySQL 8+ atau MariaDB modern dengan InnoDB, `utf8mb4`, dan dukungan indeks InnoDB setidaknya 3072 byte.
- Composer 2 dan akses terminal untuk menjalankan Artisan (direkomendasikan).

## Buat database dan pengguna

Melalui panel hosting, buat database MySQL dan pengguna khusus untuk aplikasi. Berikan pengguna hak akses hanya pada database tersebut. Salin nama database, pengguna, kata sandi, host, dan port yang diberikan panel; shared hosting sering menambahkan prefix akun pada database dan pengguna.

## Environment produksi

Salin `.env.example` menjadi `.env` di server atau gunakan secret manager/panel hosting. Jangan memasukkan `.env` ke Git atau mengirim nilai rahasia melalui chat. Isi variabel berikut dengan nilai dari panel:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda.example
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
DB_CONNECTION=mysql
DB_HOST=host-dari-panel
DB_PORT=3306
DB_DATABASE=nama_database_dari_panel
DB_USERNAME=pengguna_dari_panel
DB_PASSWORD=password_database
```

Aktifkan sertifikat TLS dan paksa redirect HTTP ke HTTPS melalui panel hosting. Pertahankan `APP_KEY` saat memperbarui deployment. Gunakan cookie session `Secure`, `HttpOnly`, dan `SameSite=Lax` melalui variabel di atas. Untuk database session/cache/queue, gunakan `SESSION_DRIVER=database`, `CACHE_STORE=database`, dan `QUEUE_CONNECTION=database`; tabelnya dibuat oleh migrasi. Jika hosting tidak menyediakan worker antrean, gunakan `QUEUE_CONNECTION=sync` atau atur worker sesuai fasilitas hosting.

## Fresh install dan akun admin

Cadangkan file SQLite lama sebelum perubahan lokal; jangan mengimpor record-nya. Setelah upload kode, atur `.env` dan siapkan database kosong, jalankan:

```sh
composer install --no-dev --optimize-autoloader
php artisan migrate --force
```

Migrasi aman untuk database kosong dan tidak menghapus database lama. Jangan gunakan `migrate:fresh` atau `db:wipe` pada database produksi.

Buat administrator secara manual melalui prompt tersembunyi, bukan dengan password pada command line:

```sh
php artisan admin:create admin@zyuru.com --name="Admin Zyuru"
```

Perintah ini meminta password dan konfirmasi tanpa menampilkannya. Di development, password minimal 8 karakter. Di production, password harus minimal 16 karakter dengan huruf besar/kecil, angka, dan simbol. Perintah menormalkan email, membuat hash password Laravel, dan tidak mengubah password bila akun tersebut sudah ada. Jangan gunakan password sementara development pada production. Alternatif seeder juga tidak membuat akun tanpa kredensial eksplisit dan tidak mereset akun yang sudah ada.

## Deploy file dan web root

Atur document root domain ke direktori `public` Laravel, bukan root proyek. Jika panel tidak mendukung pengaturan ini, ikuti prosedur aman hosting agar `.env`, `vendor`, dan source aplikasi tidak dapat diakses melalui web.

Media profil dan proyek disimpan pada `storage/app/public`. Salin berkas media yang memang ingin dipertahankan secara terpisah; record lama tidak diimpor sehingga berkas lama tidak otomatis terhubung ke proyek baru. Buat storage link:

```sh
php artisan storage:link
```

Pastikan pengguna PHP dapat menulis ke `storage` dan `bootstrap/cache` (biasanya izin direktori `775` dengan kepemilikan/grup yang sesuai hosting). Jangan memakai izin global `777`.

Jika terminal tersedia, sesudah konfigurasi database siap, jalankan optimasi berikut:

```sh
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Pengujian dan pemeriksaan deployment

Sediakan database test terpisah bernama `portfolio_test` dan kredensial lokal yang memiliki hak pada database tersebut. PHPUnit dipaksa menggunakan koneksi MySQL dan nama database ini; ia tidak memiliki fallback SQLite. Database test boleh di-reset oleh trait migrasi test, jadi jangan pernah arahkan konfigurasi test ke database produksi.

Setelah deploy, periksa status migrasi (`php artisan migrate:status`), halaman publik dan empty state, login/logout admin, perubahan profil, CRUD proyek dan media, tautan sosial, serta dashboard admin. Verifikasi juga bahwa akun tamu diarahkan ke halaman login dan admin berhasil masuk ke dashboard.

- `SQLSTATE[HY000] [2002]`: periksa host/port atau socket persis dari panel dan pastikan layanan menerima koneksi dari hosting.
- `Access denied`: periksa prefix nama database/pengguna serta hak akses pengguna.
- `Unknown database`: database belum dibuat atau `DB_DATABASE` salah.
- Tabel tidak ditemukan: pastikan `.env` menunjuk ke database yang benar, jalankan `php artisan config:clear`, lalu `php artisan migrate --force`.
- Ekstensi tidak ditemukan: aktifkan `pdo_mysql` untuk versi PHP yang dipakai web server dan CLI.

Untuk error lebih lanjut, periksa `storage/logs/laravel.log` dan log hosting tanpa mengaktifkan `APP_DEBUG` atau membagikan kredensial.
