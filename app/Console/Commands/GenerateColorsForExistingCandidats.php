<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Candidat;
use ColorThief\ColorThief;
use Illuminate\Support\Facades\Storage;

class GenerateColorsForExistingCandidats extends Command
{
    protected $signature = 'candidats:generate-colors';
    protected $description = 'Générer les couleurs dominantes pour les candidats existants';

    public function handle()
    {
        $candidats = Candidat::whereNull('couleur_dominante')->get();

        foreach ($candidats as $candidat) {
            if (!$candidat->photo_url) {
                continue; // pas de photo
            }

            $relativePath = str_replace('/storage/', '', $candidat->photo_url);
            $fullPath = storage_path('app/public/' . $relativePath);

            if (!file_exists($fullPath)) {
                $this->warn("Fichier non trouvé : {$fullPath}");
                continue;
            }

            $color = ColorThief::getColor($fullPath);
            $hex = sprintf("#%02x%02x%02x", $color[0], $color[1], $color[2]);
            $darker = sprintf("#%02x%02x%02x",
                max(0, $color[0] * 0.7),
                max(0, $color[1] * 0.7),
                max(0, $color[2] * 0.7)
            );

            $candidat->update([
                'couleur_dominante' => $hex,
                'couleur_dominante_sombre' => $darker,
            ]);

            $this->info("Candidat {$candidat->nom_complet} mis à jour. { $hex} - { $darker }");
        }

        $this->info('Toutes les couleurs ont été générées !');
    }
}
