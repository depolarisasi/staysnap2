<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomPhotos extends Model
{
    use HasFactory;
    protected $fillable = [
        'room_id',
        'path'
    ];

    /**
     * Relasi ke model Room
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
