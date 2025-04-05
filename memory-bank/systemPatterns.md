# System Patterns: StaySnap

## Arsitektur Sistem
StaySnap mengikuti arsitektur MVC (Model-View-Controller) yang disediakan oleh Laravel dengan penambahan komponen Livewire untuk membuat antarmuka yang reaktif tanpa perlu banyak JavaScript.

```
[Client Browser] <-> [Laravel/Livewire] <-> [Database]
                      |
                      v
              [Payment Gateway]
```

## Model Data Utama
1. **Branch**: Merepresentasikan cabang/properti dengan lokasi, fasilitas, dan foto
2. **Room**: Merepresentasikan kamar dengan tipe, fasilitas, ketersediaan, dan harga
3. **User**: Pengguna sistem dengan berbagai peran (admin, pemilik properti, tamu)
4. **Transaction**: Transaksi pemesanan dengan status dan detail pembayaran
5. **Cart**: Keranjang belanja untuk proses pemesanan

## Detail Relasi Model

### Room dan Relasi Terkait
- **Room**:
  - Memiliki `base_price` (harga dasar) dan stok
  - Kepemilikan: Milik suatu `Branch` (belongs to)
  - Relasi Many-to-Many dengan `Amenity` melalui tabel pivot `amenity_room`
  - Relasi Many-to-Many dengan `RoomPolicy` melalui tabel pivot `policy_room`
  - Memiliki banyak `RoomPhotos` (has many)
  - Memiliki banyak `RoomPrices` untuk harga dinamis per tanggal (has many)
  - Memiliki banyak `RoomAvailability` untuk ketersediaan per tanggal (has many)
  - Auto-generate ketersediaan kamar saat dibuat untuk 1 tahun ke depan

- **RoomAvailability**:
  - Menyimpan data ketersediaan kamar untuk setiap tanggal
  - Atribut: `room_id`, `date`, `available` (jumlah yang tersedia)
  - Relasi: Milik suatu `Room` (belongs to)
  - Menggunakan `available` dari stok dasar Room untuk inisialisasi

- **RoomPrices**:
  - Menyimpan data harga kamar untuk tanggal tertentu
  - Atribut: `room_id`, `date`, `price`
  - Relasi: Milik suatu `Room` (belongs to)
  - Memungkinkan penerapan harga dinamis berbasis tanggal

- **RoomPhotos**:
  - Menyimpan gambar-gambar untuk setiap kamar
  - Relasi: Milik suatu `Room` (belongs to)

- **RoomPolicy**:
  - Menyimpan kebijakan yang dapat diterapkan pada kamar
  - Relasi Many-to-Many dengan `Room` melalui tabel pivot `policy_room`
  - Berkaitan dengan kebijakan pembatalan dan reschedule

- **Amenity**:
  - Menyimpan fasilitas yang tersedia di kamar
  - Relasi Many-to-Many dengan `Room` melalui tabel pivot `amenity_room`

### Branch dan Relasi Terkait
- **Branch**:
  - Memiliki informasi dasar tentang cabang seperti nama, alamat, dll.
  - Memiliki banyak `Room` (has many)
  - Relasi Many-to-Many dengan `BranchFacilities` melalui tabel pivot `facilities_branch`
  - Memiliki banyak `BranchPhoto` (has many)
  - Relasi Many-to-Many dengan `BranchTag` melalui tabel pivot `branch_branch_tag`
  - Terhubung dengan `Province` dan `Regency` untuk lokasi (belongs to)
  - Memiliki banyak `User` (has many) untuk staf manajemen cabang

- **BranchFacilities**:
  - Menyimpan fasilitas yang tersedia di cabang
  - Relasi Many-to-Many dengan `Branch` melalui tabel pivot `facilities_branch`

- **BranchPhoto**:
  - Menyimpan gambar-gambar untuk setiap cabang
  - Relasi: Milik suatu `Branch` (belongs to)

- **BranchTag**:
  - Menyimpan tag/kategori untuk cabang
  - Relasi Many-to-Many dengan `Branch` melalui tabel pivot `branch_branch_tag`

- **Province** dan **Regency**:
  - Menyimpan data lokasi (provinsi dan kota/kabupaten)
  - Relasi: Memiliki banyak `Branch` (has many)

