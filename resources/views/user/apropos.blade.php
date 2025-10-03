<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Katanga Award | À propos</title>
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
          <a href="{{ route('user.apropos') }}" class="text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">À propos</a>
            <a href="{{ route('user.contact') }}" class="text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Contact</a>
        </div>

        <!-- Boutons utilisateur -->
        <div class="flex items-center space-x-2">
          @if(Auth::guard('web')->check())
              <strong class="px-4 truncate max-w-[120px] text-right">
                  {{ Auth::guard('web')->user()->numero ?? Auth::guard('web')->user()->email }}
              </strong>
          @else
              <p class="text-orange-500 font-semibold">UNKNOW</p>
          @endif
        </div>

        <!-- Hamburger mobile -->
        <div class="md:hidden flex items-center">
            <button id="mobile-menu-button" class="text-gray-700 focus:outline-none">
                <span class="material-icons">menu</span>
            </button>
        </div>
      </div>

      <!-- Menu mobile -->
      <div id="mobile-menu" class="hidden md:hidden mt-2 space-y-2">
          <a href="{{ route('user.index') }}" class="block text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Accueil</a>
          <a href="#" class="block text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Résultats</a>
          <a href="{{ route('user.apropos') }}" class="block text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">À propos</a>
      </div>
    </div>
  </nav>

  <script>
      const btn = document.getElementById('mobile-menu-button');
      const menu = document.getElementById('mobile-menu');
      btn.addEventListener('click', () => menu.classList.toggle('hidden'));
  </script>

  <!-- CONTENU PRINCIPAL -->
  <main class="flex-1 max-w-7xl mx-auto p-6">

    <!-- Section Présentation -->
    <section class="mb-12 text-center animate-fade-in">
      <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">À propos du Katanga Award</h1>
      <p class="text-gray-600 max-w-3xl mx-auto leading-relaxed">
        Le <span class="font-semibold text-[#A28224]">Katanga Award</span> est un événement prestigieux qui met en lumière
        et récompense les talents, initiatives et réussites des acteurs qui contribuent au rayonnement de notre région.
        Plus qu'une cérémonie, c'est un espace de reconnaissance et de valorisation qui célèbre l’excellence,
        la créativité et l’engagement.
      </p>
    </section>

    <!-- Mission et Vision -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
      <div class="bg-white shadow-md rounded-2xl p-6 hover:shadow-lg transition transform hover:-translate-y-1">
        <h2 class="text-2xl font-semibold text-[#A28224] mb-4">Notre Mission</h2>
        <p class="text-gray-600 leading-relaxed">
          Promouvoir et récompenser les efforts des individus et organisations qui œuvrent dans
          différents domaines tels que la culture, l’innovation, l’entrepreneuriat, la musique,
          le sport et bien d’autres, afin d’inspirer les générations futures.
        </p>
      </div>
      <div class="bg-white shadow-md rounded-2xl p-6 hover:shadow-lg transition transform hover:-translate-y-1">
        <h2 class="text-2xl font-semibold text-[#A28224] mb-4">Notre Vision</h2>
        <p class="text-gray-600 leading-relaxed">
          Faire du <span class="font-semibold">Katanga Award</span> une référence nationale et
          internationale en matière de célébration de l’excellence, en devenant un levier
          de motivation et de développement pour toute la jeunesse congolaise.
        </p>
      </div>
    </section>

    <!-- Valeurs -->
    <section class="mb-12">
      <h2 class="text-2xl font-semibold text-center text-gray-800 mb-8">Nos Valeurs</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <div class="bg-[#A28224]/10 rounded-xl p-6 text-center hover:scale-105 transition">
          <h3 class="text-lg font-bold text-[#A28224] mb-2">Excellence</h3>
          <p class="text-gray-600 text-sm">Récompenser ceux qui se distinguent par leur savoir-faire et leur impact.</p>
        </div>
        <div class="bg-[#A28224]/10 rounded-xl p-6 text-center hover:scale-105 transition">
          <h3 class="text-lg font-bold text-[#A28224] mb-2">Innovation</h3>
          <p class="text-gray-600 text-sm">Mettre en avant les projets créatifs qui transforment positivement la société.</p>
        </div>
        <div class="bg-[#A28224]/10 rounded-xl p-6 text-center hover:scale-105 transition">
          <h3 class="text-lg font-bold text-[#A28224] mb-2">Engagement</h3>
          <p class="text-gray-600 text-sm">Valoriser l’esprit de service, le leadership et la contribution active.</p>
        </div>
      </div>
    </section>

    <!-- Historique -->
    <section class="bg-white shadow-md rounded-2xl p-8 mb-12">
      <h2 class="text-2xl font-semibold text-gray-800 mb-4">Notre Histoire</h2>
      <p class="text-gray-600 leading-relaxed">
        Créé pour honorer les talents et inspirer toute une génération, le <span class="font-semibold text-[#A28224]">Katanga Award</span>
        est devenu au fil des années une cérémonie incontournable dans le paysage culturel et social.
        Chaque édition rassemble des milliers de participants, témoignant de l’importance de célébrer
        nos propres héros et modèles de réussite.
      </p>
    </section>

    <!-- Call to Action -->
    <section class="text-center">
      <h2 class="text-2xl font-semibold text-gray-800 mb-4">Rejoignez l’aventure Katanga Award</h2>
      <p class="text-gray-600 mb-6">Venez célébrer avec nous l’excellence et soutenir ceux qui façonnent l’avenir.</p>
      <a href="{{ route('user.vote') }}" class="bg-[#A28224] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#8b6c1d] transition">
        Participez au vote
      </a>
    </section>

  </main>

  <!-- FOOTER -->
  <footer class="bg-white border-t mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-center items-center text-sm text-gray-500">
        <p class="text-center">© 2025 Katanga Award. Tous droits réservés.</p>
    </div>
  </footer>

  <script>
    // Loader disparaît après 2 secondes
    window.addEventListener("load", () => {
      const loader = document.getElementById("loader");
      loader.style.animation = "fadeOut 1s forwards";
    });
  </script>

</body>
</html>
