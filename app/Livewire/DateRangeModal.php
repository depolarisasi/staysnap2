<?php

namespace App\Livewire;

use App\Models\Room;
use App\Models\Branch;
use Livewire\Component;

class DateRangeModal extends Component
{
    public $showModal = false;
    public $startDate = null;
    public $endDate = null;
    public $selectedHotelId = null;
    public $roomPrices = [];

    protected $listeners = ['hotelSelected' => 'updateSelectedHotel'];

    public function mount()
    {
        $this->showModal = false;
    }

    public function toggleModal()
    {
        $this->showModal = !$this->showModal;
        if ($this->showModal) {
            // Kirim event untuk membuka modal di portal
            $this->dispatch('open-modal-portal', [
                'modalId' => 'dateModal'
            ]);
            $this->dispatch('modalOpened');
        } else {
            // Kirim event untuk menutup modal di portal
            $this->dispatch('close-modal-portal');
        }
    }

    public function updateSelectedHotel($hotel)
    {
        $this->selectedHotelId = $hotel['id'];
        // Reset tanggal ketika hotel berubah
        $this->startDate = null;
        $this->endDate = null;
    }

    public function setDateRange($dates)
    {
        $dates = explode(' to ', $dates);
        if (count($dates) == 2) {
            $this->startDate = $dates[0];
            $this->endDate = $dates[1];
            $this->loadRoomPrices();
            $this->dispatch('dateRangeSelected', [
                'startDate' => $this->startDate,
                'endDate' => $this->endDate
            ]);
            $this->toggleModal();
        }
    }

    public function loadRoomPrices()
    {
        if (!$this->selectedHotelId || !$this->startDate || !$this->endDate) {
            return;
        }

        $startDate = \Carbon\Carbon::parse($this->startDate);
        $endDate = \Carbon\Carbon::parse($this->endDate);

        $dateRange = [];
        $currentDate = clone $startDate;

        while ($currentDate->lte($endDate)) {
            $dateRange[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        // Ambil harga kamar untuk hotel yang dipilih
        $rooms = Room::where('branch_id', $this->selectedHotelId)->get();
        
        $this->roomPrices = [];
        foreach ($dateRange as $date) {
            $this->roomPrices[$date] = [];
            foreach ($rooms as $room) {
                // Di sini kita bisa menambahkan logika untuk harga berdasarkan musim/tanggal khusus
                // Untuk contoh, kita gunakan harga dasar + random untuk simulasi harga berbeda per hari
                $basePrice = $room->price;
                $randomFactor = rand(90, 110) / 100; // Faktor 0.9 - 1.1 untuk variasi harga
                $this->roomPrices[$date][$room->id] = round($basePrice * $randomFactor);
            }
        }
    }

    public function render()
    {
        return view('livewire.date-range-modal');
    }
} 