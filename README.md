# SetUp Pedia - Gaming & Tech Setup E-Commerce Platform

**SetUp Pedia** adalah platform e-commerce gaming dan *tech setup* modern yang dibangun menggunakan **Laravel 13**, **PHP 8.3+**, **MySQL 8+ / SQLite**, **Blade**, **Tailwind CSS v4**, **Alpine.js**, dan **Laravel Sanctum**. Mengusung konsep visual modern dengan palet warna terpadu **Hijau Sage** (`#507159`) dan **Putih Abu** (`#f6f8f6`), integrasi resmi **Midtrans Snap Payment Gateway** (QRIS, E-Wallet, Virtual Account), mitigasi race condition stok melalui *pessimistic row locking*, pengelolaan katalog produk terpusat oleh Administrator toko, proteksi akun belanja (`CustomerOnlyMiddleware`), cetak invoice resmi, serta REST API v1 siap integrasi mobile apps.

Sistem dirancang dengan arsitektur **2 Peran Murni (Pure 2-Role System: Super Admin & Pelanggan)** tanpa perantara *seller*, memberikan kontrol penuh kepada pemilik toko dalam mengelola katalog perlengkapan komputer, laptop, dan gear setup.

---

## 🌟 Fitur Utama Berdasarkan Peran

### 1. Pelanggan (Customer)
* **Katalog & Beranda Interaktif**:
  * Hero banner slider promosi gaming gear beresolusi tinggi.
  * Navigasi Mega Menu kategori interaktif dengan ikon vektor elegan.
  * Section prioritas **Laptop Gaming Flagship & Ultrabook** di bagian teratas.
  * Koleksi **50 Produk Budget (< Rp 5 Juta)** dengan tombol filter cepat.
  * Super Flash Sale dengan hitung mundur waktu (*countdown timer*) real-time berbasis Alpine.js.
  * Filter multi-kriteria: kategori, rentang harga, rating bintang, urutan (termurah, termahal, terlaris, rating tertinggi).
  * Halaman detail produk komprehensif: galeri multi-foto, varian dinamis (spesifikasi/RAM/warna) dengan penyesuaian harga real-time, badge garansi & estimasi pengiriman.
* **Keranjang Belanja & Wishlist**:
  * Pengelolaan produk yang ingin dibeli dengan tombol navigasi kembali dan breadcrumb yang rapi.
  * Fitur centang pilihan item (*checkbox item & pilih semua*) untuk fleksibilitas checkout sebagian.
  * Fitur Beli Langsung (*Buy Now*) langsung mengarah ke alur checkout pesanan.
  * Wishlist: simpan gear impian dan pindahkan langsung ke keranjang dengan 1 klik.
* **Buku Alamat Pengiriman**:
  * Pengelolaan multi-alamat penerima lengkap dengan penanda alamat utama (*primary*).
* **Checkout Aman & Midtrans Payment Gateway**:
  * Validasi voucher diskon platform (*nominal tetap / potongan harga*) dengan syarat belanja minimum.
  * Pilihan kurir pengiriman (Reguler, Hemat, Express / JNE, SiCepat, GoSend).
  * **Midtrans Snap Popup Resmi (Sandbox)**: Mendukung pembayaran QRIS otomatis (Gopay, OVO, ShopeePay), Transfer Bank Virtual Account (BCA, Mandiri, BNI, BRI, Permata), dan Kartu Kredit.
  * Tombol **Perbarui Sesi** jika transaksi Midtrans kedaluwarsa.
  * **Pessimistic Row Locking (`lockForUpdate`)**: Menjamin stok produk tidak akan pernah bernilai negatif meskipun terjadi lonjakan transaksi checkout secara bersamaan (*race condition prevention*).
* **Riwayat Pesanan, Invoice & Ulasan**:
  * Pelacakan status pesanan real-time: `pending` (menunggu pembayaran) → `paid` (sudah dibayar) → `processing` (diproses penjual) → `shipped` (sedang dikirim) → `delivered` (telah sampai) → `completed` (selesai) / `cancelled` (dibatalkan).
  * **Cetak Invoice Resmi**: Ekspor dan cetak rincian faktur transaksi belanja.
  * Fitur pembatalan pesanan mandiri berstatus *pending* dengan pengembalian stok otomatis (*inventory rollback*).
  * Konfirmasi penerimaan pesanan & sistem ulasan produk (*rating bintang 1-5, upload foto, dan ulasan teks*).

---

### 2. Administrator Toko (Super Admin)
* **Dashboard Metrik Platform**:
  * Ringkasan GMV (*Gross Merchandise Value*), total transaksi platform, total pengguna terdaftar, dan total katalog SKU aktif.
  * Visualisasi distribusi pesanan masuk dan performa penjualan.
* **Manajemen Katalog Produk Terpusat**:
  * Form Tambah & Edit Produk: multi-upload foto produk, kategori, berat, kondisi barang, harga coret/diskon flash sale, dan varian dinamis.
  * Pengelolaan status aktif/nonaktif dan pemantauan stok menipis (≤5 unit).
* **Manajemen Kategori Belanja**:
  * Tambah dan kelola hierarki kategori (*parent-child*) dengan **Custom Vector Icon Picker** SVG elegan (tanpa emoji AI).
* **Moderasi Pengguna Platform**:
  * Daftar seluruh akun pengguna (Admin dan Pelanggan).
  * Filter role dan status akun.
  * Fitur moderasi: tombol suspend / aktifkan kembali akun pengguna.
* **Manajemen Pesanan & Resi Pengiriman**:
  * Monitoring menyeluruh terhadap seluruh order pelanggan, verifikasi status pembayaran Midtrans, dan pemrosesan pesanan.
  * Fitur pengiriman dengan input nomor resi kurir (`processing` → `shipped` + `tracking_number`).
