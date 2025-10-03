<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Vote en ligne</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://unpkg.com/alpinejs" defer></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}">
  <script>
    function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("-translate-x-full");
      document.getElementById("overlay").classList.toggle("hidden");
    }

    function previewImage(event) {
      const preview = document.getElementById("preview");
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = e => {
          preview.src = e.target.result;
          preview.classList.remove("hidden");
        };
        reader.readAsDataURL(file);
      }
    }
  </script>
</head>
<body class="flex min-h-screen bg-gray-100 font-sans">

  <!-- Sidebar -->
  @include('components.aside-admin')

  <!-- Overlay (mobile only) -->
  <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40 md:hidden" onclick="toggleSidebar()"></div>
  
  <!-- Contenu principal -->
  <div class="flex-1 flex flex-col md:ml-64 p-6">
    <h2 class="text-xl font-bold mb-6 text-center">{{ isset($Candidat) ? 'Modifier le candidat' : 'Créer un candidat' }}</h2>

    <form action="{{ isset($Candidat) ? route('candidats.update', $Candidat->id) : route('candidats.store') }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="bg-white p-6 rounded-lg shadow-md">
      @csrf
      @if(isset($Candidat))
          @method('PUT')
      @endif

      <div class="grid grid-cols-3 gap-6">

        <!-- Colonne 1 : Photo -->
        <div class="flex flex-col items-center">
          <label class="block text-sm font-medium text-gray-700 mb-2">Photo</label>
          <input type="file" name="photo_url" id="photo_url" accept="image/*" onchange="previewImage(event)"
                 class="border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 w-full"
                 {{ isset($Candidat) ? '' : 'required' }}>
          <img id="preview" 
               src="{{ isset($Candidat) && $Candidat->photo_url ? $Candidat->photo_url : '' }}" 
               alt="Prévisualisation" 
               class="w-32 h-32 object-cover rounded shadow mt-3 {{ isset($Candidat) && $Candidat->photo_url ? '' : 'hidden' }}">
          @error('photo_url')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Colonne 2 : Nom et Description -->
        <div class="flex flex-col">
          <!-- Nom -->
          <div class="mb-4">
            <label for="nom_complet" class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
            <input type="text" name="nom_complet" id="nom_complet" 
                   value="{{ old('nom_complet', $Candidat->nom_complet ?? '') }}" 
                   required
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
            @error('nom_complet')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Description -->
          <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" id="description" rows="6" required
                      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">{{ old('description', $Candidat->description ?? '') }}</textarea>
            @error('description')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <!-- Colonne 3 : Catégorie et Édition -->
        <div class="flex flex-col">
          <!-- Catégorie -->
          <div class="mb-4">
            <label for="categorie_id" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
            <select name="categorie_id" id="categorie_id" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
              <option value="">-- Sélectionnez une catégorie --</option>
              @foreach($Categories as $Categorie)
                <option value="{{ $Categorie->id }}" 
                    {{ (old('categorie_id', $Candidat->categorie_id ?? '') == $Categorie->id) ? 'selected' : '' }}>
                  {{ $Categorie->nom_categorie }}
                </option>
              @endforeach
            </select>
            @error('categorie_id')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Édition -->
          <div>
            <label for="edition_id" class="block text-sm font-medium text-gray-700 mb-1">Édition</label>
            <select name="edition_id" id="edition_id" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
              <option value="">-- Sélectionnez une édition --</option>
              @foreach($Editions as $Edition)
                <option value="{{ $Edition->id }}" 
                    {{ (old('edition_id', $Candidat->edition_id ?? '') == $Edition->id) ? 'selected' : '' }}>
                  {{ $Edition->titre ?? $Edition->nom_edition }}
                </option>
              @endforeach
            </select>
            @error('edition_id')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </div>

      <!-- Bouton -->
      <div class="flex justify-end mt-6">
        <button type="submit" 
                class="px-6 py-2 bg-black text-white rounded-lg shadow  transition">
          {{ isset($Candidat) ? 'Mettre à jour' : 'Créer' }}
        </button>
      </div>
    </form>
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
