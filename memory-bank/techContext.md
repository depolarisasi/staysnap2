# Tech Context: StaySnap

## Stack Teknologi

### Backend
- **Framework**: Laravel 12
- **PHP Version**: 8.2+
- **Database**: MySQL/PostgreSQL
- **Server**: Apache/Nginx

### Frontend
- **Livewire 3.4+**: Untuk komponen interaktif tanpa banyak JavaScript
- **Tailwind CSS 4.0**: Untuk styling
- **Alpine.js**: Untuk interaktivitas tambahan
- **Flatpickr**: Untuk pemilihan tanggal

### Integrasi
- **Tripay**: Payment gateway untuk pemrosesan pembayaran
- **Intervention Image**: Untuk manipulasi gambar
- **Laravel Permission (Spatie)**: Untuk manajemen role dan permission
- **Laravel Datatables**: Untuk menampilkan data dalam format tabel
- **SweetAlert**: Untuk notifikasi yang lebih interaktif

## Lingkungan Pengembangan
- **Kontrol Versi**: Git
- **Build Tools**: Vite (dengan Laravel Vite Plugin)
- **Container**: (Opsional) Docker atau Laravel Sail
- **Testing**: PHPUnit
- **CI/CD**: (Belum ditentukan)

## Panduan Setup
1. Clone repositori
2. Install dependensi dengan `composer install` dan `npm install`
3. Copy `.env.example` ke `.env` dan sesuaikan konfigurasi
4. Generate application key dengan `php artisan key:generate`
5. Jalankan migrasi dan seeder dengan `php artisan migrate --seed`
6. Jalankan development server dengan `php artisan serve` dan `npm run dev`

