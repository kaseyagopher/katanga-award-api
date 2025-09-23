<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status de connexion</title>
</head>
<body style="padding: 50px; text-align:center;">

    <h1>Status de connexion</h1>
    
    {{-- Vérification si un user est connecté --}}
    @if(Auth::guard('web')->check())
        <p style="color:green;">
            Vous êtes connecté en tant que User : <strong>{{ Auth::guard('web')->user()->numero ?? Auth::guard('web')->user()->email }}</strong>
        </p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Se déconnecter</button>
        </form>

    {{-- Vérification si un admin est connecté --}}
    @elseif(Auth::guard('admin')->check())
        <p style="color:green;">
            Vous êtes connecté en tant qu'Admin : <strong>{{ Auth::guard('admin')->user()->email }}</strong>
        </p>
        

    @else
        <p style="color:orange;">Vous n'êtes pas connecté.</p>
    @endif

</body>
</html>
