@extends('layouts.admin')

@section('title', isset($Categorie) ? 'Modifier catégorie' : 'Nouvelle catégorie')
@section('page-title', isset($Categorie) ? 'Modifier la catégorie' : 'Créer une catégorie')

@section('content')
  <div class="mx-auto max-w-lg">
    <div class="rounded-2xl border border-neutral-200 bg-white p-6 sm:p-8 shadow-sm">
      <div class="mb-6 flex items-center gap-3 border-b border-neutral-100 pb-4">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-ka-gold/15 text-ka-gold">
          <span class="material-icons">category</span>
        </span>
        <div>
          <h2 class="text-xl font-bold text-neutral-900">
            {{ isset($Categorie) ? 'Modifier la catégorie' : 'Nouvelle catégorie' }}
          </h2>
          <p class="text-sm text-neutral-500">Rattachez-la à une édition active</p>
        </div>
      </div>

      <form action="{{ isset($Categorie) ? route('categories.update', $Categorie->id) : route('categories.store') }}"
            method="POST" class="space-y-5">
        @csrf
        @if(isset($Categorie))
          @method('PUT')
        @endif

        <div>
          <label for="nom_categorie" class="mb-1 block text-sm font-medium text-neutral-700">Nom de la catégorie</label>
          <input type="text" name="nom_categorie" id="nom_categorie"
                 value="{{ old('nom_categorie', $Categorie->nom_categorie ?? '') }}" required
                 class="w-full rounded-lg border border-neutral-300 px-3 py-2.5 focus:border-ka-gold focus:outline-none focus:ring-2 focus:ring-ka-gold/30">
          @error('nom_categorie')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="edition_id" class="mb-1 block text-sm font-medium text-neutral-700">Édition</label>
          <select name="edition_id" id="edition_id" required
                  class="w-full rounded-lg border border-neutral-300 px-3 py-2.5 focus:border-ka-gold focus:outline-none focus:ring-2 focus:ring-ka-gold/30">
            <option value="">— Sélectionnez une édition —</option>
            @foreach($Editions as $Edition)
              <option value="{{ $Edition->id }}"
                {{ old('edition_id', $Categorie->edition_id ?? '') == $Edition->id ? 'selected' : '' }}>
                {{ $Edition->titre }}
              </option>
            @endforeach
          </select>
          @error('edition_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="flex gap-3 pt-2">
          <a href="{{ route('categories.index') }}"
             class="flex-1 rounded-lg border border-neutral-300 py-2.5 text-center text-sm font-medium text-neutral-700 hover:bg-neutral-50">
            Annuler
          </a>
          <button type="submit"
                  class="flex-1 rounded-lg bg-ka-gold py-2.5 text-sm font-semibold text-white shadow-md hover:bg-ka-gold/90 focus:outline-none focus:ring-2 focus:ring-ka-gold focus:ring-offset-2">
            {{ isset($Categorie) ? 'Mettre à jour' : 'Créer' }}
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
