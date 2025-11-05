<!DOCTYPE html>
<html lang="fr" data-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/pico.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <title>Inscription</title>
</head>

<body>
    <div class="wrapper">
        @include('includes.header')
        <main class="container">
            <h1>Inscription</h1>

            <form method="POST" action="{{ route('preinscription.store') }}">
                @csrf
                <label for=" email">Email :</label>
                <input type="email" id="email" name="email" required>
                <button type="submit">Valider</button>
            </form>

        </main>
        @include('includes.footer')
    </div>
</body>

</html>