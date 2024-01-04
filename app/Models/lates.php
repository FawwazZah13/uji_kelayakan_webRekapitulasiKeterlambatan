<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lates extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'nis',
        'rombel',
        'rayon',
        'date_time_late',
        'information',
        'bukti',
    ];


    public function rayon()
{
    return $this->belongsTo(rayons::class, 'rayon', 'rayon');
}

    public function rombel()
    {
        return $this->belongsTo(rombels::class);
    }

    public function student()
    {
        return $this->belongsTo(students::class, 'nis', 'nis');
    }
    // public function student()
    // {
    //     return $this->belongsTo(students::class, 'name', 'name');
    // }
}
