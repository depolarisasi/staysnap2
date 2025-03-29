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
</style>
@endsection

@section('content')
    <!-- Hotel Info Cards --> 
            <div class="py-8 max-w-7xl mx-auto overflow-hidden">
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

                <!-- Hotel Information -->
                <div class="p-6">
                    <h1 class="text-3xl font-bold">{{ $hotel->branch_name }}</h1>
                    <p class="mt-2 text-gray-600">{{ $hotel->branch_address }}</p>
                    <div class="mt-4">
                        <span class="hotel-info-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                            {{ $hotel->regency->name }}
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
                        @if($hotel->branch_email)
                        <span class="hotel-info-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                            {{ $hotel->branch_email }}
                        </span>
                        @endif
                    </div>
                    @if($hotel->branch_description)
                    <div class="text-gray-700 mt-4">
                        <h3 class="text-lg font-semibold mb-2">Tentang {{ $hotel->branch_name }}</h3>
                        <p>{{ $hotel->branch_description }}</p>
                    </div>
                    @endif
                </div>
            </div>  

    <!-- Search Form -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-center">
                    <!-- 1) Input Hotel -->
                    <div class="col-span-1">
                        <button id="openHotelModal" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-left focus:outline-none hover:bg-gray-50">
                            <span class="block text-sm text-gray-500">Hotel</span>
                            <span class="block font-medium" id="selectedHotelText">{{ $hotel->branch_name }}</span>
                        </button>
                    </div>

                    <!-- 2) Input Date Range -->
                    <div class="col-span-1">
                        <button id="openDateModal" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-left focus:outline-none hover:bg-gray-50">
                            <span class="block text-sm text-gray-500">Date Range</span>
                            <span class="block font-medium" id="selectedDateText">{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</span>
                        </button>
                    </div>

                    <!-- 3) Input Jumlah Tamu -->
                    <div class="col-span-1">
                        <button id="openGuestModal" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-left focus:outline-none hover:bg-gray-50">
                            <span class="block text-sm text-gray-500">Guests</span>
                            <span class="block font-medium" id="selectedGuestText">{{ $adults }} Adult, {{ $kids }} Kids</span>
                        </button>
                    </div>

                    <!-- 4) Input Kode Voucher -->
                    <div class="col-span-1">
                        <input type="text" id="voucherInput" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none hover:bg-gray-50" placeholder="Voucher Code">
                    </div>

                    <!-- 5) Tombol Check Availability -->
                    <div class="col-span-1">
                        <button id="checkAvailability" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg px-4 py-2 font-semibold focus:outline-none">
                            Check Availability
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Room Results -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Room List -->
            <div class="lg:col-span-8">
                <div class="p-4 border rounded-lg shadow-md bg-white">
                    <!-- Filter Section -->
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <span class="text-sm font-semibold">Filter Kamar</span>
                            <div class="inline-flex space-x-2 ml-2">
                                <button onclick="filterRooms('breakfast')" class="px-4 py-2 border rounded-full text-sm">Include Breakfast</button>
                                <button onclick="filterRooms('no-breakfast')" class="px-4 py-2 border rounded-full text-sm">Without Breakfast</button>
                            </div>
                        </div>
                        <div>
                            <span class="text-sm font-semibold">Tampilan Harga</span>
                            <a href="#" class="text-blue-500 text-sm ml-2">Total harga (termasuk pajak & biaya)</a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        @foreach($rooms as $room)
                            <div class="p-4 border rounded-lg shadow-sm bg-white">
                                <div class="flex justify-between items-start">
                                    <h2 class="text-lg font-bold">{{ $room->name }}</h2>
                                    @if($room->availability->is_available)
                                        <span class="text-xs bg-green-500 text-white px-2 py-1 rounded-full">Tersedia</span>
                                    @else
                                        <span class="text-xs bg-red-500 text-white px-2 py-1 rounded-full">Tidak Tersedia</span>
                                    @endif
                                </div>

                                <div class="flex mt-4">
                                    <!-- Room Image -->
                                    <div class="w-1/3">
                                        <img src="{{ asset('storage/' . $room->photos->first()->path) }}" alt="{{ $room->name }}" class="w-full h-48 object-cover rounded-lg">
                                    </div>
                                    
                                    <!-- Room Details -->
                                    <div class="w-2/3 pl-4">
                                        <h3 class="font-bold text-md">Detail Kamar</h3>
                                        <ul class="text-sm text-gray-600 space-y-1 mt-1">
                                            @foreach($room->amenities->take(3) as $amenity)
                                                <li>&#10003; {{ $amenity->name }}</li>
                                            @endforeach
                                        </ul>
                                        
                                        <div class="mt-2">
                                            <button onclick="showRoomAmenities({{ $room->id }})" class="text-blue-500 text-sm">
                                                Lihat Semua Fasilitas
                                            </button>
                                        </div>
                                        
                                        <div class="mt-2">
                                            <button onclick="showRoomPolicy({{ $room->id }})" class="text-blue-500 text-sm">
                                                Lihat Kebijakan Kamar
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Price Section -->
                                <div class="mt-4 p-4 border rounded-lg bg-gray-50">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs font-semibold">Total Harga untuk {{ \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) }} malam</span>
                                        @if($room->availability->is_available)
                                            <span class="text-xs bg-green-500 text-white px-2 py-1 rounded-full">{{ $room->availability->available_rooms }} kamar tersedia</span>
                                        @endif
                                    </div>
                                    
                                    <div class="text-2xl font-bold text-yellow-500 mt-2">
                                        Rp {{ number_format($room->availability->total_price, 0, ',', '.') }}
                                    </div>
                                    
                                    <p class="text-xs text-gray-600 mt-1">Termasuk Pajak & Biaya</p>
                                    
                                    @if($room->availability->is_available)
                                        <button onclick="addToCart({{ $room->id }})" class="mt-3 w-full bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                                            Pilih Kamar
                                        </button>
                                    @else
                                        <button class="mt-3 w-full bg-gray-300 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed" disabled>
                                            Tidak Tersedia
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Cart Sidebar -->
            <div class="lg:col-span-4">
                <div class="bg-white rounded-lg shadow-md p-4 sticky top-4">
                    <h2 class="text-xl font-semibold mb-4">Keranjang Anda</h2>
                    <div id="cartItems" class="space-y-4">
                        <!-- Cart items will be dynamically added here -->
                    </div>
                    <div class="mt-4 pt-4 border-t">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-gray-600">Total:</span>
                            <span class="text-xl font-semibold text-yellow-500" id="cartTotal">Rp 0</span>
                        </div>
                        <button class="w-full bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg px-4 py-2 font-semibold focus:outline-none">
                            Lanjut ke Pembayaran
                        </button>
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
@endsection

