@extends('layouts.user', ['showLoader' => true])

@section('title', 'Accueil — Katanga Awards')
@section('main-class', 'w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10')

@section('content')
  {{-- Hero --}}
  <section class="relative mb-12 overflow-hidden rounded-3xl ring-2 ring-ka-gold/30 shadow-ka-glow">
    <div id="carousel" class="relative">
      <div class="carousel-inner flex transition-transform duration-500 ease-out">
        @foreach (['affiche_officiel.jpg','IMG_6309.JPG','photo_2025-10-08_15-11-01.jpg','photo_2025-10-08_15-10-57.jpg','photo_2025-10-08_15-18-37.jpg','photo_2025-10-08_15-11-08.jpg'] as $slide)
          <div class="carousel-item min-w-full shrink-0 relative aspect-[21/9] sm:aspect-[2.5/1] min-h-[220px]">
            <img src="{{ asset($slide) }}" class="absolute inset-0 w-full h-full object-cover" alt="">
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-black/30"></div>
          </div>
        @endforeach
      </div>
      <div class="absolute inset-0 z-10 flex flex-col items-center justify-center text-center px-4 pointer-events-none">
        @if($edition ?? null)
          <span class="mb-3 inline-block rounded-full border border-ka-yellow/50 bg-black/60 px-4 py-1 text-xs font-semibold uppercase tracking-widest text-ka-yellow backdrop-blur">
            {{ $edition->titre }} · {{ $edition->theme }}
          </span>
        @endif
        <h1 class="text-3xl sm:text-5xl font-bold ka-gradient-text drop-shadow-lg max-w-3xl">
          Katanga Awards
        </h1>
        <p class="mt-3 text-white/90 text-base sm:text-lg max-w-xl">
          Soutenez vos nominés — chaque vote compte
        </p>
        @if($editionActive ?? null)
          <div class="mt-6 pointer-events-auto">
            <x-ka.button :href="route('user.vote')" variant="primary" size="lg">
              <span class="material-icons">payments</span>
              Voter · {{ number_format($votePrice ?? 0, 0, ',', ' ') }} {{ $voteCurrency ?? 'CDF' }}
            </x-ka.button>
          </div>
        @endif
      </div>
      <button type="button" id="prev" class="absolute left-3 top-1/2 z-20 -translate-y-1/2 rounded-full bg-black/70 p-2 text-ka-yellow hover:bg-ka-gold hover:text-white transition" aria-label="Précédent">&#10094;</button>
      <button type="button" id="next" class="absolute right-3 top-1/2 z-20 -translate-y-1/2 rounded-full bg-black/70 p-2 text-ka-yellow hover:bg-ka-gold hover:text-white transition" aria-label="Suivant">&#10095;</button>
    </div>
    <div id="carousel-dots" class="absolute bottom-4 left-0 right-0 z-20 flex justify-center gap-2"></div>
  </section>

  {{-- Stats --}}
  @if($edition ?? null)
    <section class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 mb-12">
      <div class="rounded-2xl border border-ka-gold/30 bg-ka-card p-4 text-center">
        <p class="text-2xl font-bold text-ka-yellow">{{ $categories->count() }}</p>
        <p class="text-xs text-neutral-400 mt-1">Catégories</p>
      </div>
      <div class="rounded-2xl border border-ka-gold/30 bg-ka-card p-4 text-center">
        <p class="text-2xl font-bold text-ka-yellow">{{ $categories->sum(fn($c) => $c->candidats->count()) }}</p>
        <p class="text-xs text-neutral-400 mt-1">Nominés</p>
      </div>
      <div class="rounded-2xl border border-ka-gold/30 bg-ka-card p-4 text-center">
        <p class="text-2xl font-bold text-ka-yellow">{{ number_format($totalVotes ?? 0, 0, ',', ' ') }}</p>
        <p class="text-xs text-neutral-400 mt-1">Votes</p>
      </div>
      <div class="rounded-2xl border border-ka-gold/30 bg-ka-card p-4 text-center col-span-2 sm:col-span-1">
        <p class="text-lg font-bold text-ka-amber">{{ number_format($votePrice ?? 0, 0, ',', ' ') }}</p>
        <p class="text-xs text-neutral-400 mt-1">{{ $voteCurrency ?? 'CDF' }} / vote</p>
      </div>
    </section>
  @endif

  {{-- Nominés avec filtre --}}
  @if($categories->isNotEmpty())
    <section x-data="{ cat: 'all' }">
      <x-ka.section-heading subtitle="Les nominés" icon="groups">
        Choisissez votre catégorie
      </x-ka.section-heading>

      <div class="flex flex-wrap gap-2 mb-8">
        <button type="button" @click="cat = 'all'"
                :class="cat === 'all' ? 'bg-ka-gold text-white' : 'bg-ka-card text-neutral-400 border border-neutral-800'"
                class="rounded-full px-4 py-2 text-sm font-semibold transition">
          Toutes
        </button>
        @foreach($categories as $c)
          <button type="button" @click="cat = '{{ $c->id }}'"
                  :class="cat === '{{ $c->id }}' ? 'bg-ka-gold text-white' : 'bg-ka-card text-neutral-400 border border-neutral-800'"
                  class="rounded-full px-4 py-2 text-sm font-semibold transition">
            {{ $c->nom_categorie }}
          </button>
        @endforeach
      </div>

      @foreach($categories as $categorie)
        <div x-show="cat === 'all' || cat === '{{ $categorie->id }}'" x-cloak class="mb-12">
          <h3 class="flex items-center gap-2 text-lg font-bold text-ka-yellow mb-5 border-l-4 border-ka-gold pl-3">
            {{ mb_strtoupper($categorie->nom_categorie) }}
          </h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($categorie->candidats as $candidat)
              <x-ka.candidat-card :candidat="$candidat" :categorie="$categorie->nom_categorie" :show-vote-link="false" />
            @endforeach
          </div>
        </div>
      @endforeach
    </section>
  @else
    <div class="rounded-2xl border border-dashed border-ka-gold/40 bg-ka-card p-12 text-center">
      <span class="material-icons text-5xl text-ka-gold/50">event_busy</span>
      <p class="mt-4 text-neutral-400">Aucune édition active ou aucun nominé pour le moment.</p>
    </div>
  @endif

  {{-- Sponsors --}}
  <section class="mt-20 pt-12 border-t border-ka-gold/20">
    <x-ka.section-heading subtitle="Partenaires" icon="handshake">
      Nos sponsors
    </x-ka.section-heading>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 items-center">
      @foreach (['tfm.jpg','Baraka.jpg','bgfibanque.jpg','novotel.jpg','ntayrock.jpg','mbegu.jpg','loft_key.jpg','morco.jpg','malaika.jpg','inpp.jpg','mannel.jpg','silocongo.jpg','topmarket.jpg','tsm.jpg'] as $image)
        <div class="flex justify-center rounded-xl bg-white/5 p-4 hover:bg-ka-gold/10 transition">
          <img src="{{ asset($image) }}" alt="Sponsor" class="h-16 sm:h-20 object-contain grayscale hover:grayscale-0 transition duration-500 zoomable cursor-pointer">
        </div>
      @endforeach
    </div>
  </section>
@endsection

@push('scripts')
<script>
  const carousel = document.querySelector('#carousel .carousel-inner');
  const items = document.querySelectorAll('.carousel-item');
  const dotsContainer = document.getElementById('carousel-dots');
  let index = 0;
  if (carousel && items.length) {
    items.forEach((_, i) => {
      const dot = document.createElement('button');
      dot.type = 'button';
      dot.className = 'h-2 rounded-full bg-neutral-600 transition-all';
      dot.addEventListener('click', () => show(i));
      dotsContainer.appendChild(dot);
    });
    const dots = dotsContainer.querySelectorAll('button');
    function show(i) {
      index = (i + items.length) % items.length;
      carousel.style.transform = `translateX(${-index * 100}%)`;
      dots.forEach((d, idx) => {
        d.classList.toggle('bg-ka-yellow', idx === index);
        d.classList.toggle('w-6', idx === index);
        d.classList.toggle('w-2', idx !== index);
      });
    }
    document.getElementById('prev')?.addEventListener('click', () => show(index - 1));
    document.getElementById('next')?.addEventListener('click', () => show(index + 1));
    setInterval(() => show(index + 1), 5000);
    show(0);
  }
</script>
@endpush
