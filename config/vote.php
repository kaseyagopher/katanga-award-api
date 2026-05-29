<?php

return [

    /*
    | Prix unitaire d'un vote (en francs congolais — CDF).
    */
    'price_cdf' => (int) env('VOTE_PRICE_CDF', 1000),

    /*
    | Devise affichée côté interface.
    */
    'currency_label' => env('VOTE_CURRENCY_LABEL', 'CDF'),

];
