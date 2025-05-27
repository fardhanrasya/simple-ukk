# Aplikasi Pemesanan Makanan Sederhana

Aplikasi web sederhana untuk memesan makanan secara online, dibuat dengan PHP, MySQL, dan Bootstrap.

## Persyaratan Sistem

1. XAMPP (terinstall PHP dan MySQL)
2. Web browser (Chrome, Firefox, dll.)

## Panduan Instalasi

### 1. Menyiapkan Database

1. Pastikan XAMPP sudah terinstall dan berjalan
2. Buka XAMPP Control Panel dan jalankan Apache dan MySQL
3. Buka web browser dan akses: `http://localhost/phpmyadmin`
4. Klik "New" di sidebar kiri untuk membuat database baru
5. Beri nama database: `db_pemesanan_makanan`
6. Klik tombol "Import" di menu atas
7. Klik "Choose File" dan cari file `database.sql` di folder proyek Anda
8. Klik tombol "Go" di bagian bawah halaman untuk mengimpor database

### 2. Menyiapkan File Aplikasi

1. Salin seluruh isi folder proyek ke dalam folder `htdocs` di XAMPP
   - Biasanya berada di: `C:\xampp\htdocs\simple-ukk`
   - Pastikan file-file berikut ada di dalam folder tersebut:
     - `index.php`
     - `detail.php`
     - `database.sql` (sudah tidak diperlukan lagi setelah diimpor)

### 3. Menjalankan Aplikasi

1. Pastikan XAMPP Apache dan MySQL sudah berjalan
2. Buka web browser (Chrome, Firefox, dll.)
3. Ketik alamat berikut di address bar:
   ```
   http://localhost/simple-ukk
   ```
4. Aplikasi siap digunakan!
