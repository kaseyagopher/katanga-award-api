<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Vote en ligne</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://unpkg.com/alpinejs" defer></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('flavicon-katanga-award.jpg') }}">
</head>
<body class="flex min-h-screen bg-gray-100 font-sans">

  <!-- Sidebar -->
  <div id="sidebar" 
       class="fixed inset-y-0 left-0 w-64 bg-black text-white p-6 transform -translate-x-full
              md:translate-x-0 transition-transform duration-200 ease-in-out z-50 flex flex-col">

    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
      <span class="material-icons">admin_panel_settings</span>
      Admin
    </h2>

    <!-- Liens navigation -->
    <nav class="space-y-4 flex-1">
      <a href="{{ route('admin.dashboard') }}"
         class="flex items-center gap-2 px-3 py-2 rounded
                {{ Route::currentRouteName() === 'admin.dashboard'
                    ? 'bg-[#A28224] text-white'
                    : 'hover:bg-[#A28224] hover:text-white' }}">
        <span class="material-icons">dashboard</span>
        Tableau de bord
      </a>

      <a href="{{ route('candidats.index') }}"
         class="flex items-center gap-2 px-3 py-2 rounded
                {{ Route::currentRouteName() === 'candidats.index'
                    ? 'bg-[#A28224] text-white'
                    : 'hover:bg-[#A28224] hover:text-white' }}">
        <span class="material-icons">groups</span>
        Candidats
      </a>

      <!-- Catégories avec sous-menu -->
      <div x-data="{ open: false }" class="space-y-1">
        <button @click="open = !open"
                class="w-full flex justify-between items-center px-3 py-2 rounded
                       {{ Str::startsWith(Route::currentRouteName(), 'categories.')
                          ? 'bg-[#A28224] text-white'
                          : 'hover:bg-[#A28224] hover:text-white' }}">
          <span class="flex items-center gap-2">
            <span class="material-icons">category</span>
            Catégories
          </span>
          <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform" fill="none"
               stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <div x-show="open" class="pl-8 space-y-1" x-cloak>
          <a href="{{ route('categories.index') }}"
             class="flex items-center gap-2 px-3 py-2 rounded text-sm
                    {{ Route::currentRouteName() === 'categories.index'
                        ? 'bg-[#A28224] text-white'
                        : 'hover:bg-[#A28224] hover:text-white' }}">
            <span class="material-icons text-sm">list</span>
            Liste
          </a>
          <a href="{{ route('categories.create') }}"
             class="flex items-center gap-2 px-3 py-2 rounded text-sm
                    {{ Route::currentRouteName() === 'categories.create'
                        ? 'bg-[#A28224] text-white'
                        : 'hover:bg-[#A28224] hover:text-white' }}">
            <span class="material-icons text-sm">add_circle</span>
            Ajouter
          </a>
        </div>
      </div>

      <a href="{{ route('editions.index') }}"
         class="flex items-center gap-2 px-3 py-2 rounded
                {{ Route::currentRouteName() === 'editions.index'
                    ? 'bg-[#A28224] text-white'
                    : 'hover:bg-[#A28224] hover:text-white' }}">
        <span class="material-icons">edit</span>
        Éditions
      </a>

      <a href="{{ route('resultats.index') }}"
         class="flex items-center gap-2 px-3 py-2 rounded
                {{ Route::currentRouteName() === 'resultats.index'
                    ? 'bg-[#A28224] text-white'
                    : 'hover:bg-[#A28224] hover:text-white' }}">
        <span class="material-icons">emoji_events</span>
        Résultats
      </a>
    </nav>

    <!-- Déconnexion -->
    <form method="GET" action="{{ route('admin.logout') }}" class="mt-auto">
      @csrf
      <button type="submit"
              class="flex items-center gap-2 w-full text-left px-3 py-2 rounded bg-red-500 hover:bg-red-600">
        <span class="material-icons">logout</span>
        Se déconnecter
      </button>
    </form>
  </div>

  <!-- Overlay pour mobile -->
  <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40 md:hidden" 
       onclick="toggleSidebar()"></div>

  <!-- Contenu principal -->
  <div class="flex-1 flex flex-col md:ml-64">
    
    <!-- Header mobile -->
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
    
  </div>
