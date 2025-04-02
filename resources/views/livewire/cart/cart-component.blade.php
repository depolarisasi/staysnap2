<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="p-6 bg-blue-700 text-white flex justify-between items-center">
        <h2 class="text-xl font-bold">Keranjang Anda</h2>
        @if(count($cartItems) > 0)
            <button wire:click="clearCart" class="text-sm bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded-lg transition">
                Hapus Semua
            </button>
        @endif
    </div>
    
    @if(session()->has('error'))
        <div class="bg-red-100 text-red-700 p-3 my-2">
            {{ session('error') }}
        </div>
    @endif

    @if(session()->has('success'))
        <div class="bg-green-100 text-green-700 p-3 my-2">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="p-6">
        @if(count($cartItems) > 0)
            <div class="divide-y divide-gray-200">
                @foreach($cartItems as $item)
                    <div class="py-4 first:pt-0 last:pb-0">
                        <div class="flex justify-between">
                            <div class="flex-1">
                                <h3 class="font-semibold">{{ $item->room->name }}</h3>
                                <div class="text-sm text-gray-600">
                                    <div>Check-in: {{ \Carbon\Carbon::parse($item->check_in_date)->format('d M Y') }}</div>
                                    <div>Check-out: {{ \Carbon\Carbon::parse($item->check_out_date)->format('d M Y') }}</div>
                                    <div>{{ $item->adult_count }} Dewasa, {{ $item->kids_count }} Anak</div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="font-bold">Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
                                <div class="flex items-center mt-2">
                                    <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})" 
                                        class="bg-gray-200 hover:bg-gray-300 rounded-l-lg px-2 py-1 text-sm">
                                        -
                                    </button>
                                    <span class="bg-gray-100 px-3 py-1 text-sm">{{ $item->quantity }}</span>
                                    <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})" 
                                        class="bg-gray-200 hover:bg-gray-300 rounded-r-lg px-2 py-1 text-sm">
                                        +
                                    </button>
                                    <button wire:click="removeItem({{ $item->id }})" 
                                        class="ml-2 text-red-600 hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Voucher Input -->
            <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                <div class="flex gap-2">
                    <input wire:model="voucherCode" type="text" placeholder="Masukkan kode voucher" 
                        class="flex-1 border rounded-lg px-3 py-2 text-sm">
                    <button wire:click="applyVoucher"
                        class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 text-sm">
                        Terapkan
                    </button>
                </div>
            </div>
            
            <!-- Summary -->
            <div class="mt-6 space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                
                @if($discount > 0)
                <div class="flex justify-between text-green-600">
                    <span>Diskon</span>
                    <span>- Rp {{ number_format($discount, 0, ',', '.') }}</span>
                </div>
                @endif
                
                <div class="flex justify-between font-bold text-lg pt-2 border-t">
                    <span>Total</span>
                    <span>Rp {{ number_format($total - $discount, 0, ',', '.') }}</span>
                </div>
            </div>
            
            <!-- Checkout Button -->
            <div class="mt-6">
                <a href="{{ route('cart.checkout') }}" 
                    class="block w-full bg-yellow-500 hover:bg-yellow-600 text-white text-center rounded-lg py-3 font-semibold">
                    Lanjut ke Pembayaran
                </a>
            </div>
        @else
            <div class="py-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="mt-4 text-lg font-semibold">Keranjang Anda Kosong</h3>
                <p class="mt-2 text-gray-500">Anda belum menambahkan kamar ke keranjang</p>
                <a href="{{ route('frontpage') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-6 py-2">
                    Cari Kamar
                </a>
            </div>
        @endif
    </div>
</div>
