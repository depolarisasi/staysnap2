<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use App\Services\CartService;

class CartComponent extends Component
{
    public $cartItems = [];
    public $total = 0;
    public $discount = 0;
    public $voucherCode = '';
    public $voucherApplied = false;

    protected $listeners = [
        'cartUpdated' => 'loadCart',
        'itemAdded' => 'loadCart'
    ];

    public function mount(CartService $cartService)
    {
        $this->loadCart($cartService);
    }

    public function loadCart(CartService $cartService = null)
    {
        if (!$cartService) {
            $cartService = app(CartService::class);
        }
        
        $this->cartItems = $cartService->getItems();
        $this->total = $cartService->getTotal();
        $this->calculateDiscount();
    }

    public function updateQuantity($cartId, $quantity, CartService $cartService = null)
    {
        if (!$cartService) {
            $cartService = app(CartService::class);
        }

        if ($quantity < 1) {
            $quantity = 1;
        }

        $cartService->updateQuantity($cartId, $quantity);
        $this->loadCart($cartService);
        $this->emit('cartUpdated');
    }

    public function removeItem($cartId, CartService $cartService = null)
    {
        if (!$cartService) {
            $cartService = app(CartService::class);
        }

        $cartService->removeItem($cartId);
        $this->loadCart($cartService);
        $this->emit('cartUpdated');
    }

    public function clearCart(CartService $cartService = null)
    {
        if (!$cartService) {
            $cartService = app(CartService::class);
        }

        $cartService->clearCart();
        $this->loadCart($cartService);
        $this->emit('cartUpdated');
    }

    public function applyVoucher(CartService $cartService = null)
    {
        if (!$cartService) {
            $cartService = app(CartService::class);
        }

        if (empty($this->voucherCode)) {
            session()->flash('error', 'Masukkan kode voucher terlebih dahulu');
            return;
        }

        try {
            $cartService->applyVoucher($this->voucherCode);
            $this->voucherApplied = true;
            $this->loadCart($cartService);
            session()->flash('success', 'Voucher berhasil diterapkan');
            $this->emit('cartUpdated');
        } catch (\Exception $e) {
            session()->flash('error', 'Voucher tidak valid: ' . $e->getMessage());
        }
    }

    public function calculateDiscount()
    {
        $this->discount = collect($this->cartItems)->sum('discount_amount');
    }

    public function render()
    {
        return view('livewire.cart.cart-component');
    }
}
