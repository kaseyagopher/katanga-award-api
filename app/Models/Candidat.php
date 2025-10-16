<?php

namespace App\Models;

use App\Models\Vote;
use App\Models\Edition;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    protected $table = 'candidats';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName()
{
    return 'uuid';
}

    protected $fillable = [
        'nom_complet', 'photo_url', 'description', 'categorie_id', 'edition_id', 'couleur_dominante', 'couleur_dominante_sombre', 'uuid'
    ];

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
