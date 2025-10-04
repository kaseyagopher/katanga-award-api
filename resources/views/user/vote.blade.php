<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Katanga Award | Vote</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- NAVBAR -->
  <nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16 items-center">

        <!-- Liens Desktop -->
        <div class="hidden md:flex items-center space-x-4">
          <a href="{{ route('user.index') }}" 
             class="text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md 
             {{ Route::currentRouteName() === 'user.index' ? 'text-[#A28224]' : '' }}">
             Accueil
          </a>
          <a href="#" 
             class="text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">
             Résultats
          </a>
          <a href="{{ route('user.apropos') }}" 
             class="text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md 
             {{ Route::currentRouteName() === 'user.apropos' ? 'text-[#A28224]' : '' }}">
             À propos
          </a>
          <a href="{{ route('user.contact') }}" 
             class="text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md 
             {{ Route::currentRouteName() === 'user.contact' ? 'text-[#A28224]' : '' }}">
             Contact
          </a>
        </div>

        <!-- Logo au centre -->
        <div class="flex items-center space-x-2 px-4 py-1">
          <span class="font-bold text-lg">
            <span class="text-black">Katanga</span>
            <span class="text-[#A28224]"> Award</span>
          </span>
        </div>

        <!-- Boutons utilisateur -->
        <div class="flex items-center space-x-2">
          @if(Auth::guard('web')->check())
              <strong class="px-4 truncate max-w-[120px] text-right">
                  {{ Auth::guard('web')->user()->numero ?? Auth::guard('web')->user()->email }}
              </strong>
          @else
              <p class="text-orange-500 font-semibold">UNKNOW</p>
          @endif
        </div>

        <!-- Hamburger Mobile -->
        <div class="md:hidden flex items-center">
          <button id="mobile-menu-button" class="text-gray-700 focus:outline-none">
            <span class="material-icons">menu</span>
          </button>
        </div>
      </div>

      <!-- Menu Mobile -->
      <div id="mobile-menu" class="hidden md:hidden mt-2 space-y-2">
        <a href="{{ route('user.index') }}" 
           class="block text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md 
           {{ Route::currentRouteName() === 'user.index' ? 'text-[#A28224]' : '' }}">
           Accueil
        </a>
        <a href="#" 
           class="block text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">
           Résultats
        </a>
        <a href="{{ route('user.apropos') }}" 
           class="block text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md 
           {{ Route::currentRouteName() === 'user.apropos' ? 'text-[#A28224]' : '' }}">
           À propos
        </a>
        <a href="{{ route('user.contact') }}" 
           class="block text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md 
           {{ Route::currentRouteName() === 'user.contact' ? 'text-[#A28224]' : '' }}">
           Contact
        </a>
      </div>
    </div>
  </nav>

  
  <!-- CONTENU PRINCIPAL -->
  <main class="flex-1 max-w-5xl mx-auto p-6">
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
        <div class="border border-gray-200 p-4 rounded-lg mb-4">
          <h2 class="text-lg font-semibold mb-3">{{ $Categorie->nom_categorie }}</h2>

          @if($Categorie->Candidats->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
              @foreach($Categorie->Candidats as $Candidat)
                <label class="flex flex-col items-center cursor-pointer select-none">
                  <input type="radio"
                         name="votes[{{ $Categorie->id }}]"
                         value="{{ $Candidat->id }}"
                         class="hidden peer">
                  <div class="w-full bg-white border border-gray-300 rounded-lg p-2 text-center shadow-sm hover:shadow-md transition
                              peer-checked:bg-[#A28224] peer-checked:text-white">
                    <img src="{{ asset($Candidat->photo_url) }}"
                         alt="{{ $Candidat->nom_complet }}"
                         class="w-20 h-20 object-cover rounded mb-1 mx-auto">
                    <span class="text-sm font-medium truncate block">{{ $Candidat->nom_complet }}</span>
                  </div>
                </label>
              @endforeach
            </div>
          @else
            <p class="text-gray-500">Aucun candidat pour cette catégorie</p>
          @endif
        </div>
      @endforeach

      <input type="hidden" name="user_id" value="{{ auth()->id() }}">
      <input type="hidden" name="edition_id" value="{{ $edition->id }}">

      <button type="submit" class="mt-4 bg-[#A28224] text-white px-4 py-2 rounded hover:bg-[#8f6e1a] transition">
          Voter
      </button>
    </form>
  </main>

  <!-- FOOTER -->
  <footer class="bg-white border-t mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-center items-center text-sm text-gray-500">
        <p class="text-center">© 2025 Katanga Award. Tous droits réservés.</p>
    </div>
  </footer>

  <!-- SCRIPT NAVBAR -->
  <script>
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');
    const icon = btn.querySelector('.material-icons');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        icon.textContent = menu.classList.contains('hidden') ? 'menu' : 'close';
    });
  </script>
</body>
</html>
