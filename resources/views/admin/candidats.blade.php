@forelse ($Candidats as $Candidat)
    <div>{{$Candidat->nom_complet}}</div>
@empty
    Aucun candidat 
@endforelse