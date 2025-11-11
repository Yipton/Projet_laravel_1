@extends('layouts.default')

@section('title', 'Gestion des abonnements')

@section('content')
<div class="grid">
    <div></div>
    <div>
        <br>
    <h1>Liste des demandes d'abonnement</h1>
    <form method="POST" action="{{ route('gestion.confirmer_auto_abo') }}">
    @csrf
    <table>
         <thead>
             <tr>
                <td>Nom</td>
                <td>Prénom</td>
                <td>Mail</td>
                <td>Approuver</td>
        </thead>
        <tbody>
            @foreach ($demandes as $une_demande)
            <tr>
                <td>{{ $une_demande->nom }}</td>
                <td>{{ $une_demande->prenom }}</td>
                <td>{{-- $une_demande->email --}}</td>
                <td><select>
                    <option value="Attendre">Attendre</option>
                    <option value="Oui">Oui</option>
                    <option value="Non">Non (Supprime l'utilisateur)</option>
                    </select>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <button type="submit">Valider</button>
    </form>
        </div>
    <div></div>
</div>
@endsection
