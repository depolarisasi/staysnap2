<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\HandlesImageUploads;

class Amenity extends Model
{
    use HasFactory;
    use HandlesImageUploads;
 
    protected $fillable = ['name', 'icon'];

    // Konfigurasi image handler
    protected $imageDirectory = 'amenities';
    protected $imageWidth = 500;
    protected $imageHeight = 500;
    protected $imageQuality = 100;
    protected $imageFieldName = 'image';


    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'amenity_room');
    }
}
