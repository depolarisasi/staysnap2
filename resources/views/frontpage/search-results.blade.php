@extends('layouts.frontpage.app')
@section('title', 'Search Results')

@section('styles')
<style>
    /* Styling untuk gallery */
    .gallery-container {
        position: relative;
        overflow: hidden;
        border-radius: 0.5rem;
    }
    
    .gallery-main {
        height: 400px;
        width: 100%;
        object-fit: cover;
    }
    
    .gallery-thumbnails {
        display: flex;
        overflow-x: auto;
        gap: 0.5rem;
        padding: 0.5rem;
        background: #f8f9fa;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .gallery-thumbnails::-webkit-scrollbar {
        height: 6px;
    }
    
    .gallery-thumbnails::-webkit-scrollbar-thumb {
        background-color: rgba(156, 163, 175, 0.5);
        border-radius: 3px;
    }
    
    .gallery-thumbnail {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: all 0.2s;
        border: 2px solid transparent;
    }
    
    .gallery-thumbnail.active {
        border-color: #3b82f6;
    }
    
    /* Styling tambahan untuk informasi hotel */
    .hotel-info-icon {
        display: inline-flex;
        align-items: center;
        margin-right: 1.5rem;
    }
    
    .hotel-info-icon svg {
        width: 1.25rem;
        height: 1.25rem;
        margin-right: 0.5rem;
        color: #4b5563;
    }

    /* Carousel styling */
    .carousel-container {
        position: relative;
        height: 400px;
        overflow: hidden;
    }

    .carousel-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }

    .carousel-slide.active {
        opacity: 1;
    }
    
    /* Modern Room Styling */
    .room-card {
        transition: all 0.3s ease;
    }
    
    .room-card:hover {
        transform: translateY(-2px);
    }
    
    /* Filter Buttons */
    .filter-button {
        transition: all 0.2s ease;
    }
    
    .filter-button.active {
        background-color: #ebf5ff;
        border-color: #3b82f6;
        color: #2563eb;
    }
    
    /* Responsive fixes */
    @media (max-width: 768px) {
        .gallery-main {
            height: 300px;
        }
        
        .room-card {
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 1rem;
        }
    }
    
    /* Search Form Container */
    .search-form-container {
        background-color: white;
        margin-top: -2rem;
        position: relative;
        z-index: 10;
    }
    
    /* Beautiful Cart Styling */
    .cart-sidebar {
        transition: all 0.3s ease;
    }
    
    .cart-item {
        border-bottom: 1px solid #f3f4f6;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }
    
    .cart-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }
    
    /* Animated elements */
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: .5;
        }
    }
</style>
@endsection

