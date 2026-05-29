@extends('layouts.user', ['showLoader' => true])

@section('title', 'À propos — Katanga Awards')

@section('content')
  <x-ka.section-heading subtitle="Notre histoire" icon="info">
    À propos de Katanga Awards
  </x-ka.section-heading>

  <p class="text-neutral-400 max-w-3xl leading-relaxed mb-12 -mt-4">
    Le Katanga Awards célèbre les talents et initiatives qui font rayonner notre région.
    Reconnaissance, excellence et créativité au service de la communauté.
  </p>

  <x-ka.section-heading subtitle="Souvenirs" icon="photo_library">
    Galerie des éditions
  </x-ka.section-heading>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-14">
    @foreach (['photo_2025-10-08_15-10-55.jpg','photo_2025-10-08_15-26-53.jpg','photo_2025-10-08_15-11-02.jpg','photo_2025-10-08_15-11-01.jpg','photo_2025-10-08_15-11-06.jpg','photo_2025-10-08_15-10-57.jpg','photo_2025-10-08_15-11-04.jpg','photo_2025-10-08_15-10-59.jpg','photo_2025-10-08_15-11-08.jpg'] as $photo)
      <div class="overflow-hidden rounded-2xl ring-1 ring-ka-gold/20 hover:ring-ka-yellow transition group">
        <img src="{{ asset($photo) }}" alt="" class="w-full h-52 object-cover group-hover:scale-105 transition duration-500 zoomable cursor-pointer">
      </div>
    @endforeach
  </div>

  <div class="rounded-2xl border border-ka-gold/30 bg-gradient-to-br from-ka-gold/15 to-transparent p-8 text-center mb-12">
    <h3 class="text-xl font-bold text-white mb-4">Soutenez vos favoris</h3>
    <x-ka.button :href="route('user.vote')" variant="primary" size="lg">
      <span class="material-icons">payments</span>
      Voter maintenant
    </x-ka.button>
  </div>

  <div class="text-center">
    <p class="text-sm text-ka-yellow font-semibold uppercase tracking-wide mb-4">Suivez-nous</p>
    <div class="flex justify-center gap-4">
      @foreach(['facebook-f' => 'https://web.facebook.com/KatangaAwards', 'instagram' => 'https://www.instagram.com/katangaawards', 'youtube' => 'https://m.youtube.com/@katangaawards6869', 'tiktok' => 'https://www.tiktok.com/@katangaawards'] as $icon => $url)
        <a href="{{ $url }}" target="_blank" rel="noopener"
           class="flex h-12 w-12 items-center justify-center rounded-full bg-ka-card border border-ka-gold/30 text-ka-yellow hover:bg-ka-gold hover:text-white transition">
          <i class="fa-brands fa-{{ $icon }}"></i>
        </a>
      @endforeach
    </div>
  </div>
@endsection
