<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Room;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class CartService
{
    public function addItem($data)
    {
        $sessionId = Session::get('cart_session_id');
        
        // Validasi ketersediaan kamar
        $room = Room::findOrFail($data['room_id']);
        $checkIn = Carbon::parse($data['check_in_date']);
        $checkOut = Carbon::parse($data['check_out_date']);
        
        // Hitung total hari dan total harga
        $totalDays = $checkIn->diffInDays($checkOut);
        $pricePerDay = $room->base_price;
        $totalPrice = $pricePerDay * $totalDays * $data['quantity'];
        
        // Cek apakah item sudah ada di keranjang dengan tanggal sama
        $existingCart = Cart::where('session_id', $sessionId)
            ->where('room_id', $data['room_id'])
            ->where('check_in_date', $data['check_in_date'])
            ->where('check_out_date', $data['check_out_date'])
            ->first();
        
        if ($existingCart) {
            // Update quantity jika kamar dengan tanggal yang sama sudah ada
            $existingCart->quantity += $data['quantity'];
            $existingCart->total_price = $pricePerDay * $totalDays * $existingCart->quantity;
            $existingCart->save();
            
            return $existingCart;
        }

        // Buat struktur data selected_rooms untuk backward compatibility
        $selectedRooms = [
            $data['room_id'] => [
                'check_in' => $data['check_in_date'],
                'check_out' => $data['check_out_date'],
                'adult_count' => $data['adult_count'],
                'kids_count' => $data['kids_count'],
                'quantity' => $data['quantity'],
                'price' => $pricePerDay
            ]
        ];

        // Buat cart item baru
        return Cart::create([
            'session_id' => $sessionId,
            'room_id' => $data['room_id'],
            'check_in_date' => $data['check_in_date'],
            'check_out_date' => $data['check_out_date'],
            'adult_count' => $data['adult_count'],
            'kids_count' => $data['kids_count'],
            'quantity' => $data['quantity'],
            'price' => $pricePerDay,
            'total_price' => $totalPrice,
            'voucher_code' => $data['voucher_code'] ?? null,
            'selected_rooms' => $selectedRooms
        ]);
    }

    public function getItems()
    {
        $sessionId = Session::get('cart_session_id');
        return Cart::where('session_id', $sessionId)
            ->with('room')
            ->get();
    }

    public function updateQuantity($cartId, $quantity)
    {
        $cart = Cart::findOrFail($cartId);
        $totalDays = Carbon::parse($cart->check_in_date)->diffInDays(Carbon::parse($cart->check_out_date));
        
        $cart->quantity = $quantity;
        $cart->total_price = $cart->price * $totalDays * $quantity;
        
        // Update selected_rooms juga
        if ($cart->selected_rooms && isset($cart->selected_rooms[$cart->room_id])) {
            $selectedRooms = $cart->selected_rooms;
            $selectedRooms[$cart->room_id]['quantity'] = $quantity;
            $cart->selected_rooms = $selectedRooms;
        } else {
            // Jika selected_rooms belum ada atau tidak valid, buat yang baru
            $selectedRooms = [
                $cart->room_id => [
                    'check_in' => $cart->check_in_date->format('Y-m-d'),
                    'check_out' => $cart->check_out_date->format('Y-m-d'),
                    'adult_count' => $cart->adult_count,
                    'kids_count' => $cart->kids_count,
                    'quantity' => $quantity,
                    'price' => $cart->price
                ]
            ];
            $cart->selected_rooms = $selectedRooms;
        }
        
        $cart->save();
        
        return $cart;
    }

    public function removeItem($cartId)
    {
        return Cart::findOrFail($cartId)->delete();
    }

    public function clearCart()
    {
        $sessionId = Session::get('cart_session_id');
        return Cart::where('session_id', $sessionId)->delete();
    }

    public function getTotal()
    {
        $sessionId = Session::get('cart_session_id');
        return Cart::where('session_id', $sessionId)->sum('total_price');
    }

    public function applyVoucher($voucherCode)
    {
        $sessionId = Session::get('cart_session_id');
        return Cart::where('session_id', $sessionId)
            ->update(['voucher_code' => $voucherCode]);
    }

    public function getCartSummary()
    {
        $items = $this->getItems();
        $total = $this->getTotal();
        $totalDiscount = 0; // Implementasi diskon bisa ditambahkan sesuai kebutuhan
        $finalTotal = $total - $totalDiscount;

        return [
            'items' => $items,
            'total' => $total,
            'total_discount' => $totalDiscount,
            'final_total' => $finalTotal,
            'item_count' => $items->count()
        ];
    }
} 