<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Vote en ligne</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("-translate-x-full");
      document.getElementById("overlay").classList.toggle("hidden");
    }
  </script>
</head>
<body class="flex min-h-screen bg-gray-100 font-sans">

  <!-- Sidebar -->
  @include('components.aside-admin')

  <!-- Overlay (mobile only) -->
  <div id="overlay" 
       class="fixed inset-0 bg-black bg-opacity-50 hidden z-40 md:hidden"
       onclick="toggleSidebar()"></div>

  <!-- Contenu principal -->
  <div class="flex-1 flex flex-col md:ml-64">
    <!-- Header (mobile only) -->
    <header class="bg-white shadow p-4 flex items-center justify-between md:hidden">
      <button onclick="toggleSidebar()" class="text-blue-700 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
      <h1 class="text-lg font-bold">Admin Dashboard</h1>
    </header>

    <!-- Section Candidats -->
    <div class="p-6">
      <!-- Bouton Ajouter -->
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Liste des categories</h2>
        <a href="{{ route('categories.create') }}" 
           class="px-4 py-2 bg-[#A28224] text-white rounded">
          + Ajouter une categorie
        </a>
      </div>

      <!-- Tableau -->
      <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full">
          <thead class="bg-black text-white">
            <tr>
              <th class="px-6 py-3 text-left text-sm font-semibold">#</th>
              <th class="px-6 py-3 text-left text-sm font-semibold">Nom complet</th>
              <th class="px-6 py-3 text-left text-sm font-semibold">Catégorie</th>
              <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
            </tr>
          </thead>
          <tbody id="candidatList" class="divide-y divide-gray-200">
            @forelse ($Categories as $Categorie)
            <tr data-id="{{ $Categorie->id }}">
                <td class="px-6 py-4">{{ $Categorie->id }}</td>
                <td class="px-6 py-4">{{ $Categorie->nom_categorie}}</td>
                
                <td class="px-6 py-4 text-sm flex gap-2">
                    <!-- Bouton Modifier -->
                    <a href="{{ route('categories.edit', $Categorie->id) }}" 
                       class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                       Modifier
                    </a>
                    <!-- Bouton Supprimer -->
                    <form method="POST" 
                          action="{{ route('candidats.destroy', $Categorie->id) }}"
                          onsubmit="return confirm('Voulez-vous vraiment supprimer ce candidat ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                          Supprimer
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="p-4 bg-gray-200 text-center rounded">Aucune  categorie</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
