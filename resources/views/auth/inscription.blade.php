@extends('layouts.default')

@section('title', 'Inscription')

@section('content')
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
@endsection