<div wire:key="hotel-modal-{{ $selectedHotel ? $selectedHotel['id'] : 'default' }}">
    <!-- Button to open modal -->
    <button wire:click="toggleModal" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-left focus:outline-none hover:bg-gray-100 transition duration-200">
        <span class="block text-xs text-gray-500 uppercase tracking-wider">Hotel</span>
        <span class="block mt-1 text-lg font-semibold">
            @if($selectedHotel)
                {{ $selectedHotel['name'] }}
            @else
                Pilih Hotel
            @endif
        </span>
    </button>

    <!-- Modal Content - Akan ditampilkan melalui portal -->
    @if($showModal)
    <div id="portalModal" class="portal-content" data-modal-id="hotelModal">
        <div class="fixed inset-0 z-50 fade-in">
            <div class="fixed inset-0 bg-black/50"></div>
            <div class="fixed inset-0 flex items-center justify-center p-4">
                <div class="bg-white rounded-2xl w-full max-w-3xl h-3/4 shadow-xl overflow-hidden flex flex-col">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-bold">Pilih Hotel</h2>
                        <button wire:click="toggleModal" class="text-red-500 font-semibold">Tutup</button>
                    </div>
                    
                    <!-- Search & Filter -->
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex flex-col md:flex-row md:items-center gap-4">
                            <input type="text" wire:model.live="search" placeholder="Cari hotel..." class="w-full md:w-1/2 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none">
                            <div class="flex flex-wrap gap-2">
                                @if($regencies->count() > 0)
                                    @foreach($regencies as $regency)
                                        <button wire:click="filterByCity('{{ $regency->id }}')" 
                                            class="px-3 py-1 rounded-full border border-gray-300 {{ $selectedCity == $regency->id ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600' }} text-sm">
                                            {{ $regency->name }}
                                        </button>
                                    @endforeach
                                @else
                                    <span class="text-gray-500 text-sm">Tidak ada kota tersedia</span>
                                @endif
                                <button wire:click="resetCity" class="px-3 py-1 rounded-full border border-red-300 bg-red-100 text-red-600 text-sm">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Debug Info - hapus di production -->
                    <div class="px-6 py-2 text-xs text-gray-500 bg-gray-100">
                        Hotels count: {{ $hotels->count() }} | 
                        Regencies count: {{ $regencies->count() }}
                    </div>
                    
                    <!-- List Hotel -->
                    <div class="flex-1 p-6 overflow-y-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($hotels as $hotel)
                                <div wire:click="selectHotel({{ $hotel->id }}, '{{ $hotel->branch_name }}')" 
                                    class="border rounded-xl p-4 flex flex-col cursor-pointer hover:shadow-md transition">
                                    @if($hotel->branch_thumbnail)
                                        <img src="{{ asset('storage/'.$hotel->branch_thumbnail) }}" 
                                            alt="{{ $hotel->branch_name }}" 
                                            class="h-32 w-full object-cover rounded-lg mb-3">
                                    @else
                                        <div class="h-32 w-full bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                                            <span class="text-gray-400">No Image</span>
                                        </div>
                                    @endif
                                    <h3 class="text-lg font-semibold">{{ $hotel->branch_name }}</h3>
                                    <p class="text-sm text-gray-500">
                                        @php
                                            $cityRegency = \App\Models\Regency::find($hotel->branch_city);
                                        @endphp
                                        {{ $cityRegency ? $cityRegency->name : 'Lokasi tidak tersedia' }}
                                    </p>
                                </div>
                            @empty
                                <div class="col-span-2 text-center py-8 text-gray-500">
                                    Tidak ada hotel ditemukan. Coba filter lain atau cari dengan kata kunci berbeda.
                                </div>
                            @endforelse
                        </div>
                        
                        <div class="mt-4">
                            {{ $hotels->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    document.addEventListener('livewire:initialized', function() {
        // Dengarkan event dari komponen Livewire
        Livewire.on('open-modal-portal', (event) => {
            const modalId = event[0].modalId;
            const portalContent = document.querySelector(`[data-modal-id="${modalId}"]`);
            
            if (portalContent) {
                // Kirim konten ke portal dengan custom event
                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: {
                        modalId: modalId,
                        modalContent: portalContent.outerHTML
                    }
                }));
            }
        });
        
        Livewire.on('close-modal-portal', () => {
            window.dispatchEvent(new CustomEvent('close-modal'));
        });
    });
</script> 