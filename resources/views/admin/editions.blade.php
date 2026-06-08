@extends('layouts.admin')

@section('title', 'Sessions')
@section('page-title', 'Sessions / Éditions')
@section('page-subtitle', 'Ouvrir, clôturer ou consulter une session de vote')

@section('header-actions')
  <button type="button" id="showFormBtn"
          class="inline-flex items-center gap-2 rounded-lg bg-ka-gold px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-ka-gold/90">
    <span class="material-icons text-[18px]">play_circle</span>
    Ouvrir une session
  </button>
@endsection

@section('content')
  <div id="editionList" class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
    @forelse ($Editions as $Edition)
      <article data-id="{{ $Edition->id }}" class="flex flex-col rounded-2xl border border-neutral-200 bg-white p-5 shadow-sm transition hover:border-ka-gold/40 hover:shadow-md">
        <div class="flex-1">
          <h3 class="text-lg font-bold text-neutral-900">{{ $Edition->titre }}</h3>
          <p class="mt-1 text-sm text-neutral-600">{{ $Edition->theme }}</p>
          <p class="mt-2 text-xs text-neutral-400">
            {{ $Edition->categories_count }} catégorie(s) · {{ $Edition->votes_count }} vote(s)
          </p>
        </div>
        <div class="mt-4">
          @if($Edition->statut == 1)
            <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
              <span class="material-icons text-[14px]">check_circle</span> Session ouverte
            </span>
          @elseif(($consultationEdition ?? null)?->id === $Edition->id)
            <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">
              <span class="material-icons text-[14px]">visibility</span> En consultation
            </span>
          @else
            <span class="inline-flex items-center gap-1 rounded-full bg-neutral-100 px-3 py-1 text-xs font-semibold text-neutral-600">
              <span class="material-icons text-[14px]">lock</span> Clôturée
            </span>
          @endif
        </div>

        @if($Edition->statut == 1)
          <div class="mt-4 flex flex-col gap-2">
            <button type="button" class="editBtn w-full rounded-lg bg-black px-3 py-2 text-sm font-semibold text-white hover:bg-neutral-800" data-id="{{ $Edition->id }}">
              Modifier
            </button>
            <button type="button" class="closeBtn w-full rounded-lg bg-amber-600 px-3 py-2 text-sm font-semibold text-white hover:bg-amber-700" data-id="{{ $Edition->id }}" data-title="{{ $Edition->titre }}">
              Clôturer la session
            </button>
          </div>
        @else
          <div class="mt-4 flex flex-col gap-2">
            <button type="button" class="consultBtn w-full rounded-lg bg-ka-gold px-3 py-2 text-sm font-semibold text-white hover:bg-ka-gold/90" data-id="{{ $Edition->id }}" data-title="{{ $Edition->titre }}">
              Consulter cette session
            </button>
            <button type="button" class="deleteBtn w-full rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-100" data-id="{{ $Edition->id }}">
              Supprimer
            </button>
          </div>
        @endif
      </article>
    @empty
      <div class="col-span-full rounded-2xl border-2 border-dashed border-neutral-200 py-16 text-center text-neutral-500">
        <span class="material-icons text-5xl text-neutral-300 mb-2">event</span>
        <p>Aucune session. Cliquez sur « Ouvrir une session ».</p>
      </div>
    @endforelse
  </div>

  {{-- Modal formulaire édition --}}
  <div id="editionFormContainer" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4 backdrop-blur-sm" role="dialog">
    <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
      <button type="button" id="closeX" class="absolute right-4 top-4 text-neutral-400 hover:text-neutral-800 text-2xl leading-none" title="Fermer">&times;</button>
      <h2 id="formTitle" class="text-xl font-bold text-neutral-900 mb-1 pr-8">Ouvrir une session</h2>
      <p id="formSubtitle" class="text-sm text-neutral-500 mb-5">Une confirmation par mot de passe sera demandée.</p>

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
        <div id="formErrors" class="text-sm text-red-600"></div>
        <div class="flex justify-end gap-2 pt-2">
          <button type="button" id="closeFormBtn" class="rounded-lg bg-neutral-200 px-4 py-2 text-sm font-medium hover:bg-neutral-300">Annuler</button>
          <button type="button" id="openPasswordForSave" class="rounded-lg bg-ka-gold px-4 py-2 text-sm font-semibold text-white hover:bg-ka-gold/90">
            Continuer
          </button>
        </div>
      </form>
    </div>
  </div>

  {{-- Modal mot de passe --}}
  <div id="passwordModal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/70 p-4 backdrop-blur-sm" role="dialog">
    <div class="relative w-full max-w-sm rounded-2xl bg-white p-6 shadow-2xl">
      <button type="button" id="closePasswordModal" class="absolute right-4 top-4 text-neutral-400 hover:text-neutral-800 text-2xl leading-none">&times;</button>
      <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-ka-gold/15">
        <span class="material-icons text-ka-gold">lock</span>
      </div>
      <h3 id="passwordModalTitle" class="text-lg font-bold text-neutral-900">Confirmer avec votre mot de passe</h3>
      <p id="passwordModalText" class="mt-1 text-sm text-neutral-500 mb-4"></p>
      <form id="passwordForm">
        <label for="adminPassword" class="mb-1 block text-sm font-medium text-neutral-700">Mot de passe administrateur</label>
        <input type="password" id="adminPassword" name="password" required autocomplete="current-password"
               class="w-full rounded-lg border border-neutral-300 px-3 py-2 focus:border-ka-gold focus:outline-none focus:ring-2 focus:ring-ka-gold/30" />
        <p id="passwordErrors" class="mt-2 text-sm text-red-600"></p>
        <div class="mt-5 flex justify-end gap-2">
          <button type="button" id="cancelPasswordBtn" class="rounded-lg bg-neutral-200 px-4 py-2 text-sm font-medium hover:bg-neutral-300">Annuler</button>
          <button type="submit" id="confirmPasswordBtn" class="rounded-lg bg-ka-gold px-4 py-2 text-sm font-semibold text-white hover:bg-ka-gold/90">Confirmer</button>
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
  const formSubtitle = document.getElementById('formSubtitle');
  const formErrors = document.getElementById('formErrors');
  const editionIdInput = document.getElementById('editionId');
  const titreInput = document.getElementById('titre');
  const themeInput = document.getElementById('theme');
  const openPasswordForSave = document.getElementById('openPasswordForSave');

  const passwordModal = document.getElementById('passwordModal');
  const passwordForm = document.getElementById('passwordForm');
  const adminPasswordInput = document.getElementById('adminPassword');
  const passwordModalTitle = document.getElementById('passwordModalTitle');
  const passwordModalText = document.getElementById('passwordModalText');
  const passwordErrors = document.getElementById('passwordErrors');
  const confirmPasswordBtn = document.getElementById('confirmPasswordBtn');
  const closePasswordModal = document.getElementById('closePasswordModal');
  const cancelPasswordBtn = document.getElementById('cancelPasswordBtn');

  let isEditing = false;
  let pendingAction = null;

  function openEditionModal() {
    editionFormContainer.classList.remove('hidden');
    editionFormContainer.classList.add('flex');
  }
  function closeEditionModal() {
    editionFormContainer.classList.add('hidden');
    editionFormContainer.classList.remove('flex');
    formErrors.textContent = '';
  }
  function openPasswordModal(title, text, action) {
    pendingAction = action;
    passwordModalTitle.textContent = title;
    passwordModalText.textContent = text;
    passwordErrors.textContent = '';
    adminPasswordInput.value = '';
    passwordModal.classList.remove('hidden');
    passwordModal.classList.add('flex');
    setTimeout(() => adminPasswordInput.focus(), 100);
  }
  function closePasswordModalFn() {
    pendingAction = null;
    passwordModal.classList.add('hidden');
    passwordModal.classList.remove('flex');
    passwordErrors.textContent = '';
    adminPasswordInput.value = '';
  }

  showFormBtn.addEventListener('click', () => {
    isEditing = false;
    formTitle.textContent = 'Ouvrir une session';
    formSubtitle.textContent = 'La session sera active immédiatement après confirmation par mot de passe.';
    editionForm.reset();
    editionIdInput.value = '';
    openPasswordForSave.textContent = 'Continuer';
    openEditionModal();
  });

  closeFormBtn.addEventListener('click', closeEditionModal);
  closeX.addEventListener('click', closeEditionModal);
  editionFormContainer.addEventListener('click', (e) => { if (e.target === editionFormContainer) closeEditionModal(); });
  closePasswordModal.addEventListener('click', closePasswordModalFn);
  cancelPasswordBtn.addEventListener('click', closePasswordModalFn);
  passwordModal.addEventListener('click', (e) => { if (e.target === passwordModal) closePasswordModalFn(); });

  openPasswordForSave.addEventListener('click', () => {
    formErrors.textContent = '';
    if (!titreInput.value.trim() || !themeInput.value.trim()) {
      formErrors.textContent = 'Remplissez le titre et le thème.';
      return;
    }
    if (isEditing) {
      submitEditionUpdate();
      return;
    }
    openPasswordModal(
      'Ouvrir la session',
      'Entrez votre mot de passe pour ouvrir cette nouvelle session de vote.',
      'create'
    );
  });

  editionList.addEventListener('click', async (e) => {
    if (e.target.closest('.editBtn')) {
      const id = e.target.closest('.editBtn').getAttribute('data-id');
      isEditing = true;
      formTitle.textContent = "Modifier la session";
      formSubtitle.textContent = 'Modification du titre et du thème uniquement.';
      formErrors.textContent = 'Chargement...';
      try {
        const res = await fetch(`editions/${id}/edit`, { headers: { Accept: 'application/json' } });
        const data = await res.json();
        if (res.ok && data.success) {
          editionIdInput.value = data.edition.id;
          titreInput.value = data.edition.titre ?? '';
          themeInput.value = data.edition.theme ?? '';
          formErrors.textContent = '';
          openPasswordForSave.textContent = 'Enregistrer';
          openEditionModal();
        } else {
          formErrors.textContent = data.message || "Impossible de charger l'édition";
        }
      } catch (err) {
        formErrors.textContent = 'Erreur réseau : ' + err.message;
      }
      return;
    }

    if (e.target.closest('.closeBtn')) {
      const btn = e.target.closest('.closeBtn');
      openPasswordModal(
        'Clôturer la session',
        `Confirmez la clôture de « ${btn.dataset.title} ». Les votes publics seront désactivés.`,
        { type: 'close', id: btn.dataset.id }
      );
      return;
    }

    if (e.target.closest('.consultBtn')) {
      const btn = e.target.closest('.consultBtn');
      openPasswordModal(
        'Consulter la session',
        `Accédez aux données de « ${btn.dataset.title} » en mode lecture (résultats, candidats, votes).`,
        { type: 'consult', id: btn.dataset.id }
      );
      return;
    }

    if (e.target.closest('.deleteBtn')) {
      const id = e.target.closest('.deleteBtn').getAttribute('data-id');
      if (!confirm('Supprimer définitivement cette session clôturée ?')) return;
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

  async function submitEditionCreate(password) {
    const formData = new FormData();
    formData.set('_token', csrfToken);
    formData.set('titre', titreInput.value.trim());
    formData.set('theme', themeInput.value.trim());
    formData.set('password', password);

    const res = await fetch("{{ route('editions.store') }}", {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrfToken, Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
      body: formData
    });
    return res.json().then(data => ({ res, data }));
  }

  async function submitEditionUpdate() {
    formErrors.textContent = '';
    openPasswordForSave.disabled = true;
    const formData = new FormData();
    formData.set('_token', csrfToken);
    formData.set('_method', 'PUT');
    formData.set('titre', titreInput.value.trim());
    formData.set('theme', themeInput.value.trim());

    try {
      const res = await fetch(`editions/${editionIdInput.value}`, {
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
      openPasswordForSave.disabled = false;
    }
  }

  async function submitClose(id, password) {
    const formData = new FormData();
    formData.set('_token', csrfToken);
    formData.set('password', password);

    const res = await fetch(`editions/${id}/close`, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrfToken, Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
      body: formData
    });
    return res.json().then(data => ({ res, data }));
  }

  async function submitConsult(id, password) {
    const formData = new FormData();
    formData.set('_token', csrfToken);
    formData.set('password', password);

    const res = await fetch(`editions/${id}/consult`, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrfToken, Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
      body: formData
    });
    return res.json().then(data => ({ res, data }));
  }

  passwordForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    passwordErrors.textContent = '';
    confirmPasswordBtn.disabled = true;
    const password = adminPasswordInput.value;

    try {
      if (pendingAction === 'create') {
        const { res, data } = await submitEditionCreate(password);
        if (res.ok && data.success) {
          location.reload();
          return;
        }
        if (res.status === 422 && data.errors?.password) {
          passwordErrors.textContent = data.errors.password.join(' · ');
        } else if (res.status === 422 && data.errors) {
          closePasswordModalFn();
          closeEditionModal();
          formErrors.textContent = Object.values(data.errors).flat().join(' · ');
        } else {
          passwordErrors.textContent = data.message || 'Une erreur est survenue';
        }
      } else if (pendingAction?.type === 'close') {
        const { res, data } = await submitClose(pendingAction.id, password);
        if (res.ok && data.success) {
          location.reload();
          return;
        }
        if (res.status === 422 && data.errors?.password) {
          passwordErrors.textContent = data.errors.password.join(' · ');
        } else {
          passwordErrors.textContent = data.message || 'Impossible de clôturer';
        }
      } else if (pendingAction?.type === 'consult') {
        const { res, data } = await submitConsult(pendingAction.id, password);
        if (res.ok && data.success) {
          window.location.href = data.redirect || "{{ route('admin.dashboard') }}";
          return;
        }
        if (res.status === 422 && data.errors?.password) {
          passwordErrors.textContent = data.errors.password.join(' · ');
        } else {
          passwordErrors.textContent = data.message || 'Impossible de consulter';
        }
      }
    } catch (err) {
      passwordErrors.textContent = 'Erreur réseau : ' + err.message;
    } finally {
      confirmPasswordBtn.disabled = false;
    }
  });
</script>
@endpush
