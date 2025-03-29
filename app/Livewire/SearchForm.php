<?php

namespace App\Livewire;

use Livewire\Component;

class SearchForm extends Component
{
    public $selectedHotel = null;
    public $startDate = null;
    public $endDate = null;
    public $adultCount = 1;
    public $kidsCount = 0;
    public $voucherCode = '';

    protected $listeners = [
        'hotelSelected' => 'setSelectedHotel',
        'dateRangeSelected' => 'setDateRange',
        'guestsSelected' => 'setGuests'
    ];

    public function setSelectedHotel($hotel)
    {
        $this->selectedHotel = $hotel;
    }

    public function setDateRange($dateRange)
    {
        $this->startDate = $dateRange['startDate'];
        $this->endDate = $dateRange['endDate'];
    }

    public function setGuests($guests)
    {
        $this->adultCount = $guests['adults'];
        $this->kidsCount = $guests['kids'];
    }

    public function setVoucherCode($code)
    {
        $this->voucherCode = $code;
    }

    public function checkAvailability()
    {
        // Validasi input
        if (!$this->selectedHotel) {
            session()->flash('error', 'Silakan pilih hotel terlebih dahulu.');
            return;
        }

        if (!$this->startDate || !$this->endDate) {
            session()->flash('error', 'Silakan pilih tanggal check-in dan check-out.');
            return;
        }

        // Redirect ke halaman pencarian dengan parameter
        return redirect()->route('search.rooms', [
            'hotel_id' => $this->selectedHotel['id'],
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'adults' => $this->adultCount,
            'kids' => $this->kidsCount,
            'voucher' => $this->voucherCode
        ]);
    }

    public function render()
    {
        return view('livewire.search-form');
    }
} 