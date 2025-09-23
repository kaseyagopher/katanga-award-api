<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Vote en ligne</title>
</head>
<body style="padding: 20px; font-family: sans-serif;">

    <h1>Tableau de bord Admin</h1>

    <p>Connecté en tant que : <strong>admin@example.com</strong></p>

    <form method="GET" action="{{route('admin.logout')}}">
        @csrf
        <button type="submit">Se déconnecter</button>
    </form>

    <hr>

    <h2>Liste candidats</h2>
    <ul>
        @forelse ( $Candidats as $Candidat )
            <li>{{$Candidat->nom_complet}}</li>
        @empty
            Aucun candidat
        @endforelse
    </ul>

    <hr>

    <h2>Liste des Categories </h2>
    <ul>
        @forelse ( $Categories as $Categorie )
            <li>{{$Categorie->nom_categorie}}</li>
        @empty
            Aucune categorie
        @endforelse
    </ul>

    <h2>Liste des Editions </h2>
    <ul>
        @forelse ( $Editions as $Edition )
            <li>{{$Edition->titre}}</li>
        @empty
            Aucunee Edition
        @endforelse
    </ul>

    <hr>
</body>
</html>