### User (Management) dan Sistem Akses
- **User**:
  - Merepresentasikan pengguna sistem backend (admin/manajemen)
  - Memiliki atribut: `name`, `email`, `password`, `role`, `profile_picture`, `phone_number`, `branch_id`
  - Relasi: Milik suatu `Branch` (belongs to) melalui `branch_id`
  - Menggunakan Spatie Laravel Permission untuk manajemen role dan permission
  - Role dapat berupa: SuperAdmin, Owner, Manager, Staff, dll.
  - Akses terbatas pada branch yang dimiliki kecuali untuk SuperAdmin
  - Pengelolaan user dilakukan melalui UserController

- **Role dan Permission**:
  - Menggunakan library Spatie Laravel Permission
  - Role mengelompokkan pengguna berdasarkan level akses (SuperAdmin, Owner, Manager, Staff)
  - Permission menentukan tindakan spesifik yang dapat dilakukan pengguna
  - Role memiliki banyak Permission (many-to-many)
  - Memungkinkan akses berbasis branch dimana staf hanya dapat mengelola data branch mereka

- **Guest** (Rencana):
  - Akan menggunakan model terpisah dari User
  - Untuk pengguna frontend aplikasi (tamu/customer)
  - Akan mengelola informasi profil, riwayat pemesanan, dan data lainnya
  - Belum diimplementasikan

## Implementasi Sistem Pencarian Hotel dan Kamar

### Komponen Frontend
- **Search Form**:
  - Implementasi menggunakan Blade dan JavaScript vanilla
  - Terdiri dari tiga file utama:
    - `/views/partials/search-form.blade.php`: Komponen utama form pencarian
    - `/views/partials/search-modals.blade.php`: Modal interaktif untuk pemilihan hotel, tanggal, dan jumlah tamu
    - `/views/partials/search-scripts.blade.php`: JavaScript untuk logika dan interaktivitas
  - Tidak menggunakan Livewire karena keterbatasan fungsionalitas untuk kasus ini

- **Search Results**:
  - Implementasi di `/views/frontpage/search-results.blade.php`
  - Menampilkan detail hotel dan kamar yang tersedia
  - Memungkinkan pemilihan kamar untuk ditambahkan ke keranjang

### Backend dan API
- **SearchController**:
  - Menangani request pencarian yang dikirim dari search form
  - Memproses parameter hotel_id, start_date, end_date, adults, kids, voucher
  - Mengambil data hotel dan kamar yang tersedia
  - Menghitung total harga untuk periode yang dipilih
  - Menampilkan halaman hasil pencarian dengan data yang relevan

- **API BranchController**:
  - Menyediakan endpoint `/api/branches/{id}/room-prices` untuk mendapatkan harga kamar
  - Mengembalikan harga terendah dan harga per kamar untuk rentang tanggal tertentu
  - Memungkinkan frontend untuk menampilkan data harga di date picker

### Alur Pencarian
1. Pengguna mengklik form pencarian untuk memilih hotel (membuka modal)
2. Pengguna memilih hotel dari daftar hotel yang tersedia
3. Pengguna memilih tanggal check-in dan check-out (membuka modal tanggal)
4. Sistem menampilkan harga terendah untuk setiap tanggal dalam kalender
5. Pengguna memilih jumlah tamu (membuka modal tamu)
6. Pengguna mengklik tombol "Check Availability"
7. Form dikirim ke SearchController yang kemudian menampilkan hasil pencarian
8. Pengguna melihat daftar kamar yang tersedia dengan harga dan detail
9. Pengguna dapat menambahkan kamar ke keranjang untuk proses booking

## Logika Bisnis Utama

### Pengelolaan Harga Kamar
1. **Harga Dasar**: Setiap `Room` memiliki `base_price` sebagai harga standard
2. **Harga Dinamis**: Disimpan dalam `RoomPrices` untuk tanggal spesifik 
3. **Harga Terendah**: Logika untuk mendapatkan harga terendah:
   - Cek harga di `RoomPrices` pada tanggal yang diminta
   - Jika tidak ada, gunakan `base_price` dari `Room`
   - Untuk pencarian rentang tanggal, harga terendah dihitung dari semua hari dalam rentang