@section('scripts')
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

    // Cart functionality
    let cart = [];

    function addToCart(roomId) {
        const room = @json($rooms).find(r => r.id === roomId);
        if (room && room.availability.is_available) {
            cart.push({
                id: room.id,
                name: room.name,
                price: room.availability.total_price,
                available_rooms: room.availability.available_rooms
            });
            updateCartDisplay();
        }
    }

    function removeFromCart(roomId) {
        cart = cart.filter(item => item.id !== roomId);
        updateCartDisplay();
    }

    function updateCartDisplay() {
        const cartItems = document.getElementById('cartItems');
        const cartTotal = document.getElementById('cartTotal');
        
        cartItems.innerHTML = cart.map(item => `
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="font-medium">${item.name}</h3>
                    <p class="text-sm text-gray-500">Rp ${item.price.toLocaleString('id-ID')}</p>
                </div>
                <button onclick="removeFromCart(${item.id})" class="text-red-500 hover:text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `).join('');

        const total = cart.reduce((sum, item) => sum + item.price, 0);
        cartTotal.textContent = `Rp ${total.toLocaleString('id-ID')}`;
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
                <div class="flex items-center space-x-2">
                    <img src="${amenity.icon}" alt="${amenity.name}" class="w-6 h-6">
                    <span>${amenity.name}</span>
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

    // Close modals when clicking outside
    window.onclick = function(event) {
        const policyModal = document.getElementById('policyModal');
        const amenitiesModal = document.getElementById('amenitiesModal');
        
        if (event.target === policyModal) {
            closePolicyModal();
        }
        if (event.target === amenitiesModal) {
            closeAmenitiesModal();
        }
    }

    // Filter Rooms Function
    function filterRooms(type) {
        const rooms = document.querySelectorAll('.room-card');
        rooms.forEach(room => {
            const hasBreakfast = room.dataset.hasBreakfast === 'true';
            if (type === 'breakfast' && hasBreakfast) {
                room.style.display = 'block';
            } else if (type === 'no-breakfast' && !hasBreakfast) {
                room.style.display = 'block';
            } else {
                room.style.display = 'none';
            }
        });
    }
</script>
@endsection 