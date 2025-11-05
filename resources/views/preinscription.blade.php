@extends('layouts.default')

@section('title', 'Preinscription')

@section('content')
<h1>Inscription</h1>

<form method="POST" action="{{ route('preinscription.store') }}">
    @csrf
    <label for=" email">Email :</label>
    <input type="email" id="email" name="email" required>
    <button type="submit">Valider</button>
</form>
@endsection