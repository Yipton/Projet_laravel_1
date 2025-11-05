@extends('layouts.default')

@section('title', 'Lien envoyé')

@section('content')
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
@endsection