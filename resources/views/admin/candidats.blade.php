<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Vote en ligne</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
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
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">Liste des candidats par catégorie</h2>
        <a href="{{ route('candidats.create') }}" 
           class="px-4 py-2 bg-green-600 text-white rounded shadow hover:bg-green-700">
          + Ajouter un candidat
        </a>
      </div>

      @foreach($Categories as $Categorie)
        <div class="mb-8">
          <h3 class="text-lg font-semibold mb-4">{{ $Categorie->nom_categorie }}</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            
            @forelse($Categorie->candidats as $Candidat)
              <div class="candidate-card relative rounded-2xl shadow-lg p-4 flex flex-col items-center text-center transition"
                   style="background: linear-gradient(135deg, {{ $Candidat->couleur_dominante ?? '#A28224' }}, {{ $Candidat->couleur_dominante_sombre ?? '#7a5c12' }});">

                <!-- Photo -->
                <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-md mb-3">
                  <img src="{{ $Candidat->photo_url ?? 'https://via.placeholder.com/150' }}" 
                       alt="{{ $Candidat->nom_complet }}" 
                       class="w-full h-full object-cover">
                </div>

                <!-- Nom -->
                <h4 class="text-lg font-bold text-white drop-shadow">{{ $Candidat->nom_complet }}</h4>

                <!-- Catégorie -->
                <p class="text-sm text-yellow-100 italic">{{ $Categorie->nom_categorie }}</p>

                <!-- Actions -->
                <div class="mt-4 flex gap-2">
                  <a href="{{ route('candidats.edit', $Candidat->id) }}" 
                     class="px-3 py-1 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                    Modifier
                  </a>
                  <form method="POST" 
                        action="{{ route('candidats.destroy', $Candidat->id) }}"
                        onsubmit="return confirm('Voulez-vous vraiment supprimer ce candidat ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-3 py-1 bg-red-500 text-white text-sm rounded-lg hover:bg-red-600">
                      Supprimer
                    </button>
                  </form>
                </div>
              </div>
            @empty
              <p class="col-span-full text-center bg-gray-200 p-4 rounded">Aucun candidat dans cette catégorie</p>
            @endforelse

          </div>
        </div>
      @endforeach

    </div>
  </div>
</body>
</html>
