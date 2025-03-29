<?php

namespace App\Livewire;

use App\Models\Branch;
use App\Models\Regency;
use Livewire\Component;
use Livewire\WithPagination;

class HotelModal extends Component
{
    use WithPagination;

    public $showModal = false;
    public $search = '';
    public $selectedCity = '';
    public $selectedHotel = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCity' => ['except' => ''],
    ];

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
                'modalId' => 'hotelModal'
            ]);
            $this->dispatch('modalOpened');
        } else {
            // Kirim event untuk menutup modal di portal
            $this->dispatch('close-modal-portal');
        }
    }

    public function selectHotel($hotelId, $hotelName)
    {
        $this->selectedHotel = [
            'id' => $hotelId,
            'name' => $hotelName
        ];
        $this->dispatch('hotelSelected', $this->selectedHotel);
        $this->toggleModal();
    }

    public function filterByCity($regencyId)
    {
        $this->selectedCity = $regencyId;
        $this->resetPage();
    }

    public function resetCity()
    {
        $this->selectedCity = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = Branch::query();

        if ($this->search) {
            $query->where('branch_name', 'like', '%' . $this->search . '%');
        }

        if ($this->selectedCity) {
            $query->where('branch_city', $this->selectedCity);
        }

        $hotels = $query->paginate(6);
        
        // Ambil daftar kota dari tabel Regency
        $regencies = Regency::whereIn('id', Branch::distinct()->pluck('branch_city'))->get();

        return view('livewire.hotel-modal', [
            'hotels' => $hotels,
            'regencies' => $regencies
        ]);
    }
} 