</header>

    <!-- Contenu -->
    <main class="p-4 sm:p-6 lg:p-8 space-y-8">
      <h1 class="text-2xl sm:text-3xl font-bold mb-4">Tableau de bord Admin</h1>

      <!-- Section cartes -->
      <section>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="bg-black text-white p-6 rounded-lg shadow">
            <div class="text-sm">Nombre de candidats</div>
            <div class="text-2xl font-bold">{{ $nbCandidats ?? 0 }}</div>
          </div>
          <div class="bg-[#A28224] text-white p-6 rounded-lg shadow">
            <div class="text-sm">Nombre de catégories</div>
            <div class="text-2xl font-bold">{{ $nbCategories ?? 0 }}</div>
          </div>
          <div class="bg-blue-600 text-white p-6 rounded-lg shadow">
            <div class="text-sm">Nombre d’éditions</div>
            <div class="text-2xl font-bold">{{ $nbEditions ?? 0 }}</div>
          </div>
          <div class="bg-green-600 text-white p-6 rounded-lg shadow">
            <div class="text-sm">Votes enregistrés</div>
            <div class="text-2xl font-bold">{{ $nbVotes ?? 0 }}</div>
          </div>
        </div>
      </section>

      <!-- Édition active -->
      <section class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg sm:text-xl font-bold mb-2">Édition en cours</h2>
        @if($editionActive)
          <p><span class="font-semibold">Titre :</span> {{ $editionActive->titre }}</p>
          <p><span class="font-semibold">Thème :</span> {{ $editionActive->theme }}</p>
          <p><span class="font-semibold">Statut :</span> 
            <span class="px-2 py-1 rounded text-white {{ $editionActive->statut ? 'bg-green-600' : 'bg-red-600' }}">
              {{ $editionActive->statut ? 'Active' : 'Clôturée' }}
            </span>
          </p>
        @else
          <p>Aucune édition active pour le moment.</p>
        @endif
      </section>

      <!-- Top candidats -->
      <section class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg sm:text-xl font-bold mb-4">Top 3 Candidats</h2>
        <div class="space-y-4">
          @foreach($topCandidats as $candidat)
            <div class="flex flex-col sm:flex-row items-center sm:justify-between gap-4">
              <div class="flex items-center gap-4">
                <img src="{{ $candidat->photo_url }}" alt="{{ $candidat->nom_complet }}" class="w-12 h-12 rounded-full object-cover">
                <div>
                  <div class="font-semibold">{{ $candidat->nom_complet }}</div>
                  <div class="text-sm text-gray-600">{{ $candidat->categorie->nom }}</div>
                </div>
              </div>
              <div class="text-lg font-bold">{{ $candidat->votes_count }}</div>
            </div>
          @endforeach
        </div>
      </section>

      <!-- Graphique votes par catégorie -->
      <section class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg sm:text-xl font-bold mb-4">Répartition des votes par catégorie</h2>
        <div class="w-full h-64 sm:h-80 md:h-96">
          <canvas id="votesParCategorie"></canvas>
        </div>
      </section>

      <!-- Activité récente -->
      <section class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg sm:text-xl font-bold mb-4">Activité récente</h2>
        <ul class="divide-y divide-gray-200">
          @foreach($recentVotes as $vote)
            <li class="py-2 text-sm">
              <span class="font-semibold">{{ $vote->user->name }}</span> a voté pour 
              <span class="font-semibold">{{ $vote->candidat->nom_complet }}</span> 
              ({{ $vote->candidat->categorie->nom }}) – 
              <span class="text-gray-500">{{ $vote->created_at->diffForHumans() }}</span>
            </li>
          @endforeach
        </ul>
      </section>
    </main>
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
