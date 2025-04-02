@extends('layouts.app')

@section('content')
<div class="py-8 px-4 md:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Keranjang Belanja</h1>
        <p class="text-gray-600">Review pesanan Anda sebelum melanjutkan ke pembayaran</p>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Cart Items List -->
        <div class="lg:col-span-2">
            @livewire('cart.cart-component')
        </div>
        
        <!-- Order Summary Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg p-6 sticky top-4">
                <h2 class="text-lg font-bold mb-4">Ringkasan Pesanan</h2>
                
                <!-- Hotel Info -->
                <div class="mb-4 pb-4 border-b">
                    <h3 class="font-semibold">Informasi Hotel</h3>
                    <p class="text-sm text-gray-600 mt-2">
                        Untuk informasi lebih lanjut tentang hotel dan fasilitas, silahkan hubungi customer service kami.
                    </p>
                </div>
                
                <!-- Payment Methods -->
                <div class="mb-4 pb-4 border-b">
                    <h3 class="font-semibold">Metode Pembayaran</h3>
                    <div class="mt-2 space-y-2">
                        <div class="flex items-center space-x-2">
                            <input type="radio" id="payment_transfer" name="payment_method" checked class="text-blue-600">
                            <label for="payment_transfer" class="text-sm">Transfer Bank</label>
                        </div>
                        <div class="flex items-center space-x-2">
                            <input type="radio" id="payment_cc" name="payment_method" class="text-blue-600">
                            <label for="payment_cc" class="text-sm">Kartu Kredit</label>
                        </div>
                        <div class="flex items-center space-x-2">
                            <input type="radio" id="payment_va" name="payment_method" class="text-blue-600">
                            <label for="payment_va" class="text-sm">Virtual Account</label>
                        </div>
                    </div>
                </div>
                
                <!-- Customer Support -->
                <div>
                    <h3 class="font-semibold">Butuh Bantuan?</h3>
                    <p class="text-sm text-gray-600 mt-2">
                        Hubungi customer service kami di:
                        <a href="tel:+6281234567890" class="text-blue-600">+62 812-3456-7890</a> atau
                        <a href="mailto:cs@staysnap.com" class="text-blue-600">cs@staysnap.com</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 