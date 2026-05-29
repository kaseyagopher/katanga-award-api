<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Katanga Awards</title>
  <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { theme: { extend: { colors: { ka: { gold: '#A28224', yellow: '#fbcd43', amber: '#e3b017' } } } } }
  </script>
  <style>
    @keyframes intro-out { to { opacity: 0; visibility: hidden; } }
    body.intro-out { animation: intro-out 0.9s forwards; }
  </style>
</head>
<body class="h-screen overflow-hidden bg-black text-white">

  <img src="{{ asset('KATANGA AWARD AFFICHE CARRE PORTRAIT[1].jpg') }}" alt=""
       class="absolute inset-0 h-full w-full object-contain md:object-cover opacity-90">

  <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-black/60"></div>

  <div class="relative z-10 flex h-full flex-col items-center justify-end pb-16 px-6 text-center">
    <img src="{{ asset('logo kataward.png') }}" alt="" class="h-16 w-16 mb-4 object-contain">
    <h1 class="text-3xl font-bold" style="background:linear-gradient(90deg,#fbcd43,#e3b017,#A28224);-webkit-background-clip:text;-webkit-text-fill-color:transparent">Katanga Awards</h1>
    <p class="mt-2 text-sm text-white/70 max-w-xs">La célébration de l'excellence katangaise</p>
    <button type="button" id="skipButton"
            class="mt-8 rounded-full border-2 border-[#fbcd43] bg-[#fbcd43]/10 px-10 py-3 text-sm font-bold text-[#fbcd43] hover:bg-[#fbcd43] hover:text-black transition">
      Entrer
    </button>
  </div>

  <script>
    const url = "{{ route('user.index') }}";
    const go = () => { document.body.classList.add('intro-out'); setTimeout(() => location.href = url, 800); };
    document.getElementById('skipButton').addEventListener('click', go);
    setTimeout(go, 5500);
  </script>
</body>
</html>
