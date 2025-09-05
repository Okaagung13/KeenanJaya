# Analisis Proyek KeenanJaya

Dokumen ini berisi analisis lengkap dari proyek e-commerce "KeenanJaya" per tanggal 5 September 2025. Tujuannya adalah untuk menjadi basis pengetahuan untuk pengembangan dan pemeliharaan di masa mendatang.

## 1. Ringkasan Umum

- **Nama Proyek:** KeenanJaya
- **Jenis Proyek:** Aplikasi Web E-commerce
- **Deskripsi:** Sebuah platform toko online untuk menjual produk (sepatu, pakaian, dll.) dengan fitur-fitur standar e-commerce.

## 2. Teknologi & Lingkungan

- **Framework Backend:** CodeIgniter (diperkirakan versi 3 berdasarkan struktur dan file konfigurasi).
- **Bahasa Pemrograman:** PHP (>= 5.3.7).
- **Database:** MySQL / MariaDB.
- **Lingkungan Pengembangan:** Docker, dengan service terpisah untuk aplikasi PHP (Apache) dan database MySQL.
- **Dependensi Utama (PHP via Composer):**
  - `midtrans/midtrans-php`: Integrasi dengan payment gateway Midtrans.
  - `dompdf/dompdf`: Untuk pembuatan file PDF (kemungkinan untuk invoice).
- **API Eksternal:**
  - **RajaOngkir**: Digunakan untuk kalkulasi biaya pengiriman secara dinamis.

## 3. Arsitektur & Struktur Proyek

Proyek ini mengikuti pola arsitektur **Model-View-Controller (MVC)** yang disediakan oleh CodeIgniter.

- **`application/controllers`**: Berisi logika utama aplikasi dan mengatur alur data.
  - Terdapat pemisahan jelas antara controller untuk publik (`Home.php`, `Dashboard.php`, `Order.php`) dan untuk admin (di dalam direktori `admin/`).
- **`application/models`**: Mengelola semua interaksi dengan database. Nama model (misal: `Model_invoice`, `Model_kategori`) jelas dan sesuai dengan fungsinya.
- **`application/views`**: Bertanggung jawab untuk presentasi (UI).
  - Menggunakan sistem **layout/template** (di dalam `views/layout/`) untuk memisahkan bagian-bagian halaman (header, footer, sidebar) dan menjaga konsistensi UI.
  - Tampilan untuk admin dan pengguna biasa juga dipisahkan dalam direktori yang berbeda.
- **`assets/`**: Menyimpan file-file statis seperti gambar produk, CSS, dan JavaScript.
- **`db/keenanjaya.sql`**: Berisi skema database awal yang digunakan untuk inisialisasi saat pertama kali dijalankan dengan Docker.

## 4. Fungsionalitas & Fitur

### Fitur untuk Pengguna (Pelanggan)

1.  **Autentikasi**: Pengguna dapat mendaftar (`Register.php`) dan masuk (`Auth.php`).
2.  **Manajemen Profil**: Pengguna dapat melihat profil dan mengubah kata sandi (`Profile.php`, `Change_password.php`).
3.  **Katalog Produk**:
    - Melihat semua produk (`Welcome.php`, `Home.php`).
    - Melihat produk berdasarkan kategori (`Categories.php`).
    - Melihat detail masing-masing produk (`Dashboard.php` -> `detail()`).
4.  **Keranjang Belanja (`Dashboard.php` -> `add_to_cart()`)**:
    - Menambahkan produk ke keranjang.
    - Melihat isi keranjang (`cart.php`).
5.  **Proses Checkout & Pembayaran**:
    - Mengisi alamat pengiriman (`checkout.php`).
    - Kalkulasi ongkos kirim otomatis menggunakan API RajaOngkir (`Rajaongkir.php`).
    - Melakukan pembayaran melalui Midtrans atau Transfer Bank Langsung (`Pay.php`, `Bill.php`).
    - Mengunggah bukti pembayaran untuk metode transfer bank.
6.  **Manajemen Pesanan**:
    - Melihat riwayat pesanan (`Order.php`).
    - Melihat detail dari setiap pesanan (`order_detail.php`).

### Fitur untuk Administrator (`/admin`)

1.  **Dashboard Admin**: Halaman utama yang menampilkan ringkasan atau statistik penting (`admin/Dashboard.php`).
2.  **Manajemen Produk (CRUD)**: Admin dapat menambah, melihat, mengedit, dan menghapus produk dari katalog (`admin/Product.php`).
3.  **Manajemen Pesanan/Invoice**:
    - Melihat semua invoice yang masuk dari pelanggan (`admin/Invoice.php`).
    - Memverifikasi pembayaran dan mengubah status pesanan.
4.  **Laporan**: Admin dapat melihat laporan (kemungkinan laporan penjualan) (`admin/Laporan.php`).

## 5. Alur Kerja Utama (E-commerce Flow)

1.  Pengguna melihat produk.
2.  Pengguna menambahkan produk ke keranjang belanja. Stok produk akan berkurang (berdasarkan *trigger* di database).
3.  Pengguna melanjutkan ke halaman checkout.
4.  Pengguna mengisi detail pengiriman. Ongkos kirim dari RajaOngkir ditampilkan.
5.  Pengguna memilih metode pembayaran (Midtrans/Transfer) dan menyelesaikan pesanan.
6.  Sebuah `invoice` (pesanan) baru dibuat di `transaction` table dengan status "pending" atau "unpaid".
7.  Jika memilih Transfer Bank, pengguna mengunggah bukti bayar. Admin akan memverifikasi ini secara manual.
8.  Jika memilih Midtrans, status pembayaran akan diperbarui secara otomatis melalui notifikasi dari Midtrans.
9.  Admin memproses pesanan yang sudah dibayar dan memasukkan nomor resi.
10. Pengguna dapat melacak status pesanannya.

## 6. Analisis Keamanan (Potensi Peningkatan)

- **Hashing Password**: Saat ini menggunakan **MD5**, yang sudah usang dan tidak aman. Ini harus segera ditingkatkan ke algoritma modern seperti **Argon2** atau **bcrypt** (menggunakan fungsi `password_hash()` dan `password_verify()` dari PHP).
- **CSRF Protection**: Fitur proteksi Cross-Site Request Forgery dari CodeIgniter saat ini **dinonaktifkan** (`$config['csrf_protection'] = FALSE;`). Ini harus diaktifkan untuk melindungi semua form dari serangan CSRF.
- **XSS (Cross-Site Scripting)**: Perlu dipastikan bahwa semua input dari pengguna (terutama pada form produk dan profil) telah di-filter dengan benar untuk mencegah serangan XSS. CodeIgniter memiliki beberapa mekanisme untuk ini yang harus digunakan secara konsisten.
