@extends('layouts.admin')

@section('title', 'Gestion des votes')
@section('page-title', 'Gestion des votes')
@section('page-subtitle', 'Consulter et annuler les votes par candidat')

@section('header-actions')
  <a href="{{ route('admin.dashboard') }}"
     class="inline-flex items-center gap-2 rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm font-medium text-neutral-700 hover:border-ka-gold hover:text-ka-gold">
    <span class="material-icons text-[18px]">arrow_back</span>
    Tableau de bord
  </a>
@endsection

@section('content')
  @if($candidats->isEmpty())
    <div class="rounded-2xl border border-neutral-200 bg-white py-16 text-center shadow-sm">
      <span class="material-icons text-5xl text-neutral-300">how_to_vote</span>
      <p class="mt-2 text-neutral-500">Aucun candidat trouvé.</p>
    </div>
  @else
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 xl:grid-cols-3">
      @foreach($candidats as $candidat)
        <article class="flex flex-col overflow-hidden rounded-2xl border border-neutral-200 bg-white shadow-sm">
          <header class="flex items-center gap-4 bg-black p-4 text-white border-b-2 border-ka-yellow">
            <img src="{{ asset($candidat->photo_url) }}"
                 alt="{{ $candidat->nom_complet }}"
                 class="h-16 w-16 shrink-0 rounded-full object-cover ring-2 ring-ka-gold">
            <div class="min-w-0">
              <h2 class="truncate text-lg font-bold">{{ $candidat->nom_complet }}</h2>
              <p class="text-sm text-neutral-400 truncate">{{ $candidat->categorie->nom_categorie ?? '—' }}</p>
              <p class="mt-1 text-sm">
                <span class="text-ka-yellow font-bold text-lg">{{ $candidat->votes_count }}</span>
                <span class="text-neutral-400"> vote(s)</span>
              </p>
            </div>
          </header>
          <div class="max-h-64 overflow-y-auto admin-scrollbar flex-1">
            <table class="min-w-full text-sm">
              <thead class="sticky top-0 bg-neutral-900 text-white">
                <tr>
                  <th class="px-4 py-2 text-left font-semibold">Paiement</th>
                  <th class="px-4 py-2 text-left font-semibold">Montant</th>
                  <th class="px-4 py-2 text-left font-semibold">Date</th>
                  <th class="px-4 py-2 text-center font-semibold">Action</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-neutral-100">
                @forelse($candidat->votes as $vote)
                  <tr class="hover:bg-ka-gold/5">
                    <td class="px-4 py-2 font-medium font-mono text-xs">{{ $vote->payment_reference ?? '—' }}</td>
                    <td class="px-4 py-2 text-ka-gold font-semibold">{{ $vote->montant ? number_format($vote->montant, 0, ',', ' ') . ' CDF' : '—' }}</td>
                    <td class="px-4 py-2 text-neutral-600">{{ $vote->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-2 text-center">
                      <form action="{{ route('admin-vote-destroy', $vote->id) }}" method="POST"
                            onsubmit="return confirm('Annuler ce vote ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-1 rounded bg-red-600 px-2 py-1 text-xs font-semibold text-white hover:bg-red-700">
                          <span class="material-icons text-[14px]">undo</span>
                          Annuler
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-neutral-400">Aucun vote.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </article>
      @endforeach
    </div>
  @endif
@endsection
