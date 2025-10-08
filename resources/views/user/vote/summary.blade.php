<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Récapitulatif du vote - Katanga Award</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

    /* Animation du loader (même principe que sur index) */
    @keyframes fadeOut {
      from { opacity: 1; }
      to { opacity: 0; visibility: hidden; }
    }
  </style>
</head>
<body class="bg-black min-h-screen flex flex-col items-center p-4 text-white transition-colors duration-500">

  <!-- En-tête -->
  <div class="flex flex-col items-center mb-8">
    <img src="{{ asset('logo kataward.png') }}" alt="Katanga Award" class="w-24 mb-2">
    <h1 class="text-3xl sm:text-4xl font-extrabold text-[#fbcd43] mb-1">Katanga Award</h1>
    <p class="text-gray-300 text-sm sm:text-base text-center">
      Récapitulatif de votre vote pour l'édition <strong class="text-[#e3b017]">{{ $editionActive->titre ?? 'en cours' }}</strong>
    </p>
  </div>

  <!-- Conteneur principal -->
  <div class="bg-[#111] shadow-xl rounded-2xl p-6 max-w-6xl w-full text-center border border-[#A28224]/50">
    <h2 class="text-2xl font-bold mb-6 text-[#fbcd43]">Merci pour votre vote !</h2>

    <!-- Grille des votes -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      @foreach($votes as $vote)
        <div class="vote-block border border-[#A28224]/40 rounded-xl p-4 bg-[#A28224]/10 hover:bg-[#A28224]/20 transition transform hover:scale-105 hover:shadow-lg duration-300">

          <!-- Badge catégorie -->
          <span class="inline-block bg-[#fbcd43] text-black text-xs px-3 py-1 rounded-full mb-2 font-semibold">
            {{ $vote->categorie->nom_categorie }}
          </span>

          <!-- Contenu du candidat -->
          <div class="flex flex-col items-center mb-2">
            <img src="{{ asset($vote->candidat->photo_url) ?? 'https://via.placeholder.com/100' }}"
                 alt="{{ $vote->candidat->nom_complet }}"
                 class="w-24 h-24 rounded-full mb-2 object-cover border-4 border-[#fbcd43]">
          </div>

          <!-- Edition et nominée -->
          <p class="text-gray-200 text-sm mb-1">
            <strong>Katanga Award Éd. </strong> {{ $vote->edition->titre ?? $editionActive->titre ?? 'En cours' }}
          </p>
          <p class="text-gray-200 text-sm">
            <strong>Nominé(e) :</strong> {{ $vote->candidat->nom_complet }}
          </p>
        </div>
      @endforeach
    </div>

    <!-- Info et boutons -->
    <p class="mt-6 text-gray-400 text-sm">
      Vous pouvez faire une capture d'écran de cette page pour partager vos votes.
    </p>

    <div class="mt-4 flex flex-col sm:flex-row justify-center gap-4">
      <a href="{{ route('user.apropos') }}"
         class="bg-[#fbcd43] text-black font-semibold px-6 py-2 rounded hover:bg-[#A28224] transition">
        Nous lire plus
      </a>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="bg-[#111] border-t border-[#A28224] mt-10 w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-center items-center text-sm text-gray-400">
        <p class="text-center">© 2025 Katanga Award. Tous droits réservés.</p>
    </div>
  </footer>

</body>
</html>
