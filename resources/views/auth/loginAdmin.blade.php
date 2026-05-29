<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion Admin — Katanga Awards</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { theme: { extend: { colors: { ka: { gold: '#A28224', yellow: '#fbcd43' } } } } }
  </script>
  <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}">
</head>
<body class="min-h-screen flex items-center justify-center bg-black p-4">

  <div class="w-full max-w-4xl overflow-hidden rounded-2xl shadow-2xl flex flex-col md:flex-row border-2 border-ka-yellow/30">
    <div class="w-full md:w-1/2 relative min-h-[200px] md:min-h-0">
      <img src="{{ asset('image-katanga-login.jpg') }}" alt="Katanga Awards"
           class="absolute inset-0 h-full w-full object-cover">
      <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent md:bg-gradient-to-r"></div>
      <div class="absolute bottom-6 left-6 right-6 text-white">
        <img src="{{ asset('logo kataward.png') }}" alt="" class="h-12 w-12 mb-3 rounded-lg">
        <p class="text-ka-yellow text-xs font-semibold uppercase tracking-widest">Katanga Awards</p>
        <h1 class="text-2xl font-bold">Espace administration</h1>
      </div>
    </div>

    <div class="w-full md:w-1/2 bg-white p-8 sm:p-10">
      <h2 class="text-2xl font-bold text-neutral-900 mb-1">Connexion</h2>
      <p class="text-sm text-neutral-500 mb-6">Accédez au tableau de bord admin</p>

      @if(session('success'))
        <p class="mb-4 rounded-lg border border-green-200 bg-green-50 p-3 text-sm text-green-800">{{ session('success') }}</p>
      @endif
      @if(session('error'))
        <p class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-800">{{ session('error') }}</p>
      @endif

      <form method="POST" action="{{ url('/katanga-award/loginAdmin') }}" class="space-y-5">
        @csrf
        <div>
          <label for="email" class="block text-sm font-medium text-neutral-700 mb-1">Email</label>
          <input type="email" name="email" id="email" required value="{{ old('email') }}"
                 class="w-full rounded-lg border border-neutral-300 px-3 py-2.5 focus:border-ka-gold focus:outline-none focus:ring-2 focus:ring-ka-gold/30">
          @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-neutral-700 mb-1">Mot de passe</label>
          <input type="password" name="password" id="password" required
                 class="w-full rounded-lg border border-neutral-300 px-3 py-2.5 focus:border-ka-gold focus:outline-none focus:ring-2 focus:ring-ka-gold/30">
          @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>
        <button type="submit"
                class="w-full rounded-lg bg-ka-gold py-3 text-sm font-semibold text-white shadow-lg shadow-ka-gold/25 hover:bg-ka-gold/90 focus:outline-none focus:ring-2 focus:ring-ka-gold focus:ring-offset-2">
          Se connecter
        </button>
      </form>
    </div>
  </div>
</body>
</html>
