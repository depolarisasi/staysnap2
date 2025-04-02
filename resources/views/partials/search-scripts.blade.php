<!-- Search Form Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
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
</style>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Global variables
    let selectedHotelId = null;
    let selectedHotelName = null;
    let hotels = [];
    let roomPrices = {};

    // Function to fetch hotel prices
    async function fetchHotelPrices(hotels) {
        console.log('Fetching prices for hotels:', hotels);
        
        for (const hotel of hotels) {
            try {
                console.log(`Fetching price for hotel ${hotel.id} (${hotel.branch_name})`);
                
                // Fetching price data for the hotel
                const response = await fetch(`/api/branches/${hotel.id}/room-prices`);
                const data = await response.json();
                
                console.log(`Price data for hotel ${hotel.id}:`, data);
                
                if (data.status === 'success') {
                    let lowestPrice = null;
                    
                    // Check if we have room prices data
                    if (data.prices) {
                        // Handle both object and array formats
                        const prices = Array.isArray(data.prices) ? data.prices : Object.values(data.prices);
                        
                        // Get current date and next month
                        const today = new Date();
                        const nextMonth = new Date();
                        nextMonth.setMonth(today.getMonth() + 1);
                        
                        // Format date range to check (today to next month)
                        const startDate = today.toISOString().split('T')[0];
                        const endDate = nextMonth.toISOString().split('T')[0];
                        
                        console.log(`Checking prices between ${startDate} and ${endDate}`);
                        
                        // Find the lowest price in the next month
                        let lowestInDateRange = null;
                        
                        for (const priceData of prices) {
                            // Handle different price data formats
                            const date = priceData.date || priceData;
                            const price = parseFloat(priceData.lowest || priceData.price || priceData);
                            
                            // Skip invalid prices
                            if (isNaN(price)) continue;
                            
                            // Check if date is within range
                            if (date >= startDate && date <= endDate) {
                                if (lowestInDateRange === null || price < lowestInDateRange) {
                                    lowestInDateRange = price;
                                }
                            }
                        }
                        
                        // If we found price in range, use it
                        if (lowestInDateRange !== null) {
                            lowestPrice = lowestInDateRange;
                        }
                    }
                    
                    // If no price found in date range, use base price
                    if (lowestPrice === null && data.room_base_price) {
                        const basePrice = parseFloat(data.room_base_price);
                        if (!isNaN(basePrice)) {
                            lowestPrice = basePrice;
                        }
                    }
                    
                    console.log(`Final lowest price for hotel ${hotel.id}: ${lowestPrice}`);
                    
                    // Update the price display
                    updateHotelPrice(hotel.id, lowestPrice);
                } else {
                    // Handle error response
                    console.error(`Error in API response for hotel ${hotel.id}:`, data.message);
                    updateHotelPrice(hotel.id, null);
                }
            } catch (error) {
                console.error(`Error fetching prices for hotel ${hotel.id}:`, error);
                updateHotelPrice(hotel.id, null);
            }
        }
    }

    // Function to update hotel price display
    function updateHotelPrice(hotelId, price) {
        const priceElement = document.querySelector(`#hotel-${hotelId} .hotel-price`);
        if (priceElement) {
            if (price !== null && !isNaN(price) && price > 0) {
                // Format price with thousand separator
                const formattedPrice = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(price);
                
                priceElement.innerHTML = `
                    <div class="text-sm text-gray-600">Mulai dari</div>
                    <div class="text-lg font-semibold text-green-600">${formattedPrice}</div>
                `;
                priceElement.classList.remove('hidden');
            } else {
                priceElement.innerHTML = `
                    <div class="text-sm text-gray-600">Hubungi hotel</div>
                `;
                priceElement.classList.remove('hidden');
            }
        }
    }

    // Function to select a hotel
    function selectHotel(hotelId) {
        const hotel = hotels.find(h => h.id === hotelId);
        if (!hotel) {
            console.error('Hotel not found:', hotelId);
            return;
        }

        // Update selected hotel data
        selectedHotelId = hotelId;
        selectedHotelName = hotel.branch_name;

        // Update hotel button text
        const hotelButton = document.getElementById('hotelButton');
        if (hotelButton) {
            hotelButton.innerHTML = `
                <div class="text-left">
                    <div class="text-sm text-gray-600">Hotel</div>
                    <div class="font-medium">${hotel.branch_name}</div>
                </div>
            `;
        }

        // Close hotel modal
        closeHotelModal();

        // Show success message
        Swal.fire({
            icon: 'success',
            title: 'Hotel Dipilih',
            text: `Anda telah memilih ${hotel.branch_name}`,
            timer: 1500,
            showConfirmButton: false
        });

        // Update URL parameters
        const url = new URL(window.location.href);
        url.searchParams.set('hotel_id', hotelId);
        window.history.pushState({}, '', url);
    }

    // Variables
    let datepickerInstance = null;
    let startDate = null;
    let endDate = null;
    let allHotels = []; // Variabel untuk menyimpan semua data hotel
    
    // Initialization
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listeners to search form elements
        document.getElementById('openHotelModal').addEventListener('click', openHotelModal);
        document.getElementById('openDateModal').addEventListener('click', openDateModal);
        document.getElementById('openGuestModal').addEventListener('click', openGuestModal);
        document.getElementById('checkAvailability').addEventListener('click', checkAvailability);
        
        // Initialize from URL parameters
        initFromUrlParams();
        
        // Auto load first branch if no hotel selected
        if (!selectedHotelId) {
            loadFirstBranch();
        }
    });

    // Initialize from URL parameters
    function initFromUrlParams() {
        const urlParams = new URLSearchParams(window.location.search);
        
        // Get hotel ID
        selectedHotelId = urlParams.get('hotel_id') || '{{ $hotel->id ?? "" }}';
        
        // Get date range
        startDate = urlParams.get('start_date') || null;
        endDate = urlParams.get('end_date') || null;
        
        // Update tanggal pada tombol daterange jika ada
        if (startDate && endDate) {
            const startObj = new Date(startDate);
            const endObj = new Date(endDate);
            const nights = Math.ceil((endObj - startObj) / (1000 * 60 * 60 * 24));
            
            const startDisplay = startObj.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
            const endDisplay = endObj.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
            
            const selectedDateText = document.getElementById('selectedDateText');
            if (selectedDateText) {
                selectedDateText.textContent = `${startDisplay} - ${endDisplay} (${nights} Malam)`;
            }
        }
        
        // If hotel is already selected, update button text and prefetch prices
        if (selectedHotelId) {
            const hotelName = document.getElementById('selectedHotelText').textContent;
            if (hotelName !== 'Pilih Hotel') {
                // Hotel name already set from controller, prefetch room prices
                console.log('Hotel already selected:', hotelName, 'ID:', selectedHotelId);
                
                // Pre-fetch room prices for faster date modal opening
                fetchRoomPrices(selectedHotelId)
                    .then(data => {
                        console.log('Room prices pre-fetched successfully');
                    })
                    .catch(error => {
                        console.error('Error pre-fetching room prices:', error);
                    });
            }
        }
    }
    
    // Auto load first branch
    function loadFirstBranch() {
        fetch('{{ route("api.hotels") }}')
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    // Select first hotel
                    const firstHotel = data[0];
                    selectHotel(firstHotel.id, firstHotel.branch_name);
                }
            })
            .catch(error => {
                console.error('Error loading hotels:', error);
            });
    }

    // Hotel Selection Functions
    function openHotelModal() {
        const hotelModal = document.getElementById('hotelModal');
        hotelModal.classList.remove('hidden');
        hotelModal.classList.add('flex');
        
        // Show loading state
        const hotelList = document.getElementById('hotelList');
        const hotelListLoading = document.getElementById('hotelListLoading');
        
        if (hotelList && hotelListLoading) {
            hotelList.innerHTML = '';
            hotelListLoading.classList.remove('hidden');
        }
        
        // Load hotels via AJAX if not already loaded
        if (allHotels.length === 0) {
            loadHotels();
        } else {
            // Use cached hotels data
            if (hotelListLoading) {
                hotelListLoading.classList.add('hidden');
            }
            renderHotels(allHotels);
        }
        
        // Set up search and sorting event listeners
        setupHotelFilters();
    }

    function closeHotelModal() {
        const hotelModal = document.getElementById('hotelModal');
        hotelModal.classList.add('hidden');
        hotelModal.classList.remove('flex');
    }

    // Setup filter and sorting for hotel modal
    function setupHotelFilters() {
        const searchInput = document.getElementById('hotelSearch');
        const sortSelect = document.getElementById('citySorting');
        
        if (searchInput) {
            searchInput.addEventListener('input', filterHotels);
            // Clear input on first load
            searchInput.value = '';
        }
        
        if (sortSelect) {
            sortSelect.addEventListener('change', sortHotels);
            // Reset sort on first load
            sortSelect.value = 'name';
        }
    }

    // Function to load hotels
    async function loadHotels() {
        const hotelList = document.getElementById('hotelList');
        const hotelListLoading = document.getElementById('hotelListLoading');
        
        try {
            const response = await fetch('{{ route("api.hotels") }}');
            const data = await response.json();
            
            // Store all hotels for filtering later
            allHotels = data;
            
            if (hotelListLoading) {
                hotelListLoading.classList.add('hidden');
            }
            
            if (data.length > 0) {
                // Apply initial sort by name
                sortHotelData(allHotels, 'name');
                await renderHotels(allHotels);
            } else {
                if (hotelList) {
                    hotelList.innerHTML = '<div class="col-span-full text-center py-4 text-gray-500">Tidak ada hotel tersedia</div>';
                }
            }
        } catch (error) {
            console.error('Error loading hotels:', error);
            if (hotelList) {
                hotelList.innerHTML = '<div class="col-span-full text-center py-4 text-red-500">Gagal memuat daftar hotel</div>';
            }
            if (hotelListLoading) {
                hotelListLoading.classList.add('hidden');
            }
        }
    }

    // Filter hotels based on search query
    function filterHotels() {
        const searchQuery = document.getElementById('hotelSearch').value.toLowerCase();
        const sortType = document.getElementById('citySorting').value;
        
        const filteredHotels = allHotels.filter(hotel => 
            hotel.branch_name.toLowerCase().includes(searchQuery) || 
            (hotel.regency && hotel.regency.regency.toLowerCase().includes(searchQuery)) ||
            (hotel.province && hotel.province.province.toLowerCase().includes(searchQuery))
        );
        
        // Sort the filtered hotels
        sortHotelData(filteredHotels, sortType);
        
        // Render the filtered hotels
        renderHotels(filteredHotels);
    }

    // Sort hotels based on selected criteria
    function sortHotels() {
        const searchQuery = document.getElementById('hotelSearch').value.toLowerCase();
        const sortType = document.getElementById('citySorting').value;
        
        let hotelsToSort = [...allHotels];
        
        // Apply search filter if present
        if (searchQuery) {
            hotelsToSort = hotelsToSort.filter(hotel => 
                hotel.branch_name.toLowerCase().includes(searchQuery) || 
                (hotel.regency && hotel.regency.regency.toLowerCase().includes(searchQuery)) ||
                (hotel.province && hotel.province.province.toLowerCase().includes(searchQuery))
            );
        }
        
        // Sort hotels
        sortHotelData(hotelsToSort, sortType);
        
        // Render sorted hotels
        renderHotels(hotelsToSort);
    }

    // Function to sort hotel data based on criteria
    function sortHotelData(hotels, sortType) {
        switch (sortType) {
            case 'name':
                hotels.sort((a, b) => a.branch_name.localeCompare(b.branch_name));
                break;
            case 'city':
                hotels.sort((a, b) => {
                    const cityA = a.regency ? a.regency.regency : '';
                    const cityB = b.regency ? b.regency.regency : '';
                    return cityA.localeCompare(cityB);
                });
                break;
            case 'rating':
                hotels.sort((a, b) => (b.branch_star || 0) - (a.branch_star || 0));
                break;
            case 'price':
                // Default to name sorting as price may not be available immediately
                hotels.sort((a, b) => a.branch_name.localeCompare(b.branch_name));
                break;
        }
    }

    // Render hotels as cards
    async function renderHotels(hotels) {
        const hotelList = document.getElementById('hotelList');
        
        if (!hotelList) return;
        
        if (hotels.length === 0) {
            hotelList.innerHTML = '<div class="col-span-full text-center py-8 text-gray-500">Tidak ada hotel yang sesuai dengan pencarian Anda</div>';
            return;
        }
        
        let hotelsHtml = '';
        
        hotels.forEach(hotel => {
            hotelsHtml += generateHotelCard(hotel);
        });
        
        hotelList.innerHTML = hotelsHtml;
        
        // Fetch prices for each hotel to update the cards
        await fetchHotelPrices(hotels);
    }

    function generateHotelCard(hotel) {
        return `
            <div id="hotel-${hotel.id}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 cursor-pointer" onclick="selectHotel(${hotel.id})">
                <div class="relative h-48">
                    <img src="${hotel.branch_thumbnail ? 'storage/' + hotel.branch_thumbnail : '/images/default-hotel.jpg'}" alt="${hotel.branch_name}" class="w-full h-full object-cover">
                    <div class="absolute top-2 right-2 bg-white px-2 py-1 rounded-full text-sm font-medium text-gray-800">
                        ${hotel.branch_star || '4.5'} ⭐
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">${hotel.branch_name}</h3>
                    <div class="flex items-center text-gray-600 mb-2">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-sm">${hotel.regency ? hotel.regency.regency : ''}, ${hotel.province ? hotel.province.province : ''}</span>
                    </div>
                    <div class="hotel-price hidden">
                        <div class="text-sm text-gray-600">Memuat harga...</div>
                    </div>
                </div>
            </div>
        `;
    }

    // Date Selection Functions
    function openDateModal() {
        if (!selectedHotelId) {
            Swal.fire({
                icon: 'warning',
                title: 'Pilih Hotel Terlebih Dahulu',
                text: 'Silakan pilih hotel sebelum memilih tanggal',
                confirmButtonText: 'OK'
            });
            return;
        }

        const dateModal = document.getElementById('dateModal');
        const datepickerContainer = document.getElementById('datepickerContainer');
        const loadingState = document.getElementById('loadingState');

        if (dateModal && datepickerContainer && loadingState) {
            dateModal.classList.remove('hidden');
            loadingState.classList.remove('hidden');
            datepickerContainer.classList.add('hidden');

            // Inisialisasi flatpickr
            initializeFlatpickr();
        }
    }

    function closeDateModal() {
        const dateModal = document.getElementById('dateModal');
        if (dateModal) {
            dateModal.classList.add('hidden');
        }
    }
    
    // Function to fetch room prices from API
    async function fetchRoomPrices(hotelId) {
        try {
            const today = new Date();
            const oneYearLater = new Date();
            oneYearLater.setFullYear(today.getFullYear() + 1);
            
            const startDateParam = today.toISOString().split('T')[0];
            const endDateParam = oneYearLater.toISOString().split('T')[0];
            
            const response = await fetch(`/api/branches/${hotelId}/room-prices?start_date=${startDateParam}&end_date=${endDateParam}`);
            const data = await response.json();
            
            // Save price data
            roomPrices = data.prices || {};
            roomPrices.room_base_price = data.room_base_price;
            
            return data;
        } catch (error) {
            console.error('Error fetching room prices:', error);
            roomPrices = {}; // Reset if error
            throw error;
        }
    }
    
    // Function to format price for display
    function formatPrice(price, format) {
        if (!price || price === '-') return '-';
        
        // Convert to number
        let numPrice = 0;
        if (typeof price === 'string') {
            // Remove all non-digit characters and convert to integer
            numPrice = parseInt(price.replace(/[^\d]/g, ''));
        } else {
            numPrice = parseInt(price);
        }

        // Validate to ensure numPrice is a valid number
        if (isNaN(numPrice)) return '-';
        
        // For price display in hotel cards, use full format with thousands separator
        if (format === 'full') {
            return numPrice.toLocaleString('id-ID');
        }
        
        // For calendar display, use abbreviated K and M format
        if (numPrice >= 1000000) {
            return Math.floor(numPrice / 1000000) + 'M';
        } else if (numPrice >= 1000) {
            return Math.floor(numPrice / 1000) + 'K';
        } else {
            return numPrice.toString();
        }
    }

    // Initialize flatpickr
    function initializeFlatpickr() {
        const datepickerContainer = document.getElementById('datepickerContainer');
        const loadingState = document.getElementById('loadingState');
        const datepickerElement = document.getElementById('datepicker');
        
        if (!datepickerContainer || !loadingState || !datepickerElement) return;

        // Deteksi perangkat mobile
        const isMobile = window.innerWidth <= 768;

        // Inisialisasi flatpickr
        datepickerInstance = flatpickr(datepickerElement, {
            mode: "range",
            inline: true,
            minDate: "today",
            showMonths: isMobile ? 1 : 2,
            dateFormat: "Y-m-d",
            locale: "id",
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    startDate = instance.formatDate(selectedDates[0], "Y-m-d");
                    endDate = instance.formatDate(selectedDates[1], "Y-m-d");
                    
                    // Format untuk tampilan
                    const startDisplay = selectedDates[0].toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
                    const endDisplay = selectedDates[1].toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
                    const nights = Math.ceil((selectedDates[1] - selectedDates[0]) / (1000 * 60 * 60 * 24));
                    
                    // Update teks pada tombol daterange
                    const selectedDateText = document.getElementById('selectedDateText');
                    if (selectedDateText) {
                        selectedDateText.textContent = `${startDisplay} - ${endDisplay} (${nights} Malam)`;
                    }
                    
                    // Update informasi tanggal di dalam modal
                    const dateInfo = document.getElementById('dateInfo');
                    if (dateInfo) {
                        const formatDate = (date) => {
                            return new Date(date).toLocaleDateString('id-ID', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });
                        };
                        
                        dateInfo.innerHTML = `
                            <div class="flex flex-col space-y-2">
                                <div class="flex justify-between items-center">
                                    <div class="flex-1">
                                        <div class="text-sm text-gray-500">Check-in</div>
                                        <div class="font-medium">${formatDate(startDate)}</div>
                                    </div>
                                    <div class="flex-1 text-right">
                                        <div class="text-sm text-gray-500">Check-out</div>
                                        <div class="font-medium">${formatDate(endDate)}</div>
                                    </div>
                                </div>
                                <div class="flex justify-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        ${nights} Malam
                                    </span>
                                </div>
                            </div>
                        `;
                        dateInfo.classList.remove('hidden');
                    }
                    
                    // Simpan ke URL
                    const url = new URL(window.location.href);
                    url.searchParams.set('start_date', startDate);
                    url.searchParams.set('end_date', endDate);
                    window.history.pushState({}, '', url);

                    // Tutup modal setelah 1 detik
                    setTimeout(closeDateModal, 1000);
                }
            },
            onDayCreate: function(dObj, dStr, fp, dayElem) {
                if (dayElem.dateObj) {
                    let dayDate = new Date(dayElem.dateObj.getTime());
                    dayDate.setHours(0,0,0,0);
                    let today = new Date();
                    today.setHours(0,0,0,0);

                    if (dayDate >= today) {
                        // Format date to YYYY-MM-DD
                        const dateKey = dayDate.toISOString().split('T')[0];

                        // Get price from API data if available, or show base price from Rooms
                        let price = "-";
                        if (roomPrices[dateKey] && roomPrices[dateKey].lowest) {
                            // Format price to K and M
                            price = formatPrice(roomPrices[dateKey].lowest);
                        } else if (roomPrices.room_base_price) {
                            // Use room_base_price if no specific price available
                            price = formatPrice(roomPrices.room_base_price);
                        }
                        
                        // Save day number
                        let dayNumber = dayElem.innerHTML;
                        dayElem.innerHTML = `
                            <span class="day-number">${dayNumber}</span>
                            <span class="day-price">${price}</span>
                        `;
                    }
                }
            }
        });

        // Add event listener for screen size changes
        window.addEventListener('resize', function() {
            if (datepickerInstance) {
                // Update number of months displayed based on screen size
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

        // Sembunyikan loading state dan tampilkan datepicker
        loadingState.classList.add('hidden');
        datepickerContainer.classList.remove('hidden');

        // Jika sudah ada tanggal yang dipilih, set tanggal tersebut
        if (startDate && endDate) {
            datepickerInstance.setDate([startDate, endDate]);
            
            // Update juga informasi tanggal di bawah calendar
            const dateInfo = document.getElementById('dateInfo');
            if (dateInfo) {
                const startObj = new Date(startDate);
                const endObj = new Date(endDate);
                const nights = Math.ceil((endObj - startObj) / (1000 * 60 * 60 * 24));
                
                const formatDate = (date) => {
                    return new Date(date).toLocaleDateString('id-ID', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                };
                
                dateInfo.innerHTML = `
                    <div class="flex flex-col space-y-2">
                        <div class="flex justify-between items-center">
                            <div class="flex-1">
                                <div class="text-sm text-gray-500">Check-in</div>
                                <div class="font-medium">${formatDate(startDate)}</div>
                            </div>
                            <div class="flex-1 text-right">
                                <div class="text-sm text-gray-500">Check-out</div>
                                <div class="font-medium">${formatDate(endDate)}</div>
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                ${nights} Malam
                            </span>
                        </div>
                    </div>
                `;
                dateInfo.classList.remove('hidden');
            }
        }
    }

    // Fungsi untuk menyimpan tanggal ke URL
    function saveDatesToUrl(startDate, endDate) {
        if (!startDate || !endDate) return;
        
        const url = new URL(window.location.href);
        url.searchParams.set('start_date', startDate);
        url.searchParams.set('end_date', endDate);
        window.history.pushState({}, '', url);
    }

    // Guest Selection Functions
    function openGuestModal() {
        document.getElementById('guestModal').classList.remove('hidden');
        document.getElementById('guestModal').classList.add('flex');
    }

    function closeGuestModal() {
        document.getElementById('guestModal').classList.add('hidden');
        document.getElementById('guestModal').classList.remove('flex');
    }

    function updateGuestCount(type, change) {
        const countElement = document.getElementById(type === 'adults' ? 'adultCount' : 'kidCount');
        let currentCount = parseInt(countElement.textContent);
        
        if (type === 'adults' && currentCount + change < 1) return;
        if (type === 'kids' && currentCount + change < 0) return;
        
        countElement.textContent = currentCount + change;
    }

    function applyGuestSelection() {
        const adults = document.getElementById('adultCount').textContent;
        const kids = document.getElementById('kidCount').textContent;
        
        document.getElementById('selectedGuestText').textContent = `${adults} Adult, ${kids} Kids`;
        closeGuestModal();
        
        // Store guest counts in URL params for session
        const url = new URL(window.location.href);
        url.searchParams.set('adults', adults);
        url.searchParams.set('kids', kids);
        window.history.pushState({}, '', url);
    }

    // Check Availability Function
    function checkAvailability() {
        // Get all necessary parameters
        const urlParams = new URLSearchParams(window.location.search);
        
        const hotelId = selectedHotelId || urlParams.get('hotel_id');
        const startDateParam = startDate || urlParams.get('start_date');
        const endDateParam = endDate || urlParams.get('end_date');
        const adults = urlParams.get('adults') || document.getElementById('adultCount')?.textContent || 1;
        const kids = urlParams.get('kids') || document.getElementById('kidCount')?.textContent || 0;
        const voucher = document.getElementById('voucherInput').value;
        
        if (!hotelId) {
            Swal.fire({
                title: 'Error!',
                text: 'Silakan pilih hotel terlebih dahulu',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        if (!startDateParam || !endDateParam) {
            Swal.fire({
                title: 'Error!',
                text: 'Silakan pilih tanggal check-in dan check-out',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        // Redirect to search results with updated parameters
        window.location.href = `{{ route('search.rooms') }}?hotel_id=${hotelId}&start_date=${startDateParam}&end_date=${endDateParam}&adults=${adults}&kids=${kids}&voucher=${voucher}`;
    }
</script> 