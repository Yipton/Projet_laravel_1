@extends('layouts.default')

@section('title', 'Inscription')

@section('content')
<div class="grid">
    <div></div>
    <div>
        <br>
        <h1>Inscription</h1>

        <form method="POST" action="{{ route('inscription.store') }}">
            @csrf
            @if ($errors->any())
                <article class="alert alert-danger" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </article>
            @endif

            {{-- EMAIL --}}
            <label for="email">Email</label>
            <input type="email" id="email"
                   value="{{ auth()->user()->email }}"
                   readonly aria-readonly="true" tabindex="-1">

            {{-- PRENOM --}}
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" required>
            @error('prenom')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            {{-- NOM --}}
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required>
            @error('nom')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            {{-- GENRE --}}
            <label for="genre">Genre</label>
            <div class="genre-group">
                <label><input type="radio" name="genre" value="H" {{ old('genre')==='H'?'checked':'' }} required> Homme</label>
                <label><input type="radio" name="genre" value="F" {{ old('genre')==='F'?'checked':'' }} required> Femme</label>
                <label><input type="radio" name="genre" value="I" {{ old('genre')==='I'?'checked':'' }} required> Inconnu</label>
            </div>
            @error('genre')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            <br>

            {{-- MOT DE PASSE --}}
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>

            <button type="submit">Valider</button>
        </form>
    </div>
    <div></div>
</div>
@endsection
