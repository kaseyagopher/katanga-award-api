<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des Votes - Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}">
</head>

<body class="flex min-h-screen bg-gray-100 font-sans">
  <!-- Sidebar -->
  @include('components.aside-admin')

  <!-- Contenu principal -->
  <div class="flex-1 flex flex-col md:ml-64">
    <header class="bg-white shadow p-4 flex items-center justify-between">
      <h1 class="text-2xl font-bold text-gray-800">Gestion des Votes par Candidat</h1>
      <a href="{{ route('admin.dashboard') }}"
         class="bg-[#A28224] text-white px-4 py-2 rounded hover:bg-[#8f6f1c]">
         Retour au tableau de bord
      </a>
    </header>

    <main class="p-6">
      @if($candidats->isEmpty())
        <div class="text-center text-gray-500">
          Aucun candidat trouvé.
        </div>
      @else
        <!-- ✅ Affichage en grille -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          @foreach($candidats as $candidat)
            <div class="bg-white shadow-lg rounded-lg border border-gray-200 overflow-hidden flex flex-col">

              <!-- En-tête du candidat -->
              <div class="flex items-center gap-4 bg-[#111] text-white p-4">
                <img src="{{ asset($candidat->photo_url) }}"
                     alt="{{ $candidat->nom_complet }}"
                     class="w-16 h-16 rounded-full object-cover border-2 border-[#A28224]">
                <div>
                  <h2 class="text-lg font-bold">{{ $candidat->nom_complet }}</h2>
                  <p class="text-sm text-gray-300">
                    Catégorie : {{ $candidat->categorie->nom_categorie ?? 'Non définie' }}
                  </p>
                  <p class="text-sm text-gray-400">
                    Total votes : <span class="text-[#fbcd43] font-semibold">{{ $candidat->votes_count }}</span>
                  </p>
                </div>
              </div>

              <!-- Liste des votes -->
              <div class="overflow-y-auto max-h-64">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                  <thead class="bg-gray-800 text-white sticky top-0">
                    <tr>
                      <th class="px-4 py-2 text-left font-semibold">Utilisateur</th>
                      <th class="px-4 py-2 text-left font-semibold">Date</th>
                      <th class="px-4 py-2 text-center font-semibold">Action</th>
                    </tr>
                  </thead>

                  <tbody class="divide-y divide-gray-100">
                    @forelse($candidat->votes as $vote)
                      <tr>
                        <td class="px-4 py-2">{{ $vote->user->numero ?? 'Utilisateur supprimé' }}</td>
                        <td class="px-4 py-2 text-gray-700">
                          {{ $vote->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-2 text-center">
                          <form action="{{ route('admin-vote-destroy', $vote->id) }}" method="POST"
                                onsubmit="return confirm('Voulez-vous vraiment supprimer ce vote ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-xs">
                              Annuler
                            </button>
                          </form>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="3" class="px-4 py-2 text-center text-gray-500">
                          Aucun vote.
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </main>
  </div>
</body>
</html>
