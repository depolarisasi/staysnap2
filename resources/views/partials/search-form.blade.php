<!-- Search Form -->
<div class="max-w-7xl mx-auto px-4 py-4 w-full bg-white rounded-xl shadow-sm border border-gray-100 search-form-container">
    <div class="p-2 md:p-4">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 md:gap-4 items-center">
            <!-- 1) Input Hotel -->
            <div class="md:col-span-3">
                <button id="openHotelModal" class="w-full border border-gray-200 bg-white hover:shadow-md rounded-xl px-3 py-3 text-left focus:outline-none focus:ring-2 focus:ring-blue-100 transition-all duration-200">
                    <span class="block text-xs text-gray-500 uppercase tracking-wider search-form-label">Hotel</span>
                    <span class="block mt-1 font-medium text-gray-800 search-form-text" id="selectedHotelText">{{ $hotel->branch_name ?? 'Pilih Hotel' }}</span>
                </button>
            </div>
            
            <!-- 2) Input Date Range -->
            <div class="md:col-span-3">
                <button id="openDateModal" class="w-full border border-gray-200 bg-white hover:shadow-md rounded-xl px-3 py-3 text-left focus:outline-none focus:ring-2 focus:ring-blue-100 transition-all duration-200">
                    <span class="block text-xs text-gray-500 uppercase tracking-wider search-form-label">Date Range</span>
                    <span class="block mt-1 font-medium text-gray-800 search-form-text" id="selectedDateText">
                        @if(isset($startDate) && isset($endDate))
                            {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                        @else
                            Pilih Tanggal
                        @endif
                    </span>
                </button>
            </div>
            
            <!-- 3) Input Jumlah Tamu -->
            <div class="md:col-span-2">
                <button id="openGuestModal" class="w-full border border-gray-200 bg-white hover:shadow-md rounded-xl px-3 py-3 text-left focus:outline-none focus:ring-2 focus:ring-blue-100 transition-all duration-200">
                    <span class="block text-xs text-gray-500 uppercase tracking-wider search-form-label">Guests</span>
                    <span class="block mt-1 font-medium text-gray-800 search-form-text" id="selectedGuestText">{{ $adults ?? 1 }} Adult, {{ $kids ?? 0 }} Kids</span>
                </button>
            </div>
            
            <!-- 4) Input Kode Voucher - Styling diseragamkan-->
            <div class="md:col-span-2">
                <div class="relative h-full">
                    <div class="border border-gray-200 bg-white rounded-xl px-3 py-1.5 h-full flex flex-col justify-center">
                        <span class="block text-xs text-gray-500 uppercase tracking-wider search-form-label">Voucher Code</span>
                        <input type="text" id="voucherInput" class="w-full bg-transparent border-none py-1 px-0 text-gray-700 focus:outline-none focus:ring-0" placeholder="Enter voucher code">
                    </div>
                </div>
            </div>
            
            <!-- 5) Tombol Check Availability -->
            <div class="md:col-span-2">
                <button id="checkAvailability" class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-3 py-3.5 font-medium transition duration-200 shadow-sm text-base flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>Check Rooms</span>
                </button>
            </div>
        </div>
    </div> 
</div> 