### Pengelolaan Ketersediaan Kamar
1. **Stok Dasar**: Setiap `Room` memiliki jumlah `stock` yang tersedia
2. **Ketersediaan per Tanggal**: Disimpan dalam `RoomAvailability` 
3. **Auto-Generate**: Ketersediaan dibuat otomatis saat room baru dibuat untuk 1 tahun
4. **Update Manual**: Admin dapat memperbarui ketersediaan untuk rentang tanggal tertentu

### Manajemen Akses Berbasis Branch
1. **Pembatasan Akses**:
   - User (kecuali SuperAdmin) hanya dapat mengakses data branch yang terkait dengan mereka
   - SuperAdmin dapat mengakses semua branch dan berpindah antar branch
2. **Dashboard Management**:
   - Tersedia di URL "/management/"
   - Tampilan dan akses disesuaikan berdasarkan role pengguna
3. **Alur Pembuatan User**:
   - Admin membuat user baru dengan menentukan branch dan role
   - User mendapatkan akses sesuai dengan branch dan role yang ditetapkan

### Pencarian dan Pemfilteran
1. **Pencarian Cabang**: Berdasarkan lokasi (provinsi/kota) dan ketersediaan
2. **Filter Kamar**: Berdasarkan kapasitas, amenities, dan harga
3. **Harga Terendah di Cabang**: Ditampilkan sebagai harga awal dari cabang, dihitung dari semua kamar yang tersedia
4. **Cek Ketersediaan**: Verifikasi apakah kamar tersedia untuk rentang tanggal yang dipilih
5. **Perhitungan Harga Total**: Perhitungan harga untuk seluruh periode menginap berdasarkan harga dinamis atau harga dasar

## Pola Desain yang Digunakan
1. **Repository Pattern**: Untuk isolasi logika bisnis dari infrastruktur data
2. **Service Layer**: Untuk mengenkapsulasi logika bisnis yang kompleks (seperti CartService)
3. **Observer Pattern**: Untuk menangani event-driven logic (seperti pada model)
4. **Middleware**: Untuk mengelola autentikasi dan otorisasi
5. **Trait**: Untuk berbagi fungsi umum di antara model (seperti HandlesImageUploads)
6. **Role-Based Access Control**: Menggunakan Spatie Laravel Permission untuk manajemen akses

## Strategi Penyimpanan Data
- Penggunaan database relasional untuk menyimpan data transaksional
- File storage untuk menangani upload gambar dan file lainnya
- Caching untuk mengoptimalkan kinerja query

## Komponen Utama
### Frontend
- Livewire untuk komponen UI interaktif
- Tailwind CSS untuk styling
- Blade template engine untuk rendering view
- JavaScript untuk interaktivitas form pencarian

### Backend
- Controller untuk menangani request HTTP
- Model untuk interaksi dengan database
- Service classes untuk logika bisnis yang kompleks
- API untuk integrasi dengan layanan eksternal

## Pola Integrasi
- RESTful API untuk komunikasi dengan layanan eksternal
- Webhook untuk menerima notifikasi dari payment gateway
- Integrasi langsung dengan Tripay untuk pemrosesan pembayaran

## Strategi Skalabilitas
- Pemisahan komponen menjadi layanan independen jika diperlukan
- Database yang dapat dioptimalkan untuk beban tinggi
- Caching untuk mengurangi beban database

## Manajemen State
- Session untuk penyimpanan state sementara
- Database untuk penyimpanan state persisten
- Livewire untuk pengelolaan state UI
- JavaScript untuk manajemen state form pencarian

## Fitur yang Belum Diimplementasikan
1. **Reservasi Kamar**: Sistem pemesanan kamar untuk periode tertentu
2. **Transaction**: Pencatatan dan pengelolaan transaksi pemesanan
3. **Payment**: Integrasi pembayaran dengan payment gateway
4. **Notification**: Pemberitahuan untuk reservasi, pembayaran, konfirmasi, dll. (via email, WhatsApp, SMS)
5. **Voucher**: Sistem diskon dan promo
6. **Pencarian Ketersediaan Kamar**: Logika untuk mencari kamar berdasarkan ketersediaan pada periode tertentu
7. **Model Guest**: Pemisahan model untuk pengguna frontend dari model User untuk manajemen
8. **Pembatasan Akses Berbasis Branch**: Implementasi lengkap untuk pembatasan akses berdasarkan branch 