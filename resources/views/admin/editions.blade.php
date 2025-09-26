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
      document.getElementById("overlay").classList.toggle("hidden");
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
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
      <h1 class="text-lg font-bold">Admin Dashboard</h1>
    </header>

    <main class="p-8 space-y-8">

      <!-- Titre -->
      <h1 class="text-3xl font-bold">Editions</h1>
      <div class="flex items-center justify-between">
          <h2 class="text-2xl font-semibold"></h2>
          <button id="showFormBtn" class="px-5 py-2 bg-[#A28224] text-white rounded">
             Ajouter
          </button>
      </div>

      <!-- Tableau des éditions -->
      <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full">
          <thead class="bg-black text-white">
            <tr>
              <th class="px-6 py-3 text-left text-sm font-semibold">#</th>
              <th class="px-6 py-3 text-left text-sm font-semibold">Titre</th>
              <th class="px-6 py-3 text-left text-sm font-semibold">Thème</th>
              <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
            </tr>
          </thead>
          <tbody id="editionList" class="divide-y divide-gray-200">
            @forelse ($Editions as $Edition)
            <tr data-id="{{ $Edition->id }}">
                <td class="px-6 py-4">{{ $Edition->id }}</td>
                <td class="px-6 py-4">{{ $Edition->titre }}</td>
                <td class="px-6 py-4">{{ $Edition->theme }}</td>
                <td class="px-6 py-4 text-sm flex gap-2">
                    <button class="editBtn px-2 py-1 bg-black text-white rounded">Modifier</button>
                    <button class="deleteBtn px-2 py-1 bg-red-500 text-white rounded">Supprimer</button>
                </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="p-4 bg-gray-200 text-center rounded">Aucune Édition</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Formulaire popup -->
      <div id="editionFormContainer" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <form id="editionForm" class="bg-white p-6 rounded shadow-lg w-full max-w-md space-y-4">
          @csrf
          <input type="hidden" id="editionId" name="editionId">

          <div>
            <label for="titre" class="block font-medium mb-1">Titre :</label>
            <input type="text" id="titre" name="titre" required class="w-full px-3 py-2 border rounded">
          </div>

          <div>
            <label for="theme" class="block font-medium mb-1">Thème :</label>
            <input type="text" id="theme" name="theme" required class="w-full px-3 py-2 border rounded">
          </div>

          <div>
            <label for="statut" class="block font-medium mb-1">Statut :</label>
            <select name="statut" id="statut" required class="w-full px-3 py-2 border rounded">
              <option value="1">Active</option>
              <option value="0">Non active</option>
            </select>
          </div>

          <div class="flex justify-end gap-2">
            <button type="submit" id="submitBtn" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Enregistrer</button>
            <button type="button" id="closeFormBtn" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Annuler</button>
          </div>

          <div id="formMessage" class="text-sm text-red-500"></div>
        </form>
      </div>

    </main>
  </div>

<script>
const showFormBtn = document.getElementById('showFormBtn');
const closeFormBtn = document.getElementById('closeFormBtn');
const editionFormContainer = document.getElementById('editionFormContainer');
const editionForm = document.getElementById('editionForm');
const editionIdInput = document.getElementById('editionId');
const titreInput = document.getElementById('titre');
const themeInput = document.getElementById('theme');
const statutInput = document.getElementById('statut');
const formMessage = document.getElementById('formMessage');
const editionList = document.getElementById('editionList');

let isEditing = false;

// Ouvrir popup
showFormBtn.addEventListener('click', () => {
    isEditing = false;
    editionForm.reset();
    editionIdInput.value = '';
    editionFormContainer.classList.remove('hidden');
    formMessage.innerText = '';
});

// Fermer popup
closeFormBtn.addEventListener('click', () => {
    editionFormContainer.classList.add('hidden');
});

// Modifier une édition
if (editionList) {
    editionList.addEventListener('click', async (e) => {
        if(!e.target.classList.contains('editBtn')) return;

        const tr = e.target.closest('tr');
        const id = tr.dataset.id;
        isEditing = true;
        editionFormContainer.classList.remove('hidden');
        formMessage.innerText = "Chargement des données...";

        try {
            const response = await fetch(`editions/${id}/edit`, {
                headers: { "Accept": "application/json" }
            });
            const data = await response.json();

            if(response.ok && data.success){
                editionIdInput.value = data.edition.id;
                titreInput.value = data.edition.titre;
                themeInput.value = data.edition.theme;
                statutInput.value = data.edition.statut;
                formMessage.innerText = '';
            } else {
                formMessage.innerText = data.message || "Impossible de récupérer les données";
            }
        } catch(err){
            formMessage.innerText = "Erreur AJAX : " + err.message;
        }
    });
}

// Supprimer une édition
editionList.addEventListener('click', async (e) => {
    if(!e.target.classList.contains('deleteBtn')) return;

    if(!confirm("Voulez-vous vraiment supprimer cette édition ?")) return;

    const tr = e.target.closest('tr');
    const id = tr.dataset.id;

    try {
        const response = await fetch(`editions/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            }
        });

        const data = await response.json();

        if(response.ok && data.success){
            tr.remove();
            alert("✅ Édition supprimée avec succès");
        } else {
            alert("⚠️ Erreur : " + (data.message || "Impossible de supprimer"));
        }
    } catch(err){
        alert("❌ Une erreur est survenue : " + err.message);
    }
});


// Envoi AJAX (create ou update)
editionForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    formMessage.innerText = "Envoi en cours...";

    const formData = new FormData(editionForm);
    let url = "{{ route('editions.store') }}";
    let method = "POST";

    if(isEditing){
        const id = editionIdInput.value;
        url = `editions/${id}`;
        method = "POST"; // Laravel nécessite POST + _method=PUT
        formData.append('_method', 'PUT');
    }

    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: formData
        });
        const data = await response.json();

        if(response.ok && data.success){
            formMessage.innerText = isEditing ? "✅ Édition modifiée avec succès" : "✅ Édition enregistrée avec succès";

            if(isEditing){
                const tr = editionList.querySelector(`tr[data-id='${data.edition.id}']`);
                tr.innerHTML = `
                  <td class="px-6 py-4">${data.edition.id}</td>
                  <td class="px-6 py-4">${data.edition.titre}</td>
                  <td class="px-6 py-4">${data.edition.theme}</td>
                  <td class="px-6 py-4 text-sm flex gap-2">
                      <button class="editBtn px-2 py-1 bg-black text-white rounded">Modifier</button>
                  </td>
                `;
            } else {
                const tr = document.createElement("tr");
                tr.dataset.id = data.edition.id;
                tr.innerHTML = `
                  <td class="px-6 py-4">${data.edition.id}</td>
                  <td class="px-6 py-4">${data.edition.titre}</td>
                  <td class="px-6 py-4">${data.edition.theme}</td>
                  <td class="px-6 py-4 text-sm flex gap-2">
                      <button class="editBtn px-2 py-1 bg-black text-white rounded">Modifier</button>
                  </td>
                `;
                editionList.appendChild(tr);
            }

            editionForm.reset();
            editionFormContainer.classList.add('hidden');
        } else {
            if(data.errors){
                formMessage.innerText = "⚠️ Erreurs : " + Object.values(data.errors).flat().join(", ");
            } else {
                formMessage.innerText = "⚠️ Erreur : " + (data.message || "Impossible d'enregistrer");
            }
        }
    } catch(err){
        formMessage.innerText = "❌ Une erreur est survenue : " + err.message;
    }
});
</script>
</body>
</html>
