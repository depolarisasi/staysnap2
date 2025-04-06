# Active Context: StaySnap

## Focus Areas
- Implementasi sebuah sistem reservasi hotel dengan fitur manajemen properti, kamar, dan booking
- Pengembangan antarmuka manajemen untuk admin, pemilik properti, dan staf
- Proses reservasi, termasuk pencarian kamar, booking, dan pembayaran
- Implementasi mekanisme pembayaran dan pengelolaan transaksi
- **Pengembangan form pencarian untuk ketersediaan kamar**
- **Perbaikan bug dan peningkatan UX pada form pencarian**

## Recent Changes
- Pengembangan panel admin untuk manajemen hotel dan kamar
- Implementasi sistem upload dan manajemen gambar untuk hotel dan kamar
- Penambahan sistem ketersediaan kamar dinamis berbasis tanggal
- Pengembangan manajemen harga kamar dinamis berbasis tanggal
- **Pengembangan form pencarian hotel dan kamar tanpa menggunakan Livewire**
- **Perbaikan syntax error pada search-scripts.blade.php yang menyebabkan error "Uncaught SyntaxError: expected expression, got '}'"**
- **Perbaikan format harga pada datepicker yang sebelumnya menampilkan "50M"**
- **Perbaikan fungsi AddToCart agar tidak melakukan redirect ke halaman cart**
- **Penambahan skeleton loading state untuk meningkatkan UX saat pencarian dan saat menambahkan kamar ke cart**
- **Pembaruan UI dengan menggunakan warna aksen biru untuk konsistensi desain**

## Implementasi Sistem Pencarian Saat Ini

### UI Pencarian Kamar
Sistem pencarian kamar terdiri dari tiga file utama:
- `/views/partials/search-form.blade.php`: Form pencarian dengan field untuk hotel, date range, jumlah tamu, dan voucher
- `/views/partials/search-modals.blade.php`: Modal untuk pemilihan hotel, tanggal, dan jumlah tamu
- `/views/partials/search-scripts.blade.php`: JavaScript untuk interaktivitas form pencarian
- Hasil pencarian ditampilkan di `/views/frontpage/search-results.blade.php`

### Controller dan API
- `SearchController.php`: Menangani request pencarian dan menampilkan hasil
- `Api/BranchController.php`: API untuk mengambil data harga kamar

### Alur Pencarian
1. Pengguna mengklik form untuk memilih hotel (membuka modal hotel)
2. Setelah memilih hotel, pengguna memilih tanggal check-in dan check-out (membuka modal date)
3. Sistem menampilkan harga terendah untuk setiap tanggal
4. Pengguna memilih jumlah tamu (dewasa dan anak-anak)
5. Pengguna mengklik "Check Availability"
6. SearchController memproses permintaan dan menampilkan hasil pencarian
7. **Saat hasil pencarian loading, sistem menampilkan skeleton loading state**
8. **Pengguna dapat menambahkan kamar ke cart dan menerima notifikasi berhasil tanpa redirect**

### Relasi Model yang Diimplementasikan
- `Room`: Model kamar dengan harga dasar dan stok
- `RoomAvailability`: Ketersediaan kamar per tanggal
- `RoomPrice`: Harga kamar dinamis per tanggal
- `Branch`: Properti/hotel yang memiliki banyak kamar

### Fungsi Inti yang Perlu Dikembangkan
- Mendapatkan harga kamar terendah untuk suatu periode
- Memeriksa ketersediaan kamar untuk suatu periode
- Menghitung total harga untuk seluruh periode menginap
- Sistem reservasi kamar
- API untuk user tamu (guest)

### Fitur yang Belum Diimplementasikan
- Proses reservasi kamar
- Pengelolaan transaksi pemesanan
- Integrasi pembayaran
- Sistem notifikasi untuk reservasi dan konfirmasi
- Sistem voucher dan promo

## Active Decisions and Considerations
- Menggunakan pendekatan server-side rendering untuk sebagian besar halaman
- Memanfaatkan Livewire untuk komponen interaktif di bagian manajemen
- **Implementasi form pencarian tanpa Livewire karena keterbatasan fungsionalitas untuk kasus ini**
- **Menggunakan JavaScript vanilla untuk interaktivitas form pencarian**
- Pengembangan sistem berbasis komponen untuk UI yang konsisten
- Implementasi relasi model yang jelas untuk mempermudah query dan reporting
- Prioritas pada UX yang intuitif untuk proses pencarian dan booking
- **Menggunakan skeleton loading state untuk meningkatkan perceived performance**
- **Menjaga konsistensi UI dengan menggunakan warna aksen biru di seluruh aplikasi**

## Tantangan Saat Ini
- Memastikan akurasi ketersediaan kamar saat booking
- Mengelola booking untuk periode yang sama oleh beberapa user secara bersamaan
- Optimalisasi proses booking dari pencarian hingga pembayaran
- Mengembangkan UI yang responsif dan user-friendly
- **Memperbaiki bug dan meningkatkan performa sistem pencarian**

## Feedback and Adjustments
- Iterasi cepat berdasarkan feedback dari pengujian internal
- Penyesuaian UI berdasarkan pengalaman pengguna
- Perbaikan bug dan penambahan fitur secara bertahap
- Pemantauan performa sistem secara berkelanjutan
- **Perbaikan UI untuk meningkatkan konsistensi dan estetika aplikasi** 