<!DOCTYPE html>
<html lang="fr" data-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/pico.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <title>Concours robot</title>
</head>

<body>
    <div class="wrapper">
        <header class="header">
            @include('includes.header')
        </header>
        <aside class="aside">
            <nav class="navigation">
                @include('includes.menu')
            </nav>
        </aside>
        <main id="main" class="main">
            @yield('contenu')
        </main>
    </div>
</body>

</html>