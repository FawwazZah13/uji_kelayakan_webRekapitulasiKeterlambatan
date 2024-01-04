<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

public function rayons()
{
    return $this->hasMany(rayons::class);
}



// public function hasRole($role, $rayon)
// {
//     return $this->role === $role && $this->rayon->name === $rayon;
// }


public function isAdmin()
{
    return $this->role === 'admin'; 
}
public function isPembimbingSiswa()
{
    return $this->role === 'ps'; 
}

public function rayon()
{
    return $this->belongsTo(rayons::class);
}



    
    // public function role()
    // {
    //     return $this->belongsTo(users::class);
    // }
}
