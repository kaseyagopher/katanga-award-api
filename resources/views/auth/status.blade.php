<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catégories</title>
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
        <div>
          <button class="bg-[#A28224] text-white px-4 py-2 rounded-md hover:bg-[#A28224]/90 focus:outline-none focus:ring-2 focus:ring-[#A28224]/50">
            Voter
          </button>
        </div>
      </div>
    </div>
  </nav>

  <!-- Contenu principal -->
  <main class="flex-1 max-w-7xl mx-auto p-6">

    <!-- Status de connexion -->
    <div class="mb-6 text-center">
      @if(Auth::guard('web')->check())
        <p class="text-green-600 font-semibold">
          Vous êtes connecté en tant que User : <strong>{{ Auth::guard('web')->user()->numero ?? Auth::guard('web')->user()->email }}</strong>
        </p>
        <form method="POST" action="" class="mt-2">
          @csrf
          <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Se déconnecter</button>
        </form>
      @elseif(Auth::guard('admin')->check())
        <p class="text-green-600 font-semibold">
          Vous êtes connecté en tant qu'Admin : <strong>{{ Auth::guard('admin')->user()->email }}</strong>
        </p>
      @else
        <p class="text-orange-500 font-semibold">Vous n'êtes pas connecté.</p>
      @endif
    </div>

    <!-- Liste des catégories -->
    <h2 class="text-2xl font-bold mb-4">Catégories</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @forelse($Categories as $Categorie)
        <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center">
          <h3 class="text-lg font-semibold mb-2">{{ $Categorie->nom_categorie }}</h3>
          @if($Categorie->description)
            <p class="text-gray-600 text-sm mb-4">{{ $Categorie->description }}</p>
          @endif
          <button class="bg-[#A28224] text-white px-4 py-2 rounded hover:bg-[#A28224]/90 focus:outline-none focus:ring-2 focus:ring-[#A28224]/50">
            Voter
          </button>
        </div>
      @empty
        <p class="col-span-full text-center text-gray-500">Aucune catégorie disponible</p>
      @endforelse
    </div>

  </main>

</body>
</html>
