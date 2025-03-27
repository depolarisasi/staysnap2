<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Branch;

class BranchTag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    public $timestamps = false; // Hanya untuk table pivot

    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class);
    }
}
