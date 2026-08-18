# Dokumen Lengkap Database CMS E-Commerce Sekolah

Dokumen ini berisi rancangan database lengkap untuk aplikasi CMS e-commerce sekolah berbasis Laravel. Fokus dokumen adalah backend, struktur tabel, relasi, data awal, query dashboard, serta catatan implementasi.

Rancangan ini tetap memakai referensi awal:

- Modul user dan autentikasi: `admin`, `pembeli`, `siswa`.
- Modul profile.
- Modul jurusan.
- Modul katalog produk dan jasa.
- Modul pemesanan dan transaksi.
- Modul ulasan.
- Modul dashboard dan ringkasan.
- Produk sekolah: aksesoris, merchandise, dan pepelege produk.
- Jasa setiap jurusan: DKV & Animasi, Pemasaran, PPLG, dan Akuntansi.

---

## 1. Informasi Umum Database

| Item | Nilai |
|---|---|
| Nama database | `cms_ecommerce_sekolah` |
| DBMS | MySQL / MariaDB |
| Storage engine | InnoDB |
| Charset | `utf8mb4` |
| Collation | `utf8mb4_unicode_ci` |
| Framework backend | Laravel |
| Fokus sistem | CMS e-commerce sekolah |
| Tipe konten | Produk fisik dan jasa jurusan |

---

## 2. Ruang Lingkup Database

Database ini dirancang untuk menyimpan data berikut:

1. Data user dan role.
2. Data profil user.
3. Data jurusan.
4. Data kategori produk dan jasa.
5. Data produk fisik.
6. Data jasa jurusan.
7. Relasi produk/jasa dengan jurusan.
8. Gambar produk.
9. Data pesanan.
10. Detail item pesanan.
11. Bukti pembayaran.
12. Verifikasi pembayaran.
13. Ulasan pembeli.
14. Pengaturan sistem.

Catatan penting:

- Kolom `bukti_pembayaran` dari referensi ditempatkan pada tabel `payments`.
- Tabel `payments` dipisahkan dari tabel `orders` agar riwayat pembayaran lebih rapi.
- Jika dibutuhkan versi yang lebih sederhana, bukti pembayaran dapat disimpan langsung di tabel `orders`, tetapi untuk skala CMS profesional lebih aman dipisahkan.
- `(tag: saran)` Istilah `Pepelege Produk` tetap dipertahankan sesuai referensi, tetapi untuk tampilan publik dapat diperjelas menjadi `Perangkat / IoT`.

---

## 3. Modul Referensi dan Pemetaan Tabel

| Modul Referensi | Tabel Terkait | Keterangan |
|---|---|---|
| Modul User dan Autentikasi | `users` | Menyimpan akun admin, pembeli, dan siswa. |
| Profile | `profiles` | Menyimpan detail profil user. |
| Modul Jurusan | `jurusan` | Menyimpan data jurusan sekolah. |
| Kategori Produk/Jasa | `categories` | Menyimpan kategori dan subkategori katalog. |
| Katalog Produk dan Jasa | `products` | Menyimpan produk fisik dan jasa. |
| Relasi Produk/Jasa ke Jurusan | `product_jurusan` | Menyimpan relasi banyak-ke-banyak antara produk/jasa dan jurusan. |
| Gambar Produk | `product_images` | Menyimpan gambar produk. |
| Pemesanan dan Transaksi | `orders` | Menyimpan data pesanan utama. |
| Detail Pesanan | `order_items` | Menyimpan item yang dipesan. |
| Bukti Pembayaran | `payments` | Menyimpan bukti dan status pembayaran. |
| Ulasan | `reviews` | Menyimpan rating dan komentar pembeli. |
| Dashboard | Tidak memerlukan tabel khusus | Dashboard diambil dari agregasi tabel transaksi dan katalog. |
| Pengaturan Sistem | `settings` | Menyimpan konfigurasi dinamis. |

---

## 4. ERD Ringkas

Berikut ERD sederhana dalam bentuk teks.

```txt
jurusan 1 -- N users
users 1 -- 1 profiles
users 1 -- N orders

categories 1 -- N categories
categories 1 -- N products

products N -- M jurusan
products N -- M jurusan melalui product_jurusan

products 1 -- N product_images

orders 1 -- N order_items
order_items N -- 1 products

orders 1 -- N payments
payments N -- 1 users melalui verified_by

users 1 -- N reviews
products 1 -- N reviews
orders 1 -- N reviews
```

---

## 5. Daftar Tabel Utama

| No | Tabel | Fungsi Utama |
|---|---|---|
| 1 | `jurusan` | Data jurusan sekolah. |
| 2 | `users` | Data akun pengguna. |
| 3 | `profiles` | Data profil pengguna. |
| 4 | `categories` | Kategori produk dan jasa. |
| 5 | `products` | Produk fisik dan jasa. |
| 6 | `product_jurusan` | Relasi produk/jasa dengan jurusan. |
| 7 | `product_images` | Gambar produk. |
| 8 | `orders` | Data pesanan utama. |
| 9 | `order_items` | Detail item pesanan. |
| 10 | `payments` | Pembayaran dan bukti pembayaran. |
| 11 | `reviews` | Ulasan produk/jasa. |
| 12 | `settings` | Pengaturan aplikasi. |

---

# 6. Detail Struktur Tabel

---

## 6.1 Tabel `jurusan`

### Fungsi

Menyimpan data jurusan sekolah.

### Referensi Jurusan

1. RPL / PPLG
2. Animasi
3. Akuntansi
4. DKV
5. Pemasaran

### Primary Key

```sql
PRIMARY KEY (id)
```

### Unique Constraint

| Nama Constraint | Kolom | Fungsi |
|---|---|---|
| `uq_jurusan_kode` | `kode_jurusan` | Mencegah kode jurusan duplikat. |
| `uq_jurusan_slug` | `slug` | Mencegah slug jurusan duplikat. |

### Struktur Kolom

| Kolom | Tipe Data | Null | Default | Keterangan |
|---|---|---|---|---|
| `id` | `BIGINT UNSIGNED AUTO_INCREMENT` | Tidak | - | Primary key. |
| `kode_jurusan` | `VARCHAR(20)` | Tidak | - | Kode jurusan, contoh: `PPLG`, `DKV`. |
| `nama_jurusan` | `VARCHAR(100)` | Tidak | - | Nama jurusan. |
| `slug` | `VARCHAR(120)` | Tidak | - | Slug untuk URL. |
| `deskripsi` | `TEXT` | Ya | `NULL` | Deskripsi jurusan. |
| `logo` | `VARCHAR(255)` | Ya | `NULL` | Path file logo jurusan. |
| `is_active` | `TINYINT(1)` | Tidak | `1` | Status aktif/nonaktif. |
| `created_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data dibuat. |
| `updated_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data diperbarui. |

---

## 6.2 Tabel `users`

### Fungsi

Menyimpan data akun pengguna sistem.

### Role Pengguna

| Role | Keterangan |
|---|---|
| `admin` | Mengelola seluruh sistem. |
| `pembeli` | Melihat katalog, memesan, upload bukti pembayaran, memberi ulasan. |
| `siswa` | Mengelola produk/jasa dan pesanan sesuai jurusan yang ditugaskan. |

### Primary Key

```sql
PRIMARY KEY (id)
```

### Unique Constraint

| Nama Constraint | Kolom | Fungsi |
|---|---|---|
| `uq_users_email` | `email` | Mencegah email duplikat. |

### Index

| Nama Index | Kolom | Fungsi |
|---|---|---|
| `idx_users_role` | `role` | Mempercepat filter berdasarkan role. |
| `idx_users_jurusan` | `jurusan_id` | Mempercepat pencarian user berdasarkan jurusan. |

### Foreign Key

| Nama Constraint | Kolom | Tabel Referensi | Aksi Delete |
|---|---|---|---|
| `fk_users_jurusan` | `jurusan_id` | `jurusan(id)` | `SET NULL` |

### Struktur Kolom

| Kolom | Tipe Data | Null | Default | Keterangan |
|---|---|---|---|---|
| `id` | `BIGINT UNSIGNED AUTO_INCREMENT` | Tidak | - | Primary key. |
| `name` | `VARCHAR(100)` | Tidak | - | Nama pengguna. |
| `email` | `VARCHAR(255)` | Tidak | - | Email login. |
| `email_verified_at` | `TIMESTAMP` | Ya | `NULL` | Waktu verifikasi email. |
| `password` | `VARCHAR(255)` | Tidak | - | Password ter-hash. |
| `role` | `ENUM('admin','pembeli','siswa')` | Tidak | `pembeli` | Role pengguna. |
| `jurusan_id` | `BIGINT UNSIGNED` | Ya | `NULL` | Jurusan milik user, khusus siswa atau user yang terkait jurusan. |
| `whatsapp` | `VARCHAR(20)` | Ya | `NULL` | Nomor WhatsApp. |
| `is_active` | `TINYINT(1)` | Tidak | `1` | Status aktif akun. |
| `remember_token` | `VARCHAR(100)` | Ya | `NULL` | Token remember login Laravel. |
| `created_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data dibuat. |
| `updated_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data diperbarui. |

