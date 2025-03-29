@extends('layouts.frontpage.app') 
@section('title', 'Home')
@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>
  /* Animasi fade-in untuk modal */
  .fade-in {
    animation: fadeIn 0.3s ease-out;
  }
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  /* Style untuk flatpickr-calendar */
  .flatpickr-calendar {
    width: 100% !important;
    max-width: 100% !important;
    border: none !important;
    box-shadow: none !important;
  }

  /* Menyesuaikan posisi kalender */
  .flatpickr-months {
    display: flex;
    justify-content: center;
  }
  
  .flatpickr-month {
    width: 100%;
    text-align: center;
  }

  .flatpickr-current-month {
    left: 0 !important;
    right: 0 !important;
    width: 100% !important;
    padding: 0 !important;
  }
  
  .flatpickr-prev-month, .flatpickr-next-month {
    padding: 10px !important;
  }
  
  /* Mengatur lebar container bulan */
  .flatpickr-rContainer, 
  .flatpickr-days,
  .dayContainer {
    width: 100% !important;
    max-width: 100% !important;
  }
  
  /* Memastikan grid bulan sejajar dengan baik */
  .flatpickr-days .flatpickr-day {
    max-width: none !important;
  }

  /* Style untuk tanggal pada calendar */
  .flatpickr-day {
    width: 14.2857% !important; 
    height: 3.5rem !important;
    margin: 0 !important;
    border-radius: 0 !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: center !important;
    line-height: 1.2 !important;
    position: relative;
    font-size: 0.875rem;
    color: #111827;
    padding: 2px 0 !important;
  }

  /* Style untuk prices di bawah tanggal */
  .day-number {
    display: block;
    font-weight: 500;
    margin-bottom: 2px;
  }
  .day-price {
    color: #ef4444;
    font-size: 0.7rem;
    margin-top: 2px;
    line-height: 1;
    font-weight: 600;
    letter-spacing: -0.01em;
  }
  
  /* Style untuk tanggal terpilih */
  .flatpickr-day.selected {
    background-color: #3b82f6 !important;
    color: white !important;
  }
  .flatpickr-day.selected .day-price {
    color: white !important;
  }

  /* Modal styles */
  .modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 50;
  }
  
  .modal.show {
    display: block;
  }

  .modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 10;
  }
  
  .modal-dialog {
    position: relative;
    z-index: 30;
    pointer-events: auto;
  }
  
  .modal-content {
    background: white;
    pointer-events: auto;
  }
  
  /* Style untuk search form pada tampilan mobile */
  @media (max-width: 768px) {
    .search-form-text {
      font-size: 0.85rem !important;
    }
    .search-form-label {
      font-size: 0.65rem !important;
    }
    .search-form-container {
      margin-bottom: 4rem;
    }
  }

  /* Ukuran teks pada search form */
  .search-form-text {
    font-size: 0.95rem;
  }
  .search-form-label {
    font-size: 0.7rem;
  }
</style>

@endsection

