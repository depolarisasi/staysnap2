<!-- Hotel Selection Modal -->
<div id="hotelModal" class="fixed inset-0 hidden items-center justify-center z-50">
    <div class="bg-black/50 bg-opacity-1 absolute inset-0" onclick="closeHotelModal()"></div>
    <div class="bg-white w-11/12 md:w-4/5 max-w-6xl rounded-lg p-4 md:p-6 relative z-10 max-h-[90vh] overflow-hidden flex flex-col">
        <div class="flex justify-between items-center mb-4 border-b pb-4">
            <h2 class="text-xl font-bold text-gray-800">Pilih Hotel</h2>
            <button onclick="closeHotelModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Search and Filter -->
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-3">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" id="hotelSearch" class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Cari hotel...">
            </div>
            <div class="flex items-center space-x-3">
                <label for="citySorting" class="text-sm font-medium text-gray-700">Sort by:</label>
                <select id="citySorting" class="w-full border border-gray-300 rounded-lg py-2 pl-3 pr-10 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="name">Nama Hotel (A-Z)</option>
                    <option value="city">Kota</option>
                    <option value="rating">Rating (Tertinggi)</option>
                    <option value="price">Harga (Terendah)</option>
                </select>
            </div>
        </div>
        
        <!-- Loading State -->
        <div id="hotelListLoading" class="text-center py-8 hidden">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-yellow-500"></div>
            <p class="mt-2 text-gray-600">Memuat daftar hotel...</p>
        </div>
        
        <!-- Hotel Cards Container -->
        <div class="overflow-y-auto flex-grow" style="max-height: calc(90vh - 180px);">
            <div id="hotelList" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Hotel cards will be loaded here via AJAX -->
                <div class="text-center py-4">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-yellow-500"></div>
                    <p class="mt-2 text-gray-600">Memuat daftar hotel...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tanggal -->
<div id="dateModal" class="fixed inset-0 overflow-y-auto h-full w-full hidden z-50">
    <div class="bg-black/50 bg-opacity-1 absolute inset-0" onclick="closeDateModal()"></div>
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 max-w-4xl shadow-lg rounded-md bg-white z-10">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Pilih Tanggal Check-in & Check-out</h3>
            <button onclick="closeDateModal()" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Loading State -->
        <div id="loadingState" class="flex justify-center items-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
        </div>

        <!-- Datepicker Container -->
        <div id="datepickerContainer" class="hidden">
            <!-- Informasi Tanggal -->
            <div id="dateInfo" class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200"></div>
            
            <!-- Calendar -->
            <div id="datepicker"></div>
        </div>
    </div>
</div>

<!-- Guest Selection Modal -->
<div id="guestModal" class="fixed inset-0 hidden items-center justify-center z-50">
    <div class="bg-black/50 bg-opacity-1 absolute inset-0" onclick="closeGuestModal()"></div>
    <div class="bg-white w-11/12 md:w-1/3 max-w-sm rounded-lg p-4 relative z-10">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Pilih Jumlah Tamu</h2>
            <button onclick="closeGuestModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dewasa</label>
                <div class="flex items-center space-x-4">
                    <button onclick="updateGuestCount('adults', -1)" class="w-8 h-8 border rounded-full flex items-center justify-center hover:bg-gray-100">-</button>
                    <span id="adultCount" class="text-lg font-semibold">{{ $adults ?? 1 }}</span>
                    <button onclick="updateGuestCount('adults', 1)" class="w-8 h-8 border rounded-full flex items-center justify-center hover:bg-gray-100">+</button>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Anak</label>
                <div class="flex items-center space-x-4">
                    <button onclick="updateGuestCount('kids', -1)" class="w-8 h-8 border rounded-full flex items-center justify-center hover:bg-gray-100">-</button>
                    <span id="kidCount" class="text-lg font-semibold">{{ $kids ?? 0 }}</span>
                    <button onclick="updateGuestCount('kids', 1)" class="w-8 h-8 border rounded-full flex items-center justify-center hover:bg-gray-100">+</button>
                </div>
            </div>
        </div>
        <div class="mt-4 flex justify-end">
            <button onclick="applyGuestSelection()" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
                Terapkan
            </button>
        </div>
    </div>
</div> 