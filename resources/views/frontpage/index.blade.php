@extends('layouts.frontpage.app')
@section('content')
 <section class="hero-section">
    <div class="owl-carousel hero-carousel owl-theme">
        @foreach($slider as $slide)
        <div class="item">
            <img src="{{asset('storage/'.$slide->image)}}" alt="{{$slide->title}}"> 
        </div> 
        @endforeach
    </div>
</section>

<!-- Booking Form -->
<section class="booking-form-section">
    <div class="container">
        <div class="card booking-card shadow">
            <div class="card-body">
                <form id="bookingForm">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="hotel-select-wrapper">
                                <label class="form-label"><i class="fas fa-hotel"></i> Select Hotel</label>
                                <div class="custom-select">
                                    <input type="text" class="form-control" id="hotelSelector" readonly placeholder="Choose your destination" data-bs-toggle="modal" data-bs-target="#hotelModal">
                                    <input type="hidden" id="selectedHotel" name="hotel" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="date-picker-wrapper">
                                <label class="form-label"><i class="fas fa-calendar"></i> Check In - Check Out</label>
                                <div class="date-input-group">
                                    <input type="text" class="form-control" id="dateRange" placeholder="Select dates" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="guests-wrapper">
                                <label class="form-label"><i class="fas fa-user"></i> Guests</label>
                                <div class="guests-select-group">
                                    <select class="form-select" id="guests" required>
                                        <option value="1">1 Adult</option>
                                        <option value="2">2 Adults</option>
                                        <option value="3">3 Adults</option>
                                        <option value="4">4 Adults</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-search me-2"></i>Check Availability
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

    <!-- Hotel Selection Modal -->
    <div class="modal fade" id="hotelModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Your Hotel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="hotel-search mb-4">
                        <input type="text" class="form-control" id="hotelSearch" placeholder="Search hotels...">
                    </div>
                    <div class="row g-4" id="hotelList">
                        <!-- Hotel cards will be populated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Featured Hotels -->
<section class="featured-hotels py-5">
    <div class="container">
        <h2 class="text-center mb-5">Featured Hotels</h2>
        <div class="row g-4" id="featuredHotels">
            @foreach($branches as $branch)
            <div class="col-md-4">
                <div class="card hotel-card">
                    <img src="{{asset('storage/'.$branch->branch_thumbnail)}}" class="card-img-top" alt="{{$branch->branch_name}}">
                    <div class="card-body">
                        <h5 class="card-title">{{$branch->branch_name}}</h5>
                        <p class="card-text">
                            <i class="fas fa-map-marker-alt"></i> {{$branch->branch_city}}, {{$branch->branch_province}}<br>
                            <span class="text-primary">Rp {{ number_format($branch->lowest_price, 0, ',', '.') }}</span> / night<br>
                            Rating: {{$branch->branch_star}}
                        </p>
                        <button class="btn btn-primary w-100">See All Rooms</button>
                    </div>
                </div>
            </div>
 
            @endforeach
        </div>
    </div>
</section>
@section('script')
<script>// Sample hotel data
    const hotels = [
        {
            id: 1,
            name: "Sahid Jakarta",
            location: "Jakarta",
            price: "$100",
            image: "https://picsum.photos/800/600?random=1",
            rating: 4.5,
            description: "Luxury hotel in the heart of Jakarta"
        },
        {
            id: 2,
            name: "Sahid Sudirman",
            location: "Jakarta",
            price: "$120",
            image: "https://picsum.photos/800/600?random=2",
            rating: 4.6,
            description: "Modern comfort in Sudirman business district"
        },
        {
            id: 3,
            name: "Sahid Bali",
            location: "Bali",
            price: "$150",
            image: "https://picsum.photos/800/600?random=3",
            rating: 4.8,
            description: "Beachfront resort in beautiful Bali"
        },
        {
            id: 4,
            name: "Sahid Kuta",
            location: "Bali",
            price: "$130",
            image: "https://picsum.photos/800/600?random=4",
            rating: 4.7,
            description: "Experience the vibrant Kuta lifestyle"
        },
        {
            id: 5,
            name: "Sahid Yogyakarta",
            location: "Yogyakarta",
            price: "$90",
            image: "https://picsum.photos/800/600?random=5",
            rating: 4.3,
            description: "Cultural heritage meets modern luxury"
        }
    ];
    
    // Initialize the booking form and carousel
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Owl Carousel
        $('.hero-carousel').owlCarousel({
            items: 1,
            loop: true,
            nav: true,
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            animateOut: 'fadeOut',
            navText: [
                '<i class="fas fa-chevron-left"></i>',
                '<i class="fas fa-chevron-right"></i>'
            ]
        });
    
        // Initialize Flatpickr date range picker
        flatpickr("#dateRange", {
            mode: "range",
            minDate: "today",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
            showMonths: 2,
            static: true
        });
     
    });
    
    // Function to initialize hotel modal
    function initializeHotelModal() {
        const hotelList = document.getElementById('hotelList');
        const hotelSearch = document.getElementById('hotelSearch');
        const hotelSelector = document.getElementById('hotelSelector');
        const selectedHotelInput = document.getElementById('selectedHotel');
    
        // Populate hotel cards in modal
        function populateHotelCards(hotelsToShow = hotels) {
            hotelList.innerHTML = '';
            hotelsToShow.forEach(hotel => {
                const hotelCard = document.createElement('div');
                hotelCard.className = 'col-md-6 mb-4';
                hotelCard.innerHTML = `
                    <div class="card hotel-card-modal" data-hotel-id="${hotel.id}">
                        <img src="${hotel.image}" class="card-img-top" alt="${hotel.name}">
                        <div class="card-body">
                            <h5 class="card-title">${hotel.name}</h5>
                            <p class="card-text">
                                <i class="fas fa-map-marker-alt"></i> ${hotel.location}<br>
                                <small>${hotel.description}</small><br>
                                <span class="text-primary">${hotel.price}</span> / night
                            </p>
                        </div>
                    </div>
                `;
                hotelList.appendChild(hotelCard);
    
                // Add click event to hotel card
                hotelCard.querySelector('.hotel-card-modal').addEventListener('click', function() {
                    const hotelId = this.dataset.hotelId;
                    const selectedHotel = hotels.find(h => h.id === parseInt(hotelId));
                    
                    // Update the hotel selector input
                    hotelSelector.value = selectedHotel.name;
                    selectedHotelInput.value = hotelId;
    
                    // Remove selected class from all cards and add to clicked card
                    document.querySelectorAll('.hotel-card-modal').forEach(card => {
                        card.classList.remove('selected');
                    });
                    this.classList.add('selected');
    
                    // Close the modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('hotelModal'));
                    modal.hide();
                });
            });
        }
     
     
    }
     
    // Add smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>

@endsection
@endsection