* **Marketing & Promosi Platform**:
  * Pengelolaan banner slider beranda (*hero banner, promo banner, sort order*).
  * Pengelolaan voucher diskon platform (kode kupon unik, kuota pemakaian, masa berlaku, potongan harga).
* **Proteksi Transaksi Admin (`CustomerOnlyMiddleware`)**:
  * Akun Administrator dibatasi dari melakukan aktivitas belanja / checkout agar tidak mencemari data pembukuan platform.
  * Tombol belanja pada halaman produk digantikan dengan notifikasi informatif dan shortcut langsung ke Dashboard Admin.

---

### 3. REST API v1 (Laravel Sanctum)
REST API versi 1 siap digunakan untuk integrasi Mobile Apps (Android/iOS) atau Frontend SPA terpisah:
* `POST /api/v1/auth/login`: Otentikasi dan penerbitan personal access token Sanctum.
* `POST /api/v1/auth/register`: Pendaftaran akun pelanggan baru.
* `GET  /api/v1/auth/me`: Informasi profil pengguna yang sedang login (`Bearer Token`).
* `POST /api/v1/auth/logout`: Revoke/hapus token otentikasi.
* `GET  /api/v1/products`: Katalog produk publik dengan pencarian, kategori, pengurutan harga/terlaris, dan paginasi.
* `GET  /api/v1/products/{slugOrId}`: Detail produk lengkap beserta varian, foto, dan spesifikasi.
* `GET  /api/v1/categories`: Daftar seluruh kategori aktif beserta sub-kategorinya.
* `GET  /api/v1/cart`: Daftar item dalam keranjang belanja pelanggan.
* `POST /api/v1/cart/add`: Menambahkan item dan varian ke keranjang belanja.
* `PUT  /api/v1/cart/{id}`: Mengubah kuantitas item keranjang.
* `DELETE /api/v1/cart/{id}`: Menghapus item dari keranjang.
* `POST /api/v1/checkout`: Eksekusi checkout transaksi dengan locking stok atomik.
* `GET  /api/v1/orders`: Daftar transaksi pesanan pelanggan.
* `GET  /api/v1/orders/{id}`: Detail pesanan dan status pengiriman.
* `POST /api/v1/orders/{id}/pay`: Simulasi konfirmasi pembayaran.
* `POST /api/v1/orders/{id}/cancel`: Pembatalan pesanan dan pengembalian stok.
* `POST /api/v1/midtrans/callback`: Webhook notifikasi pembayaran otomatis dari Midtrans.

---

## 🔐 Akun Uji Coba Default (Demo Credentials)

Semua akun demo menggunakan kata sandi default: `password`

| Peran (Role) | Email | Kata Sandi | Akses Halaman | Keterangan |
| :--- | :--- | :--- | :--- | :--- |
| **Super Admin** | `admin@example.com` | `password` | `/admin/dashboard` | Pengelola penuh toko & katalog |
| **Pelanggan (Customer)**| `customer@example.com` | `password` | `/` (Beranda Toko) | Pembeli perlengkapan setup |

> [!NOTE]  
> Pada halaman login (`/login`), tersedia tombol **Akun Demo** untuk mengisi kredensial Admin dan Pelanggan secara instan dalam 1 klik.

---

## 🛠️ Persyaratan Sistem & Instalasi

### Persyaratan
- PHP >= 8.3 (dengan ekstensi: `pdo_mysql`, `pdo_sqlite`, `mbstring`, `openssl`, `fileinfo`, `gd`/`imagick`, `curl`)
- MySQL >= 8.0 atau SQLite
- Composer >= 2.x
- Node.js >= 18.x & npm

### Langkah Instalasi
1. **Clone Repository**:
   ```bash
   git clone https://github.com/fikriirwnsyh21-del/ecommerce_SetUp-Pedia.git
   cd ecommerce_SetUp-Pedia
   ```

2. **Salin environment file & konfigurasi database**:
   ```bash
   cp .env.example .env
   ```
   *Sesuaikan konfigurasi database (`DB_CONNECTION=mysql` atau `DB_CONNECTION=sqlite`) serta kunci `MIDTRANS_SERVER_KEY` & `MIDTRANS_CLIENT_KEY` di file `.env`.*

3. **Install dependensi PHP**:
   ```bash
   composer install
   ```

4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

5. **Jalankan Migrasi & Database Seeder**:
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Buat Symlink Storage untuk Berkas Gambar**:
   ```bash
   php artisan storage:link
   ```

7. **Install dependensi Frontend & Build Assets**:
   ```bash
   npm install
   npm run build
   ```

8. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui peramban di: `http://localhost:8000`

---

## 📐 Arsitektur & Standar Koding
- **Separation of Concerns**: Menggunakan *Dedicated Service Classes* (`CartService`, `CheckoutService`, `VoucherService`, `MidtransService`, `BudgetProductsSeeder`) untuk memisahkan domain business logic dari Controller.
- **Data Integrity & Concurrency**: Memanfaatkan database transactions (`DB::transaction`) dan row-level locking (`lockForUpdate`) untuk memastikan integritas data keuangan dan inventori saat checkout berbarengan.
- **Role Isolation Security**: Penggunaan middleware `CustomerOnlyMiddleware` untuk memisahkan akun Administrator dari keranjang belanja dan transaksi konsumen.
- **Clean UI & Responsive Design**: Dibangun dengan Tailwind CSS v4 `@theme` dengan palet warna terpadu Hijau Sage dan Putih Abu yang konsisten di layar mobile, tablet, maupun desktop.
- **Clean Code Style**: Diformat mengikuti standar PSR-12 dan Laravel Pint.
