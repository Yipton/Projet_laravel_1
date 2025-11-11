@extends ('layouts.default')

@section('title', 'Validation auto_inscriptions')

@section('content')
<div class="grid">
    <div></div>
    <div>
        <br>
        <h1>Valider les infos ci dessous :</h1>

        <form method="POST" action="{{ route('home') }}">
            @csrf
           
            <button type="submit">Valider</button>
        </form>
    </div>
    <div></div>
</div>
@endsection