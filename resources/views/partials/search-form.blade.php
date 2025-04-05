<!-- Search Form -->
<div class="max-w-7xl mx-auto px-4 py-2 w-full rounded-3xl shadow overflow-visible border border-gray-200 search-form-container">
        <div class="p-2 md:p-4">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 md:gap-4 items-center">
                <!-- 1) Input Hotel -->
                <div class="md:col-span-3">
                    <button id="openHotelModal" class="w-full border border-gray-300 rounded-xl px-3 py-2 md:px-4 md:py-3 text-left focus:outline-none hover:bg-gray-100 transition duration-200">
                        <span class="block text-xs text-gray-500 uppercase tracking-wider search-form-label">Hotel</span>
                        <span class="block mt-1 font-semibold search-form-text" id="selectedHotelText">{{ $hotel->branch_name ?? 'Pilih Hotel' }}</span>
                    </button>
                </div>
                
                <!-- 2) Input Date Range -->
                <div class="md:col-span-3">
                    <button id="openDateModal" class="w-full border border-gray-300 rounded-xl px-3 py-2 md:px-4 md:py-3 text-left focus:outline-none hover:bg-gray-100 transition duration-200">
                        <span class="block text-xs text-gray-500 uppercase tracking-wider search-form-label">Date Range</span>
                        <span class="block mt-1 font-semibold search-form-text" id="selectedDateText">
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
                    <button id="openGuestModal" class="w-full border border-gray-300 rounded-xl px-3 py-2 md:px-4 md:py-3 text-left focus:outline-none hover:bg-gray-100 transition duration-200">
                        <span class="block text-xs text-gray-500 uppercase tracking-wider search-form-label">Guests</span>
                        <span class="block mt-1 font-semibold search-form-text" id="selectedGuestText">{{ $adults ?? 1 }} Adult, {{ $kids ?? 0 }} Kids</span>
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