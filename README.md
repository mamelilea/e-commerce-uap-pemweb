<p align="center">
  <a href="https://github.com/rsyfariz/e-commerce-uap-pemweb.git">
    <h1 align="center">E-Commerce UAP Kelompok 4</h1>
  </a>
</p>

Repository ini merupakan proyek Laravel 12 yang sudah dilengkapi dengan Laravel Breeze sebagai starter kit untuk fitur autentikasi, serta struktur database yang telah disediakan. Fitur sudah dikembangkan sesuai instruksi dengan menggunakan repository https://github.com/mamelilea/e-commerce-uap-pemweb.git sebagai dasar.

## Link Youtube Demo

https://youtu.be/i07uLfd19RE

## Penjelasan Fitur

Membuat antarmuka CRUD sederhana untuk aplikasi E-Commerce dengan beberapa halaman berikut:

Halaman Pengguna (Customer Side)

1. **Homepage:** Berisi daftar produk, termasuk:
    - Daftar seluruh produk
    - Daftar produk berdasarkan kategori
2. **Halaman Detail Produk:** Menampilkan satu produk beserta detailnya, seperti deskripsi, gambar, kategori, dan ulasan.
3. **Halaman Checkout:** Pengguna mengisi alamat, memilih jenis pengiriman, dan menyelesaikan pembelian.
4. **Halaman Riwayat Transaksi (Opsional) :** Menampilkan riwayat pembelian dan detail transaksinya.

Halaman Toko (Seller Dashboard):

1. **Halaman Registrasi Toko:** Penjual membuat profil toko
2. **Halaman Manajemen Pesanan:** Melihat dan memperbarui pesanan masuk, informasi pengiriman, serta nomor resi.
3. **Halaman Saldo Toko:** Melihat saldo dan riwayat perubahan saldo.
4. **Halaman Penarikan Saldo:** Mengajukan penarikan dan melihat riwayat penarikan, termasuk:
    - Mengelola (mengubah) nama bank, nama pemilik rekening, dan nomor rekening
5. **Halaman Manajemen Toko:** Untuk penjual mengelola tokonya, termasuk:
    - Mengelola (ubah/hapus) profil toko
    - Mengelola (buat/ubah/hapus) produk
    - Mengelola (buat/ubah/hapus) kategori produk
    - Mengelola (buat/ubah/hapus) gambar produk

Halaman Admin (Owner of e-commerce):

1. **Halaman Verifikasi Toko:** Memverifikasi atau menolak pengajuan pembuatan toko.
2. **Halaman Manajemen Pengguna & Toko:** Melihat dan mengelola seluruh pengguna dan toko yang terdaftar.

## Struktur Database

![db structure](https://github.com/WisnuIbnu/E-Commerce-pemweb-uap/blob/main/public/db_structure.png?raw=true)

## Prasyarat

Untuk menjalankan proyek ini, Anda memerlukan:

-   PHP >= 8.3
-   Composer
-   NPM
-   Database server (MySQL, MariaDB, PostgreSQL, or SQLite)

## Instalasi

Ikuti langkah-langkah berikut untuk melakukan instalasi dan menjalankan proyek dalam lingkungan pengembangan di komputer lokal Anda:

1. Clone repository versi terbaru dari sumber yang diberikan:

```bash
git clone https://github.com/mamelilea/e-commerce-uap-pemweb.git
```

2. masuk ke folder tersebut

```bash
cd e-commerce-uap-pemweb
```

3. Instal dependensi PHP menggunakan Composer:

```bash
composer install
```

4. Salin file .env.example menjadi .env lalu sesuaikan konfigurasi database:

```bash
cp .env.example .env
```

5. Generate application key:

```bash
php artisan key:generate
```

6. pastikan xampp menyala, dan di database local kamu sudah buat `database` dengan nama yang sama dengan .env :

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=e_commerce_uap
DB_USERNAME=root
DB_PASSWORD=
```

7. Jalankan migrasi database:

```bash
php artisan migrate
```

Jika ingin menambahkan data dummy, gunakan:

```bash
php artisan migrate --seed
```

8. Jalankan development server Laravel:

```bash
php artisan serve
```

9. buka terminal yang lain (terminal ada 2), Pada terminal lain, install semua modul Node.js dan lakukan build:

```bash
npm install
npm run build
```

10. Kompilasi asset dalam mode pengembangan:

```bash
npm run dev
```

11. Buka browser dan akses aplikasi:

```bash
http://localhost:8000
```

12. Akun Login :

```bash
Customer
email : rasyacahyo12@gmail.com
password : 12345678
```

```bash
Seller
email : elektronik@marketplace.com
password : password
```

```bash
Admin
email : admin@marketplace.com
password : password
```

<h3 align="center">Big Thanks Kak Achmal & Kak Winaya 💕</h3>
