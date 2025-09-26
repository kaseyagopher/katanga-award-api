<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Vote en ligne</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("-translate-x-full");
    }
  </script>
</head>
<body class="flex min-h-screen bg-gray-100 font-sans">

  <!-- Sidebar -->
  @include('components.aside-admin')
  <!-- Overlay (mobile only) -->
  <div id="overlay" 
       class="fixed inset-0 bg-black bg-opacity-50 hidden z-40 md:hidden"
       onclick="toggleSidebar()"></div>

  <!-- Contenu principal -->
  <div class="flex-1 flex flex-col md:ml-64">
    <!-- Header -->
    <header class="bg-white shadow p-4 flex items-center justify-between md:hidden">
      <button onclick="toggleSidebar()" class="text-blue-700 focus:outline-none">
        <!-- Icône hamburger -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
      <h1 class="text-lg font-bold">Admin Dashboard</h1>
    </header>

    <main class="p-8">
      <h1 class="text-3xl font-bold mb-4">Tableau de bord Admin</h1>
      
      <section class="mb-6">
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    
    <div class="bg-black text-white p-6 rounded-lg shadow">
      <div class="text-sm">Nombre de candidats</div>
      <div class="text-2xl font-bold">43</div>
    </div>
    
    <div class="bg-[#A28224] text-white p-6 rounded-lg shadow">
      <div class="text-sm">Nombre de catégories</div>
      <div class="text-2xl font-bold">12</div>
    </div>
    
    <div class="bg-blue-600 text-white p-6 rounded-lg shadow">
      <div class="text-sm">Nombre d’éditions</div>
      <div class="text-2xl font-bold">5</div>
    </div>
    
    <div class="bg-green-600 text-white p-6 rounded-lg shadow">
      <div class="text-sm">Votes enregistrés</div>
      <div class="text-2xl font-bold">254</div>
    </div>
  
  </div>
</section>

</body>
</html>
