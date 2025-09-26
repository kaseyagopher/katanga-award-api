<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">

  <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6"> Connexion Admin</h2>

    {{-- Messages flash --}}
    @if(session('success'))
      <p class="mb-4 text-green-600 text-sm font-medium bg-green-100 border border-green-300 p-2 rounded">
        {{ session('success') }}
      </p>
    @endif

    @if(session('error'))
      <p class="mb-4 text-red-600 text-sm font-medium bg-red-100 border border-red-300 p-2 rounded">
        {{ session('error') }}
      </p>
    @endif

    {{-- Formulaire --}}
    <form method="POST" action="" class="space-y-5">
      @csrf

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Admin</label>
        <input type="email" name="email" id="email" required value="{{ old('email') }}"
               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#A28224] focus:border-[#A28224]">
        @error('email')
          <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
        <input type="password" name="password" id="password" required
               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#A28224] focus:border-[#A28224]">
        @error('password')
          <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <button type="submit"
                class="w-full py-2 px-4 bg-[#A28224] text-white font-semibold rounded-lg shadow hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#A28224]">
          Se connecter
        </button>
      </div>
    </form>
  </div>

</body>
</html>
