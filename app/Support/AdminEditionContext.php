<?php

namespace App\Support;

use App\Models\Edition;

class AdminEditionContext
{
    public static function active(): ?Edition
    {
        return Edition::where('statut', 1)->first();
    }

    public static function consultation(): ?Edition
    {
        $id = session('admin_consultation_edition_id');

        return $id ? Edition::find($id) : null;
    }

    /** Édition utilisée pour filtrer les vues admin (consultation prioritaire). */
    public static function viewing(): ?Edition
    {
        return static::consultation() ?? static::active();
    }

    public static function inConsultation(): bool
    {
        return session()->has('admin_consultation_edition_id');
    }
}