---

## 6.3 Tabel `profiles`

### Fungsi

Menyimpan data profil tambahan untuk user.

### Relasi

One-to-one dengan tabel `users`.

```txt
users.id = profiles.user_id
```

### Primary Key

```sql
PRIMARY KEY (id)
```

### Unique Constraint

| Nama Constraint | Kolom | Fungsi |
|---|---|---|
| `uq_profiles_user` | `user_id` | Satu user hanya memiliki satu profil. |

### Foreign Key

| Nama Constraint | Kolom | Tabel Referensi | Aksi Delete |
|---|---|---|---|
| `fk_profiles_user` | `user_id` | `users(id)` | `CASCADE` |

### Struktur Kolom

| Kolom | Tipe Data | Null | Default | Keterangan |
|---|---|---|---|---|
| `id` | `BIGINT UNSIGNED AUTO_INCREMENT` | Tidak | - | Primary key. |
| `user_id` | `BIGINT UNSIGNED` | Tidak | - | ID user terkait. |
| `nis_nip` | `VARCHAR(50)` | Ya | `NULL` | NIS untuk siswa atau NIP untuk guru/admin. |
| `kelas` | `VARCHAR(50)` | Ya | `NULL` | Kelas siswa. |
| `alamat` | `TEXT` | Ya | `NULL` | Alamat user. |
| `foto` | `VARCHAR(255)` | Ya | `NULL` | Path file foto profil. |
| `created_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data dibuat. |
| `updated_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data diperbarui. |

---

## 6.4 Tabel `categories`

### Fungsi

Menyimpan kategori dan subkategori untuk produk maupun jasa.

### Tipe Kategori

| Tipe | Keterangan |
|---|---|
| `produk` | Kategori untuk produk fisik. |
| `jasa` | Kategori untuk jasa jurusan. |

### Struktur Kategori Referensi

```txt
Produk Sekolah
├── Aksesoris
│   ├── Ganci
│   ├── Nametag
│   ├── Pin
│   ├── Kaos
│   └── Gelas Custom
├── Merchandise
│   ├── Kaos Khusus Sekolah
│   ├── Gelas BN
│   └── Pulpen BN
└── Pepelege Produk
    └── IoT Hardware

Jasa Jurusan
├── DKV & Animasi
│   ├── Animasi
│   ├── Motion Graphic
│   ├── Video Promosi
│   ├── Desain Grafis
│   ├── Logo Gerak
│   ├── Iklan Animasi
│   └── Blender 3D
├── Pemasaran
│   ├── Digital Marketing
│   └── Admin Medsos
├── PPLG
│   ├── Website
│   ├── Mobile
│   ├── Server Hosting
│   ├── Cloud
│   ├── Game Dev
│   ├── Excel
│   └── IoT Software
└── Akuntansi
    ├── Pembukuan
    ├── Pembuatan Laporan
    └── Konsultasi Pajak
```

### Primary Key

```sql
PRIMARY KEY (id)
```

### Unique Constraint

| Nama Constraint | Kolom | Fungsi |
|---|---|---|
| `uq_categories_slug` | `slug` | Mencegah slug kategori duplikat. |

### Index

| Nama Index | Kolom | Fungsi |
|---|---|---|
| `idx_categories_parent` | `parent_id` | Mempercepat pencarian kategori anak. |
| `idx_categories_tipe` | `tipe` | Mempercepat filter kategori produk/jasa. |

### Foreign Key

| Nama Constraint | Kolom | Tabel Referensi | Aksi Delete |
|---|---|---|---|
| `fk_categories_parent` | `parent_id` | `categories(id)` | `CASCADE` |

### Struktur Kolom

| Kolom | Tipe Data | Null | Default | Keterangan |
|---|---|---|---|---|
| `id` | `BIGINT UNSIGNED AUTO_INCREMENT` | Tidak | - | Primary key. |
| `parent_id` | `BIGINT UNSIGNED` | Ya | `NULL` | ID kategori induk. |
| `nama_kategori` | `VARCHAR(120)` | Tidak | - | Nama kategori. |
| `slug` | `VARCHAR(140)` | Tidak | - | Slug untuk URL kategori. |
| `tipe` | `ENUM('produk','jasa')` | Tidak | - | Tipe kategori. |
| `deskripsi` | `TEXT` | Ya | `NULL` | Deskripsi kategori. |
| `is_active` | `TINYINT(1)` | Tidak | `1` | Status aktif kategori. |
| `created_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data dibuat. |
| `updated_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data diperbarui. |

---

## 6.5 Tabel `products`

### Fungsi

Menyimpan produk fisik dan jasa.

### Tipe Produk

| Tipe | Keterangan |
|---|---|
| `barang` | Produk fisik, memiliki stok. |
| `jasa` | Layanan jurusan, biasanya menggunakan estimasi pengerjaan. |

### Status Produk

| Status | Keterangan |
|---|---|
| `draft` | Produk belum dipublikasikan. |
| `aktif` | Produk tampil di katalog. |
| `nonaktif` | Produk tidak tampil di katalog. |

### Primary Key

```sql
PRIMARY KEY (id)
```

### Unique Constraint

| Nama Constraint | Kolom | Fungsi |
|---|---|---|
| `uq_products_slug` | `slug` | Mencegah slug produk duplikat. |

### Index

| Nama Index | Kolom | Fungsi |
|---|---|---|
| `idx_products_category` | `category_id` | Mempercepat filter produk berdasarkan kategori. |
| `idx_products_tipe` | `tipe` | Mempercepat filter barang/jasa. |
| `idx_products_status` | `status` | Mempercepat filter status produk. |
| `ft_products_cari` | `nama_produk`, `deskripsi` | Fulltext search untuk pencarian katalog. |

### Foreign Key

| Nama Constraint | Kolom | Tabel Referensi | Aksi Delete |
|---|---|---|---|
| `fk_products_category` | `category_id` | `categories(id)` | `RESTRICT` |

### Struktur Kolom

| Kolom | Tipe Data | Null | Default | Keterangan |
|---|---|---|---|---|
| `id` | `BIGINT UNSIGNED AUTO_INCREMENT` | Tidak | - | Primary key. |
| `category_id` | `BIGINT UNSIGNED` | Tidak | - | Kategori produk/jasa. |
| `nama_produk` | `VARCHAR(180)` | Tidak | - | Nama produk atau jasa. |
| `slug` | `VARCHAR(200)` | Tidak | - | Slug untuk URL detail produk. |
| `tipe` | `ENUM('barang','jasa')` | Tidak | - | Tipe produk. |
| `deskripsi` | `TEXT` | Ya | `NULL` | Deskripsi produk/jasa. |
| `harga` | `DECIMAL(15,2)` | Tidak | `0` | Harga normal. |
| `harga_diskon` | `DECIMAL(15,2)` | Ya | `NULL` | Harga diskon, jika ada. |
| `stok` | `INT UNSIGNED` | Ya | `0` | Stok untuk produk fisik. |
| `satuan` | `VARCHAR(30)` | Ya | `NULL` | Satuan, contoh: pcs, paket, buah. |
| `is_custom` | `TINYINT(1)` | Tidak | `0` | Penanda produk custom. |
| `estimasi_pengerjaan` | `VARCHAR(100)` | Ya | `NULL` | Estimasi pengerjaan untuk jasa. |
| `status` | `ENUM('draft','aktif','nonaktif')` | Tidak | `draft` | Status publikasi produk. |
| `created_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data dibuat. |
| `updated_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data diperbarui. |

### Catatan Penting

- Untuk tipe `barang`, kolom `stok` sebaiknya diisi.
- Untuk tipe `jasa`, kolom `stok` dapat diisi `0` atau `NULL`.
- Untuk jasa, kolom `estimasi_pengerjaan` dapat diisi, contoh: `7 hari kerja`.
- Untuk produk custom seperti kaos custom atau gelas custom, kolom `is_custom` diisi `1`.

---

## 6.6 Tabel `product_jurusan`

### Fungsi

Menyimpan relasi banyak-ke-banyak antara produk/jasa dan jurusan.

### Alasan Tabel Ini Dibutuhkan

Satu jasa bisa dimiliki oleh lebih dari satu jurusan.

Contoh:

```txt
Jasa Motion Graphic dapat dimiliki oleh jurusan DKV dan Animasi.
```

### Primary Key

```sql
PRIMARY KEY (product_id, jurusan_id)
```

### Index

| Nama Index | Kolom | Fungsi |
|---|---|---|
| `idx_product_jurusan_jurusan` | `jurusan_id` | Mempercepat pencarian produk berdasarkan jurusan. |

### Foreign Key

| Nama Constraint | Kolom | Tabel Referensi | Aksi Delete |
|---|---|---|---|
| `fk_product_jurusan_product` | `product_id` | `products(id)` | `CASCADE` |
| `fk_product_jurusan_jurusan` | `jurusan_id` | `jurusan(id)` | `CASCADE` |