@section('content')
    <!-- Hero Section with Search -->
    <div class="relative h-[500px]">
        <livewire:slider-front />  
        
        <!-- Search Form -->
        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 w-full max-w-7xl px-4">
            <div class="bg-white rounded-3xl shadow-2xl overflow-visible border border-gray-200 search-form-container">
                <div class="p-4 md:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 md:gap-4 items-center">
                <!-- 1) Input Hotel -->
                        <div class="md:col-span-3">
                            <button id="openHotelModal" class="w-full border border-gray-300 rounded-xl px-3 py-2 md:px-4 md:py-3 text-left focus:outline-none hover:bg-gray-100 transition duration-200">
                                <span class="block text-xs text-gray-500 uppercase tracking-wider search-form-label">Hotel</span>
                                <span class="block mt-1 font-semibold search-form-text" id="selectedHotelText">Pilih Hotel</span>
                  </button>
                </div>
                        
                <!-- 2) Input Date Range -->
                        <div class="md:col-span-3">
                            <button id="openDateModal" class="w-full border border-gray-300 rounded-xl px-3 py-2 md:px-4 md:py-3 text-left focus:outline-none hover:bg-gray-100 transition duration-200">
                                <span class="block text-xs text-gray-500 uppercase tracking-wider search-form-label">Date Range</span>
                                <span class="block mt-1 font-semibold search-form-text" id="selectedDateText">Pilih Tanggal</span>
                  </button>
                </div>
                        
                <!-- 3) Input Jumlah Tamu -->
                        <div class="md:col-span-2">
                            <button id="openGuestModal" class="w-full border border-gray-300 rounded-xl px-3 py-2 md:px-4 md:py-3 text-left focus:outline-none hover:bg-gray-100 transition duration-200">
                                <span class="block text-xs text-gray-500 uppercase tracking-wider search-form-label">Guests</span>
                                <span class="block mt-1 font-semibold search-form-text" id="selectedGuestText">1 Adult, 0 Kids</span>
                  </button>
                </div>
                        
                <!-- 4) Input Kode Voucher -->
                        <div class="md:col-span-2">
                            <input type="text" id="voucherInput" class="w-full border border-gray-300 rounded-xl px-3 py-2 md:px-4 md:py-3 focus:outline-none hover:bg-gray-100 transition duration-200 text-base" placeholder="Voucher Code">
                </div>
                        
                <!-- 5) Tombol Check Availability -->
                        <div class="md:col-span-2">
                            <button id="checkAvailability" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl px-3 py-2 md:px-4 md:py-3 font-bold transition duration-200 shadow text-base">
                    Check Availability
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>  

    <!-- Branches Section -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8">Our Branches</h2> 
            <livewire:hotel-branch-front /> 
        </div>
    </section>
    
  <!-- Modal Hotel -->
    <div id="hotelModal" class="modal fade-in">
        <div class="modal-backdrop" id="hotelModalBackdrop"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4 modal-dialog">
            <div class="bg-white rounded-2xl w-full max-w-3xl h-3/4 shadow-xl overflow-hidden flex flex-col modal-content">
                <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-bold">Pilih Hotel</h2>
                    <button id="closeHotelModal" class="text-red-500 font-semibold">Tutup</button>
                </div>
                    
                <!-- Search & Filter -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-center gap-4">
                        <input type="text" id="hotelSearch" placeholder="Cari hotel..." class="w-full md:w-1/2 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none">
                        <div class="flex flex-wrap gap-2" id="cityFilters">
                            <!-- City filters will be populated dynamically -->
                            <button id="resetCity" class="px-3 py-1 rounded-full border border-red-300 bg-red-100 text-red-600 text-sm">Reset</button>
                        </div>
                    </div>
                </div>
                    
                <!-- List Hotel -->
                <div class="flex-1 p-6 overflow-y-auto">
                    <div id="hotelList" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Hotels will be loaded here -->
                        <div class="col-span-2 text-center py-8 text-gray-500">
                            Loading hotels...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Date Range -->
    <div id="dateModal" class="modal fade-in">
        <div class="modal-backdrop" id="dateModalBackdrop"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4 modal-dialog">
            <div class="bg-white rounded-2xl w-full max-w-3xl shadow-xl overflow-hidden modal-content">
                <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-bold">Pilih Tanggal</h2>
                    <button id="closeDateModal" class="text-red-500 font-semibold">Tutup</button>
                </div>
                <div class="p-6">
                    <div id="datepicker" class="mx-auto"></div>
                    <div id="loadingState" class="mt-4 p-4 bg-gray-100 text-gray-500 rounded-lg hidden">
                        <p>Loading tanggal dan harga kamar...</p>
                    </div>
                    <div id="dateInfo" class="mt-4 p-3 bg-blue-50 text-blue-700 rounded-lg hidden">
                        <p class="font-medium text-sm" id="dateRangeSummary"></p>
                        <span class="inline-flex items-center px-2 py-1 mt-1 rounded text-xs font-medium bg-blue-100 text-blue-800" id="nightsBadge"></span>
                    </div>
                    <div id="dateWarning" class="mt-4 p-4 bg-yellow-50 text-yellow-700 rounded-lg">
                        <p>Silakan pilih hotel terlebih dahulu untuk melihat harga kamar.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Guest -->
    <div id="guestModal" class="modal fade-in">
        <div class="modal-backdrop" id="guestModalBackdrop"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4 modal-dialog">
            <div class="bg-white rounded-2xl w-full max-w-sm shadow-xl overflow-hidden modal-content">
                <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-bold">Jumlah Tamu</h2>
                    <button id="closeGuestModal" class="text-red-500 font-semibold">Tutup</button>
                </div>
                <div class="px-6 py-4">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-medium">Adults</span>
                        <div class="flex items-center gap-3">
                            <button id="decreaseAdult" class="bg-gray-200 text-xl w-8 h-8 flex items-center justify-center rounded-full">–</button>
                            <span id="adultCount" class="text-lg font-semibold">1</span>
                            <button id="increaseAdult" class="bg-gray-200 text-xl w-8 h-8 flex items-center justify-center rounded-full">+</button>
                        </div>
                    </div>
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-lg font-medium">Kids</span>
                        <div class="flex items-center gap-3">
                            <button id="decreaseKids" class="bg-gray-200 text-xl w-8 h-8 flex items-center justify-center rounded-full">–</button>
                            <span id="kidsCount" class="text-lg font-semibold">0</span>
                            <button id="increaseKids" class="bg-gray-200 text-xl w-8 h-8 flex items-center justify-center rounded-full">+</button>
                        </div>
                    </div>
                    <button id="saveGuest" class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-3 font-bold transition">OK</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts') 
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variabel untuk menyimpan data
        let selectedHotelId = null;
        let selectedHotelName = null;
        let startDate = null;
        let endDate = null;
        let adultCount = 1;
        let kidsCount = 0;
        let hotels = [];
        let regencies = [];
        let datepickerInstance = null;
        let roomPrices = {}; // Untuk menyimpan data harga kamar
        
        // Pastikan semua modal tertutup saat awal load
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.classList.remove('show');
        });

        // Fungsi untuk mengambil data hotel dan regency
        async function fetchHotels() {
            try {
                const response = await fetch('/api/branches');
                const data = await response.json();
                hotels = data.branches;
                regencies = data.regencies;
                renderHotels(hotels);
                renderCityFilters(regencies);
                
                // Set hotel pertama sebagai default jika ada
                if (hotels && hotels.length > 0) {
                    const defaultHotel = hotels[0];
                    selectedHotelId = defaultHotel.id;
                    selectedHotelName = defaultHotel.branch_name;
                    document.getElementById('selectedHotelText').textContent = selectedHotelName;
                }
            } catch (error) {
                console.error('Error fetching hotels:', error);
                document.getElementById('hotelList').innerHTML = '<div class="col-span-2 text-center py-8 text-red-500">Gagal memuat data hotel.</div>';
            }
        }

        // Fungsi untuk render daftar hotel
        function renderHotels(hotelsToRender) {
            const hotelList = document.getElementById('hotelList');
            if (hotelsToRender.length === 0) {
                hotelList.innerHTML = '<div class="col-span-2 text-center py-8 text-gray-500">Tidak ada hotel ditemukan.</div>';
                return;
            }

            hotelList.innerHTML = hotelsToRender.map(hotel => `
                <div class="hotel-card border rounded-xl p-4 flex flex-col cursor-pointer hover:shadow-md transition" 
                     data-id="${hotel.id}" data-name="${hotel.branch_name}">
                    ${hotel.branch_thumbnail 
                        ? `<img src="/storage/${hotel.branch_thumbnail}" alt="${hotel.branch_name}" class="h-32 w-full object-cover rounded-lg mb-3">` 
                        : `<div class="h-32 w-full bg-gray-200 rounded-lg mb-3 flex items-center justify-center"><span class="text-gray-400">No Image</span></div>`
                    }
                    <h3 class="text-lg font-semibold">${hotel.branch_name}</h3>
                    <p class="text-sm text-gray-500">${getCityName(hotel.branch_city)}</p>
                </div>
            `).join('');

            // Tambahkan event listener untuk setiap hotel card
            document.querySelectorAll('.hotel-card').forEach(card => {
                card.addEventListener('click', function() {
                    selectedHotelId = this.getAttribute('data-id');
                    selectedHotelName = this.getAttribute('data-name');
                    document.getElementById('selectedHotelText').textContent = selectedHotelName;
                    
                    // Reset data harga saat hotel berubah
                    roomPrices = {};
                    
                    // Perbarui tampilan datepicker jika modal sedang terbuka
                    if (document.getElementById('dateModal').classList.contains('show')) {
                        const datepickerElement = document.getElementById('datepicker');
                        const dateWarning = document.getElementById('dateWarning');
                        
                        datepickerElement.style.display = 'block';
                        dateWarning.style.display = 'none';
                        
                        // Reload datepicker dengan data harga baru
                        initDatepicker();
                    }
                    
                    toggleModal('hotelModal', false);
                });
            });
        }

        // Fungsi untuk mendapatkan nama kota dari ID
        function getCityName(cityId) {
            const city = regencies.find(c => c.id == cityId);
            return city ? city.name : 'Lokasi tidak tersedia';
        }

        // Fungsi untuk render filter kota
        function renderCityFilters(cities) {
            const filterContainer = document.getElementById('cityFilters');
            const cityButtons = cities.map(city => `
                <button class="city-filter px-3 py-1 rounded-full border border-gray-300 bg-gray-100 text-gray-600 text-sm" 
                        data-id="${city.id}">${city.name}</button>
            `).join('');
            
            // Sisipkan tombol kota sebelum tombol reset
            const resetButton = filterContainer.querySelector('#resetCity');
            filterContainer.innerHTML = cityButtons;
            filterContainer.appendChild(resetButton);
            
            // Tambahkan event listener untuk filter kota
            document.querySelectorAll('.city-filter').forEach(button => {
                button.addEventListener('click', function() {
                    const cityId = this.getAttribute('data-id');
                    const filteredHotels = hotels.filter(hotel => hotel.branch_city == cityId);
                    renderHotels(filteredHotels);
                    
                    // Highlight tombol yang aktif
                    document.querySelectorAll('.city-filter').forEach(btn => {
                        btn.classList.remove('bg-blue-100', 'text-blue-600');
                        btn.classList.add('bg-gray-100', 'text-gray-600');
                    });
                    this.classList.remove('bg-gray-100', 'text-gray-600');
                    this.classList.add('bg-blue-100', 'text-blue-600');
                });
            });
        }

        // Fungsi untuk toggle modal yang diperbaiki
        function toggleModal(modalId, show = true) {
            const modal = document.getElementById(modalId);
            
            // Tutup semua modal terlebih dahulu jika membuka modal baru
            if (show) {
                document.querySelectorAll('.modal').forEach(m => {
                    if (m.id !== modalId) {
                        m.classList.remove('show');
                    }
                });
            }
            
            if (show) {
                modal.classList.add('show');
                
                if (modalId === 'dateModal') {
      if (!datepickerInstance) {
                        initDatepicker();
                    } else {
                        // Perbarui tampilan berdasarkan status pemilihan hotel
                        const datepickerElement = document.getElementById('datepicker');
                        const dateWarning = document.getElementById('dateWarning');
                        
                        if (!selectedHotelId) {
                            datepickerElement.style.display = 'none';
                            dateWarning.style.display = 'block';
                        } else {
                            datepickerElement.style.display = 'block';
                            dateWarning.style.display = 'none';
                            datepickerInstance.redraw();
                        }
                    }
                }
            } else {
                modal.classList.remove('show');
            }
        }

        // Fungsi untuk inisialisasi datepicker
        function initDatepicker() {
            const datepickerElement = document.getElementById('datepicker');
            const dateWarning = document.getElementById('dateWarning');
            const loadingState = document.getElementById('loadingState');
            
            // Periksa apakah hotel sudah dipilih
            if (!selectedHotelId) {
                // Jika hotel belum dipilih, sembunyikan datepicker dan tampilkan peringatan
                datepickerElement.style.display = 'none';
                dateWarning.style.display = 'block';
                loadingState.style.display = 'none';
                return; // Hentikan fungsi di sini
            }
            
            // Jika hotel sudah dipilih, tampilkan loading state
            datepickerElement.style.display = 'none';
            dateWarning.style.display = 'none';
            loadingState.style.display = 'block';
            
            // Ambil data harga kamar dari API
            fetchRoomPrices(selectedHotelId)
                .then(() => {
                    // Inisialisasi flatpickr setelah data harga diambil
                    loadingState.style.display = 'none';
                    datepickerElement.style.display = 'block';
                    initializeFlatpickr();
                })
                .catch(error => {
                    console.error('Error fetching room prices:', error);
                    // Tetap inisialisasi flatpickr meskipun ada error
                    loadingState.style.display = 'none';
                    datepickerElement.style.display = 'block';
                    initializeFlatpickr();
                });
        }
        
        // Fungsi untuk mengambil data harga kamar dari API
        async function fetchRoomPrices(hotelId) {
            try {
                const today = new Date();
                const oneYearLater = new Date();
                oneYearLater.setFullYear(today.getFullYear() + 1);
                
                const startDateParam = today.toISOString().split('T')[0];
                const endDateParam = oneYearLater.toISOString().split('T')[0];
                
                const response = await fetch(`/api/branches/${hotelId}/room-prices?start_date=${startDateParam}&end_date=${endDateParam}`);
                const data = await response.json();
                
                // Simpan data harga
                roomPrices = data.prices;
                
                return data;
            } catch (error) {
                console.error('Error fetching room prices:', error);
                roomPrices = {}; // Reset jika ada error
                throw error;
            }
        }
        
        // Fungsi untuk format harga ke format K dan M
        function formatPrice(price) {
            if (!price || price === '-') return '-';
            
            // Konversi ke angka jika string
            let numPrice = 0;
            if (typeof price === 'string') {
                // Hapus semua karakter non-digit dan konversi ke integer
                numPrice = parseInt(price.replace(/[^\d]/g, ''));
            } else {
                numPrice = parseInt(price);
            }

            // Validasi untuk memastikan numPrice adalah angka valid
            if (isNaN(numPrice)) return '-';
            
            if (numPrice >= 1000000) {
                return Math.floor(numPrice / 1000000) + 'M';
            } else if (numPrice >= 1000) {
                return Math.floor(numPrice / 1000) + 'K';
            } else {
                return numPrice.toString();
            }
        }

        // Fungsi untuk format tanggal dengan nama hari dan bulan
        function formatDateWithDay(dateStr) {
            const date = new Date(dateStr);
            const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            
            return `${days[date.getDay()]}, ${months[date.getMonth()]} ${date.getDate()}`;
        }

        // Fungsi untuk menghitung jumlah malam
        function calculateNights(startDate, endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);
            const diffTime = Math.abs(end - start);
            return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        }

        // Fungsi untuk update informasi tanggal
        function updateDateInfo(startDate, endDate) {
            const dateInfo = document.getElementById('dateInfo');
            const dateRangeSummary = document.getElementById('dateRangeSummary');
            const nightsBadge = document.getElementById('nightsBadge');
            
            if (startDate && endDate) {
                const formattedStartDate = formatDateWithDay(startDate);
                const formattedEndDate = formatDateWithDay(endDate);
                const nights = calculateNights(startDate, endDate);
                
                dateRangeSummary.textContent = `${formattedStartDate} - ${formattedEndDate}`;
                nightsBadge.textContent = `${nights} night${nights > 1 ? 's' : ''}`;
                
                dateInfo.classList.remove('hidden');
            } else {
                dateInfo.classList.add('hidden');
            }
        }

        // Fungsi untuk inisialisasi flatpickr
        function initializeFlatpickr() {
            // Deteksi perangkat mobile
            const isMobile = window.innerWidth < 768;
            
        datepickerInstance = flatpickr("#datepicker", {
          mode: "range",
          inline: true,
                minDate: "today",
                showMonths: isMobile ? 1 : 2, // Tampilkan 1 bulan di mobile, 2 di desktop
          dateFormat: "Y-m-d",
                onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length === 2) {
                        startDate = instance.formatDate(selectedDates[0], "Y-m-d");
                        endDate = instance.formatDate(selectedDates[1], "Y-m-d");
                        
                        // Update informasi tanggal
                        updateDateInfo(startDate, endDate);
                        
                        // Update teks di tombol daterange
                        document.getElementById('selectedDateText').textContent = startDate + " - " + endDate;
                        
                        // Tutup modal secara otomatis setelah pemilihan tanggal
                        setTimeout(() => toggleModal('dateModal', false), 1000);
            }
          },
          onDayCreate: function(dObj, dStr, fp, dayElem) {
            if (dayElem.dateObj) {
              let dayDate = new Date(dayElem.dateObj.getTime());
              dayDate.setHours(0,0,0,0);
              let today = new Date();
              today.setHours(0,0,0,0);

              if (dayDate >= today) {
                            // Format tanggal ke YYYY-MM-DD
                            const dateKey = dayDate.toISOString().split('T')[0];
                            
                            // Ambil harga dari data API jika tersedia, atau tampilkan base price dari Rooms
                            let price = "-";
                            if (roomPrices[dateKey] && roomPrices[dateKey].lowest) {
                                // Format harga ke K dan M
                                price = formatPrice(roomPrices[dateKey].lowest);
                            } else if (roomPrices.room_base_price) {
                                // Gunakan room_base_price jika tidak ada harga spesifik
                                price = formatPrice(roomPrices.room_base_price);
                            }
                            
                            // Simpan nomor hari
                let dayNumber = dayElem.innerHTML;
                dayElem.innerHTML = `
                  <span class="day-number">${dayNumber}</span>
                  <span class="day-price">${price}</span>
                `;
              }
            }
          }
        });
            
            // Tambahkan event listener untuk perubahan ukuran layar
            window.addEventListener('resize', function() {
                if (datepickerInstance) {
                    // Update jumlah bulan yang ditampilkan berdasarkan ukuran layar
                    const shouldShowOneMonth = window.innerWidth < 768;
                    if (shouldShowOneMonth && datepickerInstance.config.showMonths !== 1) {
                        datepickerInstance.set('showMonths', 1);
                        datepickerInstance.redraw();
                    } else if (!shouldShowOneMonth && datepickerInstance.config.showMonths !== 2) {
                        datepickerInstance.set('showMonths', 2);
        datepickerInstance.redraw();
      }
                }
            });
        }

        // Pencarian hotel
        document.getElementById('hotelSearch').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            if (searchTerm.length > 0) {
                const filteredHotels = hotels.filter(hotel => 
                    hotel.branch_name.toLowerCase().includes(searchTerm) || 
                    getCityName(hotel.branch_city).toLowerCase().includes(searchTerm)
                );
                renderHotels(filteredHotels);
            } else {
                renderHotels(hotels);
            }
        });

        // Reset filter kota
        document.getElementById('resetCity').addEventListener('click', function() {
            renderHotels(hotels);
            document.querySelectorAll('.city-filter').forEach(btn => {
                btn.classList.remove('bg-blue-100', 'text-blue-600');
                btn.classList.add('bg-gray-100', 'text-gray-600');
            });
        });

        // Event untuk modal hotel
        document.getElementById('openHotelModal').addEventListener('click', function(e) {
            e.preventDefault();
            toggleModal('hotelModal', true);
        });
        document.getElementById('closeHotelModal').addEventListener('click', function(e) {
            e.preventDefault();
            toggleModal('hotelModal', false);
        });

        // Event untuk modal tanggal
        document.getElementById('openDateModal').addEventListener('click', function(e) {
            e.preventDefault();
            toggleModal('dateModal', true);
        });
        document.getElementById('closeDateModal').addEventListener('click', function(e) {
            e.preventDefault();
            toggleModal('dateModal', false);
        });

        // Event untuk modal tamu
        document.getElementById('openGuestModal').addEventListener('click', function(e) {
            e.preventDefault();
            toggleModal('guestModal', true);
        });
        document.getElementById('closeGuestModal').addEventListener('click', function(e) {
            e.preventDefault();
            toggleModal('guestModal', false);
        });

        // Event untuk jumlah tamu
  document.getElementById('increaseAdult').addEventListener('click', () => {
    adultCount++;
    document.getElementById('adultCount').textContent = adultCount;
  });
  document.getElementById('decreaseAdult').addEventListener('click', () => {
            if (adultCount > 1) {
      adultCount--;
      document.getElementById('adultCount').textContent = adultCount;
    }
  });
  document.getElementById('increaseKids').addEventListener('click', () => {
    kidsCount++;
    document.getElementById('kidsCount').textContent = kidsCount;
  });
  document.getElementById('decreaseKids').addEventListener('click', () => {
            if (kidsCount > 0) {
      kidsCount--;
      document.getElementById('kidsCount').textContent = kidsCount;
    }
  });
  document.getElementById('saveGuest').addEventListener('click', () => {
    document.getElementById('selectedGuestText').textContent = adultCount + " Adult, " + kidsCount + " Kids";
            toggleModal('guestModal', false);
        });

        // Event untuk check availability
        document.getElementById('checkAvailability').addEventListener('click', function() {
            if (!selectedHotelId) {
                alert("Silakan pilih hotel terlebih dahulu.");
                return;
            }
            if (!startDate || !endDate) {
                alert("Silakan pilih tanggal check-in dan check-out.");
                return;
            }
            
            const voucher = document.getElementById('voucherInput').value;
            
            // Redirect ke halaman pencarian dengan parameter
            window.location.href = `/search-rooms?hotel_id=${selectedHotelId}&start_date=${startDate}&end_date=${endDate}&adults=${adultCount}&kids=${kidsCount}&voucher=${voucher}`;
        });

        // Event listener untuk menutup modal dengan backdrop
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.addEventListener('click', function() {
                const modalId = this.closest('.modal').id;
                toggleModal(modalId, false);
    });
  });

        // Load hotels on page load
        fetchHotels();
  });
</script>
@endsection