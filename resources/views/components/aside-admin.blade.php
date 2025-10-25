<aside id="sidebar"
       class="fixed inset-y-0 left-0 w-64 bg-black text-white p-6 transform -translate-x-full
              md:translate-x-0 transition-transform duration-200 ease-in-out z-50 flex flex-col">

  <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
    <span class="material-icons">admin_panel_settings</span>
    Admin
  </h2>

  <!-- Liens de navigation -->
  <nav class="space-y-4 flex-1">
    <!-- Dashboard -->
    <a href="{{ route('admin.dashboard') }}"
       class="flex items-center gap-2 px-3 py-2 rounded
              {{ Route::currentRouteName() === 'admin.dashboard'
                  ? 'bg-[#A28224] text-white hover:bg-[#A28224]'
                  : 'hover:bg-[#A28224] hover:text-white' }}">
      <span class="material-icons">dashboard</span>
      Tableau de bord
    </a>

    <!-- Candidats -->
    <a href="{{ route('candidats.index') }}"
       class="flex items-center gap-2 px-3 py-2 rounded
              {{ Route::currentRouteName() === 'candidats.index'
                  ? 'bg-[#A28224] text-white hover:bg-[#A28224]'
                  : 'hover:bg-[#A28224] hover:text-white' }}">
      <span class="material-icons">groups</span>
      Candidats
    </a>

    <!-- Catégories avec menu déroulant -->
    <div x-data="{ open: false }" class="space-y-1">
      <button @click="open = !open"
              class="w-full flex justify-between items-center px-3 py-2 rounded hover:bg-[#A28224]
              {{ Str::startsWith(Route::currentRouteName(), 'categories.')
                  ? 'bg-[#A28224] text-white hover:bg-[#A28224]'
                  : 'hover:bg-[#A28224] hover:text-white' }}">
        <span class="flex items-center gap-2">
          <span class="material-icons">category</span>
          Catégories
        </span>
        <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform" fill="none"
             stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7" />
        </svg>
      </button>

      <div x-show="open" class="pl-8 space-y-1" x-cloak>
        <a href="{{ route('categories.index') }}"
           class="flex items-center gap-2 px-3 py-2 rounded text-sm
                  {{ Route::currentRouteName() === 'categories.index'
                      ? 'bg-[#A28224] text-white hover:bg-[#A28224]'
                      : 'hover:bg-[#A28224] hover:text-white' }}">
          <span class="material-icons text-sm">list</span>
          Liste
        </a>
        <a href="{{ route('categories.create') }}"
           class="flex items-center gap-2 px-3 py-2 rounded text-sm
                  {{ Route::currentRouteName() === 'categories.create'
                      ? 'bg-[#A28224] text-white hover:bg-[#A28224]'
                      : 'hover:bg-[#A28224] hover:text-white' }}">
          <span class="material-icons text-sm">add_circle</span>
          Ajouter
        </a>
      </div>
    </div>

    <!-- Editions -->
    <a href="{{ route('editions.index') }}"
       class="flex items-center gap-2 px-3 py-2 rounded
              {{ Route::currentRouteName() === 'editions.index'
                  ? 'bg-[#A28224] text-white hover:bg-[#A28224]/90'
                  : 'hover:bg-[#A28224] hover:text-white' }}">
      <span class="material-icons">edit</span>
      Éditions
    </a>

    <!-- Résultats -->
    <a href="{{ route('resultats.index') }}"
       class="flex items-center gap-2 px-3 py-2 rounded
              {{ Route::currentRouteName() === 'resultats.index'
                  ? 'bg-[#A28224] text-white hover:bg-[#A28224]/90'
                  : 'hover:bg-[#A28224] hover:text-white' }}">
      <span class="material-icons">emoji_events</span>
      Résultats
    </a>

    <a href="{{ route('admin.gestion-votes') }}"
       class="flex items-center gap-2 px-3 py-2 rounded
              {{ Route::currentRouteName() === 'admin.gestion-votes'
                  ? 'bg-[#A28224] text-white hover:bg-[#A28224]/90'
                  : 'hover:bg-[#A28224] hover:text-white' }}">
      <span class="material-icons">manage_accounts</span>
      Gest. votes
    </a>

  </nav>

  <!-- Déconnexion -->
  <form method="GET" action="{{ route('admin.logout') }}" class="mt-auto">
    @csrf
    <button type="submit"
            class="flex items-center gap-2 w-full text-left px-3 py-2 rounded bg-red-500 hover:bg-red-600">
      <span class="material-icons">logout</span>
      Se déconnecter
    </button>
  </form>
</aside>