### Struktur Kolom

| Kolom | Tipe Data | Null | Default | Keterangan |
|---|---|---|---|---|
| `product_id` | `BIGINT UNSIGNED` | Tidak | - | ID produk/jasa. |
| `jurusan_id` | `BIGINT UNSIGNED` | Tidak | - | ID jurusan. |

---

## 6.7 Tabel `product_images`

### Fungsi

Menyimpan gambar produk.

### Primary Key

```sql
PRIMARY KEY (id)
```

### Index

| Nama Index | Kolom | Fungsi |
|---|---|---|
| `idx_product_images_product` | `product_id` | Mempercepat pencarian gambar berdasarkan produk. |

### Foreign Key

| Nama Constraint | Kolom | Tabel Referensi | Aksi Delete |
|---|---|---|---|
| `fk_product_images_product` | `product_id` | `products(id)` | `CASCADE` |

### Struktur Kolom

| Kolom | Tipe Data | Null | Default | Keterangan |
|---|---|---|---|---|
| `id` | `BIGINT UNSIGNED AUTO_INCREMENT` | Tidak | - | Primary key. |
| `product_id` | `BIGINT UNSIGNED` | Tidak | - | ID produk. |
| `path` | `VARCHAR(255)` | Tidak | - | Path file gambar. |
| `is_primary` | `TINYINT(1)` | Tidak | `0` | Penanda gambar utama. |
| `sort_order` | `INT` | Tidak | `0` | Urutan tampilan gambar. |
| `created_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data dibuat. |
| `updated_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data diperbarui. |

---

## 6.8 Tabel `orders`

### Fungsi

Menyimpan data pesanan utama.

### Status Pesanan

| Status | Keterangan |
|---|---|
| `menunggu_pembayaran` | Pesanan dibuat, pembeli belum upload bukti pembayaran. |
| `menunggu_verifikasi` | Bukti pembayaran sudah diupload, menunggu verifikasi admin/siswa. |
| `diproses` | Pembayaran disetujui, pesanan sedang diproses. |
| `selesai` | Pesanan selesai. |
| `dibatalkan` | Pesanan dibatalkan. |
| `ditolak` | Pesanan atau pembayaran ditolak. |

### Primary Key

```sql
PRIMARY KEY (id)
```

### Unique Constraint

| Nama Constraint | Kolom | Fungsi |
|---|---|---|
| `uq_orders_kode_pesanan` | `kode_pesanan` | Mencegah kode pesanan duplikat. |

### Index

| Nama Index | Kolom | Fungsi |
|---|---|---|
| `idx_orders_user` | `user_id` | Mempercepat pencarian pesanan berdasarkan pembeli. |
| `idx_orders_status` | `status` | Mempercepat filter status pesanan. |

### Foreign Key

| Nama Constraint | Kolom | Tabel Referensi | Aksi Delete |
|---|---|---|---|
| `fk_orders_user` | `user_id` | `users(id)` | `RESTRICT` |

### Struktur Kolom

| Kolom | Tipe Data | Null | Default | Keterangan |
|---|---|---|---|---|
| `id` | `BIGINT UNSIGNED AUTO_INCREMENT` | Tidak | - | Primary key, sekaligus `id_pesanan`. |
| `kode_pesanan` | `VARCHAR(30)` | Tidak | - | Kode pesanan unik. |
| `user_id` | `BIGINT UNSIGNED` | Tidak | - | Pembeli yang membuat pesanan. |
| `status` | `ENUM` | Tidak | `menunggu_pembayaran` | Status pesanan. |
| `subtotal` | `DECIMAL(15,2)` | Tidak | `0` | Total harga sebelum diskon. |
| `diskon` | `DECIMAL(15,2)` | Tidak | `0` | Nominal diskon. |
| `total` | `DECIMAL(15,2)` | Tidak | `0` | Total bayar akhir. |
| `catatan` | `TEXT` | Ya | `NULL` | Catatan pesanan dari pembeli. |
| `link_wa` | `VARCHAR(255)` | Ya | `NULL` | Link WhatsApp untuk komunikasi pesanan. |
| `created_at` | `TIMESTAMP` | Ya | `NULL` | Waktu pesanan dibuat. |
| `updated_at` | `TIMESTAMP` | Ya | `NULL` | Waktu pesanan diperbarui. |

### Contoh Kode Pesanan

```txt
ESK-20260814-0001
```

Keterangan:

```txt
ESK       = kode aplikasi e-commerce sekolah
20260814  = tanggal pesanan
0001      = nomor urut pesanan pada tanggal tersebut
```

---

## 6.9 Tabel `order_items`

### Fungsi

Menyimpan detail item dari satu pesanan.

### Alasan Snapshot Digunakan

Kolom `nama_snapshot` dan `harga_snapshot` disimpan agar riwayat pesanan tidak berubah ketika admin mengubah nama atau harga produk di masa depan.

### Primary Key

```sql
PRIMARY KEY (id)
```

### Index

| Nama Index | Kolom | Fungsi |
|---|---|---|
| `idx_order_items_order` | `order_id` | Mempercepat pencarian item berdasarkan pesanan. |
| `idx_order_items_product` | `product_id` | Mempercepat pencarian item berdasarkan produk. |

### Foreign Key

| Nama Constraint | Kolom | Tabel Referensi | Aksi Delete |
|---|---|---|---|
| `fk_order_items_order` | `order_id` | `orders(id)` | `RESTRICT` |
| `fk_order_items_product` | `product_id` | `products(id)` | `RESTRICT` |

### Struktur Kolom

| Kolom | Tipe Data | Null | Default | Keterangan |
|---|---|---|---|---|
| `id` | `BIGINT UNSIGNED AUTO_INCREMENT` | Tidak | - | Primary key. |
| `order_id` | `BIGINT UNSIGNED` | Tidak | - | ID pesanan. |
| `product_id` | `BIGINT UNSIGNED` | Tidak | - | ID produk yang dipesan. |
| `nama_snapshot` | `VARCHAR(180)` | Tidak | - | Nama produk saat transaksi. |
| `harga_snapshot` | `DECIMAL(15,2)` | Tidak | - | Harga produk saat transaksi. |
| `qty` | `INT UNSIGNED` | Tidak | `1` | Jumlah item. |
| `subtotal` | `DECIMAL(15,2)` | Tidak | - | Harga total untuk item ini. |
| `catatan_kustom` | `TEXT` | Ya | `NULL` | Catatan custom, misalnya nama untuk nametag. |
| `file_desain` | `VARCHAR(255)` | Ya | `NULL` | File desain dari pembeli, jika produk custom. |
| `created_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data dibuat. |
| `updated_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data diperbarui. |

---

## 6.10 Tabel `payments`

### Fungsi

Menyimpan data pembayaran dan bukti pembayaran.

### Status Pembayaran

| Status | Keterangan |
|---|---|
| `pending` | Bukti pembayaran sudah diupload, menunggu verifikasi. |
| `approved` | Pembayaran disetujui. |
| `rejected` | Pembayaran ditolak. |

### Primary Key

```sql
PRIMARY KEY (id)
```

### Index

| Nama Index | Kolom | Fungsi |
|---|---|---|
| `idx_payments_order` | `order_id` | Mempercepat pencarian pembayaran berdasarkan pesanan. |
| `idx_payments_status` | `status` | Mempercepat filter status pembayaran. |
| `idx_payments_verified_by` | `verified_by` | Mempercepat pencarian verifier. |

### Foreign Key

| Nama Constraint | Kolom | Tabel Referensi | Aksi Delete |
|---|---|---|---|
| `fk_payments_order` | `order_id` | `orders(id)` | `RESTRICT` |
| `fk_payments_verified_by` | `verified_by` | `users(id)` | `SET NULL` |

### Struktur Kolom

| Kolom | Tipe Data | Null | Default | Keterangan |
|---|---|---|---|---|
| `id` | `BIGINT UNSIGNED AUTO_INCREMENT` | Tidak | - | Primary key. |
| `order_id` | `BIGINT UNSIGNED` | Tidak | - | ID pesanan terkait. |
| `nominal` | `DECIMAL(15,2)` | Tidak | - | Nominal pembayaran. |
| `metode` | `VARCHAR(50)` | Tidak | `transfer` | Metode pembayaran. |
| `bukti_pembayaran` | `VARCHAR(255)` | Tidak | - | Path file bukti pembayaran. |
| `status` | `ENUM('pending','approved','rejected')` | Tidak | `pending` | Status pembayaran. |
| `verified_by` | `BIGINT UNSIGNED` | Ya | `NULL` | Admin/siswa yang memverifikasi. |
| `verified_at` | `TIMESTAMP` | Ya | `NULL` | Waktu verifikasi. |
| `catatan` | `TEXT` | Ya | `NULL` | Catatan verifikasi. |
| `created_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data dibuat. |
| `updated_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data diperbarui. |

