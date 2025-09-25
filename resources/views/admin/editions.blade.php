<div>
    <h3>Éditions</h3>

    <!-- Liste des éditions -->
    <ul id="editionList">
        @forelse ($Editions as $Edition)
            <li data-id="{{ $Edition->id }}">
                {{ $Edition->theme }} – {{ $Edition->created_at ?? 'Pas de date' }}
                <button class="editBtn">✏️ Modifier</button>
            </li>
        @empty
            <li>Aucune Edition</li>
        @endforelse
    </ul>

    <!-- Bouton Ajouter -->
    <button id="showFormBtn">➕ Ajouter une édition</button>

    <!-- Formulaire popup (caché) -->
    <div id="editionFormContainer" hidden>
        <form id="editionForm">
            @csrf
            <input type="hidden" id="editionId" name="editionId">

            <label for="titre">Titre :</label>
            <input type="text" id="titre" name="titre" required>

            <label for="theme">Thème :</label>
            <input type="text" id="theme" name="theme" required>

            <label for="statut">Statut :</label>
            <select name="statut" id="statut" required>
                <option value="1">Active</option>
                <option value="0">Non active</option>
            </select>

            <button type="submit" id="submitBtn">Enregistrer</button>
            <button type="button" id="closeFormBtn">Annuler</button>
        </form>

        <div id="formMessage"></div>
    </div>
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

// Clic sur Ajouter
showFormBtn.addEventListener('click', () => {
    isEditing = false;
    editionForm.reset();
    editionIdInput.value = '';
    editionFormContainer.hidden = false;
    formMessage.innerText = '';
});

// Clic sur Annuler
closeFormBtn.addEventListener('click', () => {
    editionFormContainer.hidden = true;
});

// Clic sur Modifier
editionList.addEventListener('click', async (e) => {
    if(!e.target.classList.contains('editBtn')) return;

    const li = e.target.closest('li');
    const id = li.dataset.id;
    isEditing = true;
    editionFormContainer.hidden = false;
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
        method = "PUT";
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
                const li = editionList.querySelector(`li[data-id='${data.edition.id}']`);
                li.innerHTML = `${data.edition.theme} – ${data.edition.created_at} <button class="editBtn">✏️ Modifier</button>`;
            } else {
                const li = document.createElement("li");
                li.dataset.id = data.edition.id;
                li.innerHTML = `${data.edition.theme} – ${data.edition.created_at} <button class="editBtn">✏️ Modifier</button>`;
                editionList.appendChild(li);
            }

            editionForm.reset();
            editionFormContainer.hidden = true;
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
