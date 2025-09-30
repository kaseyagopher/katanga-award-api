<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Vote en ligne</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>
<body class="flex min-h-screen bg-gray-100 font-sans">

  <!-- Sidebar -->
  @include('components.aside-admin')

  <!-- Contenu principal -->
  <div class="flex-1 flex flex-col md:ml-64">
    <main class="p-8 space-y-8">
      <h1 class="text-3xl font-bold mb-4">Tableau de bord Admin</h1>

      <!-- Section cartes -->
      <section>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
          <div class="bg-black text-white p-6 rounded-lg shadow">
            <div class="text-sm">Nombre de candidats</div>
            <div class="text-2xl font-bold">{{ $nbCandidats ?? 0 }}</div>
          </div>
          <div class="bg-[#A28224] text-white p-6 rounded-lg shadow">
            <div class="text-sm">Nombre de catégories</div>
            <div class="text-2xl font-bold">{{ $nbCategories ?? 0 }}</div>
          </div>
          <div class="bg-blue-600 text-white p-6 rounded-lg shadow">
            <div class="text-sm">Nombre d’éditions</div>
            <div class="text-2xl font-bold">{{ $nbEditions ?? 0 }}</div>
          </div>
          <div class="bg-green-600 text-white p-6 rounded-lg shadow">
            <div class="text-sm">Votes enregistrés</div>
            <div class="text-2xl font-bold">{{ $nbVotes ?? 0 }}</div>
          </div>
        </div>
      </section>

      <!-- Édition active -->
      <section class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-2">Édition en cours</h2>
        @if($editionActive)
          <p><span class="font-semibold">Titre :</span> {{ $editionActive->titre }}</p>
          <p><span class="font-semibold">Thème :</span> {{ $editionActive->theme }}</p>
          <p><span class="font-semibold">Statut :</span> 
            <span class="px-2 py-1 rounded text-white {{ $editionActive->statut ? 'bg-green-600' : 'bg-red-600' }}">
              {{ $editionActive->statut ? 'Active' : 'Clôturée' }}
            </span>
          </p>
        @else
          <p>Aucune édition active pour le moment.</p>
        @endif
      </section>

      <!-- Top candidats -->
      <section class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Top 3 Candidats</h2>
        <div class="space-y-4">
          @foreach($topCandidats as $candidat)
            <div class="flex items-center gap-4">
              <img src="{{ $candidat->photo_url }}" alt="{{ $candidat->nom_complet }}" class="w-12 h-12 rounded-full object-cover">
              <div class="flex-1">
                <div class="font-semibold">{{ $candidat->nom_complet }}</div>
                <div class="text-sm text-gray-600">{{ $candidat->categorie->nom }}</div>
              </div>
              <div class="text-lg font-bold">{{ $candidat->votes_count }}</div>
            </div>
          @endforeach
        </div>
      </section>

      <!-- Graphique votes par catégorie -->
      <section class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Répartition des votes par catégorie</h2>
        <canvas id="votesParCategorie"></canvas>
      </section>

      <!-- Activité récente -->
      <section class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Activité récente</h2>
        <ul class="divide-y divide-gray-200">
          @foreach($recentVotes as $vote)
            <li class="py-2 text-sm">
              <span class="font-semibold">{{ $vote->user->name }}</span> a voté pour 
              <span class="font-semibold">{{ $vote->candidat->nom_complet }}</span> 
              ({{ $vote->candidat->categorie->nom }}) – 
              <span class="text-gray-500">{{ $vote->created_at->diffForHumans() }}</span>
            </li>
          @endforeach
        </ul>
      </section>
    </main>
  </div>

  <script>
    // Données envoyées depuis Laravel
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
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  </script>
</body>
</html>
