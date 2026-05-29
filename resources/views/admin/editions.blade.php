@extends('layouts.admin')

@section('title', 'Éditions')
@section('page-title', 'Éditions')
@section('page-subtitle', 'Gérer les éditions du prix')

@section('header-actions')
  <button type="button" id="showFormBtn"
          class="inline-flex items-center gap-2 rounded-lg bg-ka-gold px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-ka-gold/90">
    <span class="material-icons text-[18px]">add</span>
    Nouvelle édition
  </button>
@endsection

@section('content')
  <div id="editionList" class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
    @forelse ($Editions as $Edition)
      <article data-id="{{ $Edition->id }}" class="flex flex-col rounded-2xl border border-neutral-200 bg-white p-5 shadow-sm transition hover:border-ka-gold/40 hover:shadow-md">
        <div class="flex-1">
          <h3 class="text-lg font-bold text-neutral-900">{{ $Edition->titre }}</h3>
          <p class="mt-1 text-sm text-neutral-600">{{ $Edition->theme }}</p>
        </div>
        <div class="mt-4">
          @if($Edition->statut == 1)
            <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
              <span class="material-icons text-[14px]">check_circle</span> Active
            </span>
          @else
            <span class="inline-flex items-center gap-1 rounded-full bg-neutral-100 px-3 py-1 text-xs font-semibold text-neutral-600">
              <span class="material-icons text-[14px]">lock</span> Clôturée
            </span>
          @endif
        </div>
        @if($Edition->statut == 1)
          <div class="mt-4 flex gap-2">
            <button type="button" class="editBtn flex-1 rounded-lg bg-black px-3 py-2 text-sm font-semibold text-white hover:bg-neutral-800" data-id="{{ $Edition->id }}">
              Modifier
            </button>
            <button type="button" class="deleteBtn flex-1 rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700" data-id="{{ $Edition->id }}">
              Supprimer
            </button>
          </div>
        @endif
      </article>
    @empty
      <div class="col-span-full rounded-2xl border-2 border-dashed border-neutral-200 py-16 text-center text-neutral-500">
        <span class="material-icons text-5xl text-neutral-300 mb-2">event</span>
        <p>Aucune édition. Cliquez sur « Nouvelle édition ».</p>
      </div>
    @endforelse
  </div>

  {{-- Modal --}}
  <div id="editionFormContainer" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4 backdrop-blur-sm" role="dialog">
    <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
      <button type="button" id="closeX" class="absolute right-4 top-4 text-neutral-400 hover:text-neutral-800 text-2xl leading-none" title="Fermer">&times;</button>
      <h2 id="formTitle" class="text-xl font-bold text-neutral-900 mb-5 pr-8">Ajouter une édition</h2>

      <form id="editionForm" class="space-y-4">
        @csrf
        <input type="hidden" id="editionId" name="editionId" value="">

        <div>
          <label for="titre" class="mb-1 block text-sm font-medium text-neutral-700">Titre</label>
          <input type="text" id="titre" name="titre" required
                 class="w-full rounded-lg border border-neutral-300 px-3 py-2 focus:border-ka-gold focus:outline-none focus:ring-2 focus:ring-ka-gold/30" />
        </div>
        <div>
          <label for="theme" class="mb-1 block text-sm font-medium text-neutral-700">Thème</label>
          <input type="text" id="theme" name="theme" required
                 class="w-full rounded-lg border border-neutral-300 px-3 py-2 focus:border-ka-gold focus:outline-none focus:ring-2 focus:ring-ka-gold/30" />
        </div>
        <div>
          <label for="statut" class="mb-1 block text-sm font-medium text-neutral-700">Statut</label>
          <select id="statut" name="statut" required
                  class="w-full rounded-lg border border-neutral-300 px-3 py-2 focus:border-ka-gold focus:outline-none focus:ring-2 focus:ring-ka-gold/30">
            <option value="1">Active</option>
            <option value="0">Non active</option>
          </select>
        </div>
        <div id="formErrors" class="text-sm text-red-600"></div>
        <div class="flex justify-end gap-2 pt-2">
          <button type="button" id="closeFormBtn" class="rounded-lg bg-neutral-200 px-4 py-2 text-sm font-medium hover:bg-neutral-300">Annuler</button>
          <button type="submit" id="submitBtn" class="rounded-lg bg-ka-gold px-4 py-2 text-sm font-semibold text-white hover:bg-ka-gold/90">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
<script>
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
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

  function openModal() {
    editionFormContainer.classList.remove('hidden');
    editionFormContainer.classList.add('flex');
  }
  function closeModal() {
    editionFormContainer.classList.add('hidden');
    editionFormContainer.classList.remove('flex');
    formErrors.textContent = '';
  }

  showFormBtn.addEventListener('click', () => {
    isEditing = false;
    formTitle.textContent = 'Ajouter une édition';
    editionForm.reset();
    editionIdInput.value = '';
    submitBtn.textContent = 'Enregistrer';
    openModal();
  });
  closeFormBtn.addEventListener('click', closeModal);
  closeX.addEventListener('click', closeModal);
  editionFormContainer.addEventListener('click', (e) => { if (e.target === editionFormContainer) closeModal(); });

  editionList.addEventListener('click', async (e) => {
    if (e.target.closest('.editBtn')) {
      const id = e.target.closest('.editBtn').getAttribute('data-id');
      isEditing = true;
      formTitle.textContent = "Modifier l'édition";
      formErrors.textContent = 'Chargement...';
      try {
        const res = await fetch(`editions/${id}/edit`, { headers: { Accept: 'application/json' } });
        const data = await res.json();
        if (res.ok && data.success) {
          editionIdInput.value = data.edition.id;
          titreInput.value = data.edition.titre ?? '';
          themeInput.value = data.edition.theme ?? '';
          statutInput.value = String(data.edition.statut ?? '1');
          formErrors.textContent = '';
          openModal();
        } else {
          formErrors.textContent = data.message || "Impossible de charger l'édition";
        }
      } catch (err) {
        formErrors.textContent = 'Erreur réseau : ' + err.message;
      }
      return;
    }
    if (e.target.closest('.deleteBtn')) {
      const id = e.target.closest('.deleteBtn').getAttribute('data-id');
      if (!confirm('Supprimer cette édition ?')) return;
      try {
        const res = await fetch(`editions/${id}`, {
          method: 'DELETE',
          headers: { 'X-CSRF-TOKEN': csrfToken, Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await res.json();
        if (res.ok && data.success) {
          document.querySelector(`article[data-id='${id}']`)?.remove();
        } else {
          alert(data.message || 'Impossible de supprimer');
        }
      } catch (err) {
        alert('Erreur réseau : ' + err.message);
      }
    }
  });

  editionForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    formErrors.textContent = '';
    submitBtn.disabled = true;
    const formData = new FormData(editionForm);
    formData.set('_token', csrfToken);
    let url = "{{ route('editions.store') }}";
    if (isEditing) {
      formData.set('_method', 'PUT');
      url = `editions/${editionIdInput.value}`;
    }
    try {
      const res = await fetch(url, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: formData
      });
      const data = await res.json();
      if (res.ok && data.success) {
        location.reload();
      } else if (res.status === 422 && data.errors) {
        formErrors.textContent = Object.values(data.errors).flat().join(' · ');
      } else {
        formErrors.textContent = data.message || 'Une erreur est survenue';
      }
    } catch (err) {
      formErrors.textContent = 'Erreur réseau : ' + err.message;
    } finally {
      submitBtn.disabled = false;
    }
  });
</script>
@endpush
