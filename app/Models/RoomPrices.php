<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomPrices extends Model
{
    use HasFactory;
    protected $fillable = ['room_id', 'date', 'price'];
    
    protected $casts = [
        'date' => 'date',
        'price' => 'float'
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
