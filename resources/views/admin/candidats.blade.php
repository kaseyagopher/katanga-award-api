@extends('layouts.admin')

@section('title', 'Candidats')
@section('page-title', 'Candidats')
@section('page-subtitle', 'Liste par catégorie')

@section('header-actions')
  <a href="{{ route('candidats.create') }}"
     class="inline-flex items-center gap-2 rounded-lg bg-ka-gold px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-ka-gold/90">
    <span class="material-icons text-[18px]">person_add</span>
    Nouveau candidat
  </a>
@endsection

@section('content')
  <x-admin.page-header title="Candidats par catégorie">
    <x-slot:actions>
      <a href="{{ route('candidats.create') }}" class="inline-flex items-center gap-1 rounded-lg bg-ka-gold px-3 py-2 text-sm font-semibold text-white">
        <span class="material-icons text-[18px]">add</span>
        Ajouter
      </a>
    </x-slot:actions>
  </x-admin.page-header>

  @forelse($Categories as $Categorie)
    <section class="mb-10">
      <div class="mb-4 flex items-center gap-2 border-l-4 border-ka-gold pl-3">
        <span class="material-icons text-ka-gold">category</span>
        <h3 class="text-lg font-bold text-neutral-900">{{ $Categorie->nom_categorie }}</h3>
        <span class="rounded-full bg-neutral-100 px-2 py-0.5 text-xs font-medium text-neutral-600">
          {{ $Categorie->candidats->count() }}
        </span>
      </div>

      <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @forelse($Categorie->candidats as $Candidat)
          <article class="group relative flex flex-col items-center overflow-hidden rounded-2xl p-5 text-center shadow-lg transition hover:scale-[1.02] hover:shadow-xl"
                   style="background: linear-gradient(145deg, {{ $Candidat->couleur_dominante ?? '#A28224' }}, {{ $Candidat->couleur_dominante_sombre ?? '#7a5c12' }});">
            <div class="mb-3 h-24 w-24 overflow-hidden rounded-full border-4 border-white/90 shadow-lg ring-2 ring-ka-yellow/50">
              <img src="{{ $Candidat->photo_url ? asset($Candidat->photo_url) : 'https://via.placeholder.com/150' }}"
                   alt="{{ $Candidat->nom_complet }}"
                   class="h-full w-full object-cover">
            </div>
            <h4 class="text-lg font-bold text-white drop-shadow-sm">{{ $Candidat->nom_complet }}</h4>
            <p class="mt-1 text-xs font-medium text-ka-yellow/90">{{ $Categorie->nom_categorie }}</p>
            <div class="mt-4 flex gap-2 opacity-95">
              <a href="{{ route('candidats.edit', $Candidat->uuid) }}"
                 class="inline-flex items-center gap-1 rounded-lg bg-black/80 px-3 py-1.5 text-xs font-semibold text-white backdrop-blur hover:bg-black">
                <span class="material-icons text-[14px]">edit</span>
                Modifier
              </a>
              <form method="POST" action="{{ route('candidats.destroy', $Candidat->uuid) }}"
                    onsubmit="return confirm('Supprimer ce candidat ?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-1 rounded-lg bg-red-600/90 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-700">
                  <span class="material-icons text-[14px]">delete</span>
                </button>
              </form>
            </div>
          </article>
        @empty
          <div class="col-span-full rounded-xl border-2 border-dashed border-neutral-200 bg-neutral-50 py-10 text-center text-sm text-neutral-500">
            Aucun candidat dans cette catégorie.
          </div>
        @endforelse
      </div>
    </section>
  @empty
    <div class="rounded-2xl border border-neutral-200 bg-white py-16 text-center shadow-sm">
      <span class="material-icons text-5xl text-neutral-300">groups</span>
      <p class="mt-2 text-neutral-500">Aucune catégorie définie.</p>
    </div>
  @endforelse
@endsection
