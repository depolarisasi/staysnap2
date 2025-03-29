<div wire:key="date-range-modal-{{ $selectedHotelId ?? 'default' }}">
    <!-- Button to open modal -->
    <button wire:click="toggleModal" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-left focus:outline-none hover:bg-gray-100 transition duration-200">
        <span class="block text-xs text-gray-500 uppercase tracking-wider">Date Range</span>
        <span class="block mt-1 text-lg font-semibold">
            @if($startDate && $endDate)
                {{ $startDate }} - {{ $endDate }}
            @else
                Pilih Tanggal
            @endif
        </span>
    </button>

    <!-- Modal Content - Akan ditampilkan melalui portal -->
    @if($showModal)
    <div id="portalModal" class="portal-content" data-modal-id="dateModal">
        <div class="fixed inset-0 z-50 fade-in">
            <div class="fixed inset-0 bg-black/50"></div>
            <div class="fixed inset-0 flex items-center justify-center p-4">
                <div class="bg-white rounded-2xl w-full max-w-3xl shadow-xl overflow-hidden">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-bold">Pilih Tanggal</h2>
                        <button wire:click="toggleModal" class="text-red-500 font-semibold">Tutup</button>
                    </div>
                    <div class="p-6">
                        <div id="datepicker" class="mx-auto" wire:ignore></div>
                        
                        @if(!$selectedHotelId)
                        <div class="mt-4 p-4 bg-yellow-50 text-yellow-700 rounded-lg">
                            <p>Silakan pilih hotel terlebih dahulu untuk melihat harga kamar.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    document.addEventListener('livewire:initialized', function() {
        const component = @this;
        
        // Portal event listeners
        Livewire.on('open-modal-portal', (event) => {
            const modalId = event[0].modalId;
            if (modalId === 'dateModal') {
                const portalContent = document.querySelector(`[data-modal-id="${modalId}"]`);
                if (portalContent) {
                    window.dispatchEvent(new CustomEvent('open-modal', {
                        detail: {
                            modalId: modalId,
                            modalContent: portalContent.outerHTML
                        }
                    }));
                    
                    // Inisialisasi flatpickr setelah modal dibuka
                    setTimeout(() => {
                        initFlatpickr();
                    }, 100);
                }
            }
        });
        
        // Flatpickr init
        function initFlatpickr() {
            const picker = document.querySelector('#modalPortal #datepicker');
            if (!picker) return;
            
            return flatpickr(picker, {
                mode: "range",
                inline: true,
                minDate: "today",
                showMonths: 2,
                dateFormat: "Y-m-d",
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        let startFormat = instance.formatDate(selectedDates[0], "Y-m-d");
                        let endFormat = instance.formatDate(selectedDates[1], "Y-m-d");
                        component.setDateRange(startFormat + ' to ' + endFormat);
                    }
                },
                onDayCreate: function(dObj, dStr, fp, dayElem) {
                    if (dayElem.dateObj) {
                        let dayDate = new Date(dayElem.dateObj.getTime());
                        dayDate.setHours(0,0,0,0);
                        let today = new Date();
                        today.setHours(0,0,0,0);

                        if (dayDate >= today) {
                            // Gunakan data harga dari komponen Livewire jika tersedia
                            let dateStr = dayDate.toISOString().split('T')[0]; // Format Y-m-d
                            let price = '';
                            
                            // Jika ada data harga untuk tanggal ini, tampilkan harga terendah
                            if (component.roomPrices && component.roomPrices[dateStr]) {
                                let prices = Object.values(component.roomPrices[dateStr]);
                                if (prices.length > 0) {
                                    price = Math.min(...prices);
                                }
                            } else {
                                // Harga dummy jika belum ada data
                                price = Math.floor(Math.random() * 500) + 100;
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
        }
    });
</script> 