---

## 6.11 Tabel `reviews`

### Fungsi

Menyimpan ulasan pembeli untuk produk atau jasa.

### Primary Key

```sql
PRIMARY KEY (id_ulasan)
```

### Unique Constraint

| Nama Constraint | Kolom | Fungsi |
|---|---|---|
| `uq_reviews_order_product_user` | `order_id`, `product_id`, `user_id` | Mencegah satu user mengulas produk yang sama pada pesanan yang sama lebih dari sekali. |

### Index

| Nama Index | Kolom | Fungsi |
|---|---|---|
| `idx_reviews_user` | `user_id` | Mempercepat pencarian ulasan berdasarkan user. |
| `idx_reviews_product` | `product_id` | Mempercepat pencarian ulasan berdasarkan produk. |
| `idx_reviews_status` | `status` | Mempercepat filter status ulasan. |

### Check Constraint

| Nama Constraint | Aturan | Fungsi |
|---|---|---|
| `chk_reviews_rating` | `rating BETWEEN 1 AND 5` | Rating hanya boleh 1 sampai 5. |

### Foreign Key

| Nama Constraint | Kolom | Tabel Referensi | Aksi Delete |
|---|---|---|---|
| `fk_reviews_user` | `user_id` | `users(id)` | `CASCADE` |
| `fk_reviews_product` | `product_id` | `products(id)` | `CASCADE` |
| `fk_reviews_order` | `order_id` | `orders(id)` | `SET NULL` |

### Struktur Kolom

| Kolom | Tipe Data | Null | Default | Keterangan |
|---|---|---|---|---|
| `id_ulasan` | `BIGINT UNSIGNED AUTO_INCREMENT` | Tidak | - | Primary key, sesuai referensi `id_ulasan`. |
| `user_id` | `BIGINT UNSIGNED` | Tidak | - | User yang memberi ulasan. |
| `product_id` | `BIGINT UNSIGNED` | Tidak | - | Produk/jasa yang diulas. |
| `order_id` | `BIGINT UNSIGNED` | Ya | `NULL` | Pesanan terkait. |
| `rating` | `TINYINT UNSIGNED` | Tidak | - | Rating 1 sampai 5. |
| `komentar` | `TEXT` | Ya | `NULL` | Komentar ulasan. |
| `status` | `ENUM('pending','approved','rejected')` | Tidak | `pending` | Status moderasi ulasan. |
| `created_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data dibuat. |
| `updated_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data diperbarui. |

### Catatan

`(tag: saran)` Ulasan sebaiknya hanya dapat dibuat oleh pembeli yang pesanannya sudah berstatus `selesai`.

---

## 6.12 Tabel `settings`

### Fungsi

Menyimpan pengaturan aplikasi yang dapat diubah melalui halaman admin.

### Primary Key

```sql
PRIMARY KEY (id)
```

### Unique Constraint

| Nama Constraint | Kolom | Fungsi |
|---|---|---|
| `uq_settings_key` | `key` | Mencegah key pengaturan duplikat. |

### Struktur Kolom

| Kolom | Tipe Data | Null | Default | Keterangan |
|---|---|---|---|---|
| `id` | `BIGINT UNSIGNED AUTO_INCREMENT` | Tidak | - | Primary key. |
| `key` | `VARCHAR(100)` | Tidak | - | Nama pengaturan. |
| `value` | `TEXT` | Ya | `NULL` | Nilai pengaturan. |
| `created_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data dibuat. |
| `updated_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data diperbarui. |

### Contoh Settings

| Key | Value | Keterangan |
|---|---|---|
| `nama_aplikasi` | `CMS E-Commerce Sekolah` | Nama aplikasi. |
| `whatsapp_admin` | `6281234567890` | Nomor WhatsApp admin. |
| `alamat_sekolah` | `Isi alamat sekolah` | Alamat sekolah. |
| `email_sekolah` | `admin@sekolah.sch.id` | Email sekolah. |

---

# 7. SQL Lengkap untuk Membuat Database

Berikut script SQL lengkap untuk membuat database dan semua tabel inti.

```sql
-- =====================================================
-- DATABASE CMS E-COMMERCE SEKOLAH
-- =====================================================

CREATE DATABASE IF NOT EXISTS cms_ecommerce_sekolah
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE cms_ecommerce_sekolah;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS settings;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS product_images;
DROP TABLE IF EXISTS product_jurusan;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS profiles;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS jurusan;

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- TABEL JURUSAN
-- =====================================================

CREATE TABLE jurusan (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    kode_jurusan VARCHAR(20) NOT NULL,
    nama_jurusan VARCHAR(100) NOT NULL,
    slug VARCHAR(120) NOT NULL,
    deskripsi TEXT NULL,
    logo VARCHAR(255) NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    PRIMARY KEY (id),
    UNIQUE KEY uq_jurusan_kode (kode_jurusan),
    UNIQUE KEY uq_jurusan_slug (slug)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- =====================================================
-- TABEL USERS
-- =====================================================

CREATE TABLE users (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    email_verified_at TIMESTAMP NULL DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'pembeli', 'siswa') NOT NULL DEFAULT 'pembeli',
    jurusan_id BIGINT UNSIGNED NULL,
    whatsapp VARCHAR(20) NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    PRIMARY KEY (id),
    UNIQUE KEY uq_users_email (email),
    KEY idx_users_role (role),
    KEY idx_users_jurusan (jurusan_id),

    CONSTRAINT fk_users_jurusan
        FOREIGN KEY (jurusan_id)
        REFERENCES jurusan (id)
        ON DELETE SET NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- =====================================================
-- TABEL PROFILES
-- =====================================================

CREATE TABLE profiles (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    nis_nip VARCHAR(50) NULL,
    kelas VARCHAR(50) NULL,
    alamat TEXT NULL,
    foto VARCHAR(255) NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    PRIMARY KEY (id),
    UNIQUE KEY uq_profiles_user (user_id),

    CONSTRAINT fk_profiles_user
        FOREIGN KEY (user_id)
        REFERENCES users (id)
        ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- =====================================================
-- TABEL CATEGORIES
-- =====================================================

CREATE TABLE categories (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    parent_id BIGINT UNSIGNED NULL,
    nama_kategori VARCHAR(120) NOT NULL,
    slug VARCHAR(140) NOT NULL,
    tipe ENUM('produk', 'jasa') NOT NULL,
    deskripsi TEXT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    PRIMARY KEY (id),
    UNIQUE KEY uq_categories_slug (slug),
    KEY idx_categories_parent (parent_id),
    KEY idx_categories_tipe (tipe),

    CONSTRAINT fk_categories_parent
        FOREIGN KEY (parent_id)
        REFERENCES categories (id)
        ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- =====================================================
-- TABEL PRODUCTS
-- =====================================================

CREATE TABLE products (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    category_id BIGINT UNSIGNED NOT NULL,
    nama_produk VARCHAR(180) NOT NULL,
    slug VARCHAR(200) NOT NULL,
    tipe ENUM('barang', 'jasa') NOT NULL,
    deskripsi TEXT NULL,
    harga DECIMAL(15, 2) NOT NULL DEFAULT 0,
    harga_diskon DECIMAL(15, 2) NULL,
    stok INT UNSIGNED NULL DEFAULT 0,
    satuan VARCHAR(30) NULL,
    is_custom TINYINT(1) NOT NULL DEFAULT 0,
    estimasi_pengerjaan VARCHAR(100) NULL,
    status ENUM('draft', 'aktif', 'nonaktif') NOT NULL DEFAULT 'draft',
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    PRIMARY KEY (id),
    UNIQUE KEY uq_products_slug (slug),
    KEY idx_products_category (category_id),
    KEY idx_products_tipe (tipe),
    KEY idx_products_status (status),

    CONSTRAINT fk_products_category
        FOREIGN KEY (category_id)
        REFERENCES categories (id)
        ON DELETE RESTRICT
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- =====================================================
-- TABEL PRODUCT_JURUSAN
-- =====================================================

CREATE TABLE product_jurusan (
    product_id BIGINT UNSIGNED NOT NULL,
    jurusan_id BIGINT UNSIGNED NOT NULL,

    PRIMARY KEY (product_id, jurusan_id),
    KEY idx_product_jurusan_jurusan (jurusan_id),

    CONSTRAINT fk_product_jurusan_product
        FOREIGN KEY (product_id)
        REFERENCES products (id)
        ON DELETE CASCADE,

    CONSTRAINT fk_product_jurusan_jurusan
        FOREIGN KEY (jurusan_id)
        REFERENCES jurusan (id)
        ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- =====================================================
-- TABEL PRODUCT_IMAGES
-- =====================================================

CREATE TABLE product_images (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    product_id BIGINT UNSIGNED NOT NULL,
    path VARCHAR(255) NOT NULL,
    is_primary TINYINT(1) NOT NULL DEFAULT 0,
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    PRIMARY KEY (id),
    KEY idx_product_images_product (product_id),

    CONSTRAINT fk_product_images_product
        FOREIGN KEY (product_id)
        REFERENCES products (id)
        ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- =====================================================
-- TABEL ORDERS
-- =====================================================

CREATE TABLE orders (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    kode_pesanan VARCHAR(30) NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    status ENUM(
        'menunggu_pembayaran',
        'menunggu_verifikasi',
        'diproses',
        'selesai',
        'dibatalkan',
        'ditolak'
    ) NOT NULL DEFAULT 'menunggu_pembayaran',
    subtotal DECIMAL(15, 2) NOT NULL DEFAULT 0,
    diskon DECIMAL(15, 2) NOT NULL DEFAULT 0,
    total DECIMAL(15, 2) NOT NULL DEFAULT 0,
    catatan TEXT NULL,
    link_wa VARCHAR(255) NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    PRIMARY KEY (id),
    UNIQUE KEY uq_orders_kode_pesanan (kode_pesanan),
    KEY idx_orders_user (user_id),
    KEY idx_orders_status (status),

    CONSTRAINT fk_orders_user
        FOREIGN KEY (user_id)
        REFERENCES users (id)
        ON DELETE RESTRICT
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- =====================================================
-- TABEL ORDER_ITEMS
-- =====================================================

CREATE TABLE order_items (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    order_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    nama_snapshot VARCHAR(180) NOT NULL,
    harga_snapshot DECIMAL(15, 2) NOT NULL,
    qty INT UNSIGNED NOT NULL DEFAULT 1,
    subtotal DECIMAL(15, 2) NOT NULL,
    catatan_kustom TEXT NULL,
    file_desain VARCHAR(255) NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    PRIMARY KEY (id),
    KEY idx_order_items_order (order_id),
    KEY idx_order_items_product (product_id),

    CONSTRAINT fk_order_items_order
        FOREIGN KEY (order_id)
        REFERENCES orders (id)
        ON DELETE RESTRICT,

    CONSTRAINT fk_order_items_product
        FOREIGN KEY (product_id)
        REFERENCES products (id)
        ON DELETE RESTRICT
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- =====================================================
-- TABEL PAYMENTS
-- =====================================================

CREATE TABLE payments (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    order_id BIGINT UNSIGNED NOT NULL,
    nominal DECIMAL(15, 2) NOT NULL,
    metode VARCHAR(50) NOT NULL DEFAULT 'transfer',
    bukti_pembayaran VARCHAR(255) NOT NULL,
    status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
    verified_by BIGINT UNSIGNED NULL,
    verified_at TIMESTAMP NULL DEFAULT NULL,
    catatan TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    PRIMARY KEY (id),
    KEY idx_payments_order (order_id),
    KEY idx_payments_status (status),
    KEY idx_payments_verified_by (verified_by),

    CONSTRAINT fk_payments_order
        FOREIGN KEY (order_id)
        REFERENCES orders (id)
        ON DELETE RESTRICT,

    CONSTRAINT fk_payments_verified_by
        FOREIGN KEY (verified_by)
        REFERENCES users (id)
        ON DELETE SET NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- =====================================================
-- TABEL REVIEWS
-- =====================================================

CREATE TABLE reviews (
    id_ulasan BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    order_id BIGINT UNSIGNED NULL,
    rating TINYINT UNSIGNED NOT NULL,
    komentar TEXT NULL,
    status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    PRIMARY KEY (id_ulasan),
    UNIQUE KEY uq_reviews_order_product_user (order_id, product_id, user_id),
    KEY idx_reviews_user (user_id),
    KEY idx_reviews_product (product_id),
    KEY idx_reviews_status (status),

    CONSTRAINT chk_reviews_rating
        CHECK (rating BETWEEN 1 AND 5),

    CONSTRAINT fk_reviews_user
        FOREIGN KEY (user_id)
        REFERENCES users (id)
        ON DELETE CASCADE,

    CONSTRAINT fk_reviews_product
        FOREIGN KEY (product_id)
        REFERENCES products (id)
        ON DELETE CASCADE,

    CONSTRAINT fk_reviews_order
        FOREIGN KEY (order_id)
        REFERENCES orders (id)
        ON DELETE SET NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- =====================================================
-- TABEL SETTINGS
-- =====================================================

CREATE TABLE settings (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `key` VARCHAR(100) NOT NULL,
    value TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    PRIMARY KEY (id),
    UNIQUE KEY uq_settings_key (`key`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- =====================================================
-- INDEX TAMBAHAN UNTUK PENCARIAN PRODUK
-- =====================================================

ALTER TABLE products
ADD FULLTEXT INDEX ft_products_cari (nama_produk, deskripsi);
```

