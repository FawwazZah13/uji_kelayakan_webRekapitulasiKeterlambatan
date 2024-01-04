<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class students extends Model
{
    use HasFactory;
    protected $fillable = [
        'nis',
        'name',
        'rombel_id',
        'rayon_id',
    ];
    public function rombel()
    {
        return $this->belongsTo(rombels::class,'rombel_id');
    }

    // public function rayon()
    // {
    //     return $this->belongsTo(rayons::class);
    //     //belongsTo buat ambil data nya terus dimasukin ke id nya ke table yan mau di ambil
    // }

//     public function rombel()
// {
//     return $this->belongsTo(rombels::class, 'rombel_id');
// }

// public function rayon()
// {
//     return $this->belongsTo(rayons::class);
// }

public function lates()
{
    return $this->hasMany(lates::class, 'nis', 'nis');
}

public function rayon()
    {
        return $this->belongsTo(rayons::class, 'rayon_id');
    }



// public function lates()
// {
//     return $this->hasMany(lates::class,'name', 'name');
// }
    
}
