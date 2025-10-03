<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Katanga Award | Message</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}">
  <!-- Font Awesome pour les icônes réseaux (Facebook, Twitter, Instagram, LinkedIn, YouTube, TikTok) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
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
          <a href="{{ route('user.contact') }}" class="block text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Contact</a>
      </div>
    </div>
  </nav>

  <script>
      const btn = document.getElementById('mobile-menu-button');
      const menu = document.getElementById('mobile-menu');
      btn.addEventListener('click', () => menu.classList.toggle('hidden'));
  </script>

  <!-- CONTENU PRINCIPAL -->
  <main class="flex-1 max-w-5xl mx-auto p-6">
    <section class="text-center mb-12">
      <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Contactez-nous</h1>
      <p class="text-gray-600 max-w-2xl mx-auto">
        Une question ? Un partenariat ? Une suggestion ?
        Remplissez le formulaire ci-dessous ou retrouvez-nous sur nos réseaux sociaux.
      </p>
    </section>

    <!-- Formulaire -->
    <section class="bg-white shadow-lg rounded-2xl p-8 mb-12">
      <form action="#" method="POST" class="grid grid-cols-1 gap-6">
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Nom complet</label>
          <input type="text" name="nom" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#A28224] outline-none" required>
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Adresse Email</label>
          <input type="email" name="email" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#A28224] outline-none" required>
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Sujet</label>
          <input type="text" name="sujet" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#A28224] outline-none" required>
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Message</label>
          <textarea name="message" rows="5" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#A28224] outline-none" required></textarea>
        </div>
        <button type="submit" class="bg-[#A28224] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#8b6c1d] transition">
          Envoyer
        </button>
      </form>
    </section>

    <!-- Réseaux sociaux -->
    <section class="text-center">
      <h2 class="text-2xl font-semibold text-gray-800 mb-6">Suivez-nous</h2>
      <div class="flex justify-center space-x-6 text-3xl">
        <a href="https://web.facebook.com/KatangaAwards?locale=fr_FR" aria-label="Facebook" class="hover:scale-110 transition transform" target="_blank" title="Facebook">
          <i class="fa-brands fa-facebook-f"></i>
        </a>
        <a href="https://x.com/awards_katanga?s=21" aria-label="Twitter" class="hover:scale-110 transition transform" target="_blank" title="Twitter">
          <i class="fa-brands fa-twitter"></i>
        </a>
        <a href="https://www.instagram.com/katangaawards?igsh=NnBnbHR6MXV1engw" aria-label="Instagram" class="hover:scale-110 transition transform" target="_blank" title="Instagram">
          <i class="fa-brands fa-instagram"></i>
        </a>
        <a href="https://www.linkedin.com/in/billy-makela-officiel-3b406836b?trk=people-search-result" aria-label="LinkedIn" class="hover:scale-110 transition transform" target="_blank" title="LinkedIn">
          <i class="fa-brands fa-linkedin-in"></i>
        </a>
        <a href="https://m.youtube.com/@katangaawards6869" aria-label="YouTube" class="hover:scale-110 transition transform" target="_blank" title="YouTube">
          <i class="fa-brands fa-youtube"></i>
        </a>
        <!-- TikTok ajouté -->
        <a href="https://www.tiktok.com/@katangaawards?_t=ZM-90F3lFByLAS&_r=1" aria-label="TikTok" class="hover:scale-110 transition transform" target="_blank" title="TikTok">
          <i class="fa-brands fa-tiktok"></i>
        </a>
      </div>
      <p class="text-gray-500 text-sm mt-4">Cliquez sur une icône pour visiter notre page.</p>
    </section>
  </main>

  <!-- FOOTER -->
  <footer class="bg-white border-t mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-center items-center text-sm text-gray-500">
        <p class="text-center">© 2025 Katanga Award. Tous droits réservés.</p>
    </div>
  </footer>

  <script>
    // Loader disparaît après chargement
    window.addEventListener("load", () => {
      const loader = document.getElementById("loader");
      loader.style.animation = "fadeOut 1s forwards";
    });
  </script>

</body>
</html>
