<?php

namespace App\Livewire;

use Livewire\Component;

class GuestModal extends Component
{
    public $showModal = false;
    public $adultCount = 1;
    public $kidsCount = 0;

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
                'modalId' => 'guestModal'
            ]);
        } else {
            // Kirim event untuk menutup modal di portal
            $this->dispatch('close-modal-portal');
        }
    }

    public function increaseAdult()
    {
        $this->adultCount++;
    }

    public function decreaseAdult()
    {
        if ($this->adultCount > 1) {
            $this->adultCount--;
        }
    }

    public function increaseKids()
    {
        $this->kidsCount++;
    }

    public function decreaseKids()
    {
        if ($this->kidsCount > 0) {
            $this->kidsCount--;
        }
    }

    public function saveGuests()
    {
        $this->dispatch('guestsSelected', [
            'adults' => $this->adultCount,
            'kids' => $this->kidsCount
        ]);
        $this->toggleModal();
    }

    public function render()
    {
        return view('livewire.guest-modal');
    }
} 