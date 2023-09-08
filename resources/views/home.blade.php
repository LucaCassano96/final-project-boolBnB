@extends('layouts.app')
@section('content')

<div class="container border border-primary rounded bg-primary">

    <div class="text-end m-3">
        <a class="btn btn-primary border-white" href="{{route('apartment.create')}}">Aggiungi Appartamento</a>
    </div>

    @foreach ($apartments as $apartment)
        {{-- titolo appartamento --}}
        <h2 class="text-uppercase mt-5 m-3" >
            <a class="
            text-decoration-none border border-white p-2 rounded"
            style="color: rgb(255, 255, 255)"
            href="{{ route('apartment.show', $apartment->id) }}"> {{ $apartment->title }}</a>
        </h2>

        <div class="card border border-primary m-3 p-2 flex-row bg-primary-subtle">


            {{-- CARD LEFT --}}
            <div class="card-left p-2">

                {{-- immagine --}}
                <div class="img rounded" style="width: 350px; height: 350px ">
                    <img class="rounded" src="{{$apartment -> picture}}" alt="" style="max-width: 100%;">
                </div>

            </div>

            {{-- CARD RIGHT --}}
            <div class="card-right p-2">

                {{-- nome proprietario --}}
                <h3>{{ $apartment -> user -> name}}</h3>

                {{-- descrizione appartamento --}}
                <div class="border border-black rounded p-2 m-2">
                    <a class="text-decoration-none " style="color: black" href="{{ route('apartment.show', $apartment->id) }}"> {{ $apartment->description }}</a>
                </div>

                {{-- dati appartamento --}}
                <ul>
                    <li> Numero di Stanze:  {{ $apartment->rooms }}</li>
                    <li> Numero di Letti:  {{ $apartment->beds }}</li>
                    <li> Numero di Bagni:  {{ $apartment->bathrooms }}</li>
                    <li> Metri Quadrati:  {{ $apartment->square_meters }}</li>
                    <li> prezzo:  {{ $apartment->price }}</li>
                </ul>
            </div>
        </div>
    @endforeach




</div>

<div class="content">

</div>
@endsection
