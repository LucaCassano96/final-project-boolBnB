@extends('layouts.app')
@section('content')

<div class="jumbotron p-5 mb-4 bg-light rounded-3">

    <a href="{{route('apartment.create')}}">Aggiungi Appartamento</a>

    <ul>

        @foreach ($apartments as $apartment)

        <h2>
            <a href="{{ route('apartment.show', $apartment->id) }}"> {{ $apartment->title }}</a>
        </h2>
        <div>{{ $apartment -> user -> name}}</div>
        <img src="{{$apartment -> picture}}" alt="">
        @endforeach

    </ul>

</div>

<div class="content">

</div>
@endsection
