<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Récapitulatif du vote - Katanga Award</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('logo_kataward.png') }}">
  <script>
    // Détection du mode sombre
    if (
      localStorage.theme === 'dark' ||
      (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
      document.documentElement.classList.add('dark')
    } else {
      document.documentElement.classList.remove('dark')
    }
  </script>
  <style>
    /* Appliquer la police Poppins aux blocs de vote */
    .vote-block {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex flex-col items-center p-4 transition-colors duration-500">

  <!-- En-tête -->
  <div class="flex flex-col items-center mb-8">
    <img src="{{ asset('logo kataward.png') }}" alt="Katanga Award" class="w-24 mb-2">
    <h1 class="text-3xl sm:text-4xl font-extrabold text-[#A28224] dark:text-[#fbcd43] mb-1">Katanga Award</h1>
    <p class="text-gray-600 dark:text-gray-300 text-sm sm:text-base text-center">
      Récapitulatif de votre vote pour l'édition <strong>{{ $editionActive->titre ?? 'en cours' }}</strong>
    </p>
  </div>

  <!-- Conteneur principal -->
  <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-6 max-w-6xl w-full text-center transition-colors duration-500">
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Merci pour votre vote !</h2>

    <!-- Grille des votes -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      @foreach($votes as $vote)
        <div class="vote-block border border-[#A28224]/30 dark:border-[#A28224]/40 rounded-xl p-4 bg-[#A28224]/10 dark:bg-[#A28224]/20 transition transform hover:scale-105 hover:shadow-lg duration-300">
          
          <!-- Badge catégorie -->
          <span class="inline-block bg-[#A28224] text-white text-xs px-3 py-1 rounded-full mb-2">
            {{ $vote->categorie->nom_categorie }}
          </span>

          <!-- Contenu du candidat -->
          <div class="flex flex-col items-center mb-2">
            <img src="{{ asset($vote->candidat->photo_url) ?? 'https://via.placeholder.com/100' }}"
                 alt="{{ $vote->candidat->nom_complet }}"
                 class="w-24 h-24 rounded-full mb-2 object-cover border-4 border-[#A28224]">
          </div>

          <!-- Edition et nominée -->
          <p class="text-gray-700 dark:text-gray-200 text-sm mb-1">
            <strong>Katanga Award Éd. </strong> {{ $vote->edition->titre ?? $editionActive->titre ?? 'En cours' }}
          </p>
          <p class="text-gray-700 dark:text-gray-200 text-sm">
            <strong>Nominé(e) :</strong> {{ $vote->candidat->nom_complet }}
          </p>
        </div>
      @endforeach
    </div>

    <!-- Info et boutons -->
    <p class="mt-6 text-gray-500 dark:text-gray-400 text-sm">
      Vous pouvez faire une capture d'écran de cette page pour partager vos votes.
    </p>

    <div class="mt-4 flex flex-col sm:flex-row justify-center gap-4">
      <a href="{{ route('user.index') }}"
         class="bg-[#fbcd43] text-black px-6 py-2 rounded hover:bg-[#8f6e1a] transition">
        Retour à l'accueil
      </a>
    </div>
  </div>
</body>
</html>
