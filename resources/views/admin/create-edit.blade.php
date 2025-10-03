<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($Categorie) ? 'Modifier la catégorie' : 'Créer une catégorie' }} - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('flavicon-katanga-award.jpg') }}">


    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("-translate-x-full");
            document.getElementById("overlay").classList.toggle("hidden");
        }
    </script>
</head>
<body class="flex min-h-screen bg-gray-100 font-sans">

    <!-- Sidebar -->
    @include('components.aside-admin')

    <!-- Overlay (mobile) -->
    <div id="overlay" 
         class="fixed inset-0 bg-black bg-opacity-50 hidden z-40 md:hidden"
         onclick="toggleSidebar()"></div>

    <!-- Contenu principal -->
    <div class="flex-1 flex flex-col md:ml-64">

        <!-- Header mobile -->
        <header class="bg-white shadow p-4 flex items-center justify-between md:hidden">
            <button onclick="toggleSidebar()" class="text-blue-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <h1 class="text-lg font-bold">Admin</h1>
        </header>
        
        <!-- Contenu -->
        <main class="p-8 flex justify-center">
            
            <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-6 text-center">
                    {{ isset($Categorie) ? 'Modifier la catégorie' : 'Créer une catégorie' }}
                </h2>

                <form action="{{ isset($Categorie) ? route('categories.update', $Categorie->id) : route('categories.store') }}" 
                      method="POST" class="space-y-5">
                    @csrf
                    @if(isset($Categorie))
                        @method('PUT')
                    @endif

                    <!-- Nom de la catégorie -->
                    <div>
                        <label for="nom_categorie" class="block text-sm font-medium text-gray-700 mb-1">
                            Nom de la catégorie
                        </label>
                        <input type="text" name="nom_categorie" id="nom_categorie" 
                               value="{{ old('nom_categorie', $Categorie->nom_categorie ?? '') }}" 
                               required
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#A28224] focus:border-[#A28224]">
                        @error('nom_categorie')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sélection édition -->
                    <div>
                        <label for="edition_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Édition
                        </label>
                        <select name="edition_id" id="edition_id" required
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#A28224] focus:border-[#A28224]">
                            <option value="">-- Sélectionnez une édition --</option>
                            @foreach($Editions as $Edition)
                                <option value="{{ $Edition->id }}"
                                    {{ (old('edition_id', $Categorie->edition_id ?? '') == $Edition->id) ? 'selected' : '' }}>
                                    {{ $Edition->titre }}
                                </option>
                            @endforeach
                        </select>
                        @error('edition_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bouton -->
                    <div>
                        <button type="submit"
                                class="w-full py-2 px-4 bg-[#A28224] text-white font-semibold rounded-lg shadow hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#A28224]">
                            {{ isset($Categorie) ? 'Mettre à jour' : 'Créer' }}
                        </button>
                    </div>
                </form>
            </div>

        </main>
    </div>
<script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      sidebar.classList.toggle('-translate-x-full');
      overlay.classList.toggle('hidden');
    }

    // Graphique
    const categories = @json($categoriesLabels ?? []);
    const votes = @json($categoriesVotes ?? []);

    const ctx = document.getElementById('votesParCategorie').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: categories,
        datasets: [{
          label: 'Votes',
          data: votes,
          backgroundColor: 'rgba(162, 130, 36, 0.8)',
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  </script>
</body>
</html>
