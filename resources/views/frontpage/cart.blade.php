@extends('layouts.frontpage.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Keranjang Anda</h1>
                <p class="mt-2 text-gray-600">Kelola pesanan Anda di sini</p>
            </div>

            @if($cartSummary['item_count'] > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2 space-y-6">
                        @foreach($cartSummary['items'] as $item)
                            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                                <div class="p-6">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <h3 class="text-xl font-semibold text-gray-900">{{ $item->room->name }}</h3>
                                                <span class="text-lg font-bold text-yellow-500">
                                                    Rp {{ number_format($item->total_price, 0, ',', '.') }}
                                                </span>
                                            </div>
                                            
                                            <div class="mt-4 grid grid-cols-2 gap-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">Check-in</p>
                                                    <p class="font-medium">{{ \Carbon\Carbon::parse($item->check_in_date)->format('d M Y') }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">Check-out</p>
                                                    <p class="font-medium">{{ \Carbon\Carbon::parse($item->check_out_date)->format('d M Y') }}</p>
                                                </div>
                                            </div>

                                            <div class="mt-4 flex items-center space-x-6">
                                                <div>
                                                    <p class="text-sm text-gray-500">Jumlah Kamar</p>
                                                    <p class="font-medium">{{ $item->quantity }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">Dewasa</p>
                                                    <p class="font-medium">{{ $item->adult_count }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">Anak</p>
                                                    <p class="font-medium">{{ $item->kids_count }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="ml-6">
                                            <form action="{{ route('cart.remove', ['cartId' => $item->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl shadow-sm p-6 sticky top-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6">Ringkasan Pesanan</h2>
                            
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Total Harga</span>
                                    <span class="font-medium">Rp {{ number_format($cartSummary['total'], 0, ',', '.') }}</span>
                                </div>

                                @if($cartSummary['total_discount'] > 0)
                                    <div class="flex justify-between items-center text-green-600">
                                        <span>Diskon</span>
                                        <span>- Rp {{ number_format($cartSummary['total_discount'], 0, ',', '.') }}</span>
                                    </div>
                                @endif

                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex justify-between items-center">
                                        <span class="font-semibold text-gray-900">Total Akhir</span>
                                        <span class="text-xl font-bold text-yellow-500">
                                            Rp {{ number_format($cartSummary['final_total'], 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            @auth
                                <a href="{{ route('cart.checkout') }}" 
                                   class="block w-full bg-yellow-500 hover:bg-yellow-600 text-white text-center rounded-lg px-6 py-3 font-semibold mt-6 transition-colors">
                                    Lanjut ke Pembayaran
                                </a>
                            @else
                                <div class="mt-6">
                                    <p class="text-sm text-gray-600 mb-4">Silakan login untuk melanjutkan ke pembayaran</p>
                                    <a href="{{ route('login') }}" 
                                       class="block w-full bg-yellow-500 hover:bg-yellow-600 text-white text-center rounded-lg px-6 py-3 font-semibold transition-colors">
                                        Login
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                    <div class="w-24 h-24 mx-auto mb-6 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Keranjang Anda Kosong</h3>
                    <p class="text-gray-600 mb-6">Belum ada item yang ditambahkan ke keranjang</p>
                    <a href="{{ route('frontend.rooms.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 001.414 1.414L10 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414l-3-3z" clip-rule="evenodd" />
                        </svg>
                        Lihat Kamar Tersedia
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
