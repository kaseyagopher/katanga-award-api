@extends('layouts.user')

@section('title', $candidat->nom_complet . ' — Katanga Awards')
@section('main-class', 'max-w-lg mx-auto px-4 sm:px-6 py-8')

@section('content')
  <article class="rounded-3xl border-2 border-ka-gold/40 bg-ka-card overflow-hidden shadow-ka-glow">
    <div class="aspect-[4/5] max-h-[420px] overflow-hidden ring-b-2 ring-ka-yellow">
      <img src="{{ asset($candidat->photo_url) }}" alt="{{ $candidat->nom_complet }}"
           class="w-full h-full object-cover zoomable cursor-pointer">
    </div>
    <div class="p-6 sm:p-8 text-center">
      <span class="inline-block rounded-full bg-ka-gold/20 px-3 py-1 text-xs font-bold uppercase tracking-wide text-ka-yellow mb-3">
        {{ $candidat->categorie->nom_categorie ?? 'Nominé' }}
      </span>
      <h1 class="text-2xl sm:text-3xl font-bold text-white">{{ $candidat->nom_complet }}</h1>
      @if($edition ?? null)
        <p class="text-sm text-neutral-500 mt-1">{{ $edition->titre }}</p>
      @endif

      <div class="mt-6 rounded-xl bg-black/50 border border-ka-gold/20 p-5 text-left text-sm text-neutral-300 leading-relaxed">
        {{ $candidat->description ?? 'Aucune description.' }}
      </div>

      <div class="mt-8 flex flex-col gap-3">
        @if($editionActive ?? $edition ?? null)
          <x-ka.button :href="route('user.vote')" variant="primary" size="lg" class="w-full">
            <span class="material-icons">payments</span>
            Voter · {{ number_format($votePrice ?? 0, 0, ',', ' ') }} {{ $voteCurrency ?? 'CDF' }}
          </x-ka.button>
        @endif
        <div class="flex gap-3">
          <x-ka.button type="button" variant="outline" size="sm" class="flex-1" id="shareBtn">
            <span class="material-icons text-[18px]">share</span>
            Partager
          </x-ka.button>
          <x-ka.button :href="route('user.index')" variant="ghost" size="sm" class="flex-1">
            Retour
          </x-ka.button>
        </div>
      </div>
    </div>
  </article>
@endsection

@push('scripts')
<script>
  document.getElementById('shareBtn')?.addEventListener('click', async () => {
    const d = { title: '{{ $candidat->nom_complet }}', text: 'Soutenez {{ $candidat->nom_complet }} !', url: location.href };
    if (navigator.share) { try { await navigator.share(d); } catch(e) {} }
    else window.open('https://wa.me/?text=' + encodeURIComponent(d.text + ' ' + d.url), '_blank');
  });
</script>
@endpush
