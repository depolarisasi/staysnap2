<div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 w-full max-w-5xl px-4">
    <div class="bg-white rounded-3xl shadow-2xl overflow-visible border border-gray-200">
        
        <!-- Form Utama -->
        <div class="p-6">
            @if(session()->has('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-600 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-center">
                <!-- Komponen Modal -->
                <div>
                    @livewire('hotel-modal')
                </div>
                
                <div>
                    @livewire('date-range-modal')
                </div>
                
                <div>
                    @livewire('guest-modal')
                </div>
                
                <!-- 4) Input Kode Voucher -->
                <div>
                    <div class="relative">
                        <input 
                            type="text" 
                            wire:model="voucherCode" 
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none hover:bg-gray-100 transition duration-200" 
                            placeholder="Voucher Code"
                        >
                    </div>
                </div>
                
                <!-- 5) Tombol Check Availability -->
                <div>
                    <button 
                        wire:click="checkAvailability"
                        class="w-full bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl px-4 py-3 font-bold transition duration-200 shadow"
                    >
                        <span wire:loading.remove wire:target="checkAvailability">Check Availability</span>
                        <span wire:loading wire:target="checkAvailability">Loading...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div> 