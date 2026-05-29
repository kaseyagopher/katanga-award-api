@extends('layouts.admin')

@section('title', 'Catégories')
@section('page-title', 'Catégories')
@section('page-subtitle', 'Gérer les catégories de l\'édition')

@section('header-actions')
  <a href="{{ route('categories.create') }}"
     class="inline-flex items-center gap-2 rounded-lg bg-ka-gold px-4 py-2 text-sm font-semibold text-white shadow-md shadow-ka-gold/20 transition hover:bg-ka-gold/90 focus:outline-none focus:ring-2 focus:ring-ka-gold focus:ring-offset-2">
    <span class="material-icons text-[18px]">add</span>
    Nouvelle catégorie
  </a>
@endsection

@section('content')
  <x-admin.page-header title="Liste des catégories" subtitle="{{ $Categories->count() }} catégorie(s)">
    <x-slot:actions>
      <a href="{{ route('categories.create') }}"
         class="inline-flex items-center gap-1 rounded-lg bg-ka-gold px-3 py-2 text-sm font-semibold text-white">
        <span class="material-icons text-[18px]">add</span>
        Ajouter
      </a>
    </x-slot:actions>
  </x-admin.page-header>

  <div class="overflow-hidden rounded-2xl border border-neutral-200 bg-white shadow-sm">
    <div class="overflow-x-auto admin-scrollbar">
      <table class="min-w-full text-sm">
        <thead>
          <tr class="bg-black text-left text-white">
            <th class="px-6 py-4 font-semibold">#</th>
            <th class="px-6 py-4 font-semibold">Catégorie</th>
            <th class="px-6 py-4 font-semibold text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-neutral-100">
          @forelse ($Categories as $Categorie)
            <tr class="transition hover:bg-ka-gold/5">
              <td class="px-6 py-4 text-neutral-500">{{ $Categorie->id }}</td>
              <td class="px-6 py-4 font-medium text-neutral-900">{{ $Categorie->nom_categorie }}</td>
              <td class="px-6 py-4">
                <div class="flex justify-end gap-2">
                  <a href="{{ route('categories.edit', $Categorie->id) }}"
                     class="inline-flex items-center gap-1 rounded-lg bg-black px-3 py-1.5 text-xs font-semibold text-white hover:bg-neutral-800">
                    <span class="material-icons text-[14px]">edit</span>
                    Modifier
                  </a>
                  <form method="POST" action="{{ route('categories.destroy', $Categorie->id) }}"
                        onsubmit="return confirm('Supprimer cette catégorie ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-1 rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-700">
                      <span class="material-icons text-[14px]">delete</span>
                      Supprimer
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="3" class="px-6 py-12 text-center text-neutral-500">
                <span class="material-icons text-4xl text-neutral-300 mb-2 block">category</span>
                Aucune catégorie. Créez-en une pour commencer.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
