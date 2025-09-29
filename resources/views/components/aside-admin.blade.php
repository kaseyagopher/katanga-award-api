<aside id="sidebar"
       class="fixed inset-y-0 left-0 w-64 bg-black text-white p-6 transform -translate-x-full 
              md:translate-x-0 transition-transform duration-200 ease-in-out z-50 flex flex-col">

    <h2 class="text-2xl font-bold mb-6">Admin</h2>

    <!-- Liens de navigation -->
    <nav class="space-y-4 flex-1">
      <a href="{{ route('admin.dashboard') }}"
         class="block px-3 py-2 rounded 
                {{ Route::currentRouteName() === 'admin.dashboard' 
                    ? 'bg-[#A28224] text-white hover:bg-[#A28224]' 
                    : 'hover:bg-[#A28224] hover:text-white' }}">
         Tableau de bord
      </a>

      <a href="{{ route('candidats.index') }}"
         class="block px-3 py-2 rounded hover:bg-[#A28224] 
         {{ Route::currentRouteName() === 'candidats.index' 
                    ? 'bg-[#A28224] text-white hover:bg-[#A28224]' 
                    : 'hover:bg-[#A28224] hover:text-white' }}">
         Candidats
      </a>

      <a href="{{route('categories.index')}}"
         class="block px-3 py-2 rounded hover:bg-[#A28224] 
         {{ Route::currentRouteName() === 'categories.index' 
                    ? 'bg-[#A28224] text-white hover:bg-[#A28224]' 
                    : 'hover:bg-[#A28224] hover:text-white' }}">
         Catégories
      </a>

      <a href="{{ route('editions.index') }}"
         class="block px-3 py-2 rounded 
                {{ Route::currentRouteName() === 'editions.index' 
                    ? 'bg-[#A28224] text-white hover:bg-[#A28224]/90' 
                    : 'hover:bg-[#A28224] hover:text-white' }}">
         Éditions
      </a>
    </nav>

    <!-- Bouton déconnexion en bas -->
    <form method="GET" action="{{ route('admin.logout') }}" class="mt-auto">
      @csrf
      <button type="submit" 
              class="w-full text-left px-3 py-2 rounded bg-red-500 hover:bg-red-600">
        Se déconnecter
      </button>
    </form>

</aside>
