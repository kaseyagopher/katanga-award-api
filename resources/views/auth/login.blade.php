<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Utilisateur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}">
</head>
<body class="relative min-h-screen flex items-center justify-center"
      style="background-image: url('{{ asset('image-katanga.jpg') }}'); background-size: cover; background-position: center;">

    <!-- Overlay sombre -->
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>

    <!-- Formulaire -->
    <div class="relative z-10 w-full max-w-md bg-white rounded-lg shadow-lg p-6">

        <!-- Logo ou image -->
        <div class="flex justify-center mb-4">
            <img src="{{ asset('image-kat.jpg') }}" alt="Logo Katanga Awards" class="w-20 h-20 rounded-full shadow">
        </div>

        <h3 class="text-center text-2xl font-bold mb-6 text-gray-800">Connexion</h3>

        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-center">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="" class="space-y-4">
            @csrf

            <div>
                <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Numéro de téléphone</label>
                <input type="text" name="telephone" id="telephone"
                       placeholder="Ex: +243854721056"
                       value="{{ old('telephone') }}"
                       class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-[#A28224] focus:border-[#A28224]">
                @error('telephone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full px-4 py-2 bg-[#A28224] text-white rounded-lg font-semibold shadow hover:bg-[#8B701F] focus:outline-none focus:ring-2 focus:ring-[#A28224] focus:ring-offset-2 transition">
                Se connecter
            </button>
        </form>
    </div>
</body>
</html>
