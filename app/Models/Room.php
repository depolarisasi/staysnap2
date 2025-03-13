<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'name',
        'base_price',
        'description',
        'capacity',
        'room_size',
        'special_bonus',
        'stock',
        'status'
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'amenity_room');
    }

    public function policies(): BelongsToMany
    {
        return $this->belongsToMany(RoomPolicy::class, 'policy_room');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(RoomPhotos::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(RoomPrices::class);
    }

    public function availabilities(): HasMany
    {
        return $this->hasMany(RoomAvailability::class);
    }

    public function scopeJoinBranches($query)
    {
        return $query->join('branches', 'branches.id', '=', 'rooms.branch_id')
            ->select('rooms.*', 'branches.name as branch_name');
    }
}