---

# 8. Seeder Data Awal

Seeder berikut mengisi data jurusan, kategori, dan pengaturan awal.

```sql
-- =====================================================
-- SEED JURUSAN
-- =====================================================

INSERT INTO jurusan (
    id,
    kode_jurusan,
    nama_jurusan,
    slug,
    deskripsi,
    logo,
    is_active,
    created_at,
    updated_at
) VALUES
(1, 'PPLG', 'Pengembangan Perangkat Lunak dan Gim (RPL)', 'pplg', 'Jurusan Pengembangan Perangkat Lunak dan Gim, biasa disebut RPL.', NULL, 1, NOW(), NOW()),
(2, 'ANIMASI', 'Animasi', 'animasi', 'Jurusan Animasi.', NULL, 1, NOW(), NOW()),
(3, 'AKUNTANSI', 'Akuntansi', 'akuntansi', 'Jurusan Akuntansi.', NULL, 1, NOW(), NOW()),
(4, 'DKV', 'Desain Komunikasi Visual', 'dkv', 'Jurusan Desain Komunikasi Visual.', NULL, 1, NOW(), NOW()),
(5, 'PEMASARAN', 'Pemasaran', 'pemasaran', 'Jurusan Pemasaran.', NULL, 1, NOW(), NOW());

-- =====================================================
-- SEED KATEGORI PRODUK DAN JASA
-- =====================================================

INSERT INTO categories (
    id,
    parent_id,
    nama_kategori,
    slug,
    tipe,
    deskripsi,
    is_active,
    created_at,
    updated_at
) VALUES
-- Kategori utama produk sekolah
(1, NULL, 'Produk Sekolah', 'produk-sekolah', 'produk', 'Kategori utama produk unit produksi sekolah.', 1, NOW(), NOW()),

-- Subkategori produk sekolah
(2, 1, 'Aksesoris', 'aksesoris', 'produk', 'Produk aksesoris sekolah.', 1, NOW(), NOW()),
(3, 1, 'Merchandise', 'merchandise', 'produk', 'Produk merchandise sekolah.', 1, NOW(), NOW()),
(4, 1, 'Pepelege Produk', 'pepelege-produk', 'produk', 'Kategori produk sesuai referensi awal.', 1, NOW(), NOW()),

-- Kategori utama jasa jurusan
(5, NULL, 'Jasa Jurusan', 'jasa-jurusan', 'jasa', 'Kategori utama jasa setiap jurusan.', 1, NOW(), NOW()),

-- Subkategori jasa berdasarkan jurusan
(6, 5, 'DKV & Animasi', 'dkv-animasi', 'jasa', 'Jasa desain komunikasi visual dan animasi.', 1, NOW(), NOW()),
(7, 5, 'Pemasaran', 'jasa-pemasaran', 'jasa', 'Jasa pemasaran dan media sosial.', 1, NOW(), NOW()),
(8, 5, 'PPLG', 'jasa-pplg', 'jasa', 'Jasa pengembangan perangkat lunak dan gim.', 1, NOW(), NOW()),
(9, 5, 'Akuntansi', 'jasa-akuntansi', 'jasa', 'Jasa akuntansi dan keuangan.', 1, NOW(), NOW()),

-- Detail aksesoris
(10, 2, 'Ganci', 'ganci', 'produk', 'Gantungan kunci.', 1, NOW(), NOW()),
(11, 2, 'Nametag', 'nametag', 'produk', 'Name tag.', 1, NOW(), NOW()),
(12, 2, 'Pin', 'pin', 'produk', 'Pin.', 1, NOW(), NOW()),
(13, 2, 'Kaos', 'kaos', 'produk', 'Kaos.', 1, NOW(), NOW()),
(14, 2, 'Gelas Custom', 'gelas-custom', 'produk', 'Gelas custom.', 1, NOW(), NOW()),

-- Detail merchandise
(15, 3, 'Kaos Khusus Sekolah', 'kaos-khusus-sekolah', 'produk', 'Kaos khusus sekolah.', 1, NOW(), NOW()),
(16, 3, 'Gelas BN', 'gelas-bn', 'produk', 'Gelas BN.', 1, NOW(), NOW()),
(17, 3, 'Pulpen BN', 'pulpen-bn', 'produk', 'Pulpen BN.', 1, NOW(), NOW()),

-- Detail pepelege produk
(18, 4, 'IoT Hardware', 'iot-hardware', 'produk', 'Produk IoT hardware.', 1, NOW(), NOW()),

-- Detail jasa DKV & Animasi
(19, 6, 'Animasi', 'animasi-jasa', 'jasa', 'Jasa animasi.', 1, NOW(), NOW()),
(20, 6, 'Motion Graphic', 'motion-graphic', 'jasa', 'Jasa motion graphic.', 1, NOW(), NOW()),
(21, 6, 'Video Promosi', 'video-promosi', 'jasa', 'Jasa video promosi.', 1, NOW(), NOW()),
(22, 6, 'Desain Grafis', 'desain-grafis', 'jasa', 'Jasa desain grafis.', 1, NOW(), NOW()),
(23, 6, 'Logo Gerak', 'logo-gerak', 'jasa', 'Jasa animasi logo gerak.', 1, NOW(), NOW()),
(24, 6, 'Iklan Animasi', 'iklan-animasi', 'jasa', 'Jasa iklan animasi.', 1, NOW(), NOW()),
(25, 6, 'Blender 3D', 'blender-3d', 'jasa', 'Jasa pembuatan objek/animasi Blender.', 1, NOW(), NOW()),

-- Detail jasa Pemasaran
(26, 7, 'Digital Marketing', 'digital-marketing', 'jasa', 'Jasa digital marketing.', 1, NOW(), NOW()),
(27, 7, 'Admin Medsos', 'admin-medsos', 'jasa', 'Jasa admin media sosial.', 1, NOW(), NOW()),

-- Detail jasa PPLG
(28, 8, 'Website', 'jasa-website', 'jasa', 'Jasa pembuatan website.', 1, NOW(), NOW()),
(29, 8, 'Mobile', 'jasa-mobile', 'jasa', 'Jasa pembuatan aplikasi mobile.', 1, NOW(), NOW()),
(30, 8, 'Server Hosting', 'server-hosting', 'jasa', 'Jasa server hosting.', 1, NOW(), NOW()),
(31, 8, 'Cloud', 'cloud', 'jasa', 'Jasa cloud.', 1, NOW(), NOW()),
(32, 8, 'Game Dev', 'game-dev', 'jasa', 'Jasa pengembangan game.', 1, NOW(), NOW()),
(33, 8, 'Excel', 'excel', 'jasa', 'Jasa pengolahan Excel.', 1, NOW(), NOW()),
(34, 8, 'IoT Software', 'iot-software', 'jasa', 'Jasa IoT software.', 1, NOW(), NOW()),

-- Detail jasa Akuntansi
(35, 9, 'Pembukuan', 'pembukuan', 'jasa', 'Jasa pembukuan.', 1, NOW(), NOW()),
(36, 9, 'Pembuatan Laporan', 'pembuatan-laporan', 'jasa', 'Jasa pembuatan laporan.', 1, NOW(), NOW()),
(37, 9, 'Konsultasi Pajak', 'konsultasi-pajak', 'jasa', 'Jasa konsultasi pajak.', 1, NOW(), NOW());

-- =====================================================
-- SEED SETTINGS
-- =====================================================

INSERT INTO settings (`key`, value, created_at, updated_at) VALUES
('nama_aplikasi', 'CMS E-Commerce Sekolah', NOW(), NOW()),
('whatsapp_admin', '6281234567890', NOW(), NOW()),
('alamat_sekolah', 'Isi alamat sekolah di sini', NOW(), NOW()),
('email_sekolah', 'admin@sekolah.sch.id', NOW(), NOW());
```

