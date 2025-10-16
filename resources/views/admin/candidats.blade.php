<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Vote en ligne</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://unpkg.com/alpinejs" defer></script>
  <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}">
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
    <!-- Header mobile -->
<header class="bg-white shadow p-4 flex items-center justify-between md:hidden">
  <!-- Bouton menu -->
  <button onclick="toggleSidebar()" class="text-blue-700 focus:outline-none">
    <span class="material-icons">menu</span>
  </button>

  <!-- Titre -->
  <h1 class="text-lg font-bold">Admin</h1>

  <!-- Liens rapides -->
  <div class="flex items-center gap-4">
    <!-- Dashboard -->
    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
      <span class="material-icons">dashboard</span>
    </a>
    <!-- Candidats -->
    <a href="{{ route('candidats.index') }}" class="text-gray-700 hover:text-blue-600">
      <span class="material-icons">groups</span>
    </a>
    <!-- Déconnexion -->
    <form method="GET" action="{{ route('admin.logout') }}">
      @csrf
      <button type="submit" class="text-red-600 hover:text-red-800">
        <span class="material-icons">logout</span>
      </button>
    </form>
  </div>
</header>

    <!-- Section Candidats -->
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">Liste des candidats par catégorie</h2>
        <a href="{{ route('candidats.create') }}"
           class="px-4 py-2 bg-[#A28224] text-white rounded shadow ">
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
                <img src="{{ $Candidat->photo_url ? url($Candidat->photo_url) : 'https://via.placeholder.com/150' }}"
                alt="{{ $Candidat->nom_complet }}"
                class="w-full h-full object-cover">
            </div>

                <!-- Nom -->
                <h4 class="text-lg font-bold text-white drop-shadow">{{ $Candidat->nom_complet }}</h4>

                <!-- Catégorie -->
                <p class="text-sm text-yellow-100 italic">{{ $Categorie->nom_categorie }}</p>

                <!-- Actions -->
                <div class="mt-4 flex gap-2">
                  <a href="{{ route('candidats.edit', $Candidat->uuid) }}"
                     class="px-3 py-1 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                    Modifier
                  </a>
                  <form method="POST"
                        action="{{ route('candidats.destroy', $Candidat->uuid) }}"
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
              <div class="col-span-full p-6 bg-gray-200 text-center rounded">Aucune édition</div>
            @endforelse

          </div>
        </div>
      @endforeach

    </div>
  </div>
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      sidebar.classList.toggle('-translate-x-full');
      overlay.classList.toggle('hidden');
    }

    // Graphique
    const categories = @json($categoriesLabels ?? []);
    const votes = @json($categoriesVotes ?? []);

    const ctx = document.getElementById('votesParCategorie').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: categories,
        datasets: [{
          label: 'Votes',
          data: votes,
          backgroundColor: 'rgba(162, 130, 36, 0.8)',
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  </script>
</body>
</html>
