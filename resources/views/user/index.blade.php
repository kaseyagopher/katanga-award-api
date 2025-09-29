<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catégories</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">


  <nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    @include('components.nav-user')
    </div>
  </nav>

  <main class="flex-1 max-w-7xl mx-auto p-6">

    <h2 class="text-2xl font-bold mb-4">Catégories</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @forelse($Categories as $Categorie)
        <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center">
          <h3 class="text-lg font-semibold mb-2">{{ $Categorie->nom_categorie }}</h3>
          @if($Categorie->description)
            <p class="text-gray-600 text-sm mb-4">{{ $Categorie->description }}</p>
          @endif
        </div>
      @empty
        <p class="col-span-full text-center text-gray-500">Aucune catégorie disponible</p>
      @endforelse
    </div>

  </main>

</body>
</html>
