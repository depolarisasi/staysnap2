<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\HandlesImageUploads;

class BranchFacilities extends Model
{
    use HasFactory;
  
    protected $fillable = ['name', 'icon'];
    
    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'facilities_branch');
    }
}
