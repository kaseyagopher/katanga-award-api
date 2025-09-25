<h2>{{ isset($Candidat) ? 'Modifier le candidat' : 'Créer un candidat' }}</h2>

<form action="{{ isset($Candidat) ? route('candidats.update', $Candidat->id) : route('candidats.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($Candidat))
        @method('PUT')
    @endif

    <div>
        <label for="nom_complet">Nom complet</label>
        <input type="text" name="nom_complet" id="nom_complet" 
               value="{{ old('nom_complet', $Candidat->nom_complet ?? '') }}" required>
        @error('nom_complet')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="description">Description</label>
        <textarea name="description" id="description" required>{{ old('description', $Candidat->description ?? '') }}</textarea>
        @error('description')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="photo_url">Photo</label>
        <input type="file" name="photo_url" id="photo_url" {{ isset($Candidat) ? '' : 'required' }}>
        @if(isset($Candidat) && $Candidat->photo_url)
            <div>Photo actuelle : <img src="{{ $Candidat->photo_url }}" alt="Photo" width="100"></div>
        @endif
        @error('photo_url')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="categorie_id">Catégorie</label>
        <select name="categorie_id" id="categorie_id" required>
            <option value="">-- Sélectionnez une catégorie --</option>
            @foreach($Categories as $Categorie)
                <option value="{{ $Categorie->id }}"
                    {{ (old('categorie_id', $Candidat->categorie_id ?? '') == $Categorie->id) ? 'selected' : '' }}>
                    {{ $Categorie->nom_categorie }}
                </option>
            @endforeach
        </select>
        @error('categorie_id')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="edition_id">Édition</label>
        <select name="edition_id" id="edition_id" required>
            <option value="">-- Sélectionnez une édition --</option>
            @foreach($Editions as $Edition)
                <option value="{{ $Edition->id }}"
                    {{ (old('edition_id', $Candidat->edition_id ?? '') == $Edition->id) ? 'selected' : '' }}>
                    {{ $Edition->titre ?? $Edition->nom_edition }}
                </option>
            @endforeach
        </select>
        @error('edition_id')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <button type="submit">{{ isset($Candidat) ? 'Mettre à jour' : 'Créer' }}</button>
    </div>
</form>
