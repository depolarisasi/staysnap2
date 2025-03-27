<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; 
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\BranchPhoto;
use App\Models\BranchTag;
use App\Models\BranchFacilities;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     
    protected $fillable = ['branch_name', 'branch_address', 'branch_logo', 'branch_phone', 'branch_web','branch_star','branch_maps_link','branch_province','branch_city','branch_thumbnail','branch_description']; 

    public function photos()
    {
        return $this->hasMany(BranchPhoto::class, 'branch_id'); // Pastikan foreign key sesuai
    }

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(
            BranchFacilities::class,       // Model tujuan yang benar
            'facilities_branch',   // Nama tabel pivot
            'branch_id',           // FK untuk branch di tabel pivot
            'facilities_id'          // FK untuk facility di tabel pivot
        );
    }

    /**
     * Relasi ke Province
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'branch_province');
    }

    /**
     * Relasi ke Regency (Kabupaten/Kota)
     */
    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class, 'branch_city');
    }

    public function tags()
    {
        return $this->belongsToMany(BranchTag::class, 'branch_branch_tag')
                    ->withTimestamps(); // Aktifkan timestamp
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
