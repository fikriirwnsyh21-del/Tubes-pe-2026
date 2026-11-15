# SetUp Pedia - E-Commerce TUBES PEMROGRAMAN ECOMMERCE

Aplikasi web e-commerce untuk perlengkapan komputer, laptop, dan gaming setup yang dibangun menggunakan **Laravel 13**, **MySQL**, **Tailwind CSS**, dan **Midtrans Payment Gateway (Sandbox)**. 

Dibuat untuk memenuhi Tugas Besar Praktikum Pemrograman E-Commerce dengan 2 role pengguna: **Admin** dan **Customer**.

---

## 🔑 Akun Demo (Uji Coba)

Pada halaman login (`/login`), sudah tersedia tombol cepat untuk mengisi akun demo:

| Role | Email | Password | Akses |
|---|---|---|---|
| **Admin** | `admin@example.com` | `password` | `/admin/dashboard` |
| **Customer** | `customer@example.com` | `password` | `/` (Halaman Toko) |

---

## 🚀 Fitur Aplikasi

### 1. Halaman Admin
- **Dashboard**: Menampilkan total produk, total kategori, total pelanggan, total pesanan, pesanan menunggu pembayaran, dan pesanan sudah dibayar.
- **Kelola Kategori**: Tambah, lihat, edit, dan hapus kategori produk (CRUD).
- **Kelola Produk**: Tambah produk, upload gambar, atur harga, kondisi, berat, dan stok (CRUD).
- **Kelola Pesanan**: Melihat seluruh pesanan masuk, detail pembeli, item yang dibeli, dan input nomor resi pengiriman (`processing` → `shipped`).
- **Keamanan Transaksi**: Status pembayaran pesanan terhubung dengan Midtrans dan tidak bisa diubah manual secara sembarangan dari dashboard.

### 2. Halaman Customer
- **Autentikasi & Akun**: Registrasi, login, logout, dan pengelolaan alamat pengiriman.
- **Katalog & Pencarian**: Daftar produk dengan filter kategori, pencarian nama produk, filter rentang harga, dan sorting.
- **Detail Produk**: Foto produk, deskripsi, spesifikasi/varian, dan informasi stok.
- **Keranjang Belanja**: Tambah produk, ubah kuantitas, hapus item, dan cek ketersediaan stok.
- **Checkout**: Form data penerima, alamat pengiriman, dan pilihan kurir.
- **Pembayaran Midtrans**: Integrasi Midtrans Snap Sandbox (mendukung QRIS, Transfer Bank Virtual Account, dll).
- **Riwayat Pesanan & Invoice**: Pelacakan status pesanan real-time (`pending`, `paid`, `processing`, `shipped`, `delivered`, `completed`, `cancelled`) dan fitur cetak invoice.

---

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 13 (PHP 8.3+)
- **Database**: MySQL (Eloquent ORM, Migration, Seeder)
- **Frontend**: Blade, Tailwind CSS, Alpine.js
- **Payment Gateway**: Midtrans Snap Sandbox (dengan verifikasi notifikasi webhook SHA-512)
- **Autentikasi**: Laravel Auth & Middleware

---

## 🗄️ Struktur Database

Relasi antar tabel utama dalam sistem:
- `users`: Data akun admin dan customer.
- `categories`: Kategori produk.
- `products` & `product_images`: Data produk dan galeri foto.
- `carts` & `cart_items`: Keranjang belanja pengguna.
- `orders` & `order_items`: Data transaksi pesanan beserta snapshot nama & harga barang saat transaksi.
- `payments`: Data transaksi Midtrans (order ID, status, gross amount, snap token).

---

## 💻 Cara Install & Menjalankan di Komputer Lokal

### 1. Clone Repository
```bash
git clone https://github.com/fikriirwnsyh21-del/Tubes-pe-2026.git
cd Tubes-pe-2026
```

### 2. Copy `.env` & Atur Konfigurasi
```bash
cp .env.example .env
```
Buka file `.env` dan pastikan konfigurasi database dan key Midtrans sudah sesuai:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce
DB_USERNAME=root
DB_PASSWORD=

MIDTRANS_SERVER_KEY=SB-Mid-server-xxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxx
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_SNAP_URL=https://app.sandbox.midtrans.com/snap/snap.js
```

### 3. Install Dependensi PHP
```bash
composer install
php artisan key:generate
```

### 4. Migrasi & Seed Database
```bash
php artisan migrate:fresh --seed
```
*Perintah ini akan membuat semua tabel dan mengisi data awal (akun demo, kategori, serta katalog produk).*

### 5. Hubungkan Storage Gambar
```bash
php artisan storage:link
```

### 6. Install & Build Aset Frontend
```bash
npm install
npm run build
```

### 7. Jalankan Server
```bash
php artisan serve
```
Buka browser dan akses: `http://localhost:8000`

---

## 💳 Pengujian Pembayaran Midtrans Sandbox

1. Login sebagai Customer (`customer@example.com`).
2. Masukkan produk ke keranjang dan lanjut ke **Checkout**.
3. Isi data pengiriman, pilih kurir, lalu klik **Bayar Sekarang**.
4. Popup Midtrans Snap akan muncul:
   - Untuk **QRIS**: Scan via simulator atau klik simulasi bayar.
   - Untuk **Virtual Account (BCA/BNI/BRI/Mandiri)**: Salin nomor VA dan bayar via [Midtrans Payment Simulator](https://simulator.sandbox.midtrans.com/).
5. Status pesanan akan otomatis terupdate menjadi `paid` melalui notifikasi webhook, dan stok produk berkurang.
6. Detail transaksi dan bukti pembelian dapat dilihat pada menu **Riwayat Pesanan** dan tombol **Cetak Invoice**.
