<div>
    @forelse ($Categories as $Categorie)
        {{$Categorie->id}}--{{$Categorie->nom_categorie}}
    @empty
        Aucune categorie
    @endforelse
</div>