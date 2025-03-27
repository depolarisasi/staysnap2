<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Branch;
use App\Models\Province;
use App\Models\Regency;

class Province extends Model
{
    use HasFactory;
    protected $fillable = ['province'];
    
    public function regencies(): HasMany
    {
        return $this->hasMany(Regency::class);
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class, 'branch_province');
    }
}
