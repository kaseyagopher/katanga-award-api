<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Katanga Award | À propos</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}">
  <style>
    /* Animations */
    @keyframes fadeOut {
      from { opacity: 1; }
      to { opacity: 0; visibility: hidden; }
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

  </style>
</head>

<body class="bg-black text-white min-h-screen flex flex-col relative font-sans">

  <!-- Loader -->
  <div id="loader" class="fixed inset-0 bg-black flex flex-col items-center justify-center z-50">
    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-[#A28224] mb-4"></div>
    <h1 class="text-2xl font-bold text-[#fbcd43]">Katanga Awards</h1>
  </div>

  <!-- NAVBAR -->
  <nav class="bg-black border-b border-[#A28224] sticky top-0 z-40 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16 items-center">

        <!-- Logo -->
        <a href="{{ route('user.index') }}" class="flex items-center space-x-2">
          <img src="{{ asset('logo_officiel.jpg') }}" alt="Katanga Award" class="h-10 w-auto">
          <span class="font-bold">
            <span class="text-white">KATANGA</span>
            <span class="text-[#fbcd43]"> AWARDS</span>
          </span>
        </a>

        <!-- Liens desktop -->
        <div class="hidden md:flex items-center space-x-4">
          <a href="{{ route('user.index') }}" class="text-gray-300 hover:text-[#A28224] font-semibold px-3 py-2">Accueil</a>

          <a href="{{ route('user.apropos') }}" class="text-[#A28224] font-semibold px-3 py-2">À propos</a>
          <a href="{{ route('user.contact') }}" class="text-gray-300 hover:text-[#A28224] font-semibold px-3 py-2">Contact</a>
        </div>

        <!-- Bouton utilisateur -->
        <div class="hidden md:block">
          @if(Auth::guard('web')->check())
              <span class="px-4 truncate max-w-[120px] text-right font-medium text-[#fbcd43]">
                  {{ Auth::guard('web')->user()->numero ?? Auth::guard('web')->user()->email }}
              </span>
          @else
              <p class="text-orange-500 font-semibold">UNKNOW</p>
          @endif
        </div>

        <!-- Hamburger mobile -->
        <div class="md:hidden flex items-center">
            <button id="mobile-menu-button" class="text-white focus:outline-none">
                <span class="material-icons">menu</span>
            </button>
        </div>
      </div>

      <!-- Menu mobile -->
      <div id="mobile-menu" class="hidden md:hidden mt-2 space-y-2 pb-4 animate-fade-in">
          <a href="{{ route('user.index') }}" class="block text-gray-300 hover:text-[#A28224] font-semibold px-3 py-2">Accueil</a>
          <a href="#" class="block text-gray-300 hover:text-[#A28224] font-semibold px-3 py-2">Résultats</a>
          <a href="{{ route('user.apropos') }}" class="block text-[#A28224] font-semibold px-3 py-2">À propos</a>
          <a href="{{ route('user.contact') }}" class="block text-gray-300 hover:text-[#A28224] font-semibold px-3 py-2">Contact</a>
      </div>
    </div>
  </nav>

  <script>
      const btn = document.getElementById('mobile-menu-button');
      const menu = document.getElementById('mobile-menu');
      const icon = btn.querySelector('.material-icons');
      btn.addEventListener('click', () => {
          menu.classList.toggle('hidden');
          icon.textContent = menu.classList.contains('hidden') ? 'menu' : 'close';
      });
  </script>



  <!-- CONTENU PRINCIPAL -->
  <main class="flex-1 max-w-7xl mx-auto p-6 space-y-12">

    <!-- Section Présentation -->
    <section class="text-center animate-fade-in">
      <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">À propos du Katanga Award</h1>
      <p class="text-gray-300 max-w-3xl mx-auto leading-relaxed">
        Le Katanga Award est un événement prestigieux qui met en lumière
        les talents, initiatives et réussites des acteurs qui contribuent au rayonnement de notre région.
        C’est un espace de reconnaissance et de valorisation célébrant l’excellence et la créativité.
      </p>
    </section>

    <!-- Mission et Vision -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-8 animate-fade-in">
      <div class="bg-[#111] border border-[#A28224]/30 rounded-2xl p-6 hover:shadow-[0_0_15px_#A28224] transition transform hover:-translate-y-1">
        <h2 class="text-2xl font-semibold text-[#fbcd43] mb-4">Notre Mission</h2>
        <p class="text-gray-300 leading-relaxed">
          Promouvoir et récompenser les efforts des individus et organisations œuvrant dans divers domaines —
          culture, innovation, entrepreneuriat, musique, sport — pour inspirer les générations futures.
        </p>
      </div>
      <div class="bg-[#111] border border-[#A28224]/30 rounded-2xl p-6 hover:shadow-[0_0_15px_#A28224] transition transform hover:-translate-y-1">
        <h2 class="text-2xl font-semibold text-[#fbcd43] mb-4">Notre Vision</h2>
        <p class="text-gray-300 leading-relaxed">
          Faire du Katanga Award une référence nationale et internationale,
          célébrant l’excellence et servant de levier de motivation pour la jeunesse congolaise.
        </p>
      </div>
    </section>

    <!-- Valeurs -->
    <section class="animate-fade-in">
      <h2 class="text-2xl font-semibold text-center text-[#fbcd43] mb-8">Nos Valeurs</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <div class="bg-[#1a1a1a] border border-[#A28224]/20 rounded-xl p-6 text-center hover:scale-105 transition">
          <h3 class="text-lg font-bold text-[#A28224] mb-2">Excellence</h3>
          <p class="text-gray-300 text-sm">Récompenser ceux qui se distinguent par leur savoir-faire et leur impact.</p>
        </div>
        <div class="bg-[#1a1a1a] border border-[#A28224]/20 rounded-xl p-6 text-center hover:scale-105 transition">
          <h3 class="text-lg font-bold text-[#A28224] mb-2">Innovation</h3>
          <p class="text-gray-300 text-sm">Mettre en avant les projets créatifs qui transforment positivement la société.</p>
        </div>
        <div class="bg-[#1a1a1a] border border-[#A28224]/20 rounded-xl p-6 text-center hover:scale-105 transition">
          <h3 class="text-lg font-bold text-[#A28224] mb-2">Engagement</h3>
          <p class="text-gray-300 text-sm">Valoriser l’esprit de service, le leadership et la contribution active.</p>
        </div>
      </div>
    </section>

    <!-- Historique -->
    <section class="bg-[#111] border border-[#A28224]/30 rounded-2xl p-8 animate-fade-in">
      <h2 class="text-2xl font-semibold text-[#fbcd43] mb-4">Notre Histoire</h2>
      <p class="text-gray-300 leading-relaxed">
        Créé pour honorer les talents et inspirer une génération, le <span class="text-[#A28224] font-semibold">Katanga Award</span>
        est devenu une cérémonie incontournable dans le paysage culturel et social.
        Chaque édition rassemble des milliers de participants, célébrant nos héros et modèles de réussite.
      </p>
    </section>

        <!-- Galerie -->
    <section class="animate-fade-in">
      <h2 class="text-2xl font-semibold text-center text-[#fbcd43] mb-8">Galerie des Éditions Précédentes</h2>
      <p class="text-center text-gray-300 max-w-3xl mx-auto mb-8">
        Revivez quelques moments forts des précédentes éditions du <span class="text-[#A28224] font-semibold">Katanga Award</span>.
      </p>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <div class="overflow-hidden rounded-xl border border-[#A28224]/30 hover:scale-105 transition transform">
          <img src="{{asset('photo_2025-10-08_15-10-55.jpg')}}" alt="Katanga Award 1" class="w-full h-60 object-cover">
        </div>
        <div class="overflow-hidden rounded-xl border border-[#A28224]/30 hover:scale-105 transition transform">
          <img src="{{asset('photo_2025-10-08_15-26-53.jpg')}}" alt="Katanga Award 9" class="w-full h-60 object-cover">
        </div>
        <div class="overflow-hidden rounded-xl border border-[#A28224]/30 hover:scale-105 transition transform">
          <img src="{{asset('photo_2025-10-08_15-11-02.jpg')}}" alt="Katanga Award 5" class="w-full h-60 object-cover">
        </div>
        <div class="overflow-hidden rounded-xl border border-[#A28224]/30 hover:scale-105 transition transform">
          <img src="{{asset('photo_2025-10-08_15-11-01.jpg')}}" alt="Katanga Award 4" class="w-full h-60 object-cover">
        </div>
        <div class="overflow-hidden rounded-xl border border-[#A28224]/30 hover:scale-105 transition transform">
          <img src="{{asset('photo_2025-10-08_15-11-06.jpg')}}" alt="Katanga Award 7" class="w-full h-60 object-cover">
        </div>
        <div class="overflow-hidden rounded-xl border border-[#A28224]/30 hover:scale-105 transition transform">
          <img src="{{asset('photo_2025-10-08_15-10-57.jpg')}}" alt="Katanga Award 2" class="w-full h-60 object-cover">
        </div>
        <div class="overflow-hidden rounded-xl border border-[#A28224]/30 hover:scale-105 transition transform">
          <img src="{{asset('photo_2025-10-08_15-11-04.jpg')}}" alt="Katanga Award 6" class="w-full h-60 object-cover">
        </div>
        <div class="overflow-hidden rounded-xl border border-[#A28224]/30 hover:scale-105 transition transform">
          <img src="{{asset('photo_2025-10-08_15-10-59.jpg')}}" alt="Katanga Award 3" class="w-full h-60 object-cover">
        </div>



        <div class="overflow-hidden rounded-xl border border-[#A28224]/30 hover:scale-105 transition transform">
          <img src="{{asset('photo_2025-10-08_15-11-08.jpg')}}" alt="Katanga Award 8" class="w-full h-60 object-cover">
        </div>
        <div class="overflow-hidden rounded-xl border border-[#A28224]/30 hover:scale-105 transition transform">
          <img src="{{asset('photo_2025-10-08_15-11-10.jpg')}}" alt="Katanga Award 9" class="w-full h-60 object-cover">
        </div>
        <div class="overflow-hidden rounded-xl border border-[#A28224]/30 hover:scale-105 transition transform">
          <img src="{{asset('photo_2025-10-08_15-18-37.jpg')}}" alt="Katanga Award 9" class="w-full h-60 object-cover">
        </div>
        <div class="overflow-hidden rounded-xl border border-[#A28224]/30 hover:scale-105 transition transform">
          <img src="{{asset('photo_2025-10-08_15-19-07.jpg')}}" alt="Katanga Award 9" class="w-full h-60 object-cover">
        </div>

      </div>
    </section>

     <!-- Call to Action -->
    <section class="text-center animate-fade-in">
      <h2 class="text-2xl font-semibold  mb-4">Rejoignez l’aventure Katanga Award</h2>
      <p class="text-gray-300 mb-6">Célébrez l’excellence et soutenez ceux qui façonnent l’avenir.</p>
      <a href="{{ route('user.index') }}" class="bg-[#fbcd43] text-black px-6 py-3 rounded-lg font-semibold hover:bg-[#e3b017] transition shadow-lg">
        Participez au vote
      </a>
    </section>
    <section class="text-center animate-fade-in">
      <h2 class="text-2xl font-semibold text-white mb-6">Suivez-nous</h2>
      <div class="flex justify-center space-x-6 text-3xl">
        <a href="https://web.facebook.com/KatangaAwards?locale=fr_FR" target="_blank" title="Facebook" class="text-[#fbcd43] hover:text-[#A28224] hover:scale-110 transition">
          <i class="fa-brands fa-facebook-f"></i>
        </a>
        <a href="https://x.com/awards_katanga?s=21" target="_blank" title="Twitter" class="text-[#fbcd43] hover:text-[#A28224] hover:scale-110 transition">
          <i class="fa-brands fa-twitter"></i>
        </a>
        <a href="https://www.instagram.com/katangaawards?igsh=NnBnbHR6MXV1engw" target="_blank" title="Instagram" class="text-[#fbcd43] hover:text-[#A28224] hover:scale-110 transition">
          <i class="fa-brands fa-instagram"></i>
        </a>
        <a href="https://www.linkedin.com/in/billy-makela-officiel-3b406836b" target="_blank" title="LinkedIn" class="text-[#fbcd43] hover:text-[#A28224] hover:scale-110 transition">
          <i class="fa-brands fa-linkedin-in"></i>
        </a>
        <a href="https://m.youtube.com/@katangaawards6869" target="_blank" title="YouTube" class="text-[#fbcd43] hover:text-[#A28224] hover:scale-110 transition">
          <i class="fa-brands fa-youtube"></i>
        </a>
        <a href="https://www.tiktok.com/@katangaawards?_t=ZM-90F3lFByLAS&_r=1" target="_blank" title="TikTok" class="text-[#fbcd43] hover:text-[#A28224] hover:scale-110 transition">
          <i class="fa-brands fa-tiktok"></i>
        </a>
      </div>
      <p class="text-gray-400 text-sm mt-4">Cliquez sur une icône pour visiter notre page.</p>
    </section>
  </main>

  <!-- FOOTER -->
  <footer class="bg-[#0a0a0a] border-t border-[#A28224] mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-center items-center text-sm text-gray-400">
        <p class="text-center">© 2025 Katanga Awards. Tous droits réservés.</p>
    </div>
  </footer>

  <script>
    window.addEventListener("load", () => {
      const loader = document.getElementById("loader");
      loader.style.animation = "fadeOut 1s forwards";
    });
  </script>

</body>
</html>