---

# 9. Ringkasan Data Seeder

## 9.1 Data Jurusan

| ID | Kode | Nama Jurusan | Slug |
|---|---|---|---|
| 1 | `PPLG` | Pengembangan Perangkat Lunak dan Gim (RPL) | `pplg` |
| 2 | `ANIMASI` | Animasi | `animasi` |
| 3 | `AKUNTANSI` | Akuntansi | `akuntansi` |
| 4 | `DKV` | Desain Komunikasi Visual | `dkv` |
| 5 | `PEMASARAN` | Pemasaran | `pemasaran` |

## 9.2 Kategori Utama

| ID | Parent | Nama Kategori | Tipe |
|---|---|---|---|
| 1 | `NULL` | Produk Sekolah | `produk` |
| 5 | `NULL` | Jasa Jurusan | `jasa` |

## 9.3 Subkategori Produk Sekolah

| ID | Parent | Nama Kategori | Tipe |
|---|---|---|---|
| 2 | 1 | Aksesoris | `produk` |
| 3 | 1 | Merchandise | `produk` |
| 4 | 1 | Pepelege Produk | `produk` |

## 9.4 Detail Aksesoris

| ID | Parent | Nama Kategori | Tipe |
|---|---|---|---|
| 10 | 2 | Ganci | `produk` |
| 11 | 2 | Nametag | `produk` |
| 12 | 2 | Pin | `produk` |
| 13 | 2 | Kaos | `produk` |
| 14 | 2 | Gelas Custom | `produk` |

## 9.5 Detail Merchandise

| ID | Parent | Nama Kategori | Tipe |
|---|---|---|---|
| 15 | 3 | Kaos Khusus Sekolah | `produk` |
| 16 | 3 | Gelas BN | `produk` |
| 17 | 3 | Pulpen BN | `produk` |

## 9.6 Detail Pepelege Produk

| ID | Parent | Nama Kategori | Tipe |
|---|---|---|---|
| 18 | 4 | IoT Hardware | `produk` |

## 9.7 Subkategori Jasa Jurusan

| ID | Parent | Nama Kategori | Tipe |
|---|---|---|---|
| 6 | 5 | DKV & Animasi | `jasa` |
| 7 | 5 | Pemasaran | `jasa` |
| 8 | 5 | PPLG | `jasa` |
| 9 | 5 | Akuntansi | `jasa` |

## 9.8 Detail Jasa DKV & Animasi

| ID | Parent | Nama Kategori | Tipe |
|---|---|---|---|
| 19 | 6 | Animasi | `jasa` |
| 20 | 6 | Motion Graphic | `jasa` |
| 21 | 6 | Video Promosi | `jasa` |
| 22 | 6 | Desain Grafis | `jasa` |
| 23 | 6 | Logo Gerak | `jasa` |
| 24 | 6 | Iklan Animasi | `jasa` |
| 25 | 6 | Blender 3D | `jasa` |

## 9.9 Detail Jasa Pemasaran

| ID | Parent | Nama Kategori | Tipe |
|---|---|---|---|
| 26 | 7 | Digital Marketing | `jasa` |
| 27 | 7 | Admin Medsos | `jasa` |

## 9.10 Detail Jasa PPLG

| ID | Parent | Nama Kategori | Tipe |
|---|---|---|---|
| 28 | 8 | Website | `jasa` |
| 29 | 8 | Mobile | `jasa` |
| 30 | 8 | Server Hosting | `jasa` |
| 31 | 8 | Cloud | `jasa` |
| 32 | 8 | Game Dev | `jasa` |
| 33 | 8 | Excel | `jasa` |
| 34 | 8 | IoT Software | `jasa` |

## 9.11 Detail Jasa Akuntansi

| ID | Parent | Nama Kategori | Tipe |
|---|---|---|---|
| 35 | 9 | Pembukuan | `jasa` |
| 36 | 9 | Pembuatan Laporan | `jasa` |
| 37 | 9 | Konsultasi Pajak | `jasa` |

---

# 10. Alur Data Pesanan

Berikut alur data dari sisi database saat pembeli melakukan pesanan.

```txt
1. Pembeli memilih produk/jasa.
2. Sistem membuat data pada tabel orders.
3. Sistem membuat data pada tabel order_items.
4. Jika produk fisik, stok pada tabel products dapat dikurangi.
5. Pesanan mendapat kode_pesanan.
6. Status pesanan awal adalah menunggu_pembayaran.
7. Pembeli upload bukti pembayaran.
8. Sistem membuat data pada tabel payments.
9. Status pesanan berubah menjadi menunggu_verifikasi.
10. Admin/siswa memverifikasi pembayaran.
11. Jika disetujui, payments.status menjadi approved.
12. orders.status berubah menjadi diproses.
13. Setelah pekerjaan atau pengiriman selesai, orders.status menjadi selesai.
14. Pembeli dapat memberi ulasan pada tabel reviews.
```

---

# 11. Query Dashboard

Dashboard dapat mengambil data dari tabel yang sudah ada.

## 11.1 Total Produk Aktif

```sql
SELECT COUNT(*) AS total_produk_aktif
FROM products
WHERE status = 'aktif';
```

## 11.2 Total Jasa Aktif

```sql
SELECT COUNT(*) AS total_jasa_aktif
FROM products
WHERE status = 'aktif'
AND tipe = 'jasa';
```

## 11.3 Total Produk Fisik Aktif

```sql
SELECT COUNT(*) AS total_barang_aktif
FROM products
WHERE status = 'aktif'
AND tipe = 'barang';
```

## 11.4 Pesanan Masuk

