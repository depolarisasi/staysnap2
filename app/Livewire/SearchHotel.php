<?php

namespace App\Livewire;

use Livewire\Component;

class SearchHotel extends Component
{
   // Properti untuk data form
   public $selectedHotel = null;
   public $checkInDate = null;
   public $checkOutDate = null;
   public $adultCount = 1;
   public $kidsCount = 0;
   public $voucherCode = '';

   // Properti untuk mengontrol modal
   public $showHotelModal = false;
   public $showDateModal = false;
   public $showGuestModal = false;

   // Data contoh untuk daftar hotel
   public $hotels = [
       ['id' => 1, 'name' => 'Hotel A', 'city' => 'Jakarta', 'thumbnail' => 'https://via.placeholder.com/200'],
       ['id' => 2, 'name' => 'Hotel B', 'city' => 'Jakarta', 'thumbnail' => 'https://via.placeholder.com/200'],
       ['id' => 3, 'name' => 'Hotel C', 'city' => 'Bandung', 'thumbnail' => 'https://via.placeholder.com/200'],
       ['id' => 4, 'name' => 'Hotel D', 'city' => 'Bandung', 'thumbnail' => 'https://via.placeholder.com/200'],
       // dan seterusnya...
   ];

   public $searchHotel = '';
   public $selectedCity = '';

   // Metode untuk membuka modal
   public function openHotelModal()
   {
       $this->showHotelModal = true;
   }

   public function openDateModal()
   {
       $this->showDateModal = true;
   }

   public function openGuestModal()
   {
       $this->showGuestModal = true;
   }

   // Memilih hotel
   public function selectHotel($hotelId)
   {
       $this->selectedHotel = $hotelId;
       $this->showHotelModal = false;
   }

   // Metode submit
   public function checkAvailability()
   {
       // Validasi dan logic checking
       // ...

       // Contoh debugging:
       dd([
           'hotel_id' => $this->selectedHotel,
           'check_in' => $this->checkInDate,
           'check_out' => $this->checkOutDate,
           'adult' => $this->adultCount,
           'kids' => $this->kidsCount,
           'voucher' => $this->voucherCode,
       ]);
   }

   public function render()
   {
       // Filter data hotel berdasarkan search dan city
       $filteredHotels = collect($this->hotels)
           ->filter(function($hotel) {
               $matchesSearch = true;
               if ($this->searchHotel) {
                   $matchesSearch = str_contains(strtolower($hotel['name']), strtolower($this->searchHotel));
               }

               $matchesCity = true;
               if ($this->selectedCity) {
                   $matchesCity = strtolower($hotel['city']) === strtolower($this->selectedCity);
               }

               return $matchesSearch && $matchesCity;
           })
           ->all();

       return view('livewire.search-hotel', [
           'filteredHotels' => $filteredHotels,
       ]);
   }
}
