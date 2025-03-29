<div wire:key="guest-modal-{{ $adultCount }}-{{ $kidsCount }}">
    <!-- Button to open modal -->
    <button wire:click="toggleModal" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-left focus:outline-none hover:bg-gray-100 transition duration-200">
        <span class="block text-xs text-gray-500 uppercase tracking-wider">Guests</span>
        <span class="block mt-1 text-lg font-semibold">
            {{ $adultCount }} Adult, {{ $kidsCount }} Kids
        </span>
    </button>

    <!-- Modal Content - Akan ditampilkan melalui portal -->
    @if($showModal)
    <div id="portalModal" class="portal-content" data-modal-id="guestModal">
        <div class="fixed inset-0 z-50 fade-in">
            <div class="fixed inset-0 bg-black/50"></div>
            <div class="fixed inset-0 flex items-center justify-center p-4">
                <div class="bg-white rounded-2xl w-full max-w-sm shadow-xl overflow-hidden">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-bold">Jumlah Tamu</h2>
                        <button wire:click="toggleModal" class="text-red-500 font-semibold">Tutup</button>
                    </div>
                    <div class="px-6 py-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-lg font-medium">Adults</span>
                            <div class="flex items-center gap-3">
                                <button wire:click="decreaseAdult" class="bg-gray-200 text-xl w-8 h-8 flex items-center justify-center rounded-full">–</button>
                                <span class="text-lg font-semibold">{{ $adultCount }}</span>
                                <button wire:click="increaseAdult" class="bg-gray-200 text-xl w-8 h-8 flex items-center justify-center rounded-full">+</button>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-lg font-medium">Kids</span>
                            <div class="flex items-center gap-3">
                                <button wire:click="decreaseKids" class="bg-gray-200 text-xl w-8 h-8 flex items-center justify-center rounded-full">–</button>
                                <span class="text-lg font-semibold">{{ $kidsCount }}</span>
                                <button wire:click="increaseKids" class="bg-gray-200 text-xl w-8 h-8 flex items-center justify-center rounded-full">+</button>
                            </div>
                        </div>
                        <button wire:click="saveGuests" class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-3 font-bold transition">OK</button>
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
            if (modalId === 'guestModal') {
                const portalContent = document.querySelector(`[data-modal-id="${modalId}"]`);
                if (portalContent) {
                    window.dispatchEvent(new CustomEvent('open-modal', {
                        detail: {
                            modalId: modalId,
                            modalContent: portalContent.outerHTML
                        }
                    }));
                }
            }
        });
    });
</script> 