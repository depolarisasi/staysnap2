<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class BranchPhoto extends Model
{
    use HasFactory;
    protected $fillable = [
        'branch_id',
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
