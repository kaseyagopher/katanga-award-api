<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Katanga Award | Message</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <style>
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
<body class="bg-black min-h-screen flex flex-col relative text-white">

  <!-- Loader -->
  <div id="loader" class="fixed inset-0 bg-black flex flex-col items-center justify-center z-50">
    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-[#A28224] mb-4"></div>
    <h1 class="text-2xl font-bold text-[#fbcd43]">Katanga Awards</h1>
  </div>

  <!-- NAVBAR -->
  <nav class="bg-dark border-b border-[#fbcd43] shadow-md  top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16 items-center">

        <!-- Logo -->
        <a href="{{ route('user.index') }}" class="flex items-center space-x-2">
          <img src="{{ asset('logo_officiel.jpg') }}" alt="Katanga Award" class="h-10 w-auto">
          <span class="text-white font-bold" >KATANGA</span><span class="text-[#e3b017] font-bold"> AWARDS</span>
        </a>

        <!-- Liens desktop -->
        <div class="hidden md:flex items-center space-x-4">
          <a href="{{ route('user.index') }}" class="text-gray-300 hover:text-[#A28224] font-semibold px-3 py-2">Accueil</a>
          <a href="#" class="text-gray-300 hover:text-[#A28224] font-semibold px-3 py-2">Résultats</a>
          <a href="{{ route('user.apropos') }}" class="text-gray-300 hover:text-[#A28224] font-semibold px-3 py-2">À propos</a>
          <a href="{{ route('user.contact') }}" class="text-gray-300 hover:text-[#A28224] font-semibold px-3 py-2">Contact</a>
        </div>

        <!-- Utilisateur -->
        <div class="hidden md:block">
          @if(Auth::guard('web')->check())
              <span class="px-4 truncate max-w-[120px] text-right font-medium text-gray-200">
                  {{ Auth::guard('web')->user()->numero ?? Auth::guard('web')->user()->email }}
              </span>
          @else
              <p class="text-[#fbcd43] font-semibold">UNKNOW</p>
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
          <a href="{{ route('user.apropos') }}" class="block text-gray-300 hover:text-[#A28224] font-semibold px-3 py-2">À propos</a>
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
  <main class="flex-1 max-w-5xl mx-auto p-6">

    <!-- Titre -->
    <section class="text-center mb-12 animate-fade-in">
      <h1 class="text-3xl md:text-4xl font-bold text-[#fbcd43] mb-4">Contactez-nous</h1>
      <p class="text-gray-300 max-w-2xl mx-auto">
        Une question ? Un partenariat ? Une suggestion ?<br>
        Remplissez le formulaire ci-dessous ou retrouvez-nous sur nos réseaux sociaux.
      </p>
    </section>

    <!-- Formulaire -->
    <section class="bg-[#111] shadow-lg rounded-2xl p-8 mb-12 animate-fade-in border border-[#2d2d2d]">
        @if(session('success'))
            <p class="mt-4 text-green-400 font-semibold">{{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p class="mt-4 text-red-400 font-semibold">{{ session('error') }}</p>
        @endif

      <form action="{{ route('user.mail') }}" method="POST" class="grid grid-cols-1 gap-6">
        @csrf
        <div>
          <label class="block text-sm font-semibold text-gray-200 mb-2">Nom complet</label>
          <input type="text" name="nom" class="w-full bg-black border border-gray-700 rounded-lg p-3 text-white focus:ring-2 focus:ring-[#A28224] outline-none" required>
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-200 mb-2">Adresse Email</label>
          <input type="email" name="email" class="w-full bg-black border border-gray-700 rounded-lg p-3 text-white focus:ring-2 focus:ring-[#A28224] outline-none" required>
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-200 mb-2">Sujet</label>
          <input type="text" name="sujet" class="w-full bg-black border border-gray-700 rounded-lg p-3 text-white focus:ring-2 focus:ring-[#A28224] outline-none" required>
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-200 mb-2">Message</label>
          <textarea name="message" rows="5" class="w-full bg-black border border-gray-700 rounded-lg p-3 text-white focus:ring-2 focus:ring-[#A28224] outline-none" required></textarea>
        </div>
        <button type="submit" class="bg-[#e3b017] text-black px-6 py-3 rounded-lg font-semibold hover:bg-[#A28224] transition shadow-lg">
          Envoyer
        </button>
      </form>
    </section>

    <!-- Réseaux sociaux -->

  </main>

  <!-- FOOTER -->
  <footer class="bg-[#111] border-t border-[#2d2d2d] mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-center items-center text-sm text-gray-400">
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
