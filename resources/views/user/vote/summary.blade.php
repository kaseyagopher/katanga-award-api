@extends('layouts.user')

@section('title', 'Confirmation — Katanga Awards')
@section('main-class', 'max-w-3xl mx-auto px-4 sm:px-6 py-8')

@section('content')
  <div class="text-center mb-10">
    <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-green-500/20 ring-4 ring-green-500/30">
      <span class="material-icons text-5xl text-green-400">check_circle</span>
    </div>
    <h1 class="text-3xl font-bold ka-gradient-text">Vote confirmé !</h1>
    <p class="mt-2 text-neutral-400">{{ $editionActive->titre ?? '' }}</p>
    <p class="mt-2 font-mono text-xs text-ka-gold/80">{{ $paymentReference }}</p>
  </div>

  <div class="rounded-2xl border-2 border-ka-gold/40 bg-ka-card p-6 sm:p-8 shadow-ka-glow">
    <div class="flex flex-col sm:flex-row justify-between gap-4 mb-8 pb-6 border-b border-ka-gold/20">
      <div>
        <p class="text-sm text-neutral-500">Montant payé</p>
        <p class="text-3xl font-bold text-ka-yellow">{{ number_format($totalPaid, 0, ',', ' ') }} CDF</p>
      </div>
      <div class="text-sm text-neutral-400 self-end">{{ $votes->count() }} vote(s)</div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
      @foreach($votes as $vote)
        <div class="rounded-xl border border-ka-gold/30 bg-black/40 p-4 flex gap-4 items-center">
          <img src="{{ asset($vote->candidat->photo_url) }}" alt=""
               class="h-16 w-16 rounded-full object-cover ring-2 ring-ka-yellow shrink-0">
          <div>
            <span class="text-[10px] uppercase tracking-wide text-ka-gold font-bold">{{ $vote->categorie->nom_categorie }}</span>
            <p class="font-bold text-white mt-0.5">{{ $vote->candidat->nom_complet }}</p>
            <p class="text-xs text-neutral-500 mt-1">{{ number_format($vote->montant, 0, ',', ' ') }} CDF</p>
          </div>
        </div>
      @endforeach
    </div>

    <div class="flex flex-col sm:flex-row gap-3 justify-center">
      <x-ka.button :href="route('user.index')" variant="primary">
        <span class="material-icons text-[18px]">home</span>
        Accueil
      </x-ka.button>
      <x-ka.button :href="route('user.vote')" variant="outline">
        Nouveau vote
      </x-ka.button>
    </div>
  </div>
@endsection
