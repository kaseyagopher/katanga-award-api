<?php

namespace App\Models;

use App\Models\Vote;
use App\Models\Admin;
use App\Models\Edition;
use App\Models\Candidat;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
     protected $table = 'categories';
     protected $fillable = [
        'nom_categorie', 'edition_id', 'admin_id'
     ];

    // Une catégorie appartient à un admin
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    // Une catégorie appartient à une édition
    public function edition()
    {
        return $this->belongsTo(Edition::class, 'edition_id');
    }

    public function candidats() {
        return $this->hasMany(Candidat::class, 'categorie_id');
    }

    public function votes() {
        return $this->hasMany(Vote::class, 'categorie_id');
    }

}
