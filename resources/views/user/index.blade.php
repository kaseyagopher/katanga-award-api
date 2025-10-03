<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Katanga Award | Accueil</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}">
  <style>
    /* Animation du loader */
    @keyframes fadeOut {
      from { opacity: 1; }
      to { opacity: 0; visibility: hidden; }
    }
  </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col relative">

  <!-- Loader -->
  <div id="loader" class="fixed inset-0 bg-white flex flex-col items-center justify-center z-50">
    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-[#A28224] mb-4"></div>
    <h1 class="text-2xl font-bold text-[#A28224]">Katanga Award</h1>
  </div>

  <!-- NAVBAR -->
  <nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16 items-center">
        <!-- Liens desktop -->
        <div class="hidden md:flex items-center space-x-4">
          <a href="{{ route('user.index') }}" class="text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Accueil</a>
          <a href="#" class="text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Résultats</a>
          <a href="{{ route('user.apropos') }}" class="text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Apropos</a>
          <a href="{{ route('user.contact') }}" class="text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Contact</a>
        </div>

        <!-- Boutons utilisateur -->
        <div class="flex items-center space-x-2">
          @if(Auth::guard('web')->check())
              @php
                  $editionActive = \App\Models\Edition::where('statut', true)->first();
                  $aVote = false;
                  if($editionActive) {
                      $aVote = \App\Models\Vote::where('user_id', Auth::guard('web')->id())
                                                ->where('edition_id', $editionActive->id)
                                                ->exists();
                  }
              @endphp

              @if($editionActive && !$aVote)
                  <a href="{{ route('user.vote') }}"
                     class="bg-[#A28224] text-white px-4 py-2 rounded-md hover:bg-[#A28224] focus:outline-none focus:ring-2 focus:ring-[#A28224]/50 whitespace-nowrap">
                      Voter
                  </a>
              @elseif($editionActive)
                  <span class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md cursor-not-allowed whitespace-nowrap">
                      Vous avez déjà voté
                  </span>
              @else
                  <span class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md cursor-not-allowed whitespace-nowrap">
                      Pas d'édition active
                  </span>
              @endif

              

          @else
              <p class="text-orange-500 font-semibold">UNKNOW</p>
          @endif
        </div>
        <div class="flex items-center space-x-2 px-4 py-1">
                  <span class="font-bold text-lg">
                      <span class="text-black">Katanga</span>
                      <span class="text-[#A28224]"> Award</span>
                  </span>
              </div>
        <!-- Hamburger mobile -->
        <div class="md:hidden flex items-center">
            <button id="mobile-menu-button" class="text-gray-700 focus:outline-none">
                <span class="material-icons">menu</span>
            </button>
        </div>
      </div>
    <!-- Texte Katanga Award + image -->
              
      <!-- Menu mobile -->
      <div id="mobile-menu" class="hidden md:hidden mt-2 space-y-2">
  <a href="{{ route('user.index') }}" 
     class="block text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md 
     {{ Route::currentRouteName() === 'user.index' ? 'text-[#A28224]' : '' }}">
     Accueil
  </a>
  <a href="" 
     class="block text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md 
     {{ Route::currentRouteName() === '' ? 'text-[#A28224]' : '' }}">
     Résultats
  </a>
  <a href="{{ route('user.apropos') }}" 
     class="block text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md 
     {{ Route::currentRouteName() === 'user.apropos' ? 'text-[#A28224]' : '' }}">
     À propos
  </a>
  <a href="{{ route('user.contact') }}" 
     class="block text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md 
     {{ Route::currentRouteName() === 'user.contact' ? 'text-[#A28224]' : '' }}">
     Contact
  </a>
</div>
    </div>
  </nav>

  <script>
      const btn = document.getElementById('mobile-menu-button');
      const menu = document.getElementById('mobile-menu');
      btn.addEventListener('click', () => menu.classList.toggle('hidden'));

      // Loader disparaît après le chargement de la page
      window.addEventListener("load", () => {
        const loader = document.getElementById("loader");
        loader.style.animation = "fadeOut 1s forwards";
      });
  </script>

  <!-- CONTENU PRINCIPAL -->
  <main class="flex-1 max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Bienvenue sur le vote en ligne</h1>

    <!-- Candidats par catégorie -->
    @php
        $categories = \App\Models\Categorie::with(['candidats' => function($q) {
            $q->orderBy('nom_complet');
        }])->get();
    @endphp

    @foreach($categories as $categorie)
        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">{{ $categorie->nom_categorie }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($categorie->candidats as $candidat)
                    <div class="candidate-card relative rounded-2xl shadow-lg p-4 flex flex-col items-center text-center transition"
                         style="background: linear-gradient(135deg, {{ $candidat->couleur_dominante }}, {{ $candidat->couleur_dominante_sombre }});">
                        <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-md mb-3">
                            <img src="{{ asset($candidat->photo_url) ?? 'https://via.placeholder.com/150' }}"
                                 alt="{{ $candidat->nom_complet }}"
                                 class="w-full h-full object-cover candidate-photo">
                        </div>
                        <h3 class="text-lg font-bold text-white drop-shadow">{{ $candidat->nom_complet }}</h3>
                        <p class="text-sm text-yellow-100 italic">{{ $categorie->nom_categorie }}</p>
                    </div>
                @empty
                    <p class="col-span-full text-center bg-gray-200 p-4 rounded">Aucun candidat</p>
                @endforelse
            </div>
        </section>
    @endforeach
  </main>

  <!-- FOOTER -->
  <footer class="bg-white border-t mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-center items-center text-sm text-gray-500">
        <p class="text-center">© 2025 Katanga Award. Tous droits réservés.</p>
    </div>
  </footer>

</body>
</html>