```sql
SELECT COUNT(*) AS pesanan_masuk
FROM orders
WHERE status IN (
    'menunggu_pembayaran',
    'menunggu_verifikasi',
    'diproses'
);
```

## 11.5 Pesanan Menunggu Verifikasi Pembayaran

```sql
SELECT COUNT(*) AS menunggu_verifikasi
FROM orders
WHERE status = 'menunggu_verifikasi';
```

## 11.6 Pesanan Sedang Diproses

```sql
SELECT COUNT(*) AS pesanan_diproses
FROM orders
WHERE status = 'diproses';
```

## 11.7 Pesanan Selesai

```sql
SELECT COUNT(*) AS pesanan_selesai
FROM orders
WHERE status = 'selesai';
```

## 11.8 Total Omzet

```sql
SELECT COALESCE(SUM(nominal), 0) AS total_omzet
FROM payments
WHERE status = 'approved';
```

## 11.9 Produk Terlaris

```sql
SELECT
    p.nama_produk,
    SUM(oi.qty) AS total_terjual
FROM order_items oi
JOIN products p ON p.id = oi.product_id
JOIN orders o ON o.id = oi.order_id
WHERE o.status = 'selesai'
GROUP BY p.id, p.nama_produk
ORDER BY total_terjual DESC
LIMIT 10;
```

## 11.10 Jasa Terlaris

```sql
SELECT
    p.nama_produk,
    SUM(oi.qty) AS total_terjual
FROM order_items oi
JOIN products p ON p.id = oi.product_id
JOIN orders o ON o.id = oi.order_id
WHERE o.status = 'selesai'
AND p.tipe = 'jasa'
GROUP BY p.id, p.nama_produk
ORDER BY total_terjual DESC
LIMIT 10;
```

## 11.11 Pendapatan per Jurusan

```sql
SELECT
    j.nama_jurusan,
    COALESCE(SUM(oi.subtotal), 0) AS total_pendapatan
FROM order_items oi
JOIN orders o ON o.id = oi.order_id
JOIN product_jurusan pj ON pj.product_id = oi.product_id
JOIN jurusan j ON j.id = pj.jurusan_id
WHERE o.status = 'selesai'
GROUP BY j.id, j.nama_jurusan
ORDER BY total_pendapatan DESC;
```

Catatan:

Query pendapatan per jurusan dapat menghasilkan nilai ganda jika satu produk/jasa terhubung ke lebih dari satu jurusan. Jika satu pesanan jasa dimiliki bersama oleh dua jurusan, sistem perlu menentukan aturan pembagian pendapatan.

`(tag: saran)` Jika dibutuhkan pembagian omzet antar jurusan, tambahkan kolom `persentase_pembagian` pada tabel `product_jurusan`.

---

# 12. Struktur Folder File Upload

Berikut struktur folder upload yang disarankan untuk Laravel.

```txt
storage/app/private/
├── bukti-pembayaran/
├── desain-pesanan/
├── logo-jurusan/
└── profil/

storage/app/public/
├── produk/
├── kategori/
└── banner/
```

## Penjelasan

| Folder | Jenis File | Akses |
|---|---|---|
| `storage/app/private/bukti-pembayaran` | Bukti transfer atau bukti pembayaran. | Private, hanya bisa diakses melalui controller dengan authorization. |
| `storage/app/private/desain-pesanan` | File desain custom dari pembeli. | Private, hanya bisa diakses admin/siswa terkait. |
| `storage/app/private/logo-jurusan` | Logo jurusan jika tidak ingin dipublikasikan langsung. | Private atau public sesuai kebutuhan. |
| `storage/app/private/profil` | Foto profil user. | Private. |
| `storage/app/public/produk` | Gambar produk untuk katalog. | Public. |
| `storage/app/public/kategori` | Gambar kategori. | Public. |
| `storage/app/public/banner` | Banner promosi. | Public. |

`(tag: saran)` Bukti pembayaran sebaiknya tidak disimpan di folder public. Gunakan controller khusus untuk menampilkan atau mengunduh bukti pembayaran agar hanya admin/siswa berwenang yang bisa mengaksesnya.

---

# 13. Aturan Bisnis yang Perlu Dijaga di Backend

Berikut aturan bisnis yang harus diterapkan pada layer backend Laravel.

## 13.1 Produk

| Aturan | Keterangan |
|---|---|
| Slug produk unik | Digunakan untuk URL detail produk. |
| Produk nonaktif tidak tampil di katalog publik | Status `nonaktif` atau `draft` tidak boleh muncul di halaman publik. |
| Harga menggunakan `DECIMAL` | Jangan gunakan `FLOAT` untuk uang. |
| Produk jasa tidak wajib memiliki stok | Stok dapat diisi `0` atau `NULL`. |
| Produk fisik wajib memiliki stok | Minimal `0`. |
| Produk custom dapat menerima catatan atau file desain | Gunakan `order_items.catatan_kustom` dan `order_items.file_desain`. |

## 13.2 Pesanan

| Aturan | Keterangan |
|---|---|
| Kode pesanan unik | Gunakan format yang konsisten. |
| Pesanan dibuat dalam transaksi database | Untuk menjaga konsistensi data. |
| Snapshot produk disimpan di `order_items` | Nama dan harga tidak boleh berubah setelah transaksi. |
| Pesanan tidak dihapus permanen | Lebih aman menggunakan status `dibatalkan` atau `ditolak`. |
| Total dihitung dari item | `total = subtotal - diskon`. |

## 13.3 Pembayaran

| Aturan | Keterangan |
|---|---|
| Bukti pembayaran wajib divalidasi | Tipe file dan ukuran harus dibatasi. |
| Pembayaran awal berstatus `pending` | Menunggu verifikasi admin/siswa. |
| Verifikasi dicatat | `verified_by` dan `verified_at` harus diisi saat approval. |
| Pembayaran ditolak harus memiliki catatan | Agar pembeli tahu alasan penolakan. |

## 13.4 Ulasan

| Aturan | Keterangan |
|---|---|
| Rating 1 sampai 5 | Dibatasi oleh constraint database. |
| Ulasan dapat dimoderasi | Status `pending`, `approved`, `rejected`. |
| Ulasan sebaiknya berbasis pesanan | Kolom `order_id` digunakan untuk validasi transaksi. |

---

# 14. Contoh Penerapan pada Laravel

## 14.1 Nama Model yang Disarankan

| Tabel | Model Laravel |
|---|---|
| `users` | `User` |
| `profiles` | `Profile` |
| `jurusan` | `Jurusan` |
| `categories` | `Category` |
| `products` | `Product` |
| `product_jurusan` | Tidak perlu model utama jika memakai pivot, tetapi bisa memakai `ProductJurusan` jika diperlukan. |
| `product_images` | `ProductImage` |
| `orders` | `Order` |
| `order_items` | `OrderItem` |
| `payments` | `Payment` |
| `reviews` | `Review` |
| `settings` | `Setting` |

## 14.2 Contoh Relasi Eloquent

### Model `User`

```php
public function profile()
{
    return $this->hasOne(Profile::class);
}

public function jurusan()
{
    return $this->belongsTo(Jurusan::class);
}

public function orders()
{
    return $this->hasMany(Order::class);
}

public function reviews()
{
    return $this->hasMany(Review::class);
}
```

### Model `Jurusan`

```php
public function users()
{
    return $this->hasMany(User::class);
}

public function products()
{
    return $this->belongsToMany(Product::class, 'product_jurusan');
}
```

### Model `Category`

```php
public function parent()
{
    return $this->belongsTo(Category::class, 'parent_id');
}

public function children()
{
    return $this->hasMany(Category::class, 'parent_id');
}

public function products()
{
    return $this->hasMany(Product::class);
}
```

### Model `Product`

```php
public function category()
{
    return $this->belongsTo(Category::class);
}

public function jurusan()
{
    return $this->belongsToMany(Jurusan::class, 'product_jurusan');
}

public function images()
{
    return $this->hasMany(ProductImage::class);
}

public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}

public function reviews()
{
    return $this->hasMany(Review::class);
}
```

### Model `Order`

```php
public function user()
{
    return $this->belongsTo(User::class);
}

public function items()
{
    return $this->hasMany(OrderItem::class);
}

public function payments()
{
    return $this->hasMany(Payment::class);
}

public function reviews()
{
    return $this->hasMany(Review::class);
}
```

### Model `OrderItem`

```php
public function order()
{
    return $this->belongsTo(Order::class);
}

public function product()
{
    return $this->belongsTo(Product::class);
}
```

### Model `Payment`

```php
public function order()
{
    return $this->belongsTo(Order::class);
}

public function verifier()
{
    return $this->belongsTo(User::class, 'verified_by');
}
```

### Model `Review`

```php
public function user()
{
    return $this->belongsTo(User::class);
}

public function product()
{
    return $this->belongsTo(Product::class);
}

public function order()
{
    return $this->belongsTo(Order::class);
}
```

---

# 15. Tabel Tambahan Opsional

Tabel berikut tidak wajib, tetapi dapat ditambahkan jika kebutuhan sistem berkembang.

