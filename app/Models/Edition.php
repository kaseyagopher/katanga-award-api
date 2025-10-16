<?php

namespace App\Models;

use App\Models\Vote;
use App\Models\Admin;
use App\Models\Candidat;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Model;

class Edition extends Model
{
    protected $table = 'editions';

    protected $fillable = [
        'titre', 'theme', 'statut', 'admin_id', 'uuid'
    ];

    // Une édition appartient à un admin
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    // Une édition a plusieurs catégories
    public function categories()
    {
        return $this->hasMany(Categorie::class, 'edition_id');
    }

    public function candidats() {
        return $this->hasMany(Candidat::class, 'edition_id');
    }

    public function votes() {
        return $this->hasMany(Vote::class, 'edition_id');
    }
}
