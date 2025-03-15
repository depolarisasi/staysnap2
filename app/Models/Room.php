<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;

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

    protected static function booted()
{
    static::created(function (Room $room) {
        $room->generateInitialAvailability();
    });
}

public function generateInitialAvailability()
{
    $startDate = now()->startOfDay();
    $endDate = now()->addYear()->endOfDay();
    
    $this->generateAvailability($startDate, $endDate);
}

    public function generateAvailability(Carbon $startDate, Carbon $endDate)
    {
   
        $period = new \DatePeriod(
            $startDate,
            new \DateInterval('P1D'),
            $endDate
        );
    
        $existingDates = $this->availabilities()
            ->whereBetween('date', [$startDate, $endDate])
            ->pluck('date')
            ->map(fn ($date) => $date->format('Y-m-d'))
            ->toArray();
    
        $availabilityData = [];
        foreach ($period as $date) {
            $dateString = $date->format('Y-m-d');
            
            if (!in_array($dateString, $existingDates)) {
                $availabilityData[] = [
                    'room_id' => $this->id,
                    'date' => $dateString,
                    'available' => $this->stock,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }
    
        // Gunakan insert untuk skip duplicate
        RoomAvailability::insertOrIgnore($availabilityData);
    }
}
