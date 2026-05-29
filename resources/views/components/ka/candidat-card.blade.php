@props(['candidat', 'categorie' => null, 'showVoteLink' => true])

@php
  $bgFrom = $candidat->couleur_dominante ?? '#A28224';
  $bgTo = $candidat->couleur_dominante_sombre ?? '#5c4810';
  $votePrice = config('vote.price_cdf');
  $currency = config('vote.currency_label');
@endphp

<article {{ $attributes->merge(['class' => 'group relative flex flex-col items-center rounded-2xl p-5 text-center shadow-lg transition duration-300 hover:scale-[1.02] hover:shadow-ka-glow ring-1 ring-black/5']) }}
         style="background: linear-gradient(145deg, {{ $bgFrom }}, {{ $bgTo }});">
  <div class="h-24 w-24 overflow-hidden rounded-full border-4 border-white/90 shadow-lg ring-2 ring-ka-yellow/50 mb-3">
    <img src="{{ asset($candidat->photo_url) }}" alt="{{ $candidat->nom_complet }}"
         class="h-full w-full object-cover zoomable cursor-pointer transition group-hover:scale-105">
  </div>
  <h3 class="text-base font-bold text-white drop-shadow-sm line-clamp-2">{{ $candidat->nom_complet }}</h3>
  @if($categorie)
    <p class="text-[11px] text-ka-yellow/90 mt-1 uppercase tracking-wide">{{ $categorie }}</p>
  @else
    <p class="text-[11px] text-white/80 mt-1 italic">Nominé(e)</p>
  @endif
  <div class="mt-4 flex flex-col gap-2 w-full">
    <a href="{{ route('user.candidat.show', $candidat->uuid) }}"
       class="inline-flex items-center justify-center gap-1 w-full rounded-xl bg-ka-yellow px-4 py-2 text-sm font-bold text-neutral-900 hover:bg-white transition">
      Voir le profil
    </a>
    @if($showVoteLink)
      <a href="{{ route('user.vote') }}"
         class="inline-flex items-center justify-center gap-1 w-full rounded-xl border-2 border-white/50 bg-white/20 px-4 py-2 text-sm font-semibold text-white hover:bg-white/30 transition">
        Voter · {{ number_format($votePrice, 0, ',', ' ') }} {{ $currency }}
      </a>
    @endif
  </div>
</article>
