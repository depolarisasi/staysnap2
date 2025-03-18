<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; 
use App\Models\BranchPhoto;
class Branch extends Model
{
    use HasFactory;
    protected $table = 'branches'; 
    protected $primaryKey = 'id';
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */    
     
    protected $fillable = ['branch_name', 'branch_address', 'branch_logo', 'branch_phone', 'branch_web','branch_star','branch_maps_link','branch_province','branch_city','branch_thumbnail']; 

    public function photos()
    {
        return $this->hasMany(BranchPhoto::class, 'branch_id'); // Pastikan foreign key sesuai
    }

    // Gunakan event deleting untuk menghapus otomatis `branch_photos`
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($branch) {
            $branch->photos()->delete();
        });
    }
      
}
