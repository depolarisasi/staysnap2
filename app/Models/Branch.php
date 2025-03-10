<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    protected $fillable = ['branch_name', 'branch_address', 'branch_logo', 'branch_phone', 'branch_web',]; 

     // Accessor untuk URL logo lengkap
      
}
