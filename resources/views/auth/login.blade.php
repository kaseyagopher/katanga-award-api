<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion — Katanga Awards</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { theme: { extend: { colors: { ka: { gold: '#A28224', yellow: '#fbcd43' } } } } }
  </script>
  <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}">
</head>
<body class="relative min-h-screen flex items-center justify-center p-4"
      style="background-image: url('{{ asset('image-katanga.jpg') }}'); background-size: cover; background-position: center;">

  <div class="absolute inset-0 bg-black/70"></div>

  <div class="relative z-10 w-full max-w-md rounded-2xl bg-white p-8 shadow-2xl border-t-4 border-ka-gold">
    <div class="flex justify-center mb-5">
      <img src="{{ asset('image-kat.jpg') }}" alt="Katanga Awards" class="h-20 w-20 rounded-full object-cover ring-4 ring-ka-gold/30 shadow">
    </div>

    <h1 class="text-center text-2xl font-bold text-neutral-900 mb-1">Connexion</h1>
    <p class="text-center text-sm text-neutral-500 mb-6">Votez avec votre numéro de téléphone</p>

    @if (session('error'))
      <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-center text-sm text-red-700">
        {{ session('error') }}
      </div>
    @endif

    <form method="POST" action="{{ url('/katanga-award/login') }}" class="space-y-4">
      @csrf
      <div>
        <label for="telephone" class="mb-1 block text-sm font-medium text-neutral-700">Numéro de téléphone</label>
        <input type="text" name="telephone" id="telephone"
               placeholder="Ex: +243854721056"
               value="{{ old('telephone') }}"
               class="w-full rounded-lg border border-neutral-300 px-4 py-2.5 focus:border-ka-gold focus:outline-none focus:ring-2 focus:ring-ka-gold/30">
        @error('telephone')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        <p class="mt-1.5 text-xs text-neutral-500">Vodacom, Orange ou Airtel (RDC)</p>
      </div>

      <button type="submit"
              class="w-full rounded-xl bg-ka-gold py-3 font-semibold text-white shadow-lg hover:bg-ka-gold/90 focus:outline-none focus:ring-2 focus:ring-ka-gold focus:ring-offset-2 transition">
        Se connecter
      </button>
    </form>
  </div>
</body>
</html>
