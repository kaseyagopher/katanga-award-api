<!DOCTYPE html>
<html lang="fr" class="h-full scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#000000">
  <title>@yield('title', 'Katanga Awards')</title>
  <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            ka: {
              black: '#000000',
              gold: '#A28224',
              yellow: '#fbcd43',
              amber: '#e3b017',
              card: '#111111',
            }
          },
          fontFamily: { sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
          boxShadow: {
            'ka-card': '0 4px 24px rgba(0, 0, 0, 0.4)',
            'ka-glow': '0 8px 32px rgba(162, 130, 36, 0.25)',
          },
        }
      }
    }
  </script>
  @stack('head')
  <style>
    :root {
      --ka-gold: #A28224;
      --ka-yellow: #fbcd43;
      --ka-amber: #e3b017;
    }
    [x-cloak] { display: none !important; }
    @keyframes ka-fadeOut { to { opacity: 0; visibility: hidden; } }
    .ka-loader-hide { animation: ka-fadeOut 0.8s forwards; }
    .ka-bg-pattern {
      background-color: #000000;
      background-image:
        radial-gradient(ellipse 80% 50% at 50% -10%, rgba(251, 205, 67, 0.08), transparent),
        radial-gradient(circle at 100% 0%, rgba(162, 130, 36, 0.06), transparent 50%);
    }
    .user-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
    .user-scrollbar::-webkit-scrollbar-thumb { background: var(--ka-gold); border-radius: 3px; }
    .user-scrollbar::-webkit-scrollbar-track { background: #1a1a1a; }
    .ka-gradient-text {
      background: linear-gradient(90deg, var(--ka-yellow), var(--ka-amber), var(--ka-gold));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
  </style>
</head>
<body class="ka-bg-pattern text-neutral-300 min-h-screen flex flex-col font-sans antialiased">

  @if($showLoader ?? false)
    @include('components.user.loader')
  @endif

  @include('components.nav-user')

  <main class="flex-1 w-full user-scrollbar @yield('main-class', 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10')">
    @include('components.user.flash')
    @yield('content')
  </main>

  @include('components.user.footer')
  @include('components.user.image-modal')

  <script>
    (function () {
      const btn = document.getElementById('mobile-menu-button');
      const menu = document.getElementById('mobile-menu');
      if (!btn || !menu) return;
      const icon = btn.querySelector('.material-icons');
      btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        if (icon) icon.textContent = menu.classList.contains('hidden') ? 'menu' : 'close';
      });
    })();
    window.addEventListener('load', () => {
      document.getElementById('ka-loader')?.classList.add('ka-loader-hide');
    });
    const imageModal = document.getElementById('imageModal');
    const closeModalBtn = document.getElementById('closeModal');
    function hideImageModal() {
      imageModal?.classList.add('hidden');
      imageModal?.classList.remove('flex');
    }
    closeModalBtn?.addEventListener('click', hideImageModal);
    imageModal?.addEventListener('click', e => { if (e.target === imageModal) hideImageModal(); });
    document.querySelectorAll('.zoomable').forEach(img => {
      img.addEventListener('click', e => {
        e.preventDefault();
        const m = document.getElementById('modalImage');
        if (m && imageModal) {
          m.src = img.src;
          imageModal.classList.remove('hidden');
          imageModal.classList.add('flex');
        }
      });
    });
  </script>
  @stack('scripts')
</body>
</html>
