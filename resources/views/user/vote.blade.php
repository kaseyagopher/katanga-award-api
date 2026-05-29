@extends('layouts.user')

@section('title', 'Vote — Katanga Awards')
@section('main-class', 'max-w-2xl mx-auto px-4 sm:px-6 py-8')

@section('content')
@php
  $stepCount = $categories->count();
  $totalSteps = $stepCount + 1;
  $categoryIds = $categories->pluck('id')->values();
  $candidatNames = [];
  foreach ($categories as $cat) {
      foreach ($cat->candidats as $can) {
          $candidatNames[$can->id] = $can->nom_complet;
      }
  }
@endphp

<div x-data="{
  step: 0,
  total: {{ $totalSteps }},
  selections: {},
  categoryIds: @js($categoryIds),
  candidatNames: @js($candidatNames),
  get progress() { return Math.round(((this.step + 1) / this.total) * 100); },
  canNext() {
    if (this.step >= {{ $stepCount }}) return true;
    const catId = this.categoryIds[this.step];
    return !!this.selections[catId];
  },
  next() { if (this.step < this.total - 1 && this.canNext()) this.step++; },
  prev() { if (this.step > 0) this.step--; }
}">

  {{-- En-tête --}}
  <div class="text-center mb-8">
    <p class="text-xs font-semibold uppercase tracking-widest text-ka-yellow mb-2">Vote payant</p>
    <h1 class="text-2xl sm:text-3xl font-bold text-white">Parcours de vote</h1>
    <p class="mt-2 text-sm text-neutral-400">{{ $edition->titre }}</p>
    <p class="mt-3 inline-flex items-center gap-2 rounded-full border border-ka-gold/40 bg-ka-gold/10 px-4 py-1.5 text-sm text-ka-yellow">
      <span class="material-icons text-base">payments</span>
      {{ number_format($votePrice ?? config('vote.price_cdf'), 0, ',', ' ') }} {{ $voteCurrency ?? config('vote.currency_label') }} par catégorie
    </p>
  </div>

  {{-- Progression --}}
  <div class="mb-8">
    <div class="flex justify-between text-xs text-neutral-500 mb-2">
      <span>Étape <span x-text="step + 1"></span> / <span x-text="total"></span></span>
      <span x-text="progress + '%'"></span>
    </div>
    <div class="h-2 rounded-full bg-neutral-800 overflow-hidden">
      <div class="h-full bg-gradient-to-r from-ka-gold via-ka-yellow to-ka-amber transition-all duration-300"
           :style="'width:' + progress + '%'"></div>
    </div>
  </div>

  <form action="{{ route('vote.store') }}" method="POST">
    @csrf
    <input type="hidden" name="edition_id" value="{{ $edition->id }}">

    @foreach($categories as $index => $categorie)
      <div x-show="step === {{ $index }}" x-cloak
           class="rounded-2xl border border-ka-gold/40 bg-ka-card p-5 sm:p-6 shadow-lg">
        <h2 class="flex items-center gap-2 text-xl font-bold text-ka-yellow mb-1">
          <span class="material-icons">category</span>
          {{ $categorie->nom_categorie }}
        </h2>
        <p class="text-sm text-neutral-500 mb-5">Sélectionnez un nominé</p>

        <div class="grid grid-cols-2 gap-3">
          @foreach($categorie->candidats as $candidat)
            <label class="cursor-pointer">
              <input type="radio"
                     name="votes[{{ $categorie->id }}]"
                     value="{{ $candidat->id }}"
                     x-model="selections[{{ $categorie->id }}]"
                     class="peer sr-only"
                     required>
              <div class="flex flex-col items-center rounded-xl border-2 border-neutral-700 bg-black/40 p-3 transition
                          peer-checked:border-ka-yellow peer-checked:bg-ka-gold/15 peer-checked:shadow-ka-glow
                          hover:border-ka-gold/50">
                <img src="{{ asset($candidat->photo_url) }}" alt=""
                     class="h-20 w-20 rounded-full object-cover border-2 border-neutral-600 mb-2
                            peer-checked:border-ka-yellow">
                <span class="text-xs font-semibold text-white text-center line-clamp-2">{{ $candidat->nom_complet }}</span>
              </div>
            </label>
          @endforeach
        </div>
      </div>
    @endforeach

    {{-- Récapitulatif --}}
    <div x-show="step === {{ $stepCount }}" x-cloak
         class="rounded-2xl border-2 border-ka-yellow bg-ka-gold/10 p-5 sm:p-6">
      <h2 class="text-xl font-bold text-ka-yellow mb-4 flex items-center gap-2">
        <span class="material-icons">fact_check</span>
        Vérifiez votre sélection
      </h2>
      <ul class="space-y-3 mb-6">
        @foreach($categories as $categorie)
          <li class="flex justify-between gap-2 text-sm border-b border-ka-gold/20 pb-2">
            <span class="text-neutral-400">{{ $categorie->nom_categorie }}</span>
            <span class="text-white font-medium text-right"
                  x-text="candidatNames[selections[{{ $categorie->id }}]] || '—'"></span>
          </li>
        @endforeach
      </ul>
      <div class="flex justify-between items-center rounded-xl bg-black/50 p-4 mb-6">
        <span class="text-neutral-300">Total estimé</span>
        <span class="text-2xl font-bold text-ka-yellow">
          {{ number_format($categories->count() * ($votePrice ?? config('vote.price_cdf')), 0, ',', ' ') }}
          {{ $voteCurrency ?? config('vote.currency_label') }}
        </span>
      </div>
      <x-ka.button type="submit" variant="primary" size="lg" class="w-full">
        <span class="material-icons">arrow_forward</span>
        Continuer vers le paiement
      </x-ka.button>
    </div>

    {{-- Navigation --}}
    <div class="flex justify-between mt-6 gap-3" x-show="step < {{ $stepCount }}">
      <button type="button" @click="prev()" x-show="step > 0"
              class="px-5 py-2.5 rounded-xl border border-neutral-700 text-neutral-300 hover:border-ka-gold hover:text-ka-yellow transition">
        Précédent
      </button>
      <div class="flex-1" x-show="step === 0"></div>
      <button type="button" @click="next()" :disabled="!canNext()"
              class="ml-auto px-6 py-2.5 rounded-xl bg-ka-gold text-white font-semibold disabled:opacity-40 hover:bg-ka-amber hover:text-black transition">
        Suivant
      </button>
    </div>
  </form>
</div>
@endsection
