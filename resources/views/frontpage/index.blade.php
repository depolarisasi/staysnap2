@extends('layouts.frontpage.app') 
@section('title', 'Home')
@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>
  /* Animasi fade-in untuk modal */
  .fade-in {
    animation: fadeIn 0.3s ease-out;
  }
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  /* Style untuk flatpickr-calendar */
  .flatpickr-calendar {
    width: 100% !important;
    max-width: 100% !important;
    border: none !important;
    box-shadow: none !important;
  }

  /* Menyesuaikan posisi kalender */
  .flatpickr-months {
    display: flex;
    justify-content: center;
  }
  
  .flatpickr-month {
    width: 100%;
    text-align: center;
  }

  .flatpickr-current-month {
    left: 0 !important;
    right: 0 !important;
    width: 100% !important;
    padding: 0 !important;
  }

  .flatpickr-prev-month, .flatpickr-next-month {
    padding: 10px !important;
  }
  
  /* Mengatur lebar container bulan */
  .flatpickr-rContainer, 
  .flatpickr-days,
  .dayContainer {
    width: 100% !important;
    max-width: 100% !important;
  }
  
  /* Memastikan grid bulan sejajar dengan baik */
  .flatpickr-days .flatpickr-day {
    max-width: none !important;
  }

  /* Style untuk tanggal pada calendar */
  .flatpickr-day {
    width: 14.2857% !important; 
    height: 3.5rem !important;
    margin: 0 !important;
    border-radius: 0 !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: center !important;
    line-height: 1.2 !important;
    position: relative;
    font-size: 0.875rem;
    color: #111827;
    padding: 2px 0 !important;
  }

  /* Style untuk prices di bawah tanggal */
  .day-number {
    display: block;
    font-weight: 500;
    margin-bottom: 2px;
  }
  .day-price {
    color: #ef4444;
    font-size: 0.7rem;
    margin-top: 2px;
    line-height: 1;
    font-weight: 600;
    letter-spacing: -0.01em;
  }
  
  /* Style untuk tanggal terpilih */
  .flatpickr-day.selected {
    background-color: #3b82f6 !important;
    color: white !important;
  }
  .flatpickr-day.selected .day-price {
    color: white !important;
  }

  /* Modal styles */
  .modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 50;
  }
  
  .modal.show {
    display: block;
  }

  .modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 10;
  }
  
  .modal-dialog {
    position: relative;
    z-index: 30;
    pointer-events: auto;
  }
  
  .modal-content {
    background: white;
    pointer-events: auto;
  }
  
  /* Style untuk search form pada tampilan mobile */
  @media (max-width: 768px) {
    .search-form-text {
      font-size: 0.85rem !important;
    }
    .search-form-label {
      font-size: 0.65rem !important;
    }
     
  }

  /* Ukuran teks pada search form */
  .search-form-text {
    font-size: 0.95rem;
  }
  .search-form-label {
    font-size: 0.7rem;
  }
</style>

@endsection

@section('content')
    <!-- Hero Section with Search -->
    <div class="relative h-[500px]">
        <livewire:slider-front />  
        
        <!-- Search Form -->
        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 w-full max-w-7xl px-4">
            <div class="bg-white rounded-3xl mb-6 shadow overflow-visible border border-gray-200 search-form-container">
                @include('partials.search-form')
          </div>
        </div>
    </div>  

    <!-- Branches Section -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 mt-10">
            <h2 class="text-3xl font-bold text-center mb-8">Our Branches</h2> 
            <livewire:hotel-branch-front /> 
        </div>
    </section>
    
    <!-- Search Form Modals -->
    @include('partials.search-modals')
@endsection

@section('scripts') 
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Search Form Scripts -->
@include('partials.search-scripts')
@endsection