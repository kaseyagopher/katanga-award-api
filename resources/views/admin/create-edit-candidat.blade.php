@extends('layouts.admin')

@section('title', isset($Candidat) ? 'Modifier candidat' : 'Nouveau candidat')
@section('page-title', isset($Candidat) ? 'Modifier le candidat' : 'Créer un candidat')

@section('content')
  <div class="mx-auto max-w-4xl">
    <form id="formCandidat"
          action="{{ isset($Candidat) ? route('candidats.update', $Candidat->uuid) : route('candidats.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="rounded-2xl border border-neutral-200 bg-white p-6 sm:p-8 shadow-sm">
      @csrf
      @if(isset($Candidat))
        @method('PUT')
      @endif

      <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
        {{-- Photo --}}
        <div class="flex flex-col items-center md:col-span-1">
          <label class="mb-3 block text-sm font-medium text-neutral-700">Photo du candidat</label>
          <div class="relative mb-3 h-36 w-36 overflow-hidden rounded-2xl border-2 border-dashed border-ka-gold/50 bg-neutral-50 shadow-inner">
            <img id="preview"
                 src="{{ isset($Candidat) && $Candidat->photo_url ? asset($Candidat->photo_url) : '' }}"
                 alt="Aperçu"
                 class="h-full w-full object-cover {{ isset($Candidat) && $Candidat->photo_url ? '' : 'hidden' }}">
            <div id="previewPlaceholder" class="flex h-full w-full flex-col items-center justify-center text-neutral-400 {{ isset($Candidat) && $Candidat->photo_url ? 'hidden' : '' }}">
              <span class="material-icons text-4xl">add_a_photo</span>
              <span class="mt-1 text-xs">JPG, PNG</span>
            </div>
          </div>
          <input type="file" name="photo_url" id="photo_url" accept="image/*" onchange="previewImage(event)"
                 class="w-full text-sm text-neutral-600 file:mr-3 file:rounded-lg file:border-0 file:bg-ka-gold file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-ka-gold/90"
                 {{ isset($Candidat) ? '' : 'required' }}>
          @error('photo_url')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Infos --}}
        <div class="space-y-4 md:col-span-2">
          <div>
            <label for="nom_complet" class="mb-1 block text-sm font-medium text-neutral-700">Nom complet</label>
            <input type="text" name="nom_complet" id="nom_complet"
                   value="{{ old('nom_complet', $Candidat->nom_complet ?? '') }}" required
                   class="w-full rounded-lg border border-neutral-300 px-3 py-2.5 focus:border-ka-gold focus:outline-none focus:ring-2 focus:ring-ka-gold/30">
            @error('nom_complet')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="description" class="mb-1 block text-sm font-medium text-neutral-700">Description</label>
            <textarea name="description" id="description" rows="4" required
                      class="w-full rounded-lg border border-neutral-300 px-3 py-2.5 focus:border-ka-gold focus:outline-none focus:ring-2 focus:ring-ka-gold/30">{{ old('description', $Candidat->description ?? '') }}</textarea>
            @error('description')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <label for="categorie_id" class="mb-1 block text-sm font-medium text-neutral-700">Catégorie</label>
              <select name="categorie_id" id="categorie_id" required
                      class="w-full rounded-lg border border-neutral-300 px-3 py-2.5 focus:border-ka-gold focus:outline-none focus:ring-2 focus:ring-ka-gold/30">
                <option value="">— Catégorie —</option>
                @foreach($Categories as $Categorie)
                  <option value="{{ $Categorie->id }}"
                    {{ old('categorie_id', $Candidat->categorie_id ?? '') == $Categorie->id ? 'selected' : '' }}>
                    {{ $Categorie->nom_categorie }}
                  </option>
                @endforeach
              </select>
              @error('categorie_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
            <div>
              <label for="edition_id" class="mb-1 block text-sm font-medium text-neutral-700">Édition</label>
              <select name="edition_id" id="edition_id" required
                      class="w-full rounded-lg border border-neutral-300 px-3 py-2.5 focus:border-ka-gold focus:outline-none focus:ring-2 focus:ring-ka-gold/30">
                <option value="">— Édition —</option>
                @foreach($Editions as $Edition)
                  <option value="{{ $Edition->id }}"
                    {{ old('edition_id', $Candidat->edition_id ?? '') == $Edition->id ? 'selected' : '' }}>
                    {{ $Edition->titre }}
                  </option>
                @endforeach
              </select>
              @error('edition_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>
      </div>

      <div id="progress-container" class="mt-6 hidden">
        <div class="h-2.5 w-full overflow-hidden rounded-full bg-neutral-200">
          <div id="progress-bar" class="h-full rounded-full bg-ka-gold text-center text-[10px] font-bold text-white transition-all" style="width:0%">0%</div>
        </div>
        <p id="progress-message" class="mt-2 text-center text-sm text-neutral-600"></p>
      </div>

      <div class="mt-8 flex gap-3 border-t border-neutral-100 pt-6">
        <a href="{{ route('candidats.index') }}"
           class="rounded-lg border border-neutral-300 px-5 py-2.5 text-sm font-medium text-neutral-700 hover:bg-neutral-50">
          Annuler
        </a>
        <button type="submit"
                class="ml-auto inline-flex items-center gap-2 rounded-lg bg-black px-6 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-ka-yellow focus:ring-offset-2">
          <span class="material-icons text-[18px]">save</span>
          {{ isset($Candidat) ? 'Mettre à jour' : 'Créer le candidat' }}
        </button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
<script>
  function previewImage(event) {
    const preview = document.getElementById('preview');
    const placeholder = document.getElementById('previewPlaceholder');
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = e => {
        preview.src = e.target.result;
        preview.classList.remove('hidden');
        placeholder?.classList.add('hidden');
      };
      reader.readAsDataURL(file);
    }
  }

  document.getElementById('formCandidat').addEventListener('submit', function (e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    const progressContainer = document.getElementById('progress-container');
    const progressBar = document.getElementById('progress-bar');
    const progressMessage = document.getElementById('progress-message');
    progressContainer.classList.remove('hidden');

    const xhr = new XMLHttpRequest();
    xhr.open(form.method, form.action, true);
    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

    xhr.upload.onprogress = function (ev) {
      if (ev.lengthComputable) {
        const percent = Math.round((ev.loaded / ev.total) * 100);
        progressBar.style.width = percent + '%';
        progressBar.textContent = percent + '%';
      }
    };

    xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 300) {
        progressBar.classList.remove('bg-ka-gold');
        progressBar.classList.add('bg-green-600');
        progressMessage.textContent = 'Enregistrement réussi !';
        setTimeout(() => { window.location.href = '{{ route('candidats.index') }}'; }, 1000);
      } else {
        progressBar.classList.add('bg-red-600');
        progressMessage.textContent = 'Erreur lors de l\'envoi.';
      }
    };

    xhr.send(formData);
  });
</script>
@endpush
