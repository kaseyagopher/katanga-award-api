@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('page-subtitle')
  @if($consultationEdition ?? null)
    Consultation : {{ $consultationEdition->titre }}
  @else
    Vue d'ensemble de l'édition en cours
  @endif
@endsection

@push('head')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
  {{-- Statistiques --}}
  <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-8">
    <div class="relative overflow-hidden rounded-2xl bg-black p-6 text-white shadow-lg">
      <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-ka-gold/20"></div>
      <span class="material-icons text-ka-yellow mb-3">groups</span>
      <p class="text-sm text-neutral-400">Candidats</p>
      <p class="text-3xl font-bold mt-1">{{ $nbCandidats ?? 0 }}</p>
    </div>
    <div class="relative overflow-hidden rounded-2xl bg-ka-gold p-6 text-white shadow-lg shadow-ka-gold/25">
      <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-white/10"></div>
      <span class="material-icons text-ka-yellow mb-3">category</span>
      <p class="text-sm text-white/80">Catégories</p>
      <p class="text-3xl font-bold mt-1">{{ $nbCategories ?? 0 }}</p>
    </div>
    <div class="relative overflow-hidden rounded-2xl bg-neutral-900 p-6 text-white shadow-lg border border-ka-gold/30">
      <span class="material-icons text-ka-yellow mb-3">event</span>
      <p class="text-sm text-neutral-400">Éditions</p>
      <p class="text-3xl font-bold mt-1">{{ $nbEditions ?? 0 }}</p>
    </div>
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-ka-amber to-ka-gold p-6 text-black shadow-lg">
      <span class="material-icons mb-3">how_to_vote</span>
      <p class="text-sm font-medium opacity-80">Votes enregistrés</p>
      <p class="text-3xl font-bold mt-1">{{ $nbVotes ?? 0 }}</p>
    </div>
  </section>

  <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
    {{-- Édition active --}}
    <section class="xl:col-span-1 rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm">
      <h2 class="flex items-center gap-2 text-lg font-bold text-neutral-900 mb-4">
        <span class="material-icons text-ka-gold">{{ ($consultationEdition ?? null) ? 'visibility' : 'flag' }}</span>
        {{ ($consultationEdition ?? null) ? 'Session consultée' : 'Session ouverte' }}
      </h2>
      @if($editionViewing ?? null)
        <dl class="space-y-3 text-sm">
          <div>
            <dt class="text-neutral-500">Titre</dt>
            <dd class="font-semibold text-neutral-900">{{ $editionViewing->titre }}</dd>
          </div>
          <div>
            <dt class="text-neutral-500">Thème</dt>
            <dd class="text-neutral-800">{{ $editionViewing->theme }}</dd>
          </div>
          <div>
            <dt class="text-neutral-500 mb-1">Statut</dt>
            <dd>
              <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-semibold {{ $editionViewing->statut ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                <span class="material-icons text-[14px]">{{ $editionViewing->statut ? 'check_circle' : 'visibility' }}</span>
                {{ $editionViewing->statut ? 'Ouverte' : 'Clôturée (consultation)' }}
              </span>
            </dd>
          </div>
        </dl>
      @else
        <p class="text-sm text-neutral-500 rounded-lg bg-neutral-50 p-4 text-center">Aucune session active ni consultée.</p>
      @endif
    </section>

    {{-- Top candidats --}}
    <section class="xl:col-span-2 rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm">
      <h2 class="flex items-center gap-2 text-lg font-bold text-neutral-900 mb-4">
        <span class="material-icons text-ka-yellow">emoji_events</span>
        Top 3 candidats
      </h2>
      <div class="space-y-3">
        @forelse($topCandidats as $index => $candidat)
          <div class="flex items-center gap-4 rounded-xl border border-neutral-100 bg-neutral-50/50 p-4 transition hover:border-ka-gold/40 hover:shadow-md">
            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-black text-sm font-bold text-ka-yellow">
              {{ $index + 1 }}
            </span>
            <img src="{{ $candidat->photo_url ? asset($candidat->photo_url) : 'https://via.placeholder.com/80' }}"
                 alt="{{ $candidat->nom_complet }}"
                 class="h-14 w-14 shrink-0 rounded-full object-cover ring-2 ring-ka-gold">
            <div class="min-w-0 flex-1">
              <p class="font-semibold text-neutral-900 truncate">{{ $candidat->nom_complet }}</p>
              <p class="text-sm text-neutral-500 flex items-center gap-1 truncate">
                <span class="material-icons text-ka-gold text-base">category</span>
                {{ $candidat->categorie->nom_categorie ?? '—' }}
              </p>
            </div>
            <div class="shrink-0 text-right">
              <p class="text-2xl font-bold text-ka-gold">{{ $candidat->votes_count }}</p>
              <p class="text-xs text-neutral-500">votes</p>
            </div>
          </div>
        @empty
          <p class="text-center text-sm text-neutral-500 py-8">Aucun candidat pour le moment.</p>
        @endforelse
      </div>
    </section>
  </div>

  {{-- Graphique --}}
  <section class="mt-6 rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm">
    <h2 class="flex items-center gap-2 text-lg font-bold text-neutral-900 mb-4">
      <span class="material-icons text-ka-gold">bar_chart</span>
      Votes par catégorie
    </h2>
    <div class="h-64 sm:h-80">
      <canvas id="votesParCategorie"></canvas>
    </div>
  </section>

  {{-- Activité récente --}}
  <section class="mt-6 rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm">
    <h2 class="flex items-center gap-2 text-lg font-bold text-neutral-900 mb-4">
      <span class="material-icons text-ka-gold">history</span>
      Activité récente
    </h2>
    <ul class="divide-y divide-neutral-100">
      @forelse($recentVotes as $vote)
        <li class="flex flex-wrap items-center gap-2 py-3 text-sm">
          <span class="material-icons text-neutral-400 text-base">payments</span>
          <span class="font-medium text-neutral-800 font-mono text-xs">{{ $vote->payment_reference ?? 'Vote' }}</span>
          <span class="text-neutral-500">→</span>
          <span class="font-semibold text-ka-gold">{{ $vote->candidat->nom_complet ?? '—' }}</span>
          @if($vote->candidat?->categorie)
            <span class="text-neutral-400">({{ $vote->candidat->categorie->nom_categorie }})</span>
          @endif
          <span class="ml-auto text-xs text-neutral-400">{{ $vote->created_at->diffForHumans() }}</span>
        </li>
      @empty
        <li class="py-8 text-center text-sm text-neutral-500">Aucun vote récent.</li>
      @endforelse
    </ul>
  </section>
@endsection

@push('scripts')
<script>
  const categories = @json($categoriesLabels ?? []);
  const votes = @json($categoriesVotes ?? []);
  const ctx = document.getElementById('votesParCategorie');
  if (ctx && categories.length) {
    new Chart(ctx.getContext('2d'), {
      type: 'bar',
      data: {
        labels: categories,
        datasets: [{
          label: 'Votes',
          data: votes,
          backgroundColor: 'rgba(162, 130, 36, 0.85)',
          borderColor: '#A28224',
          borderWidth: 1,
          borderRadius: 8,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          y: { beginAtZero: true, grid: { color: '#f0f0f0' } },
          x: { grid: { display: false } }
        }
      }
    });
  }
</script>
@endpush
