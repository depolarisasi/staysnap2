<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sahid Hotels Booking Clone</title>
    <link href="https://cdn.jsdelivr.net/npm/fastbootstrap@2.2.0/dist/css/fastbootstrap.min.css" rel="stylesheet" integrity="sha256-V6lu+OdYNKTKTsVFBuQsyIlDiRWiOmtC8VQ8Lzdm2i4=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
                /* Reset and base styles */
        :root {
            --primary-color: #1a4b84;
            --secondary-color: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            padding-top: 76px;
        }

        /* Hero Section with Carousel */
        .hero-section {
            position: relative;
            height: 80vh;
            overflow: hidden;
        }

        .hero-carousel {
            height: 100%;
        }

        .hero-carousel .item {
            height: 80vh;
            position: relative;
        }

        .hero-carousel .item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .carousel-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            z-index: 2;
            width: 80%;
        }

        .hero-carousel .item::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }

        /* Booking Form */
        .booking-form-section {
            margin-top: -100px;
            position: relative;
            z-index: 10;
        }

        .booking-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
        }

        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }

        .form-label i {
            color: var(--primary-color);
            margin-right: 8px;
        }

        .custom-select select,
        .date-input-group input,
        .guests-select-group select,
        #hotelSelector {
            height: 50px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 0 15px;
            font-size: 1rem;
            background-color: #fff;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .custom-select select:focus,
        .date-input-group input:focus,
        .guests-select-group select:focus,
        #hotelSelector:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(26, 75, 132, 0.25);
        }

        /* Hotel Modal Styles */
        .hotel-search {
            position: relative;
        }

        .hotel-search input {
            padding-left: 40px;
            height: 45px;
        }

        .hotel-search::before {
            content: '\f002';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .hotel-card-modal {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            height: 100%;
        }

        .hotel-card-modal:hover {
            border-color: var(--primary-color);
            transform: translateY(-5px);
        }

        .hotel-card-modal.selected {
            border-color: var(--primary-color);
            background-color: rgba(26, 75, 132, 0.05);
        }

        .hotel-card-modal img {
            height: 150px;
            object-fit: cover;
            border-radius: 8px 8px 0 0;
        }

        /* Date Picker Customization */
        .flatpickr-calendar {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .flatpickr-day.selected {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .flatpickr-day.selected:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Featured Hotels */
        .hotel-card {
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .hotel-card:hover {
            transform: translateY(-5px);
        }

        .hotel-card img {
            height: 200px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }

        /* Custom Button Styles */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 12px 30px;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #123a6a;
            border-color: #123a6a;
            transform: translateY(-2px);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .booking-form-section {
                margin-top: -50px;
            }

            .booking-card {
                padding: 15px;
            }

            .carousel-content h1 {
                font-size: 2rem;
            }

            .carousel-content p {
                font-size: 1rem;
            }

            .custom-select select,
            .date-input-group input,
            .guests-select-group select,
            #hotelSelector {
                height: 45px;
            }
        }

        /* Footer Styles */
        footer {
            margin-top: 50px;
        }

        footer a {
            text-decoration: none;
            transition: opacity 0.3s ease;
        }

        footer a:hover {
            opacity: 0.8;
        }

        /* Owl Carousel Custom Styles */
        .owl-dots {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
        }

        .owl-dot span {
            background: rgba(255, 255, 255, 0.5) !important;
        }

        .owl-dot.active span {
            background: white !important;
        }

        .owl-nav {
            position: absolute;
            top: 50%;
            width: 100%;
            transform: translateY(-50%);
        }

        .owl-prev, .owl-next {
            position: absolute;
            background: rgba(255, 255, 255, 0.3) !important;
            width: 40px;
            height: 40px;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center;
            justify-content: center;
        }

        .owl-prev {
            left: 20px;
        }

        .owl-next {
            right: 20px;
        }

        .owl-prev:hover, .owl-next:hover {
            background: rgba(255, 255, 255, 0.5) !important;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg bg-white fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{asset(setting('site_logo', '#'))}}" alt="Sahid Hotels" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Hotels</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Carousel -->
    <section class="hero-section">
        <div class="owl-carousel hero-carousel owl-theme">
            <div class="item">
                <img src="https://picsum.photos/1920/1080?random=1" alt="Hotel View 1">
                <div class="carousel-content">
                    <h1 class="display-4">Welcome to Sahid Hotels</h1>
                    <p class="lead">Discover comfort and luxury at our premium locations</p>
                </div>
            </div>
            <div class="item">
                <img src="https://picsum.photos/1920/1080?random=2" alt="Hotel View 2">
                <div class="carousel-content">
                    <h1 class="display-4">Luxury Accommodations</h1>
                    <p class="lead">Experience world-class hospitality</p>
                </div>
            </div>
            <div class="item">
                <img src="https://picsum.photos/1920/1080?random=3" alt="Hotel View 3">
                <div class="carousel-content">
                    <h1 class="display-4">Perfect Locations</h1>
                    <p class="lead">Prime destinations across Indonesia</p>
                </div>
            </div>
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
                <!-- Hotels will be populated by JavaScript -->
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>About Sahid Hotels</h5>
                    <p>Experience luxury and comfort at our premium locations across Indonesia.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Our Hotels</a></li>
                        <li><a href="#" class="text-white">Special Offers</a></li>
                        <li><a href="#" class="text-white">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Info</h5>
                    <ul class="list-unstyled">
                        <li>Email: info@sahidhotels.com</li>
                        <li>Phone: +62 21 123456</li>
                        <li>Address: Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
        
            // Initialize hotel modal functionality
            initializeHotelModal();
        
            // Handle form submission
            document.getElementById('bookingForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = {
                    hotel: document.getElementById('selectedHotel').value,
                    dates: document.getElementById('dateRange').value,
                    guests: document.getElementById('guests').value
                };
        
                console.log('Booking details:', formData);
                alert('Booking search initiated! Check console for details.');
            });
        
            // Display featured hotels
            displayFeaturedHotels();
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
        
            // Initialize hotel search functionality
            hotelSearch.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const filteredHotels = hotels.filter(hotel => 
                    hotel.name.toLowerCase().includes(searchTerm) ||
                    hotel.location.toLowerCase().includes(searchTerm) ||
                    hotel.description.toLowerCase().includes(searchTerm)
                );
                populateHotelCards(filteredHotels);
            });
        
            // Initial population of hotel cards
            populateHotelCards();
        }
        
        // Function to display featured hotels
        function displayFeaturedHotels() {
            const container = document.getElementById('featuredHotels');
            
            hotels.slice(0, 3).forEach(hotel => {
                const hotelCard = document.createElement('div');
                hotelCard.className = 'col-md-4';
                hotelCard.innerHTML = `
                    <div class="card hotel-card">
                        <img src="${hotel.image}" class="card-img-top" alt="${hotel.name}">
                        <div class="card-body">
                            <h5 class="card-title">${hotel.name}</h5>
                            <p class="card-text">
                                <i class="fas fa-map-marker-alt"></i> ${hotel.location}<br>
                                <span class="text-primary">${hotel.price}</span> / night<br>
                                Rating: ${hotel.rating}/5
                            </p>
                            <button class="btn btn-primary w-100">View Details</button>
                        </div>
                    </div>
                `;
                container.appendChild(hotelCard);
            });
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

</body>
</html>