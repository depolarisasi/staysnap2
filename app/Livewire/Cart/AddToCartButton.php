<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use App\Services\CartService;

class AddToCartButton extends Component
{
    public $roomId;
    public $checkInDate;
    public $checkOutDate;
    public $adultCount;
    public $kidsCount;
    public $voucherCode;
    public $quantity = 1;
    public $isLoading = false;

    public function mount($roomId, $checkInDate, $checkOutDate, $adultCount = 1, $kidsCount = 0, $voucherCode = null)
    {
        $this->roomId = $roomId;
        $this->checkInDate = $checkInDate;
        $this->checkOutDate = $checkOutDate;
        $this->adultCount = $adultCount;
        $this->kidsCount = $kidsCount;
        $this->voucherCode = $voucherCode;
    }

    public function addToCart(CartService $cartService)
    {
        $this->isLoading = true;

        $data = [
            'room_id' => $this->roomId,
            'check_in_date' => $this->checkInDate,
            'check_out_date' => $this->checkOutDate,
            'adult_count' => $this->adultCount,
            'kids_count' => $this->kidsCount,
            'quantity' => $this->quantity,
            'voucher_code' => $this->voucherCode
        ];

        try {
            $cartItem = $cartService->addItem($data);
            $this->emit('itemAdded', $cartItem->id);
            
            session()->flash('cart-success', 'Kamar berhasil ditambahkan ke keranjang');
        } catch (\Exception $e) {
            session()->flash('cart-error', 'Gagal menambahkan ke keranjang: ' . $e->getMessage());
        }

        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.cart.add-to-cart-button');
    }
} 