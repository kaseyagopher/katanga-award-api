<?php

namespace App\Models;

use App\Models\Vote;
use App\Models\Edition;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    protected $table = 'candidats';

    public function categorie() {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function edition() {
        return $this->belongsTo(Edition::class, 'edition_id');
    }

    public function votes() {
        return $this->hasMany(Vote::class, 'candidat_id');
    }
}
