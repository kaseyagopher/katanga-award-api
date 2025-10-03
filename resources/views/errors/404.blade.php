<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 - Page introuvable</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}">
  <style>
    @keyframes bounce {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-20px);
      }
    }
    .animate-bounce-custom {
      animation: bounce 1.5s infinite ease-in-out;
    }
  </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100 font-sans">

  <div class="text-center p-6">
    <!-- 404 animé -->
    <h1 class="text-7xl sm:text-9xl font-extrabold text-[#A28224] animate-bounce-custom">
      404
    </h1>

    <!-- Sous-titre -->
    <h3 class="text-2xl sm:text-3xl font-semibold mt-4">
      Oups ! Page introuvable
    </h3>

    <!-- Message -->
    <p class="text-gray-600 mt-2 mb-6">
      La page que vous cherchez n’existe pas ou a été déplacée.
    </p>

    <!-- Bouton retour -->
    <a href="{{ url()->previous() }}"
       class="inline-block px-6 py-3 rounded-lg text-white bg-[#A28224] hover:bg-[#8b6c1e] shadow-lg transition">
       Retour à la page précédente
    </a>
  </div>

</body>
</html>
