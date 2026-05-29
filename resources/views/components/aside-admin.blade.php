@php
  $routeName = Route::currentRouteName() ?? '';
  $navClass = fn (bool $active) => $active
    ? 'bg-ka-gold text-white shadow-md shadow-ka-gold/20'
    : 'text-neutral-300 hover:bg-ka-gold/90 hover:text-white';
@endphp

<aside id="sidebar"
       class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col bg-black text-white transform -translate-x-full border-r-2 border-ka-yellow transition-transform duration-200 ease-in-out md:translate-x-0">

  {{-- En-tête --}}
  <div class="flex items-center gap-3 border-b border-white/10 px-5 py-5">
    <img src="{{ asset('logo kataward.png') }}" alt="Katanga Awards" class="h-10 w-10 rounded-lg object-contain bg-white/5 p-0.5">
    <div class="min-w-0">
      <p class="text-[10px] font-semibold uppercase tracking-widest text-ka-yellow">Katanga</p>
      <p class="truncate text-lg font-bold leading-tight">Awards Admin</p>
    </div>
  </div>

  {{-- Navigation --}}
  <nav class="admin-scrollbar flex-1 space-y-1 overflow-y-auto px-3 py-4">
    <a href="{{ route('admin.dashboard') }}"
       class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $navClass($routeName === 'admin.dashboard') }}">
      <span class="material-icons text-[20px]">dashboard</span>
      Tableau de bord
    </a>

    <a href="{{ route('candidats.index') }}"
       class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $navClass($routeName === 'candidats.index' || str_starts_with($routeName, 'candidats.')) }}">
      <span class="material-icons text-[20px]">groups</span>
      Candidats
    </a>

    <div x-data="{ open: {{ str_starts_with($routeName, 'categories.') ? 'true' : 'false' }} }" class="space-y-0.5">
      <button type="button" @click="open = !open"
              class="flex w-full items-center justify-between gap-2 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $navClass(str_starts_with($routeName, 'categories.')) }}">
        <span class="flex items-center gap-3">
          <span class="material-icons text-[20px]">category</span>
          Catégories
        </span>
        <span class="material-icons text-[18px] transition-transform" :class="open && 'rotate-180'">expand_more</span>
      </button>
      <div x-show="open" class="ml-4 space-y-0.5 border-l border-ka-gold/40 pl-3" x-cloak>
        <a href="{{ route('categories.index') }}"
           class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm transition {{ $navClass($routeName === 'categories.index') }}">
          <span class="material-icons text-[16px]">list</span>
          Liste
        </a>
        <a href="{{ route('categories.create') }}"
           class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm transition {{ $navClass($routeName === 'categories.create') }}">
          <span class="material-icons text-[16px]">add_circle</span>
          Ajouter
        </a>
      </div>
    </div>

    <a href="{{ route('editions.index') }}"
       class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $navClass(str_starts_with($routeName, 'editions.')) }}">
      <span class="material-icons text-[20px]">event</span>
      Éditions
    </a>

    <a href="{{ route('resultats.index') }}"
       class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $navClass($routeName === 'resultats.index') }}">
      <span class="material-icons text-[20px]">emoji_events</span>
      Résultats
    </a>

    <a href="{{ route('admin.gestion-votes') }}"
       class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $navClass($routeName === 'admin.gestion-votes') }}">
      <span class="material-icons text-[20px]">how_to_vote</span>
      Gestion des votes
    </a>
  </nav>

  {{-- Pied --}}
  <div class="border-t border-white/10 p-4 space-y-3">
    @auth('admin')
      <div class="flex items-center gap-2 rounded-lg bg-white/5 px-3 py-2">
        <span class="material-icons text-ka-yellow text-xl">shield</span>
        <div class="min-w-0">
          <p class="truncate text-xs font-semibold text-white">{{ Auth::guard('admin')->user()->pseudo }}</p>
          <p class="truncate text-[10px] text-neutral-400">{{ Auth::guard('admin')->user()->email }}</p>
        </div>
      </div>
    @endauth

    <form method="GET" action="{{ route('admin.logout') }}">
      <button type="submit"
              class="flex w-full items-center justify-center gap-2 rounded-lg bg-red-600 px-3 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 focus:ring-offset-black">
        <span class="material-icons text-[18px]">logout</span>
        Se déconnecter
      </button>
    </form>
  </div>
</aside>
