<!DOCTYPE html>
<html lang="fr" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/pico.css" rel="stylesheet" />
    <link href="/css/styles.css" rel="stylesheet" />
    <title>Inscription</title>
</head>

<body>
    <div class="wrapper">
        @include('includes.header')
        <main class="container">
            <h1>Inscription</h1>
            <form method="POST" action="{{ route('inscription.store') }}">

                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom">

                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom">

                <label for="email">Email</label>
                <input type="email" name="email" id="email">

                <label for="password">Email</label>
                <input type="password" name="password" id="password">

                <button type="submit">Valider</button>
            </form>

        </main>

        @include('includes.footer')

    </div>
</body>

</html>