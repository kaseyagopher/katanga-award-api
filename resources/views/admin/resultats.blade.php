<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Résultats - Vote en ligne</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script>
    async function fetchResults() {
      try {
        let response = await fetch("{{ route('resultats.data') }}");
        let data = await response.json();

        let container = document.getElementById("resultsContainer");
        container.innerHTML = "";

        data.forEach(categorie => {
          // Bloc catégorie
          let catBlock = document.createElement("div");
          catBlock.className = "mb-8";

          let catTitle = document.createElement("h2");
          catTitle.className = "text-2xl font-bold mb-4 text-blue-800";
          catTitle.textContent = categorie.nom_categorie;
          catBlock.appendChild(catTitle);

          // Grille candidats
          let grid = document.createElement("div");
          grid.className = "grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6";

          categorie.candidats.forEach(candidat => {
            let card = document.createElement("div");
            card.className = "bg-white shadow-lg rounded-xl p-4 flex flex-col items-center";

            // Photo
            let img = document.createElement("img");
            img.src = candidat.photo_url ?? "https://via.placeholder.com/150";
            img.alt = candidat.nom_complet;
            img.className = "w-24 h-24 object-cover rounded-full mb-3";
            card.appendChild(img);

            // Nom
            let name = document.createElement("h3");
            name.className = "text-lg font-semibold";
            name.textContent = candidat.nom_complet;
            card.appendChild(name);

            // Votes
            let votes = document.createElement("p");
            votes.className = "mt-2 text-blue-600 font-bold text-xl";
            votes.textContent = candidat.votes_count + " votes";
            card.appendChild(votes);

            grid.appendChild(card);
          });

          catBlock.appendChild(grid);
          container.appendChild(catBlock);
        });
      } catch (error) {
        console.error("Erreur chargement résultats:", error);
      }
    }

    // Rafraîchissement auto toutes les 5 sec
    setInterval(fetchResults, 5000);
    window.onload = fetchResults;
  </script>
</head>
<body class="bg-gray-100 min-h-screen font-sans">

  <!-- Sidebar -->
  @include('components.aside-admin')

  <!-- Contenu -->
  <div class="md:ml-64 p-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Résultats en direct</h1>
    <div id="resultsContainer"></div>
  </div>
</body>
</html>
