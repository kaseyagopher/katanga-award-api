@extends('layouts.admin')

@section('title', 'Résultats')
@section('page-title', 'Résultats en direct')
@section('page-subtitle', 'Actualisation automatique toutes les 5 secondes')

@section('content')
  <div class="mb-4 flex items-center gap-2 rounded-lg bg-ka-gold/10 border border-ka-gold/30 px-4 py-2 text-sm text-neutral-700">
    <span class="relative flex h-2 w-2">
      <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-ka-gold opacity-75"></span>
      <span class="relative inline-flex h-2 w-2 rounded-full bg-ka-gold"></span>
    </span>
    Classement mis à jour en temps réel
  </div>

  <div id="resultsContainer" class="space-y-8">
    <div class="rounded-2xl border border-neutral-200 bg-white py-12 text-center text-neutral-500 shadow-sm">
      <span class="material-icons animate-spin text-4xl text-ka-gold">sync</span>
      <p class="mt-2">Chargement des résultats…</p>
    </div>
  </div>
@endsection

@push('scripts')
<script>
  async function fetchResults() {
    try {
      const response = await fetch("{{ route('resultats.data') }}");
      const data = await response.json();
      const container = document.getElementById('resultsContainer');
      container.innerHTML = '';

      if (!data.length) {
        container.innerHTML = `
          <div class="rounded-2xl border border-neutral-200 bg-white py-12 text-center text-neutral-500">
            <span class="material-icons text-5xl text-neutral-300">emoji_events</span>
            <p class="mt-2">Aucun résultat — activez une édition avec des catégories.</p>
          </div>`;
        return;
      }

      data.forEach(categorie => {
        const block = document.createElement('section');
        block.className = 'rounded-2xl border border-neutral-200 bg-white overflow-hidden shadow-sm';

        const sorted = [...categorie.candidats].sort((a, b) => b.votes_count - a.votes_count);
        const maxVotes = sorted[0]?.votes_count || 1;

        let rows = sorted.map((candidat, index) => {
          const pct = maxVotes > 0 ? Math.round((candidat.votes_count / maxVotes) * 100) : 0;
          const medal = index === 0 ? '🥇' : index === 1 ? '🥈' : index === 2 ? '🥉' : (index + 1);
          return `
            <tr class="${index % 2 === 0 ? 'bg-neutral-50/80' : 'bg-white'} hover:bg-ka-gold/5 transition">
              <td class="py-3 px-4 font-bold text-ka-gold w-12">${medal}</td>
              <td class="py-3 px-4 font-medium text-neutral-900">${candidat.nom_complet}</td>
              <td class="py-3 px-4 w-1/3">
                <div class="h-2 rounded-full bg-neutral-200 overflow-hidden">
                  <div class="h-full rounded-full bg-gradient-to-r from-ka-gold to-ka-yellow transition-all duration-500" style="width:${pct}%"></div>
                </div>
              </td>
              <td class="py-3 px-4 text-right font-bold text-ka-gold whitespace-nowrap">
                <span class="material-icons align-middle text-ka-yellow text-base">how_to_vote</span>
                ${candidat.votes_count}
              </td>
            </tr>`;
        }).join('');

        block.innerHTML = `
          <div class="flex items-center gap-2 border-b-2 border-ka-yellow bg-black px-5 py-4 text-white">
            <span class="material-icons text-ka-yellow">category</span>
            <h2 class="text-lg font-bold">${categorie.nom_categorie}</h2>
          </div>
          <div class="overflow-x-auto admin-scrollbar">
            <table class="min-w-full text-sm">
              <thead>
                <tr class="bg-neutral-100 text-left text-neutral-600">
                  <th class="py-2 px-4 font-semibold">#</th>
                  <th class="py-2 px-4 font-semibold">Candidat</th>
                  <th class="py-2 px-4 font-semibold">Progression</th>
                  <th class="py-2 px-4 font-semibold text-right">Votes</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-neutral-100">${rows}</tbody>
            </table>
          </div>`;
        container.appendChild(block);
      });
    } catch (error) {
      console.error('Erreur chargement résultats:', error);
    }
  }

  fetchResults();
  setInterval(fetchResults, 5000);
</script>
@endpush
