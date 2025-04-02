<div>
    @if(session()->has('cart-success'))
        <div class="bg-green-100 text-green-700 p-2 rounded-lg mb-2 text-sm">
            {{ session('cart-success') }}
        </div>
    @endif

    @if(session()->has('cart-error'))
        <div class="bg-red-100 text-red-700 p-2 rounded-lg mb-2 text-sm">
            {{ session('cart-error') }}
        </div>
    @endif

    <button 
        wire:click="addToCart"
        wire:loading.attr="disabled"
        class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg py-2 px-4 transition focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 disabled:opacity-50"
    >
        <span wire:loading.remove wire:target="addToCart">Pilih Kamar</span>
        <span wire:loading wire:target="addToCart" class="flex items-center justify-center">
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Menambahkan...
        </span>
    </button>
</div> 