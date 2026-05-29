@php
  $routeName = Route::currentRouteName() ?? '';
  $link = fn (bool $active) => $active
    ? 'text-ka-yellow bg-ka-gold/15 font-semibold'
    : 'text-neutral-400 hover:text-ka-yellow hover:bg-ka-gold/10';
@endphp

<nav class="sticky top-0 z-50 border-b-2 border-ka-gold bg-black/95 backdrop-blur-md shadow-lg shadow-black/50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex h-16 items-center justify-between gap-3">

      <a href="{{ route('user.index') }}" class="flex shrink-0 items-center gap-2.5 group">
        <img src="{{ asset('logo_officiel.jpg') }}" alt="Katanga Awards"
             class="h-10 w-10 rounded-xl object-cover ring-2 ring-ka-gold/50 group-hover:ring-ka-yellow transition">
        <div class="hidden sm:block leading-tight">
          <span class="block text-[10px] font-bold uppercase tracking-widest text-ka-yellow">Katanga</span>
          <span class="block text-sm font-bold text-white">AWARDS</span>
        </div>
      </a>

      <div class="hidden lg:flex items-center gap-1">
        <a href="{{ route('user.index') }}" class="px-3 py-2 rounded-lg text-sm transition {{ $link($routeName === 'user.index') }}">Accueil</a>
        <a href="{{ route('user.apropos') }}" class="px-3 py-2 rounded-lg text-sm transition {{ $link($routeName === 'user.apropos') }}">À propos</a>
        <a href="{{ route('user.contact') }}" class="px-3 py-2 rounded-lg text-sm transition {{ $link($routeName === 'user.contact') }}">Contact</a>
      </div>

      <div class="flex items-center gap-2">
        @if($editionActive ?? null)
          <x-ka.button :href="route('user.vote')" variant="primary" size="sm" class="hidden sm:inline-flex">
            <span class="material-icons text-[18px]">payments</span>
            Voter
          </x-ka.button>
        @endif

        <button type="button" id="mobile-menu-button" class="lg:hidden p-2 rounded-lg text-ka-yellow hover:bg-ka-gold/15" aria-label="Menu">
          <span class="material-icons">menu</span>
        </button>
      </div>
    </div>

    <div id="mobile-menu" class="hidden lg:hidden border-t border-ka-gold/30 bg-black pb-4 pt-2 space-y-1">
      <a href="{{ route('user.index') }}" class="block px-3 py-2.5 rounded-lg text-sm {{ $link($routeName === 'user.index') }}">Accueil</a>
      <a href="{{ route('user.apropos') }}" class="block px-3 py-2.5 rounded-lg text-sm {{ $link($routeName === 'user.apropos') }}">À propos</a>
      <a href="{{ route('user.contact') }}" class="block px-3 py-2.5 rounded-lg text-sm {{ $link($routeName === 'user.contact') }}">Contact</a>
      @if($editionActive ?? null)
        <x-ka.button :href="route('user.vote')" variant="primary" size="sm" class="mx-3 mt-2 w-[calc(100%-1.5rem)]">
          Voter maintenant
        </x-ka.button>
      @endif
    </div>
  </div>
</nav>
