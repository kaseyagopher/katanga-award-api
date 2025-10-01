<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Récapitulatif du vote</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center p-4">

  <div class="bg-white shadow-md rounded-xl p-6 max-w-xl w-full text-center">
    <h1 class="text-2xl font-bold mb-4">Merci pour votre vote !</h1>
    <p class="text-gray-600 mb-6">Édition : <strong>{{ $editionActive->titre ?? 'Édition en cours' }}</strong></p>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      @foreach($votes as $vote)
        <div class="border rounded-lg p-4 bg-[#A28224]/10">
          <h2 class="font-semibold text-gray-800 mb-2">{{ $vote->categorie->nom_categorie }}</h2>
          <div class="flex flex-col items-center">
            <img src="{{ $vote->candidat->photo_url ?? 'https://via.placeholder.com/100' }}"
                 alt="{{ $vote->candidat->nom_complet }}"
                 class="w-20 h-20 rounded-full mb-2 object-cover border-2 border-[#A28224]">
            <span class="font-bold text-[#A28224]">{{ $vote->candidat->nom_complet }}</span>
          </div>
        </div>
      @endforeach
    </div>

    <p class="mt-6 text-gray-500 text-sm">Vous pouvez faire une capture d'écran de cette page pour partager vos votes.</p>

    <a href="{{ route('user.index') }}" class="mt-4 inline-block bg-[#A28224] text-white px-4 py-2 rounded hover:bg-[#8f6e1a] transition">
      Retour à l'accueil
    </a>
  </div>

</body>
</html>
