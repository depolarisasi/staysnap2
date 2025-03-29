@extends('layouts.frontpage.app')
@section('title', 'Search Hotel')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Hero Section -->
    <div class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Cari Hotel</h1>
                    <p class="text-gray-600 mt-1">Temukan hotel terbaik untuk perjalanan Anda</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">Lihat riwayat pencarian</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6">
                <form wire:submit.prevent="checkAvailability" class="space-y-6">
                    <!-- Hotel Selection -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hotel</label>
                            <button 
                                type="button"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-left focus:outline-none hover:bg-gray-50"
                                wire:click="openHotelModal"
                            >
                                <span class="block text-sm text-gray-500">Pilih Hotel</span>
                                <span class="block font-medium">
                                    @if($selectedHotel)
                                        {{ collect($hotels)->firstWhere('id', $selectedHotel)['name'] ?? 'Pilih Hotel' }}
                                    @else
                                        Pilih Hotel
                                    @endif
                                </span>
                            </button>
                        </div>

                        <!-- Date Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Check-in</label>
                            <button 
                                type="button"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-left focus:outline-none hover:bg-gray-50"
                                wire:click="openDateModal"
                            >
                                <span class="block text-sm text-gray-500">Pilih Tanggal</span>
                                <span class="block font-medium">
                                    @if($checkInDate && $checkOutDate)
                                        {{ $checkInDate }} - {{ $checkOutDate }}
                                    @else
                                        Pilih Tanggal
                                    @endif
                                </span>
                            </button>
                        </div>

                        <!-- Guest Count -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Tamu</label>
                            <button 
                                type="button"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-left focus:outline-none hover:bg-gray-50"
                                wire:click="openGuestModal"
                            >
                                <span class="block text-sm text-gray-500">Pilih Jumlah Tamu</span>
                                <span class="block font-medium">
                                    {{ $adultCount }} Dewasa, {{ $kidsCount }} Anak
                                </span>
                            </button>
                        </div>

                        <!-- Voucher Code -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Voucher</label>
                            <input 
                                type="text" 
                                wire:model="voucherCode"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan kode voucher"
                            >
                        </div>
                    </div>

                    <!-- Search Button -->
                    <div class="flex justify-end">
                        <button 
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                            Cari Hotel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hotel Selection Modal -->
    @if($showHotelModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white w-11/12 md:w-2/3 h-3/4 rounded-lg p-4 flex flex-col">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold">Pilih Hotel</h2>
                <button wire:click="$set('showHotelModal', false)" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Search and Filter -->
            <div class="flex flex-col md:flex-row md:items-center gap-2 mb-4">
                <input 
                    type="text" 
                    wire:model="searchHotel"
                    placeholder="Cari hotel..."
                    class="border rounded px-3 py-2 flex-1"
                />
                @php
                    $cities = collect($hotels)->pluck('city')->unique();
                @endphp
                <div class="flex flex-wrap gap-2">
                    @foreach($cities as $city)
                        <button 
                            wire:click="$set('selectedCity', '{{ $city }}')"
                            class="px-3 py-1 rounded-full border text-sm
                                   @if($selectedCity === $city) bg-blue-600 text-white @else bg-gray-100 text-gray-600 @endif"
                        >
                            {{ $city }}
                        </button>
                    @endforeach
                    <button 
                        wire:click="$set('selectedCity', '')"
                        class="px-3 py-1 rounded-full border bg-red-100 text-red-600 text-sm"
                    >
                        Reset
                    </button>
                </div>
            </div>

            <!-- Hotel List -->
            <div class="flex-1 overflow-auto">
                <div class="grid grid-cols-2 gap-4">
                    @foreach($filteredHotels as $hotel)
                    <div 
                        class="border rounded p-3 flex flex-col cursor-pointer hover:bg-gray-50
                               @if($selectedHotel === $hotel['id']) border-blue-500 @endif"
                        wire:click="selectHotel({{ $hotel['id'] }})"
                    >
                        <img 
                            src="{{ $hotel['branch_thumbnail'] }}" 
                            alt="Hotel Image" 
                            class="h-24 w-full object-cover rounded mb-2"
                        />
                        <h3 class="font-semibold">{{ $hotel['branch_name'] }}</h3>
                        <p class="text-sm text-gray-600">{{ $hotel['branch_city'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Date Selection Modal -->
    @if($showDateModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white w-11/12 md:w-2/3 rounded-lg p-4 flex flex-col">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold">Pilih Tanggal</h2>
                <button wire:click="$set('showDateModal', false)" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="datepicker" wire:ignore class="mx-auto"></div>
        </div>
    </div>
    @endif

    <!-- Guest Selection Modal -->
    @if($showGuestModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white w-80 rounded-lg p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold">Jumlah Tamu</h2>
                <button wire:click="$set('showGuestModal', false)" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Adult Count -->
            <div class="flex items-center justify-between mb-4">
                <span>Dewasa</span>
                <div class="flex items-center gap-2">
                    <button 
                        type="button"
                        class="bg-gray-200 px-2 py-1 rounded"
                        wire:click="$set('adultCount', max($adultCount - 1, 1))"
                    >-</button>
                    <span>{{ $adultCount }}</span>
                    <button 
                        type="button"
                        class="bg-gray-200 px-2 py-1 rounded"
                        wire:click="$set('adultCount', $adultCount + 1)"
                    >+</button>
                </div>
            </div>

            <!-- Kids Count -->
            <div class="flex items-center justify-between mb-4">
                <span>Anak</span>
                <div class="flex items-center gap-2">
                    <button 
                        type="button"
                        class="bg-gray-200 px-2 py-1 rounded"
                        wire:click="$set('kidsCount', max($kidsCount - 1, 0))"
                    >-</button>
                    <span>{{ $kidsCount }}</span>
                    <button 
                        type="button"
                        class="bg-gray-200 px-2 py-1 rounded"
                        wire:click="$set('kidsCount', $kidsCount + 1)"
                    >+</button>
                </div>
            </div>

            <!-- Confirm Button -->
            <button 
                type="button"
                class="bg-blue-600 hover:bg-blue-700 text-white w-full py-2 rounded"
                wire:click="$set('showGuestModal', false)"
            >
                Konfirmasi
            </button>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        flatpickr("#datepicker", {
            mode: "range",
            inline: true,
            minDate: "today",
            showMonths: 2,
            dateFormat: "Y-m-d",
            onClose: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    let startFormat = instance.formatDate(selectedDates[0], "Y-m-d");
                    let endFormat   = instance.formatDate(selectedDates[1], "Y-m-d");
                    @this.set('checkInDate', startFormat);
                    @this.set('checkOutDate', endFormat);
                    @this.set('showDateModal', false);
                }
            }
        });
    });
</script>
@endpush
@endsection
