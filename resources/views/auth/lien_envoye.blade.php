<!DOCTYPE html>
<html lang="fr" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/pico.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <title>Lien envoyé</title>
</head>

<body>
    <div class="wrapper">
        @include('includes.header')
        <main class="container">
            <h1>Vérifie ta boîte mail</h1>

            @php($u = auth()->user())
            @if($u)
            <p>Un lien de confirmation a été envoyé à <strong>{{ $u->email }}</strong>.</p>
            @else
            <p>Tu n’es pas connecté.</p>
            <p><a href="{{ route('login') }}">Se connecter</a></p>
            @endif

            @if (session('message'))
            <p style="color:green">{{ session('message') }}</p>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit">Renvoyer le lien</button>
            </form>
        </main>
        @include('includes.footer')
    </div>
</body>

</html>