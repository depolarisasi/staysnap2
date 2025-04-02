@extends('layouts.app')

@section('content')
<div class="py-8 px-4 md:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Checkout</h1>
        <p class="text-gray-600">Selesaikan pemesanan Anda</p>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Checkout Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-lg font-bold mb-4">Informasi Kontak</h2>
                
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    
                    <!-- Personal Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" id="name" name="name" required 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="email" name="email" required 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                            <input type="tel" id="phone" name="phone" required 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="identity_number" class="block text-sm font-medium text-gray-700 mb-1">NIK / Nomor KTP</label>
                            <input type="text" id="identity_number" name="identity_number" required 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    
                    <!-- Special Requests -->
                    <div class="mb-6">
                        <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-1">Permintaan Khusus (Opsional)</label>
                        <textarea id="special_requests" name="special_requests" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    
                    <!-- Payment Method -->
                    <div class="mb-6">
                        <h3 class="font-semibold mb-2">Metode Pembayaran</h3>
                        <div class="space-y-2">
                            <div class="flex items-center p-3 border border-gray-200 rounded-lg">
                                <input type="radio" id="payment_transfer" name="payment_method" value="bank_transfer" checked 
                                    class="text-blue-600">
                                <label for="payment_transfer" class="ml-2">
                                    <span class="font-medium">Transfer Bank</span>
                                    <p class="text-sm text-gray-600">Pembayaran melalui transfer bank manual</p>
                                </label>
                            </div>
                            <div class="flex items-center p-3 border border-gray-200 rounded-lg">
                                <input type="radio" id="payment_cc" name="payment_method" value="credit_card" 
                                    class="text-blue-600">
                                <label for="payment_cc" class="ml-2">
                                    <span class="font-medium">Kartu Kredit</span>
                                    <p class="text-sm text-gray-600">Visa, Mastercard, JCB, American Express</p>
                                </label>
                            </div>
                            <div class="flex items-center p-3 border border-gray-200 rounded-lg">
                                <input type="radio" id="payment_va" name="payment_method" value="virtual_account" 
                                    class="text-blue-600">
                                <label for="payment_va" class="ml-2">
                                    <span class="font-medium">Virtual Account</span>
                                    <p class="text-sm text-gray-600">BCA, Mandiri, BNI, BRI</p>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Terms and Conditions -->
                    <div class="mb-6">
                        <div class="flex items-start">
                            <input type="checkbox" id="terms" name="terms" required class="mt-1 text-blue-600">
                            <label for="terms" class="ml-2 text-sm text-gray-600">
                                Saya menyetujui <a href="#" class="text-blue-600">syarat dan ketentuan</a> serta 
                                <a href="#" class="text-blue-600">kebijakan privasi</a> yang berlaku.
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg">
                        Selesaikan Pembayaran
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg p-6 sticky top-4">
                <h2 class="text-lg font-bold mb-4">Ringkasan Pemesanan</h2>
                
                <!-- Items -->
                <div class="mb-4 pb-4 border-b">
                    @php
                        $cartService = app(\App\Services\CartService::class);
                        $items = $cartService->getItems();
                        $total = $cartService->getTotal();
                    @endphp
                    
                    @foreach($items as $item)
                        <div class="mb-3 pb-3 border-b border-gray-100 last:mb-0 last:pb-0 last:border-b-0">
                            <h3 class="font-semibold">{{ $item->room->name }}</h3>
                            <div class="text-sm text-gray-600">
                                <div>Check-in: {{ \Carbon\Carbon::parse($item->check_in_date)->format('d M Y') }}</div>
                                <div>Check-out: {{ \Carbon\Carbon::parse($item->check_out_date)->format('d M Y') }}</div>
                                <div>{{ $item->adult_count }} Dewasa, {{ $item->kids_count }} Anak</div>
                                <div>Jumlah: {{ $item->quantity }} kamar</div>
                            </div>
                            <div class="mt-1 font-medium">Rp {{ number_format($item->total_price, 0, ',', '.') }}</div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Summary -->
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    @php
                        $tax = $total * 0.1; // 10% tax
                        $grandTotal = $total + $tax;
                    @endphp
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Pajak (10%)</span>
                        <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="flex justify-between font-bold text-lg pt-2 border-t">
                        <span>Total</span>
                        <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 