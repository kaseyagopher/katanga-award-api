<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Katanga Awards | Accueil</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}">
  <style>
    @keyframes fadeOut {
      from { opacity: 1; }
      to { opacity: 0; visibility: hidden; }
    }
    .carousel-item {
      transition: transform 0.5s ease-in-out;
    }
    .overlay-text {
      position: absolute;
      inset: 0;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      pointer-events: none;
    }
  </style>
</head>

<body class="bg-black min-h-screen flex flex-col relative">

  <!-- Loader -->
  <div id="loader" class="fixed inset-0 bg-black flex flex-col items-center justify-center z-50">
    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-[#A28224] mb-4"></div>
    <h1 class="text-2xl font-bold text-[#fbcd43]">Katanga Awards</h1>
  </div>

  <!-- NAVBAR -->
  <nav class="bg-dark shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-b-2 border-[#fbcd43]">
      <div class="flex justify-between h-16 items-center">
        <!-- Liens desktop -->
        <div class="hidden md:flex items-center space-x-4">
          <a href="{{ route('user.index') }}" class="text-white hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Accueil</a>
          <a href="{{ route('user.apropos') }}" class="text-white hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">A propos</a>
          <a href="{{ route('user.contact') }}" class="text-white hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Contact</a>
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
                     class="bg-[#e3b017] text-black px-4 py-2 rounded-md hover:bg-[#A28224] focus:outline-none focus:ring-2 focus:ring-[#A28224]/50 whitespace-nowrap">
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
              <p class="text-orange-500 font-semibold">Pas connecté</p>
          @endif
        </div>

        <div class="flex items-center space-x-2 px-4 py-1">
          <span class="font-bold text-lg">
              <span class="text-white">KATANGA</span>
              <span class="text-[#e3b017]"> AWARDS</span>
          </span>
        </div>

        <!-- Hamburger mobile -->
        <div class="md:hidden flex items-center">
            <button id="mobile-menu-button" class="text-white focus:outline-none">
                <span class="material-icons">menu</span>
            </button>
        </div>
      </div>

      <!-- Menu mobile -->
      <div id="mobile-menu" class="hidden md:hidden mt-2 space-y-2">
        <a href="{{ route('user.index') }}" class="block text-white hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Accueil</a>
        <a href="{{ route('user.apropos') }}" class="block text-white hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">À propos</a>
        <a href="{{ route('user.contact') }}" class="block text-white hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Contact</a>
      </div>
    </div>
  </nav>

  <!-- CONTENU PRINCIPAL -->
  <main class="flex-1 w-full mx-auto p-6">
    <div class="w-full relative">
      <div class="overlay-text z-10">
        <h1 class="text-4xl sm:text-5xl font-bold text-[#fbcd43] drop-shadow-lg">Bienvenue à Katanga Awards <br><span class="text-white">(16<sup>ème</sup> ÉDITION)</span></h1>
        <p class="mt-2 text-white/80 text-center text-lg sm:text-xl">Découvrez nos candidats et votez en ligne</p>
      </div>

      <!-- Carousel -->
      <div id="carousel" class="overflow-hidden rounded-xl relative z-0">
        <div class="carousel-inner flex relative">
          @foreach (['affiche_officiel.jpg','IMG_6309.JPG','photo_2025-10-08_15-11-01.jpg','photo_2025-10-08_15-10-57.jpg','photo_2025-10-08_15-18-37.jpg','photo_2025-10-08_15-11-08.jpg'] as $slide)
          <div class="carousel-item flex-shrink-0 w-full relative">
            <img src="{{ asset($slide) }}" class="w-full h-64 object-cover rounded-xl" alt="Slide">
            <div class="absolute inset-0 bg-black/60 rounded-xl"></div>
          </div>
          @endforeach
        </div>
      </div>

      <!-- Contrôles carousel -->
      <button id="prev" class="absolute top-1/2 left-2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black/70 z-20">&#10094;</button>
      <button id="next" class="absolute top-1/2 right-2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black/70 z-20">&#10095;</button>

      <div class="flex justify-center space-x-2 mt-4 relative z-20">
        @for($i = 0; $i < 5; $i++)
          <button class="indicator w-3 h-3 rounded-full bg-gray-400"></button>
        @endfor
      </div>
    </div>

    <!-- Candidats par catégorie -->
    @php
      $categories = \App\Models\Categorie::with(['candidats' => fn($q) => $q->orderBy('nom_complet')])->get();
    @endphp

    @foreach($categories as $categorie)
      <section class="mb-8">
        <h2 class="text-2xl m-4 pb-2 font-semibold mb-4 text-white">{{ mb_strtoupper($categorie->nom_categorie) }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          @forelse($categorie->candidats as $candidat)
            <div class="candidate-card relative rounded-2xl shadow-lg p-4 flex flex-col items-center text-center transition-transform duration-500 ease-in-out hover:scale-105"
                 style="background: linear-gradient(135deg, {{ $candidat->couleur_dominante }}, {{ $candidat->couleur_dominante_sombre }});">

              <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-md mb-3">
                <img src="{{ asset($candidat->photo_url) }}" alt="{{ $candidat->nom_complet }}" class="w-full h-full object-cover zoomable">
              </div>

              <h3 class="text-lg font-bold text-white drop-shadow">{{ mb_strtoupper($candidat->nom_complet) }}</h3>
              <p class="text-sm text-yellow-100 m-2 italic">Nominé(e)</p>
              <a href="{{ route('user.candidat.show', $candidat->uuid) }}" class="bg-[#fbcd43] text-black px-4 m-2 rounded-2xl hover:bg-[#A28224] transition">Voir plus</a>
            </div>
          @empty
            <p class="col-span-full text-center bg-gray-200 p-4 rounded">Aucun candidat</p>
          @endforelse
        </div>
      </section>
    @endforeach

    <!-- Sponsors -->
    <section class="mt-16 text-center">
      <h2 class="text-3xl font-semibold text-[#fbcd43] mb-8">Nos Sponsors - 16<sup>ème</sup> Édition</h2>
      <p class="text-gray-300 mb-10 max-w-3xl mx-auto">
        Nous remercions chaleureusement nos partenaires et sponsors pour leur soutien à cette 16<sup>ème</sup> édition du
        <span class="text-[#A28224] font-semibold">Katanga Awards</span>.
      </p>
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-10 items-center justify-center">
        @foreach (['tfm.jpg','Baraka.jpg','bgfibanque.jpg','novotel.jpg','ntayrock.jpg','mbegu.jpg','loft_key.jpg','morco.jpg','malaika.jpg','inpp.jpg','mannel.jpg','silocongo.jpg','topmarket.jpg','tsm.jpg'] as $image)
          <div class="flex justify-center">
            <img src="{{ asset($image) }}" alt="Sponsor" class="h-28 sm:h-32 md:h-36 object-contain rounded-xl shadow-md grayscale hover:grayscale-0 hover:scale-105 transition duration-500 ease-in-out zoomable">
          </div>
        @endforeach
      </div>
    </section>
  </main>

  <!-- FOOTER -->
  <footer class="bg-[#111] border-t border-[#A28224] mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-center items-center text-sm text-gray-400">
        <p>© 2025 Katanga Awards. Tous droits réservés.</p>
    </div>
  </footer>

  <!-- ✅ MODAL DE VISUALISATION D'IMAGE -->
  <div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50 backdrop-blur-sm">
    <div class="relative">
      <img id="modalImage" src="" alt="Aperçu" class="max-w-[90vw] max-h-[85vh] rounded-lg shadow-lg transition-transform duration-300 transform scale-100 hover:scale-105">
      <button id="closeModal" class="absolute -top-4 -right-4 bg-white text-gray-800 rounded-full w-10 h-10 text-2xl font-bold shadow-md hover:bg-gray-200 flex items-center justify-center">&times;</button>
    </div>
  </div>

  <!-- SCRIPTS -->
  <script>
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');
    const icon = btn.querySelector('.material-icons');
    btn.addEventListener('click', () => {
      menu.classList.toggle('hidden');
      icon.textContent = menu.classList.contains('hidden') ? 'menu' : 'close';
    });

    window.addEventListener("load", () => {
      const loader = document.getElementById("loader");
      loader.style.animation = "fadeOut 1s forwards";
    });

    // Carousel
    const carousel = document.querySelector('#carousel .carousel-inner');
    const items = document.querySelectorAll('.carousel-item');
    const prev = document.getElementById('prev');
    const next = document.getElementById('next');
    const indicators = document.querySelectorAll('.indicator');
    let index = 0;

    function showSlide(i) {
      index = (i + items.length) % items.length;
      carousel.style.transform = `translateX(${-index * 100}%)`;
      indicators.forEach((dot, idx) => dot.classList.toggle('bg-white', idx === index));
    }

    prev.addEventListener('click', () => showSlide(index - 1));
    next.addEventListener('click', () => showSlide(index + 1));
    indicators.forEach((dot, idx) => dot.addEventListener('click', () => showSlide(idx)));
    setInterval(() => showSlide(index + 1), 4000);
    showSlide(index);

    // ✅ Visualisation des images (candidats + sponsors)
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const closeModal = document.getElementById('closeModal');

    document.querySelectorAll('.zoomable').forEach(img => {
      img.classList.add('cursor-pointer', 'transition', 'hover:opacity-80');
      img.addEventListener('click', e => {
        e.preventDefault();
        e.stopPropagation();
        modalImage.src = img.src;
        modal.classList.remove('hidden');
      });
    });

    closeModal.addEventListener('click', () => modal.classList.add('hidden'));
    modal.addEventListener('click', e => {
      if (e.target === modal) modal.classList.add('hidden');
    });
  </script>
</body>
</html>
