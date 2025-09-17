<?php

namespace App\Models;

use App\Models\Edition;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';

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
