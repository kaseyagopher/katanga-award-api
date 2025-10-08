<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Résultats - Vote en ligne</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}">
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
          catTitle.className = "text-2xl font-bold mb-4  flex items-center";
          catTitle.innerHTML = '<span class="material-icons mr-2">category</span>' + categorie.nom_categorie;
          catBlock.appendChild(catTitle);

          // Tableau
          let table = document.createElement("table");
          table.className = "min-w-full bg-white rounded-lg shadow overflow-hidden";

          // Entête
          let thead = document.createElement("thead");
          thead.innerHTML = `
            <tr class="bg-blue-100 text-left">
              <th class="py-2 px-4">#</th>
              <th class="py-2 px-4">Candidat</th>
              <th class="py-2 px-4"></th>
              <th class="py-2 px-4">Votes <span class="material-icons align-middle text-yellow-500">how_to_vote</span></th>
            </tr>
          `;
          table.appendChild(thead);

          // Corps du tableau
          let tbody = document.createElement("tbody");

          // Trier par votes décroissants
          categorie.candidats.sort((a,b) => b.votes_count - a.votes_count);

          categorie.candidats.forEach((candidat, index) => {
            let tr = document.createElement("tr");
            tr.className = index % 2 === 0 ? "bg-gray-50" : "bg-white";

            tr.innerHTML = `
              <td class="py-2 px-4 font-bold">${index + 1}</td>
              <td class="py-2 px-4 flex items-center gap-2">
                <span class="material-icons text-gray-500">person</span>
                ${candidat.nom_complet}
              </td>
              <td class="py-2 px-4">
                </td>
              <td class="py-2 px-4 font-semibold text-blue-600 flex items-center gap-1">
                <span class="material-icons text-yellow-500">star</span>
                ${candidat.votes_count}
              </td>
            `;
            tbody.appendChild(tr);
          });

          table.appendChild(tbody);
          catBlock.appendChild(table);
          container.appendChild(catBlock);
        });
      } catch (error) {
        console.error("Erreur chargement résultats:", error);
      }
    }

    setInterval(fetchResults, 5000);
    window.onload = fetchResults;
  </script>
</head>
<body class="bg-gray-100 min-h-screen font-sans">

  @include('components.aside-admin')

  <div class="md:ml-64 p-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 flex items-center">
      <span class="material-icons mr-2 text-[#fbcd43]">emoji_events</span>
      Résultats en direct
    </h1>
    <div id="resultsContainer"></div>
  </div>

</body>
</html>
