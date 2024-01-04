<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rayons extends Model
{
    use HasFactory;

    protected $fillable = [
        'rayon',
        'user_id',
    ];

    // public function students()
    // {
    //     return $this->hasMany(students::class, 'rayon_id', 'id');
    // }
    public function students()
{
    return $this->hasMany(students::class);
}
public function users(){
    return $this->hasMany(users::class);
}

public function rayon()
    {
        return $this->hasMany(students::class);
    }
public function lates(){
    return $this->hasMany(lates::class);
}
}
