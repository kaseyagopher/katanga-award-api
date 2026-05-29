<?php

namespace App\Providers;

use App\Models\Edition;
use App\Models\Vote;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer(['layouts.user', 'components.nav-user'], function ($view) {
            $editionActive = Edition::where('statut', 1)->first();

            $view->with([
                'editionActive' => $editionActive,
                'votePrice' => config('vote.price_cdf'),
                'voteCurrency' => config('vote.currency_label'),
                'totalVotes' => Vote::when($editionActive, fn ($q) => $q->where('edition_id', $editionActive->id))->count(),
            ]);
        });
    }
}
