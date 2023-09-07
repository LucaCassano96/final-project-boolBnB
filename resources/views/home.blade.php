@extends('layouts.app')
@section('content')

<div class="jumbotron p-5 mb-4 bg-light rounded-3">
    <div class="container py-5">

        <h1>ciao</h1>
        <a href="{{route('apartment.create')}}">Aggiungi</a>

        <ul>

            @foreach ($apartments as $apartment)

            <li>{{$apartment -> title}}</li>
            <li>{{$apartment -> location -> address}}</li>
            @endforeach

    </ul>

    </div>
</div>


@endsection

