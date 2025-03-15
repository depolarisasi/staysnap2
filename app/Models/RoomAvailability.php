<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class RoomAvailability extends Model
{
    use HasFactory;
    protected $fillable = ['room_id', 'date', 'available'];
    
    protected $casts = [
        'date' => 'date',
        'available' => 'integer'
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
    public function scopeForPeriod(Builder $query, $start, $end)
{
    return $query->whereBetween('date', [$start, $end]);
}
}