## Struktur Proyek Utama
- **app/**: Kode utama aplikasi
  - **Http/Controllers/**: Controller untuk menangani request
  - **Http/Middleware/**: Middleware untuk filtering request
  - **Livewire/**: Komponen Livewire
  - **Models/**: Model Eloquent untuk database
  - **Services/**: Service classes untuk logika bisnis
  - **Traits/**: Trait yang dapat digunakan kembali
- **resources/**: Frontend assets
  - **views/**: Template blade
  - **js/**: JavaScript
  - **css/**: Stylesheet
- **routes/**: Definisi route
- **database/**: Migrasi, factory, dan seeder
- **public/**: File yang dapat diakses publik
- **storage/**: File upload dan log

## Konvensi Kode
- **PSR-12**: Untuk standar penulisan kode PHP
- **Laravel Best Practices**: Mengikuti konvensi Laravel
- **Tailwind CSS**: Untuk styling dengan utility classes
- **Kebijakan penamaan**: CamelCase untuk method dan PascalCase untuk class

## Batasan Teknis
- **Kompatibilitas Browser**: Chrome, Firefox, Safari, Edge versi terbaru
- **Responsif**: Mendukung perangkat desktop dan mobile
- **Performance**: Load time maksimal 3 detik
- **Security**: Mengikuti OWASP guidelines

## Strategi Deployment
- **Hosting**: Shared hosting atau VPS
- **Domain**: Kustom domain dengan SSL
- **Backup**: Backup database berkala
- **Monitoring**: (Belum ditentukan)

## Tantangan Teknis Utama
1. Memastikan sistem ketersediaan kamar yang akurat dan real-time
2. Integrasi dengan payment gateway yang seamless
3. Optimalisasi performa untuk pencarian dengan banyak filter
4. Penanganan upload dan optimalisasi gambar
5. Implementasi sistem booking yang robust

## Implementasi Teknologi untuk Fitur Pencarian

### Stack Teknologi Pencarian
- **Frontend**:
  - HTML/CSS (Blade + Tailwind) untuk struktur dan styling
  - JavaScript vanilla untuk logika interaktif
  - Flatpickr untuk date range picker dengan kustomisasi
  - Modal custom untuk pemilihan hotel dan jumlah tamu
  - Fetch API untuk komunikasi dengan endpoint

- **Backend**:
  - Controllers untuk memproses request pencarian
  - Eloquent ORM untuk query database
  - Repository pattern untuk akses data (parsial)
  - API endpoints untuk mendapatkan data dinamis

### Komponen Teknis Pencarian
1. **Modal Hotel**:
   - Implementasi menggunakan HTML, Tailwind CSS, dan JavaScript
   - Menampilkan daftar hotel dengan pagination client-side
   - Menggunakan fetch API untuk mendapatkan data hotel
   - Filter berdasarkan lokasi menggunakan JavaScript

2. **Date Picker**:
   - Menggunakan library Flatpickr yang dikustomisasi
   - Modifikasi tampilan untuk menampilkan harga terendah per tanggal
   - Integrasi dengan API endpoint untuk mendapatkan data harga
   - Handling untuk pemilihan tanggal check-in dan check-out

3. **Guest Counter**:
   - Implementasi JavaScript custom untuk counter jumlah tamu
   - Validasi terhadap jumlah maksimum dan minimum tamu
   - Update otomatis form pencarian saat tamu dipilih

4. **Form Pencarian**:
   - Implementasi form standar HTML dengan method GET
   - Hidden inputs untuk menyimpan value dari modal selections
   - Validasi client-side dengan JavaScript sebelum submit
   - Integrasi dengan SearchController untuk pemrosesan

5. **Hasil Pencarian**:
   - Blade template rendering untuk menampilkan kamar tersedia
   - Implementasi filter dengan JavaScript untuk client-side filtering
   - Integrasi dengan endpoint API untuk mendapatkan harga
   - Implementasi "Add to Cart" dengan fetch API

### Endpoint API Pencarian
- **GET `/api/branches/{id}/room-prices`**:
  - Menerima parameter: `start_date`, `end_date`
  - Mengembalikan data harga terendah untuk setiap tanggal
  - Format respons JSON dengan harga per kamar dan harga terendah keseluruhan
  - Validasi input dengan custom request class
  - Error handling dengan try-catch dan respons terstruktur

- **Endpoint Planned**:
  - **GET `/api/branches/{id}/rooms/available`**: Untuk mendapatkan kamar yang tersedia
  - **POST `/api/cart/add`**: Untuk menambahkan kamar ke keranjang
  - **GET `/api/vouchers/validate`**: Untuk validasi kode voucher

### Database Queries
- Query untuk mendapatkan harga terendah:
  ```php
  // Get lowest price per date
  $roomPrices = RoomPrice::where('room_id', $roomId)
      ->whereDate('date', '>=', $startDate)
      ->whereDate('date', '<=', $endDate)
      ->get();
  ```

- Query untuk memeriksa ketersediaan:
  ```php
  // Check availability
  $availability = RoomAvailability::where('room_id', $roomId)
      ->whereDate('date', '>=', $startDate)
      ->whereDate('date', '<=', $endDate)
      ->where('available', '>', 0)
      ->get();
  ```

- Query untuk mencari kamar berdasarkan kriteria:
  ```php
  // Search rooms with criteria
  $rooms = Room::where('branch_id', $branchId)
      ->when($hasBreakfast, function($query) {
          $query->whereHas('amenities', function($q) {
              $q->where('name', 'like', '%breakfast%');
          });
      })
      ->when($bedType, function($query, $bedType) {
          $query->where('bed_type', $bedType);
      })
      ->get();
  ```

## Technical Constraints

### Performance Considerations
- Pagination untuk hasil pencarian dengan jumlah besar
- Lazy loading gambar untuk mempercepat load time
- Caching untuk data statis seperti provinsi dan kota
- Optimasi query database untuk pencarian

### Security Considerations
- CSRF protection untuk semua form
- Input validation untuk mencegah injection
- Rate limiting untuk API endpoints
- Authorization checks untuk akses data

### Scalability Considerations
- Database indexing untuk query yang sering digunakan
- Stateless design untuk API endpoints
- Modular code structure untuk maintainability
- Potential for horizontal scaling in the future

## Technical Debt and Roadmap

### Current Technical Debt
- Beberapa hardcoded URLs dalam JavaScript
- Kurangnya unit testing untuk core components
- Belum ada implementasi caching
- Validasi form client-side belum lengkap

### Technical Roadmap
1. **Short-term (1-2 Sprints)**:
   - Refactor JavaScript search form untuk modularitas lebih baik
   - Implementasi validasi form client-side
   - Perbaikan query untuk performa lebih baik
   - Implementasi basic caching

2. **Mid-term (2-3 Bulan)**:
   - Rewrite beberapa komponen dengan pendekatan lebih terstruktur
   - Implementasi unit testing untuk core functionality
   - Migrasi ke server production
   - Implementasi CDN untuk asset static

3. **Long-term (6+ Bulan)**:
   - Potential migration to API-driven SPA for frontend
   - Implementasi microservices untuk beberapa fungsi
   - Full test coverage
   - Horizontal scaling 