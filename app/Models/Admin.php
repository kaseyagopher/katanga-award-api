<?php

namespace App\Models;

use App\Models\Edition;
use App\Models\Categorie;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable;
    
    protected $table = 'admins';

    protected $fillable = [
        'email', 'password', 'pseudo'
    ];

    // Un admin a plusieurs éditions
    public function editions()
    {
        return $this->hasMany(Edition::class, 'admin_id');
    }

    // Un admin a plusieurs catégories
    public function categories()
    {
        return $this->hasMany(Categorie::class, 'admin_id');
    }
}
