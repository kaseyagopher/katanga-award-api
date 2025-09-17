<?php

namespace App\Models;

use App\Models\Edition;
use App\Models\Candidat;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $table = 'votes';
    // Un vote est effectué pour un seul candidat.
    public function candidat() {
        return $this->belongsTo(Candidat::class, 'candidat_id');
    }

    // Chaque vote est rattaché à une édition
    public function edition() {
        return $this->belongsTo(Edition::class, 'edition_id');
    }

    // Un vote appartient à un seul utilisateur (user)
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Un vote est associé à une seule catégorie dans une édition donnée.
    public function categorie() {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }


}
