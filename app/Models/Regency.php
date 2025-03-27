<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Province; 
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Branch;
class Regency extends Model
{
    use HasFactory;
    protected $fillable = ['province_id', 'regency'];
    
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class, 'branch_city');
    }
}
