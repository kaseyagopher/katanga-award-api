<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Admin') — Katanga Awards</title>
  <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            ka: {
              gold: '#A28224',
              yellow: '#fbcd43',
              amber: '#e3b017',
            }
          },
          fontFamily: {
            sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
          },
        }
      }
    }
  </script>
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  @stack('head')
  <style>
    [x-cloak] { display: none !important; }
    .admin-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
    .admin-scrollbar::-webkit-scrollbar-thumb { background: #A28224; border-radius: 3px; }
    .admin-scrollbar::-webkit-scrollbar-track { background: rgba(255,255,255,0.08); }
  </style>
</head>
<body class="flex min-h-screen bg-neutral-100 font-sans text-neutral-800 antialiased">

  @include('components.aside-admin')

  <div id="overlay"
       class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-40 md:hidden"
       onclick="toggleSidebar()"></div>

  <div class="flex-1 flex flex-col md:ml-64 min-h-screen">

    {{-- Barre supérieure desktop --}}
    <header class="hidden md:flex sticky top-0 z-30 items-center justify-between gap-4 px-6 lg:px-8 py-4 bg-white border-b border-neutral-200 shadow-sm">
      <div class="min-w-0">
        <p class="text-xs font-semibold uppercase tracking-wider text-ka-gold">Katanga Awards</p>
        <h1 class="text-xl font-bold text-neutral-900 truncate">@yield('page-title', 'Administration')</h1>
        @hasSection('page-subtitle')
          <p class="text-sm text-neutral-500 mt-0.5">@yield('page-subtitle')</p>
        @endif
      </div>
      <div class="flex items-center gap-3 shrink-0">
        @yield('header-actions')
        @auth('admin')
          <div class="flex items-center gap-2 pl-3 border-l border-neutral-200">
            <span class="material-icons text-ka-gold text-xl">account_circle</span>
            <span class="text-sm font-medium text-neutral-700">{{ Auth::guard('admin')->user()->pseudo }}</span>
          </div>
        @endauth
      </div>
    </header>

    {{-- Barre mobile --}}
    <header class="md:hidden sticky top-0 z-30 flex items-center justify-between gap-3 px-4 py-3 bg-black text-white border-b-2 border-ka-yellow shadow-lg">
      <button type="button" onclick="toggleSidebar()" class="p-2 -ml-1 rounded-lg hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-ka-yellow" aria-label="Menu">
        <span class="material-icons">menu</span>
      </button>
      <div class="flex-1 min-w-0 text-center">
        <p class="text-[10px] uppercase tracking-widest text-ka-yellow font-semibold">Katanga Awards</p>
        <h1 class="text-base font-bold truncate">@yield('page-title', 'Admin')</h1>
      </div>
      <div class="w-10">@yield('header-actions-mobile')</div>
    </header>

    <main class="flex-1 p-4 sm:p-6 lg:p-8 admin-scrollbar overflow-x-hidden">
      @include('components.admin.flash')
      @yield('content')
    </main>
  </div>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      if (!sidebar || !overlay) return;
      sidebar.classList.toggle('-translate-x-full');
      overlay.classList.toggle('hidden');
    }
  </script>
  @stack('scripts')
</body>
</html>
