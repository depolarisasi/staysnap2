<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RoomPolicy extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'description'];

    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'policy_room');
    }
}
