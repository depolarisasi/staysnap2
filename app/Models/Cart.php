<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'adult_count',
        'kids_count',
        'quantity',
        'price',
        'total_price',
        'voucher_code',
        'discount_amount',
        'selected_rooms',
        'user_id'
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'selected_rooms' => 'json'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