@section('content')
    <!-- Hotel Info Cards --> 
     <div class="py-4 max-w-7xl mx-auto overflow-hidden">
                 <!-- Hotel Information -->
                 <div class="p-4">
                    <h1 class="text-3xl font-bold">{{ $hotel->branch_name }}</h1> 
                    <div class="mt-4">
                        <span class="hotel-info-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                            {{ $hotel->regency->regency }}, {{ $hotel->province->province }}
                        </span>
                        <span class="hotel-info-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            {{ $hotel->branch_address ?: 'Alamat tidak tersedia' }}
                        </span>
                        @if($hotel->branch_phone)
                        <span class="hotel-info-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                            {{ $hotel->branch_phone }}
                        </span>
                        @endif
                       
                    </div>
                    
                </div>
                <!-- Gallery Container -->
                <div class="gallery-container">
                    <!-- Main Image Carousel -->
                    <div class="carousel-container">
                        @foreach($hotel->photos as $index => $photo)
                            <div class="carousel-slide {{ $index === 0 ? 'active' : '' }}" id="slide-{{ $index }}">
                                <img src="{{ asset('storage/' . $photo->path) }}" alt="Hotel Photo" class="gallery-main">
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Thumbnails -->
                    <div class="gallery-thumbnails">
                        @foreach($hotel->photos as $index => $photo)
                            <img 
                                src="{{ asset('storage/' . $photo->path) }}" 
                                alt="Thumbnail {{ $index + 1 }}" 
                                class="gallery-thumbnail {{ $index === 0 ? 'active' : '' }}" 
                                onclick="changeSlide({{ $index }})"
                            >
                        @endforeach
                    </div>
                </div>

            </div>  

    <!-- Search Form -->
    @include('partials.search-form')

    <!-- Room Results -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Room List -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-lg overflow-hidden shadow-sm border border-gray-100">
                    <!-- Filter Section -->
                    <div class="flex flex-wrap justify-between items-center p-4 border-b border-gray-100">
                        <div class="mb-2 md:mb-0">
                            <span class="text-sm font-medium text-gray-700">Filter Kamar:</span>
                            <div class="inline-flex space-x-2 ml-2">
                                <button onclick="filterRooms('breakfast')" class="px-3 py-1 border border-gray-200 rounded-full text-xs font-medium text-gray-700 hover:bg-blue-50 hover:border-blue-200 transition-all">
                                    Include Breakfast
                                </button>
                                <button onclick="filterRooms('no-breakfast')" class="px-3 py-1 border border-gray-200 rounded-full text-xs font-medium text-gray-700 hover:bg-blue-50 hover:border-blue-200 transition-all">
                                    Without Breakfast
                                </button>
                            </div>
                        </div>
                        <div>
                            <span class="text-xs font-medium text-gray-600">Tampilan Harga:</span>
                            <a href="#" class="text-blue-600 text-xs ml-1 hover:underline">Total (termasuk pajak & biaya)</a>
                        </div>
                    </div>

                    <!-- Room Cards -->
                    <div class="divide-y divide-gray-100">
                        @foreach($rooms as $room)
                            <div class="room-card hover:bg-gray-50 transition-colors duration-200">
                                <div class="p-5">
                                    <!-- Room Header -->
                                    <div class="flex justify-between items-start mb-4">
                                        <h2 class="text-lg font-bold text-gray-800">{{ $room->name }}</h2>
                                        @if($room->availability->is_available)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Tersedia
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Tidak Tersedia
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Room Content -->
                                    <div class="flex flex-col md:flex-row">
                                        <!-- Room Image -->
                                        <div class="w-full md:w-1/3 flex-shrink-0 mb-4 md:mb-0">
                                            <div class="relative aspect-[4/3] rounded-lg overflow-hidden">
                                                <img 
                                                    src="{{ asset('storage/' . $room->photos->first()->path) }}" 
                                                    alt="{{ $room->name }}" 
                                                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 hover:scale-110"
                                                    onerror="this.src='/images/default-room.jpg'"
                                                >
                                            </div>
                                        </div>
                                        
                                        <!-- Room Details -->
                                        <div class="w-full md:w-2/3 md:pl-5">
                                            <!-- Room Features -->
                                            <div class="mb-3">
                                                <h3 class="text-sm font-medium text-gray-700 mb-2">Fasilitas Kamar</h3>
                                                <div class="grid grid-cols-2 gap-2">
                                                    @foreach($room->amenities->take(6) as $amenity)
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 text-green-500 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                            <span class="text-xs text-gray-600">{{ $amenity->name }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                
                                                @if($room->amenities->count() > 6)
                                                    <button 
                                                        onclick="showRoomAmenities({{ $room->id }})" 
                                                        class="text-blue-600 text-xs mt-2 hover:underline flex items-center"
                                                    >
                                                        <span>Lihat Semua Fasilitas</span>
                                                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                            
                                            <!-- Room Policies -->
                                            <div>
                                                <button 
                                                    onclick="showRoomPolicy({{ $room->id }})" 
                                                    class="text-blue-600 text-xs hover:underline flex items-center"
                                                >
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span>Lihat Kebijakan Kamar</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Room Footer with Price - Modified layout to match the sample -->
                                    <div class="mt-5 pt-4 border-t border-gray-100 flex flex-col md:flex-row md:justify-between md:items-start">
                                        <!-- Plan and Policy Details -->
                                        <div class="md:w-1/2">
                                            <h4 class="text-base font-semibold text-blue-800 mb-2">Early Bird</h4>
                                            <div class="space-y-1 mb-3">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 text-blue-500 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <span class="text-xs text-gray-600">{{ $room->is_refundable ? 'Refundable' : 'Non-refundable' }}</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 text-blue-500 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <span class="text-xs text-gray-600">{{ $room->is_reschedule ? 'Reschedulable' : 'Non-reschedulable' }}</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 text-blue-500 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <span class="text-xs text-gray-600">{{ $room->with_breakfast ? 'With Breakfast' : 'Without Breakfast' }}</span>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <h5 class="text-sm font-medium text-gray-700">Payment Option</h5>
                                                <div class="flex items-center mt-1">
                                                    <svg class="w-4 h-4 text-blue-500 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <span class="text-xs text-gray-600">Pay now</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Price and Booking Button -->
                                        <div class="md:w-1/2 mt-4 md:mt-0 flex flex-col items-end">
                                            <div class="text-right">
                                                <div class="text-xs text-gray-500 mb-1">Total Price For {{ \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) }} night</div>
                                                <div class="text-2xl font-bold text-gray-800 mb-1">Rp {{ number_format($room->availability->total_price, 0, ',', '.') }}</div>
                                                <div class="text-xs text-gray-500 mb-3">Includes Taxes & Fees</div>
                                            </div>
                                            
                                            <!-- Book Button -->
                                            @if($room->availability->is_available)
                                                <button 
                                                    onclick="addToCart({{ $room->id }})" 
                                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium text-sm transition-colors flex items-center"
                                                >
                                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z"></path>
                                                        <path d="M16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                                                    </svg>
                                                    <span>Pilih Kamar</span>
                                                </button>
                                            @else
                                                <button 
                                                    class="bg-gray-200 text-gray-500 px-6 py-2.5 rounded-lg font-medium text-sm cursor-not-allowed" 
                                                    disabled
                                                >
                                                    Tidak Tersedia
                                                </button>
                                            @endif
                                            @if($room->availability->is_available)
                                                <div class="text-xs text-gray-500 mt-1">
                                                    {{ $room->availability->available_rooms }} kamar tersedia
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- No Rooms Found -->
                    @if(count($rooms) === 0)
                        <div class="p-10 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-700">Tidak ada kamar tersedia</h3>
                            <p class="text-gray-500 text-sm mt-1">Silakan coba tanggal atau filter lain</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Cart Sidebar -->
            <div class="lg:col-span-4">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-bold mb-4">Rooms</h2>
                    
                    <!-- Date and Guest Info -->
                    <div class="bg-gray-100 rounded-lg p-3 mb-4 flex items-center">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ \Carbon\Carbon::parse($startDate)->format('d M') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M, Y') }}
                        </span>
                        <span class="ml-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ $adults ?? 1 }} Adult(s)
                        </span>
                    </div>
                    
                    <!-- Room Details Section -->
                    <div id="cartItems" class="space-y-4">
                        @if(session('cart'))
                            @foreach(session('cart') as $id => $details)
                                <div class="pb-4 border-b border-gray-200 relative">
                                    <!-- Room Name -->
                                    <div class="pr-8">
                                        <h3 class="font-bold text-gray-800">{{ $details['room_name'] }}</h3>
                                    </div>
                                    
                                    <!-- Room details -->
                                    <p class="text-sm text-gray-600 mt-1 mb-1">{{ $details['quantity'] }} Room x {{ \Carbon\Carbon::parse($details['check_in_date'])->diffInDays(\Carbon\Carbon::parse($details['check_out_date'])) }} night</p>
                                    
                                    <!-- Price -->
                                    <p class="font-bold text-gray-800">IDR {{ number_format($details['price'], 0, ',', '.') }}</p>
                                    
                                    <!-- Trash icon for removing item -->
                                    <div class="absolute top-0 right-0">
                                        <button onclick="removeCartItem('{{ $id }}')" class="text-red-500 hover:text-red-700 p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-6 bg-gray-50 rounded-lg">
                                <p class="text-gray-500">Keranjang Anda kosong</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Total Section -->
                    <div class="mt-6">
                        <div class="flex justify-between items-center font-bold text-lg mb-2">
                            <span>Total</span>
                            <span class="text-gray-800" id="cartTotalDisplay">IDR {{ number_format(session('cart_total', 0), 0, ',', '.') }}</span>
                        </div>
                        <p class="text-right text-sm text-gray-600 mb-4">Includes Taxes & Fees</p>
                        
                        <!-- Reward Information -->
                        @if(session('cart_total', 0) > 0)
                            <div class="bg-blue-50 p-3 rounded-lg mb-4">
                                <p class="text-blue-600 text-sm text-center">You will earn {{ number_format(session('cart_total', 0)/100, 0, ',', '.') }} Sahid Coin</p>
                                <p class="text-blue-600 text-sm text-center">You will earn {{ number_format(session('cart_total', 0), 0, ',', '.') }} Sahid Reward</p>
                            </div>
                        @endif
                        
                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('cart.index') }}" class="border border-gray-300 text-gray-700 rounded-lg px-4 py-2 font-medium text-center hover:bg-gray-50 transition">
                                View Cart
                            </a>
                            
                            @if(session('cart'))
                                <a href="{{ route('cart.checkout') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg px-4 py-2 font-medium text-center transition">
                                    Book Now
                            </a>
                        @else
                                <button disabled class="bg-gray-300 text-gray-500 rounded-lg px-4 py-2 font-medium cursor-not-allowed">
                                    Book Now
                        </button>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Room Policy Modal -->
    <div id="policyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white w-11/12 md:w-2/3 rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Room Policy</h2>
                <button onclick="closePolicyModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="policyContent" class="space-y-4">
                <!-- Policy content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Room Amenities Modal -->
    <div id="amenitiesModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white w-11/12 md:w-2/3 rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Room Amenities</h2>
                <button onclick="closeAmenitiesModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="amenitiesContent" class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <!-- Amenities content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Search Form Modals -->
    @include('partials.search-modals')

    <!-- Skeleton Loading Template (hidden by default) -->
    <div id="roomSkeleton" class="hidden">
        <div class="animate-pulse space-y-6">
            <!-- Skeleton Room Card 1 -->
            <div class="bg-white rounded-lg overflow-hidden border border-gray-100">
                <div class="p-5">
                    <!-- Skeleton Header -->
                    <div class="flex justify-between items-start mb-4">
                        <div class="h-6 bg-gray-200 rounded w-1/3"></div>
                        <div class="h-5 bg-gray-200 rounded-full w-16"></div>
                    </div>
                    
                    <!-- Skeleton Content -->
                    <div class="flex flex-col md:flex-row">
                        <!-- Skeleton Image -->
                        <div class="w-full md:w-1/3 flex-shrink-0 mb-4 md:mb-0">
                            <div class="relative aspect-[4/3] rounded-lg bg-gray-200"></div>
                        </div>
                        
                        <!-- Skeleton Details -->
                        <div class="w-full md:w-2/3 md:pl-5">
                            <div class="h-5 bg-gray-200 rounded w-1/4 mb-3"></div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                            </div>
                            <div class="h-4 bg-gray-200 rounded w-32 mt-3"></div>
                        </div>
                    </div>
                    
                    <!-- Skeleton Footer -->
                    <div class="mt-5 pt-4 border-t border-gray-100 flex flex-col md:flex-row md:justify-between md:items-center">
                        <div class="mb-3 md:mb-0">
                            <div class="h-4 bg-gray-200 rounded w-40 mb-2"></div>
                            <div class="h-6 bg-gray-200 rounded w-28"></div>
                            <div class="h-3 bg-gray-200 rounded w-32 mt-1"></div>
                        </div>
                        <div class="md:text-right">
                            <div class="h-10 bg-gray-200 rounded w-full md:w-32"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Skeleton Room Card 2 -->
            <div class="bg-white rounded-lg overflow-hidden border border-gray-100">
                <div class="p-5">
                    <!-- Same structure as above -->
                    <div class="flex justify-between items-start mb-4">
                        <div class="h-6 bg-gray-200 rounded w-2/5"></div>
                        <div class="h-5 bg-gray-200 rounded-full w-16"></div>
                    </div>
                    
                    <div class="flex flex-col md:flex-row">
                        <div class="w-full md:w-1/3 flex-shrink-0 mb-4 md:mb-0">
                            <div class="relative aspect-[4/3] rounded-lg bg-gray-200"></div>
                        </div>
                        
                        <div class="w-full md:w-2/3 md:pl-5">
                            <div class="h-5 bg-gray-200 rounded w-1/4 mb-3"></div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                            </div>
                            <div class="h-4 bg-gray-200 rounded w-32 mt-3"></div>
                        </div>
                    </div>
                    
                    <div class="mt-5 pt-4 border-t border-gray-100 flex flex-col md:flex-row md:justify-between md:items-center">
                        <div class="mb-3 md:mb-0">
                            <div class="h-4 bg-gray-200 rounded w-40 mb-2"></div>
                            <div class="h-6 bg-gray-200 rounded w-28"></div>
                            <div class="h-3 bg-gray-200 rounded w-32 mt-1"></div>
                        </div>
                        <div class="md:text-right">
                            <div class="h-10 bg-gray-200 rounded w-full md:w-32"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const thumbnails = document.querySelectorAll('.gallery-thumbnail');

        function updateActiveThumbnail(index) {
            thumbnails.forEach((thumb, i) => {
                thumb.classList.toggle('active', i === index);
            });
        }

        function nextSlide() {
            // Remove active class from current slide
            slides[currentSlide].classList.remove('active');
            
            // Update current slide index
            currentSlide = (currentSlide + 1) % slides.length;
            
            // Add active class to new slide
            slides[currentSlide].classList.add('active');
            
            // Update thumbnail
            updateActiveThumbnail(currentSlide);
        }

        setInterval(nextSlide, 10000);

        // Memastikan cart badge dan sidebar selalu konsisten
        updateCartBadge();
        setTimeout(updateCartSidebar, 100);
        
        // Tambahkan event listener untuk tombol form pencarian
        document.getElementById('openHotelModal').addEventListener('click', openHotelModal);
        document.getElementById('openDateModal').addEventListener('click', openDateModal);
        document.getElementById('openGuestModal').addEventListener('click', openGuestModal);
        
        // Initialize date inputs with current values
        const checkInDate = document.getElementById('checkInDate');
        const checkOutDate = document.getElementById('checkOutDate');
        
        if (checkInDate && checkOutDate) {
            checkInDate.value = '{{ $startDate }}';
            checkOutDate.value = '{{ $endDate }}';
        }
        
        // Tambahkan ini: Tampilkan notifikasi jika ada flash message
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'Lanjut Belanja',
                showCancelButton: true,
                cancelButtonText: 'Lihat Keranjang',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (!result.isConfirmed) {
                    window.location.href = '{{ route("cart.index") }}';
                }
            });
        @endif
        
        @if(session('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    });

    function changeSlide(index) {
        const slides = document.querySelectorAll('.carousel-slide');
        const thumbnails = document.querySelectorAll('.gallery-thumbnail');
        
        // Remove active class from current slide
        slides.forEach(slide => slide.classList.remove('active'));
        
        // Add active class to selected slide
        slides[index].classList.add('active');
        
        // Update thumbnails
        thumbnails.forEach((thumb, i) => {
            thumb.classList.toggle('active', i === index);
        });
    }

    // Filter functionality
    function filterRooms(type) {
        // Tampilkan loading skeleton
        showRoomLoadingSkeleton();
        
        // Simulasi delay loading untuk efek UX yang lebih baik
        setTimeout(() => {
            // Logika filter akan diimplementasikan di sini
            // Untuk sementara, sembunyikan skeleton setelah delay
            hideRoomLoadingSkeleton();
        }, 800);
    }
    
    // Skeleton Loading Functions
    function showRoomLoadingSkeleton() {
        // Simpan konten asli room list
        const roomListContainer = document.querySelector('.divide-y.divide-gray-100');
        if (roomListContainer) {
            // Sembunyikan konten asli
            roomListContainer.style.opacity = '0';
            roomListContainer.style.height = '0';
            roomListContainer.style.overflow = 'hidden';
            
            // Tampilkan skeleton
            const skeleton = document.getElementById('roomSkeleton');
            if (skeleton) {
                skeleton.classList.remove('hidden');
            }
        }
    }
    
    function hideRoomLoadingSkeleton() {
        // Tampilkan kembali konten asli room list
        const roomListContainer = document.querySelector('.divide-y.divide-gray-100');
        if (roomListContainer) {
            roomListContainer.style.opacity = '1';
            roomListContainer.style.height = 'auto';
            roomListContainer.style.overflow = 'visible';
            
            // Sembunyikan skeleton
            const skeleton = document.getElementById('roomSkeleton');
            if (skeleton) {
                skeleton.classList.add('hidden');
            }
        }
    }
    
    // Load event untuk button-button filter
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi tampilan
        hideRoomLoadingSkeleton();
        
        // Tambahkan event listener untuk button-button filter
        const filterButtons = document.querySelectorAll('button[onclick^="filterRooms"]');
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Toggle kelas active
                filterButtons.forEach(btn => btn.classList.remove('filter-button', 'active'));
                this.classList.add('filter-button', 'active');
            });
        });
    });

    // Cart functionality
    let cart = [];

    function addToCart(roomId) {
        // Show loading skeleton before adding to cart
        showRoomLoadingSkeleton();
        
        // Ambil data dari form pencarian
        const startDate = '{{ $startDate }}';
        const endDate = '{{ $endDate }}';
        const adultCount = '{{ $adults ?? 1 }}';
        const kidsCount = '{{ $kids ?? 0 }}';

        // Tampilkan loading
        Swal.fire({
            title: 'Menambahkan ke keranjang...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Siapkan FormData untuk dikirim
        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('room_id', roomId);
        formData.append('check_in_date', startDate);
        formData.append('check_out_date', endDate);
        formData.append('adult_count', adultCount);
        formData.append('kids_count', kidsCount);
        formData.append('quantity', 1);

        // Kirim permintaan menggunakan fetch API
        fetch('{{ route("cart.addToCart") }}', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errData => {
                    throw new Error(JSON.stringify(errData));
                });
            }
            return response.json();
        })
        .then(data => {
            // Hide skeleton after response
            hideRoomLoadingSkeleton();
            
            if (data.success) {
                // Update UI
                updateCartBadge();
                updateCartSidebar();
                
                // Tampilkan notifikasi sukses yang otomatis menutup
                Swal.fire({
                    title: 'Berhasil!',
                    text: data.message || 'Kamar berhasil ditambahkan ke keranjang',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                // Tampilkan error
                Swal.fire({
                    title: 'Gagal!',
                    text: data.message || 'Terjadi kesalahan saat menambahkan kamar ke keranjang',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            // Hide skeleton on error
            hideRoomLoadingSkeleton();
            
            console.error('Error adding to cart:', error);
            let errorMessage = 'Terjadi kesalahan pada sistem. Silakan coba lagi.';
            
            try {
                const errorData = JSON.parse(error.message);
                if (errorData.errors) {
                    errorMessage = Object.values(errorData.errors).flat().join('<br>');
                } else if (errorData.message) {
                    errorMessage = errorData.message;
                }
            } catch (e) {
                errorMessage = error.message;
            }
            
            Swal.fire({
                title: 'Gagal!',
                html: errorMessage,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }

    function updateCartBadge() {
        // Ambil jumlah item terbaru dari server
        fetch('{{ route("cart.index") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            const badge = document.querySelector('#cartBadge');
            if (badge) {
                if (data.data && data.data.item_count !== undefined) {
                    // Menggunakan data.data.item_count jika tersedia
                    badge.textContent = data.data.item_count;
                    badge.style.display = data.data.item_count > 0 ? 'flex' : 'none';
                } else if (data.item_count !== undefined) {
                    // Menggunakan data.item_count sebagai fallback
                badge.textContent = data.item_count;
                badge.style.display = data.item_count > 0 ? 'flex' : 'none';
            }
            }
        })
        .catch(error => {
            console.error('Error updating cart badge:', error);
        });
    }

    // Tambahkan fungsi untuk update cart sidebar
    function updateCartSidebar() {
        fetch('{{ route("cart.index") }}', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            const cartItems = document.getElementById('cartItems');
            
            if (data.data && data.data.items && data.data.items.length > 0) {
                let itemsHtml = '';
                data.data.items.forEach(item => {
                    // Hitung durasi malam jika item.duration tidak tersedia
                    let duration = item.duration;
                    if (!duration && item.check_in_date && item.check_out_date) {
                        const checkIn = new Date(item.check_in_date);
                        const checkOut = new Date(item.check_out_date);
                        const timeDiff = Math.abs(checkOut - checkIn);
                        duration = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
                    }
                    
                    itemsHtml += `
                    <div class="pb-4 border-b border-gray-200 relative">
                        <!-- Room Name -->
                        <div class="pr-8">
                            <h3 class="font-bold text-gray-800">${item.room.name}</h3>
                        </div>
                        
                        <!-- Room details -->
                        <p class="text-sm text-gray-600 mt-1 mb-1">${item.quantity} Room x ${duration || 1} night</p>
                        
                        <!-- Price -->
                        <p class="font-bold text-gray-800">IDR ${new Intl.NumberFormat('id-ID').format(item.total_price)}</p>
                        
                        <!-- Trash icon for removing item -->
                        <div class="absolute top-0 right-0">
                            <button onclick="removeCartItem('${item.id}')" class="text-red-500 hover:text-red-700 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>`;
                });
                
                cartItems.innerHTML = itemsHtml;
                
                // Update total
                const cartTotalDisplay = document.getElementById('cartTotalDisplay');
                if (cartTotalDisplay) {
                    cartTotalDisplay.textContent = `IDR ${new Intl.NumberFormat('id-ID').format(data.data.final_total)}`;
                }
                
                // Update reward section
                const rewardSection = document.querySelector('.bg-blue-50');
                if (rewardSection) {
                    rewardSection.innerHTML = `
                        <p class="text-blue-600 text-sm text-center">You will earn ${new Intl.NumberFormat('id-ID').format(data.data.final_total/100)} Sahid Coin</p>
                        <p class="text-blue-600 text-sm text-center">You will earn ${new Intl.NumberFormat('id-ID').format(data.data.final_total)} Sahid Reward</p>
                    `;
                }
                
                // Update action buttons
                const actionButtons = document.querySelector('.grid.grid-cols-2.gap-3');
                if (actionButtons) {
                    actionButtons.innerHTML = `
                        <a href="{{ route('cart.index') }}" class="border border-gray-300 text-gray-700 rounded-lg px-4 py-2 font-medium text-center hover:bg-gray-50 transition">
                            View Cart
                        </a>
                        <a href="{{ route('cart.checkout') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg px-4 py-2 font-medium text-center transition">
                            Book Now
                    </a>
                `;
                }
                
                // Update badge saat sidebar diperbarui jika ada item
                const badge = document.querySelector('#cartBadge');
                if (badge) {
                    badge.textContent = data.data.item_count;
                    badge.style.display = data.data.item_count > 0 ? 'flex' : 'none';
                }
            } else {
                cartItems.innerHTML = '<p class="text-gray-500 text-center py-4">Keranjang Anda kosong</p>';
                
                // Update total to zero
                const cartTotalDisplay = document.getElementById('cartTotalDisplay');
                if (cartTotalDisplay) {
                    cartTotalDisplay.textContent = 'IDR 0';
                }
                
                // Hide reward section
                const rewardSection = document.querySelector('.bg-blue-50');
                if (rewardSection) {
                    rewardSection.style.display = 'none';
                }
                
                // Update action buttons
                const actionButtons = document.querySelector('.grid.grid-cols-2.gap-3');
                if (actionButtons) {
                    actionButtons.innerHTML = `
                        <a href="{{ route('cart.index') }}" class="border border-gray-300 text-gray-700 rounded-lg px-4 py-2 font-medium text-center hover:bg-gray-50 transition">
                            View Cart
                        </a>
                        <button disabled class="bg-gray-300 text-gray-500 rounded-lg px-4 py-2 font-medium cursor-not-allowed">
                            Book Now
                    </button>
                `;
                }
            }
        })
        .catch(error => {
            console.error('Error updating cart sidebar:', error);
        });
    }

    // Tambahkan fungsi untuk menghapus item dari keranjang
    function removeCartItem(itemId) {
        fetch(`{{ url('/cart') }}/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Item berhasil dihapus dari keranjang',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                updateCartBadge();
                updateCartSidebar();
            }
        })
        .catch(error => {
            console.error('Error removing item:', error);
        });
    }

    // Room Policy Modal
    function showRoomPolicy(roomId) {
        const room = @json($rooms).find(r => r.id === roomId);
        if (room && room.policies) {
            const policyContent = document.getElementById('policyContent');
            policyContent.innerHTML = room.policies.map(policy => `
                <div class="border-b pb-4">
                    <h3 class="font-semibold">${policy.name}</h3>
                    <p class="text-gray-600 mt-1">${policy.description}</p>
                </div>
            `).join('');
            
            document.getElementById('policyModal').classList.remove('hidden');
            document.getElementById('policyModal').classList.add('flex');
        }
    }

    function closePolicyModal() {
        document.getElementById('policyModal').classList.add('hidden');
        document.getElementById('policyModal').classList.remove('flex');
    }

    // Room Amenities Modal
    function showRoomAmenities(roomId) {
        const room = @json($rooms).find(r => r.id === roomId);
        if (room && room.amenities) {
            const amenitiesContent = document.getElementById('amenitiesContent');
            amenitiesContent.innerHTML = room.amenities.map(amenity => `
                <div class="p-3 border rounded-lg">
                    <h3 class="font-semibold">${amenity.name}</h3>
                    <p class="text-gray-600 text-sm mt-1">${amenity.description || ''}</p>
                </div>
            `).join('');
            
            document.getElementById('amenitiesModal').classList.remove('hidden');
            document.getElementById('amenitiesModal').classList.add('flex');
        }
    }

    function closeAmenitiesModal() {
        document.getElementById('amenitiesModal').classList.add('hidden');
        document.getElementById('amenitiesModal').classList.remove('flex');
    }

    // Hotel Selection Functions
    function openHotelModal() {
        document.getElementById('hotelModal').classList.remove('hidden');
        document.getElementById('hotelModal').classList.add('flex');
    }

    function closeHotelModal() {
        document.getElementById('hotelModal').classList.add('hidden');
        document.getElementById('hotelModal').classList.remove('flex');
    }

    function selectHotel(hotelId, hotelName) {
        document.getElementById('selectedHotelText').textContent = hotelName;
        closeHotelModal();
        // Redirect to search results with new hotel
        window.location.href = `{{ route('search.rooms') }}?hotel_id=${hotelId}&start_date={{ $startDate }}&end_date={{ $endDate }}&adults={{ $adults ?? 1 }}&kids={{ $kids ?? 0 }}`;
    }

    // Date Selection Functions
    function openDateModal() {
        document.getElementById('dateModal').classList.remove('hidden');
        document.getElementById('dateModal').classList.add('flex');
    }

    function closeDateModal() {
        document.getElementById('dateModal').classList.add('hidden');
        document.getElementById('dateModal').classList.remove('flex');
    }

    function applyDateSelection() {
        const checkInDate = document.getElementById('checkInDate').value;
        const checkOutDate = document.getElementById('checkOutDate').value;
        
        if (!checkInDate || !checkOutDate) {
            Swal.fire({
                title: 'Error!',
                text: 'Silakan pilih tanggal check-in dan check-out',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        if (new Date(checkInDate) >= new Date(checkOutDate)) {
            Swal.fire({
                title: 'Error!',
                text: 'Tanggal check-out harus setelah tanggal check-in',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        document.getElementById('selectedDateText').textContent = 
            `${new Date(checkInDate).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })} - ` +
            `${new Date(checkOutDate).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}`;
        
        closeDateModal();
        // Redirect to search results with new dates
        window.location.href = `{{ route('search.rooms') }}?hotel_id={{ $hotel->id }}&start_date=${checkInDate}&end_date=${checkOutDate}&adults={{ $adults ?? 1 }}&kids={{ $kids ?? 0 }}`;
    }

    // Guest Selection Functions
    function openGuestModal() {
        document.getElementById('guestModal').classList.remove('hidden');
        document.getElementById('guestModal').classList.add('flex');
    }

    function closeGuestModal() {
        document.getElementById('guestModal').classList.add('hidden');
        document.getElementById('guestModal').classList.remove('flex');
    }

    function updateGuestCount(type, change) {
        const countElement = document.getElementById(type === 'adults' ? 'adultCount' : 'kidCount');
        let currentCount = parseInt(countElement.textContent);
        
        if (type === 'adults' && currentCount + change < 1) return;
        if (type === 'kids' && currentCount + change < 0) return;
        
        countElement.textContent = currentCount + change;
    }

    function applyGuestSelection() {
        const adults = document.getElementById('adultCount').textContent;
        const kids = document.getElementById('kidCount').textContent;
        
        document.getElementById('selectedGuestText').textContent = `${adults} Adult, ${kids} Kids`;
        closeGuestModal();
        // Redirect to search results with new guest count
        window.location.href = `{{ route('search.rooms') }}?hotel_id={{ $hotel->id }}&start_date={{ $startDate }}&end_date={{ $endDate }}&adults=${adults}&kids=${kids}`;
    }

    // Check Availability Function
    document.getElementById('checkAvailability').addEventListener('click', function() {
        const hotelId = '{{ $hotel->id }}';
        const startDate = '{{ $startDate }}';
        const endDate = '{{ $endDate }}';
        const adults = '{{ $adults ?? 1 }}';
        const kids = '{{ $kids ?? 0 }}';
        
        window.location.href = `{{ route('search.rooms') }}?hotel_id=${hotelId}&start_date=${startDate}&end_date=${endDate}&adults=${adults}&kids=${kids}`;
    });
</script>

<!-- Search Form Scripts -->
@include('partials.search-scripts')
@endsection 