@extends('layouts.default')

@section('title', 'Accueil')

@section('content')
<div class="grid">
    <div>
        <br>
        <a href="{{ route('gestion.abonnement') }}">Retour au formulaire d'approbation</a>
        <br><br>
        <h1>Liste des demandes d'abonnement</h1>
        <br>
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <form method="POST" action="{{ route('gestion.supprimer_abo') }}"
            onsubmit="return confirm('Êtes-vous sûr de valider ?');">
            @csrf
            <table>
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Nom</td>
                        <td>Prénom</td>
                        <td>Mail</td>
                        <td>Supprimer</td>
                </thead>
                <tbody>
                    @foreach ($demandes as $une_demande)
                    <tr>
                        <td>{{ $une_demande->id }}</td>
                        <td>{{ $une_demande->nom }}</td>
                        <td>{{ $une_demande->prenom }}</td>
                        <td>{{ $une_demande->email }}</td>
                        <td><select name="statuts[{{ $une_demande->id }}]">
                                <option value="non">Attendre</option>
                                <option value="oui">Oui</option>
                            </select>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn_sup">Supprimer</button>
        </form>
    </div>
</div>
@endsection