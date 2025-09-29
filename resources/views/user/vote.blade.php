<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vote en ligne</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Barre de navigation -->
  <nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16 items-center">
        <div class="flex space-x-4">
          <a href="#" class="text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Accueil</a>
          <a href="#" class="text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Catégories</a>
          <a href="#" class="text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Résultats</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Contenu -->
  <main class="flex-1 max-w-4xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6 text-center">Formulaire de vote</h1>

    @if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('vote.store') }}" method="POST">
    @csrf
    @foreach($Categories as $Categorie)
        <div class="border border-gray-200 p-4 rounded-lg">
          <h2 class="text-lg font-semibold mb-3">{{ $Categorie->nom_categorie }}</h2>

          @if($Categorie->Candidats->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
              @foreach($Categorie->Candidats as $Candidat)
                <label class="flex flex-col items-center border rounded-lg p-3 cursor-pointer hover:shadow-md transition">
                  <input type="radio" 
                         name="votes[{{ $Categorie->id }}]" 
                         value="{{ $Candidat->id }}" 
                         class="mb-2">
                  <img src="{{ $Candidat->photo_url }}" 
                       alt="{{ $Candidat->nom_complet }}" 
                       class="w-24 h-24 object-cover rounded mb-2">
                  <span class="font-medium">{{ $Candidat->nom_complet }}</span>
                </label>
              @endforeach
            </div>
          @else
            <p class="text-gray-500">Aucun candidat pour cette catégorie</p>
          @endif
        </div>
    @endforeach

    <!-- Infos globales -->
    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
    <input type="hidden" name="edition_id" value="{{ $edition->id }}">

    <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
        Voter
    </button>
</form>

  </main>

</body>
</html>
