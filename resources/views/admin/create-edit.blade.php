<h2>{{ isset($Categorie) ? 'Modifier la catégorie' : 'Créer une catégorie' }}</h2>

<form action="{{ isset($Categorie) ? route('categories.update', $Categorie->id) : route('categories.store') }}" method="POST">
    @csrf
    @if(isset($Categorie))
        @method('PUT')
    @endif

    <div>
        <label for="nom_categorie">Nom de la catégorie</label>
        <input type="text" name="nom_categorie" id="nom_categorie" 
               value="{{ old('nom_categorie', $Categorie->nom_categorie ?? '') }}" required>
        @error('nom_categorie')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="edition_id">Édition</label>
        <select name="edition_id" id="edition_id" required>
            <option value="">-- Sélectionnez une édition --</option>
            @foreach($Editions as $Edition)
                <option value="{{ $Edition->id }}"
                    {{ (old('edition_id', $Categorie->edition_id ?? '') == $Edition->id) ? 'selected' : '' }}>
                    {{ $Edition->titre }}
                </option>
            @endforeach
        </select>
        @error('edition_id')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <button type="submit">{{ isset($Categorie) ? 'Mettre à jour' : 'Créer' }}</button>
    </div>
</form>
