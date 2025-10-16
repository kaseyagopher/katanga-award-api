<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Détails du candidat | Katanga Award</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}">
</head>

<body class="bg-black text-white min-h-screen flex flex-col">

  <!-- NAVBAR -->
  <nav class="bg-[#111] border-b-2 border-[#fbcd43] shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
      <div class="flex items-center space-x-2 px-4 py-1">
          <a href="{{ route('user.index') }}" class="flex items-center space-x-2">
          <img src="{{ asset('logo_officiel.jpg') }}" alt="Katanga Award" class="h-10 w-auto">
          <span class="text-white font-bold" >KATANGA</span><span class="text-[#e3b017] font-bold"> AWARDS</span>
        </a>
        </div>
      <a href="{{ route('user.index') }}"
         class="text-[#fbcd43] font-semibold hover:text-[#A28224] transition">← Retour</a>
    </div>
  </nav>

  <!-- CONTENU PRINCIPAL -->
  <main class="flex-1 flex items-center justify-center p-6">
    <div class="max-w-3xl w-full bg-[#111] rounded-2xl shadow-lg p-8 text-center border border-[#fbcd43]/30">

      <!-- Photo du candidat -->
      <div class="flex justify-center mb-6">
        <div class="w-20 h-20 rounded-full overflow-hidden border-4 border-[#fbcd43] shadow-lg">
          <img src="{{ asset($candidat->photo_url) }}"
               alt="{{ $candidat->nom_complet }}"
               class="w-full h-full object-cover">
        </div>
      </div>

      <!-- Nom et catégorie -->

      <h1 class="text-2xl font-bold mb-2 text-[#fbcd43]">{{ $candidat->nom_complet }}</h1>
      <p class="text-gray-300 italic mb-6">
        Categorie : {{ $candidat->categorie->nom_categorie ?? 'Catégorie non définie' }}
        <br>

            <strong>Katanga Awards Éd. </strong> {{ $edition->titre ?? $editionActive->titre ?? 'En cours' }}

      </p>

      <!-- Description -->
      <div class="bg-[#222] rounded-xl p-6 border border-[#fbcd43]/20 text-left mb-6">
        <p class="text-gray-300 leading-relaxed">

          {{ $candidat->description ?? 'Aucune description disponible pour ce candidat.' }}
        </p>
      </div>

      <!-- BOUTONS ACTION -->
      <div class="flex flex-wrap justify-center gap-4 mt-6">

        <!-- BOUTON VOTER -->
        @php
          $editionActive = \App\Models\Edition::where('statut', true)->first();
          $aVote = false;
          if($editionActive && Auth::guard('web')->check()) {
              $aVote = \App\Models\Vote::where('user_id', Auth::guard('web')->id())
                                        ->where('edition_id', $editionActive->id)
                                        ->exists();
          }
        @endphp

        @if(Auth::guard('web')->check())
          @if($editionActive && !$aVote)
            <a href="{{route('user.vote')}}" class="bg-[#fbcd43] text-black font-semibold px-6 py-2 rounded-md hover:bg-[#A28224] transition">
                Voter
            </a>
          @elseif($editionActive)
            <button class="bg-gray-500 text-white font-semibold px-6 py-2 rounded-md cursor-not-allowed">
              Vous avez déjà voté
            </button>
          @else
            <button class="bg-gray-500 text-white font-semibold px-6 py-2 rounded-md cursor-not-allowed">
              Aucune édition active
            </button>
          @endif
        @else
          <a href="{{ route('login') }}"
             class="bg-[#fbcd43] text-black font-semibold px-6 py-2 rounded-md hover:bg-[#A28224] transition">
             Connectez-vous pour voter
          </a>
        @endif

        <!-- BOUTON PARTAGER -->
        <button id="shareBtn"
                class="flex items-center gap-2 bg-[#fbcd43] text-black font-semibold px-6 py-2 rounded-md hover:bg-[#A28224] transition">
          <span class="material-icons">share</span> Partager
        </button>

      </div>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="bg-[#111] border-t border-[#A28224] py-4 mt-auto text-center text-gray-400 text-sm">
    © 2025 Katanga Award. Tous droits réservés.
  </footer>

  <!-- SCRIPT PARTAGE -->
  <script>
    const shareBtn = document.getElementById('shareBtn');
    shareBtn.addEventListener('click', async () => {
      const shareData = {
        title: 'Vote pour {{ $candidat->nom_complet }} - Katanga Award',
        text: 'Découvre le profil de {{ $candidat->nom_complet }} sur Katanga Award et vote pour lui !',
        url: "{{ url()->current() }}"
      };

      if (navigator.share) {
        try {
          await navigator.share(shareData);
        } catch (err) {
          console.log('Partage annulé', err);
        }
      } else {
        // Fallback WhatsApp si partage natif non supporté
        const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(shareData.text + ' ' + shareData.url)}`;
        window.open(whatsappUrl, '_blank');
      }
    });
  </script>

</body>
</html>
