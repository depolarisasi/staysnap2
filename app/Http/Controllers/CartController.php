<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->middleware(function ($request, $next) {
            if (!session()->has('cart_session_id')) {
                session()->put('cart_session_id', uniqid());
            }
            return $next($request);
        });
    }

    public function add(Request $request)
    {
        try {
            // Validasi request
            $validator = \Validator::make($request->all(), [
                'selected_rooms' => 'required|json',
            ]);

            if ($validator->fails()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validasi gagal',
                        'errors' => $validator->errors()
                    ], 422);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Decode selected_rooms
            $selectedRooms = json_decode($request->selected_rooms, true);
            
            if (!is_array($selectedRooms)) {
                throw new \Exception('Format data selected_rooms tidak valid');
            }

            // Validasi data di dalam selected_rooms
            foreach ($selectedRooms as $index => $room) {
                $roomValidator = \Validator::make($room, [
                    'room_id' => 'required|exists:rooms,id',
                    'check_in_date' => 'required|date',
                    'check_out_date' => 'required|date|after:check_in_date',
                    'adult_count' => 'required|integer|min:1',
                    'kids_count' => 'required|integer|min:0',
                    'quantity' => 'required|integer|min:1'
                ]);

                if ($roomValidator->fails()) {
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Validasi data kamar gagal',
                            'errors' => $roomValidator->errors(),
                            'index' => $index
                        ], 422);
                    }
                    return redirect()->back()->withErrors($roomValidator)->withInput();
                }
            }

            foreach ($selectedRooms as $room) {
                $data = [
                    'room_id' => $room['room_id'],
                    'check_in_date' => $room['check_in_date'],
                    'check_out_date' => $room['check_out_date'],
                    'adult_count' => $room['adult_count'],
                    'kids_count' => $room['kids_count'],
                    'quantity' => $room['quantity'],
                    'voucher_code' => $request->voucher_code ?? null
                ];
                
                $cartItem = $this->cartService->addItem($data);
            }

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item berhasil ditambahkan ke keranjang',
                    'data' => $this->cartService->getCartSummary()
                ]);
            }

            return redirect()->back()->with('success', 'Item berhasil ditambahkan ke keranjang');
        } catch (\Exception $e) {
            \Log::error('Cart add error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan item: ' . $e->getMessage()
                ], 422);
            }
            
            return redirect()->back()->with('error', 'Gagal menambahkan item: ' . $e->getMessage());
        }
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'adult_count' => 'required|integer|min:1',
            'kids_count' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:1',
            'voucher_code' => 'nullable|string'
        ]);

        // Validasi tanggal check-in dan check-out
        $checkIn = Carbon::parse($request->check_in_date);
        $checkOut = Carbon::parse($request->check_out_date);
        
        if ($checkIn->diffInDays($checkOut) > 30) {
            return response()->json([
                'success' => false,
                'message' => 'Durasi menginap tidak boleh lebih dari 30 hari'
            ], 422);
        }

        try {
            $cartItem = $this->cartService->addItem($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Item berhasil ditambahkan ke keranjang',
                'data' => $cartItem
            ]);
        } catch (\Exception $e) {
            \Log::error('Add to cart error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan item: ' . $e->getMessage()
            ], 422);
        }
    }

    public function getCart()
    {
        $cartSummary = $this->cartService->getCartSummary();

        return response()->json([
            'success' => true,
            'data' => $cartSummary
        ]);
    }

    public function updateQuantity(Request $request, $cartId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = $this->cartService->updateQuantity($cartId, $request->quantity);

        return response()->json([
            'success' => true,
            'message' => 'Jumlah item berhasil diperbarui',
            'data' => $cartItem
        ]);
    }

    public function removeFromCart($cartId)
    {
        $this->cartService->removeItem($cartId);

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil dihapus dari keranjang'
        ]);
    }

    public function clearCart()
    {
        $this->cartService->clearCart();

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dikosongkan'
        ]);
    }

    public function applyVoucher(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|string'
        ]);

        $this->cartService->applyVoucher($request->voucher_code);

        return response()->json([
            'success' => true,
            'message' => 'Voucher berhasil diterapkan'
        ]);
    }

    public function getCartSummary()
    {
        $cartSummary = $this->cartService->getCartSummary();

        return response()->json([
            'success' => true,
            'data' => $cartSummary
        ]);
    }

    public function getCartPage()
    {
        $cartSummary = $this->cartService->getCartSummary();
        
        if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'data' => $cartSummary
            ]);
        }
        
        return view('frontpage.cart', compact('cartSummary'));
    }
}
