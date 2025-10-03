<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Admin Dashboard - Éditions</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen bg-gray-100 font-sans">

  <!-- Sidebar -->
  @include('components.aside-admin')

  <!-- Overlay (mobile only) -->
  <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40 md:hidden" onclick="toggleSidebar()"></div>

  <!-- Contenu principal -->
  <div class="flex-1 flex flex-col md:ml-64">
    <!-- Header (mobile only) -->
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

    <main class="p-6">
      <!-- Titre + bouton Ajouter -->
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Liste des éditions</h2>

        <!-- <-- IMPORTANT : c'est un bouton JS (ouvre le modal) -->
        <button id="showFormBtn" class="px-4 py-2 bg-[#A28224] text-white rounded shadow hover:bg-yellow-700">
          + Ajouter une édition
        </button>
      </div>

      <!-- Grid des cartes -->
      <div id="editionList" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($Editions as $Edition)
          <div data-id="{{ $Edition->id }}" class="bg-white rounded-xl shadow-md p-5 flex flex-col justify-between">
            <div>
              <h3 class="text-lg font-bold text-gray-800">{{ $Edition->titre }}</h3>
              <p class="text-sm text-gray-600">{{ $Edition->theme }}</p>
            </div>

            <div class="mt-4">
              @if($Edition->statut == 1)
                <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">✅ Active</span>
              @else
                <span class="px-3 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">🔒 Clôturée</span>
              @endif
            </div>

            <div class="mt-4 flex gap-2">
              @if($Edition->statut == 1)
                <button class="editBtn flex-1 px-3 py-1 bg-black text-white rounded text-center" data-id="{{ $Edition->id }}">
                  Modifier
                </button>

                <button class="deleteBtn flex-1 px-3 py-1 bg-red-500 text-white rounded" data-id="{{ $Edition->id }}">
                  Supprimer
                </button>
              @endif
            </div>
          </div>
        @empty
          <div class="col-span-full p-6 bg-gray-200 text-center rounded">Aucune édition</div>
        @endforelse
      </div>
    </main>
  </div>

  <!-- Modal Form (create / edit) -->
  <div id="editionFormContainer" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
      <h2 id="formTitle" class="text-xl font-bold mb-4">Ajouter une édition</h2>

      <form id="editionForm" class="space-y-4">
        @csrf
        <input type="hidden" id="editionId" name="editionId" value="">

        <div>
          <label for="titre" class="block font-medium mb-1">Titre</label>
          <input type="text" id="titre" name="titre" required class="w-full px-3 py-2 border rounded" />
        </div>

        <div>
          <label for="theme" class="block font-medium mb-1">Thème</label>
          <input type="text" id="theme" name="theme" required class="w-full px-3 py-2 border rounded" />
        </div>

        <div>
          <label for="statut" class="block font-medium mb-1">Statut</label>
          <select id="statut" name="statut" required class="w-full px-3 py-2 border rounded">
            <option value="1">Active</option>
            <option value="0">Non active</option>
          </select>
        </div>

        <div id="formErrors" class="text-sm text-red-600"></div>

        <div class="flex justify-end gap-2">
          <button type="button" id="closeFormBtn" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Annuler</button>
          <button type="submit" id="submitBtn" class="px-4 py-2 bg-[#A28224] text-white rounded">Enregistrer</button>
        </div>
      </form>

      <!-- Close X -->
      <button id="closeX" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800" title="Fermer">&times;</button>
    </div>
  </div>

  <!-- JS: gestion modal + fetch create/edit/delete -->
  <script>
    // Toggle sidebar helper (reste de ton code)
    function toggleSidebar() {
      const sb = document.getElementById("sidebar");
      if (sb) sb.classList.toggle("-translate-x-full");
      document.getElementById("overlay").classList.toggle("hidden");
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Elements
    const showFormBtn = document.getElementById('showFormBtn');
    const editionFormContainer = document.getElementById('editionFormContainer');
    const closeFormBtn = document.getElementById('closeFormBtn');
    const closeX = document.getElementById('closeX');
    const editionForm = document.getElementById('editionForm');
    const editionList = document.getElementById('editionList');
    const formTitle = document.getElementById('formTitle');
    const formErrors = document.getElementById('formErrors');
    const submitBtn = document.getElementById('submitBtn');

    const editionIdInput = document.getElementById('editionId');
    const titreInput = document.getElementById('titre');
    const themeInput = document.getElementById('theme');
    const statutInput = document.getElementById('statut');

    let isEditing = false;

    // Ouvrir modal pour ajouter
    showFormBtn.addEventListener('click', () => {
      isEditing = false;
      formTitle.textContent = "Ajouter une édition";
      formErrors.textContent = "";
      editionForm.reset();
      editionIdInput.value = "";
      submitBtn.textContent = "Enregistrer";
      editionFormContainer.classList.remove('hidden');
    });

    // Fermer modal
    function closeModal() {
      editionFormContainer.classList.add('hidden');
      formErrors.textContent = "";
    }
    closeFormBtn.addEventListener('click', closeModal);
    closeX.addEventListener('click', closeModal);
    editionFormContainer.addEventListener('click', (e) => {
      if (e.target === editionFormContainer) closeModal();
    });

    // Déléguation: edit / delete sur les cartes
    editionList.addEventListener('click', async (e) => {
      // Edit
      if (e.target.closest('.editBtn')) {
        const btn = e.target.closest('.editBtn');
        const id = btn.getAttribute('data-id');
        if (!id) return;
        isEditing = true;
        formTitle.textContent = "Modifier l'édition";
        submitBtn.textContent = "Modifier";
        formErrors.textContent = "Chargement...";

        try {
          const res = await fetch(`editions/${id}/edit`, {
            headers: { "Accept": "application/json" }
          });
          const data = await res.json();
          if (res.ok && data.success) {
            editionIdInput.value = data.edition.id;
            titreInput.value = data.edition.titre ?? "";
            themeInput.value = data.edition.theme ?? "";
            statutInput.value = String(data.edition.statut ?? "1");
            formErrors.textContent = "";
            editionFormContainer.classList.remove('hidden');
          } else {
            formErrors.textContent = data.message || "Impossible de charger l'édition";
          }
        } catch (err) {
          formErrors.textContent = "Erreur réseau : " + err.message;
        }
        return;
      }

      // Delete
      if (e.target.closest('.deleteBtn')) {
        const btn = e.target.closest('.deleteBtn');
        const id = btn.getAttribute('data-id');
        if (!id) return;
        if (!confirm("Voulez-vous vraiment supprimer cette édition ?")) return;

        try {
          const res = await fetch(`editions/${id}`, {
            method: "DELETE",
            headers: {
              "X-CSRF-TOKEN": csrfToken,
              "Accept": "application/json",
              "X-Requested-With": "XMLHttpRequest"
            }
          });
          const data = await res.json();
          if (res.ok && data.success) {
            // retirer la carte
            const card = document.querySelector(`div[data-id='${id}']`);
            if (card) card.remove();
            alert("✅ Édition supprimée.");
          } else {
            alert("⚠️ Erreur : " + (data.message || "Impossible de supprimer"));
          }
        } catch (err) {
          alert("❌ Erreur réseau : " + err.message);
        }
        return;
      }
    });

    // Submit form (create / update)
    editionForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      formErrors.textContent = "";
      submitBtn.disabled = true;
      submitBtn.textContent = isEditing ? "Envoi..." : "Envoi...";

      const formData = new FormData(editionForm);
      // Append token too (sûreté)
      formData.set('_token', csrfToken);

      let url = "{{ route('editions.store') }}";
      // par défaut POST (create)
      if (isEditing) {
        const id = editionIdInput.value;
        url = `editions/${id}`;
        formData.set('_method', 'PUT'); // Laravel
      }

      try {
        const res = await fetch(url, {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": csrfToken,
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest"
          },
          body: formData
        });

        const data = await res.json();

        if (res.ok && data.success) {
          // Construire badge & boutons selon statut
          const statutBadge = data.edition.statut == 1
            ? `<span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">✅ Active</span>`
            : `<span class="px-3 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">🔒 Clôturée</span>`;

          const actionBtns = data.edition.statut == 1
            ? `<button class="editBtn flex-1 px-3 py-1 bg-black text-white rounded text-center" data-id="${data.edition.id}">Modifier</button>
               <button class="deleteBtn flex-1 px-3 py-1 bg-red-500 text-white rounded" data-id="${data.edition.id}">Supprimer</button>`
            : '';

          if (isEditing) {
            // Mettre à jour la carte existante
            const card = document.querySelector(`div[data-id='${data.edition.id}']`);
            if (card) {
              card.innerHTML = `
                <div>
                  <h3 class="text-lg font-bold text-gray-800">${escapeHtml(data.edition.titre)}</h3>
                  <p class="text-sm text-gray-600">${escapeHtml(data.edition.theme || '')}</p>
                </div>
                <div class="mt-4">${statutBadge}</div>
                <div class="mt-4 flex gap-2">${actionBtns}</div>
              `;
            }
            alert("✅ Édition modifiée avec succès");
          } else {
            // Créer une nouvelle carte
            const div = document.createElement('div');
            div.dataset.id = data.edition.id;
            div.className = "bg-white rounded-xl shadow-md p-5 flex flex-col justify-between";
            div.innerHTML = `
              <div>
                <h3 class="text-lg font-bold text-gray-800">${escapeHtml(data.edition.titre)}</h3>
                <p class="text-sm text-gray-600">${escapeHtml(data.edition.theme || '')}</p>
              </div>
              <div class="mt-4">${statutBadge}</div>
              <div class="mt-4 flex gap-2">${actionBtns}</div>
            `;
            editionList.prepend(div); // mettre en haut
            alert("✅ Édition ajoutée avec succès");
          }

          editionForm.reset();
          editionIdInput.value = "";
          isEditing = false;
          closeModal();
        } else {
          // erreurs de validation 422 / autres messages
          if (res.status === 422 && data.errors) {
            const messages = Object.values(data.errors).flat().join(' · ');
            formErrors.textContent = messages;
          } else {
            formErrors.textContent = data.message || "Une erreur est survenue";
          }
        }

      } catch (err) {
        formErrors.textContent = "Erreur réseau : " + err.message;
      } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = "Enregistrer";
      }
    });

    // Petit helper pour échapper le HTML (sécurité)
    function escapeHtml(unsafe) {
      if (!unsafe) return '';
      return String(unsafe)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
    }
  </script>
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      sidebar.classList.toggle('-translate-x-full');
      overlay.classList.toggle('hidden');
    }

    // Graphique
    const categories = @json($categoriesLabels ?? []);
    const votes = @json($categoriesVotes ?? []);

    const ctx = document.getElementById('votesParCategorie').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: categories,
        datasets: [{
          label: 'Votes',
          data: votes,
          backgroundColor: 'rgba(162, 130, 36, 0.8)',
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  </script>
</body>
</html>