---

## 15.1 Tabel `product_variants`

`(tag: saran)` Digunakan jika produk memiliki varian seperti ukuran, warna, atau tipe.

### Struktur Kolom

| Kolom | Tipe Data | Null | Default | Keterangan |
|---|---|---|---|---|
| `id` | `BIGINT UNSIGNED AUTO_INCREMENT` | Tidak | - | Primary key. |
| `product_id` | `BIGINT UNSIGNED` | Tidak | - | ID produk. |
| `nama_varian` | `VARCHAR(50)` | Tidak | - | Nama varian, contoh: Ukuran, Warna. |
| `nilai_varian` | `VARCHAR(50)` | Tidak | - | Nilai varian, contoh: XL, Merah. |
| `harga_tambahan` | `DECIMAL(15,2)` | Tidak | `0` | Tambahan harga jika ada. |
| `stok` | `INT UNSIGNED` | Tidak | `0` | Stok varian. |
| `created_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data dibuat. |
| `updated_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data diperbarui. |

### SQL

```sql
CREATE TABLE product_variants (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    product_id BIGINT UNSIGNED NOT NULL,
    nama_varian VARCHAR(50) NOT NULL,
    nilai_varian VARCHAR(50) NOT NULL,
    harga_tambahan DECIMAL(15, 2) NOT NULL DEFAULT 0,
    stok INT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    PRIMARY KEY (id),
    KEY idx_product_variants_product (product_id),

    CONSTRAINT fk_product_variants_product
        FOREIGN KEY (product_id)
        REFERENCES products (id)
        ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
```

### Catatan

Jika varian dipakai pada pesanan, tambahkan kolom `variant_id` pada tabel `order_items`.

```sql
ALTER TABLE order_items
ADD COLUMN variant_id BIGINT UNSIGNED NULL AFTER product_id;

ALTER TABLE order_items
ADD CONSTRAINT fk_order_items_variant
    FOREIGN KEY (variant_id)
    REFERENCES product_variants (id)
    ON DELETE SET NULL;
```

---

## 15.2 Tabel `carts` dan `cart_items`

`(tag: saran)` Digunakan jika kamu ingin fitur keranjang belanja sebelum checkout.

### Struktur Tabel `carts`

| Kolom | Tipe Data | Null | Default | Keterangan |
|---|---|---|---|---|
| `id` | `BIGINT UNSIGNED AUTO_INCREMENT` | Tidak | - | Primary key. |
| `user_id` | `BIGINT UNSIGNED` | Tidak | - | User pemilik keranjang. |
| `status` | `ENUM('aktif','checkout')` | Tidak | `aktif` | Status keranjang. |
| `created_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data dibuat. |
| `updated_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data diperbarui. |

### Struktur Tabel `cart_items`

| Kolom | Tipe Data | Null | Default | Keterangan |
|---|---|---|---|---|
| `id` | `BIGINT UNSIGNED AUTO_INCREMENT` | Tidak | - | Primary key. |
| `cart_id` | `BIGINT UNSIGNED` | Tidak | - | ID keranjang. |
| `product_id` | `BIGINT UNSIGNED` | Tidak | - | ID produk. |
| `qty` | `INT UNSIGNED` | Tidak | `1` | Jumlah produk. |
| `catatan_kustom` | `TEXT` | Ya | `NULL` | Catatan custom. |
| `created_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data dibuat. |
| `updated_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data diperbarui. |

### SQL

```sql
CREATE TABLE carts (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    status ENUM('aktif', 'checkout') NOT NULL DEFAULT 'aktif',
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    PRIMARY KEY (id),
    KEY idx_carts_user (user_id),

    CONSTRAINT fk_carts_user
        FOREIGN KEY (user_id)
        REFERENCES users (id)
        ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE cart_items (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    cart_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    qty INT UNSIGNED NOT NULL DEFAULT 1,
    catatan_kustom TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    PRIMARY KEY (id),
    KEY idx_cart_items_cart (cart_id),
    KEY idx_cart_items_product (product_id),

    CONSTRAINT fk_cart_items_cart
        FOREIGN KEY (cart_id)
        REFERENCES carts (id)
        ON DELETE CASCADE,

    CONSTRAINT fk_cart_items_product
        FOREIGN KEY (product_id)
        REFERENCES products (id)
        ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
```

---

## 15.3 Tabel `activity_logs`

`(tag: saran)` Digunakan untuk mencatat aktivitas admin atau siswa.

### Struktur Kolom

| Kolom | Tipe Data | Null | Default | Keterangan |
|---|---|---|---|---|
| `id` | `BIGINT UNSIGNED AUTO_INCREMENT` | Tidak | - | Primary key. |
| `user_id` | `BIGINT UNSIGNED` | Ya | `NULL` | User yang melakukan aktivitas. |
| `action` | `VARCHAR(100)` | Tidak | - | Nama aktivitas. |
| `model_type` | `VARCHAR(100)` | Ya | `NULL` | Jenis model yang diubah. |
| `model_id` | `BIGINT UNSIGNED` | Ya | `NULL` | ID data yang diubah. |
| `description` | `TEXT` | Ya | `NULL` | Deskripsi aktivitas. |
| `ip_address` | `VARCHAR(45)` | Ya | `NULL` | Alamat IP. |
| `created_at` | `TIMESTAMP` | Ya | `NULL` | Waktu aktivitas. |
| `updated_at` | `TIMESTAMP` | Ya | `NULL` | Waktu data diperbarui. |

### SQL

```sql
CREATE TABLE activity_logs (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NULL,
    action VARCHAR(100) NOT NULL,
    model_type VARCHAR(100) NULL,
    model_id BIGINT UNSIGNED NULL,
    description TEXT NULL,
    ip_address VARCHAR(45) NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    PRIMARY KEY (id),
    KEY idx_activity_logs_user (user_id),

    CONSTRAINT fk_activity_logs_user
        FOREIGN KEY (user_id)
        REFERENCES users (id)
        ON DELETE SET NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
```

---

# 16. Checklist Implementasi Database di Laravel

Berikut checklist yang bisa digunakan saat implementasi.

## 16.1 Tahap Persiapan

- [ ] Membuat database `cms_ecommerce_sekolah`.
- [ ] Menyesuaikan file `.env`.
- [ ] Mengatur `DB_DATABASE=cms_ecommerce_sekolah`.
- [ ] Menentukan driver database `mysql`.
- [ ] Menentukan charset `utf8mb4`.

Contoh `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cms_ecommerce_sekolah
DB_USERNAME=root
DB_PASSWORD=
```

## 16.2 Tahap Migration

Jika menggunakan migration Laravel, setiap tabel dapat dibuat sebagai migration terpisah.

Urutan migration yang disarankan:

```txt
1. create_jurusan_table
2. create_users_table
3. create_profiles_table
4. create_categories_table
5. create_products_table
6. create_product_jurusan_table
7. create_product_images_table
8. create_orders_table
9. create_order_items_table
10. create_payments_table
11. create_reviews_table
12. create_settings_table
```

## 16.3 Tahap Seeder

Urutan seeder yang disarankan:

```txt
1. JurusanSeeder
2. CategorySeeder
3. SettingSeeder
4. UserSeeder
5. ProductSeeder
```

Catatan penting:

- Password user harus menggunakan `Hash::make()`.
- Jangan simpan password plain text.
- Slug kategori dan produk harus unik.
- Data kategori awal sebaiknya dibuat dari seeder.

## 16.4 Tahap Pengujian Database

Pengujian minimum:

- [ ] Insert jurusan berhasil.
- [ ] Insert user dengan role berbeda berhasil.
- [ ] Insert profil user berhasil.
- [ ] Insert kategori induk dan anak berhasil.
- [ ] Insert produk fisik berhasil.
- [ ] Insert jasa berhasil.
- [ ] Relasi produk ke banyak jurusan berhasil.
- [ ] Upload gambar produk dapat menyimpan path.
- [ ] Pembuatan pesanan menghasilkan `kode_pesanan`.
- [ ] Item pesanan menyimpan snapshot nama dan harga.
- [ ] Pembayaran dapat diverifikasi.
- [ ] Ulasan hanya menerima rating 1 sampai 5.
- [ ] Dashboard mengambil data dengan benar.

---

# 17. Catatan Akhir

Database ini sudah mencakup kebutuhan inti dari referensi CMS e-commerce sekolah:

- User admin, pembeli, dan siswa.
- Profile user.
- Jurusan.
- Katalog produk dan jasa.
- Produk sekolah.
- Jasa per jurusan.
- Pemesanan.
- Transaksi.
- Bukti pembayaran.
- Link WhatsApp.
- Ulasan.
- Dashboard ringkasan.

Untuk pengembangan Laravel, skema ini dapat langsung dipakai sebagai dasar migration atau diimport sebagai SQL. Jika sistem berkembang, tabel tambahan seperti varian produk, keranjang, dan activity log dapat ditambahkan tanpa mengubah struktur inti.
