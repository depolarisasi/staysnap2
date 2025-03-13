<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Voucher;
use Illuminate\Support\Facades\Session;
 
class BookingController extends Controller
{
    public function initiateBooking(Request $request)
    {
        // Validasi
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required|integer|min:1'
        ]);

        // Hitung total harga dengan dynamic pricing
        $total = $this->calculateTotalPrice(
            $request->room_id,
            $request->check_in,
            $request->check_out
        );

        // Simpan ke keranjang
        $cart = Cart::updateOrCreate(
            ['session_id' => $request->session()->getId()],
            ['selected_rooms' => json_encode($request->rooms)]
        );

        return redirect()->route('booking.guest-info');
    }

    public function applyVoucher(Request $request)
    {
        $voucher = Voucher::where('code', $request->code)
            ->where('valid_from', '<=', now())
            ->where('valid_to', '>=', now())
            ->whereRaw('used_count < usage_limit')
            ->firstOrFail();

        // Validasi kamar yang eligible
        if ($voucher->rooms->count() > 0 && !$voucher->rooms->contains($request->room_id)) {
            abort(422, 'Voucher tidak berlaku untuk kamar ini');
        }

        Session::put('active_voucher', [
            'id' => $voucher->id,
            'type' => $voucher->type,
            'value' => $voucher->value
        ]);
    }
}
