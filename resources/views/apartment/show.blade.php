@extends('layouts.app')
@section('content')

    <h2 class="text-center my-3">{{ $apartment->title }}</h2>

    <div class="comic d-flex">

        <div class="thumb">

            <img src="{{ $apartment->picture }}" alt="l'immagine non è presente">

        </div>

        <div class="description">

            <h5>Description:</h5>
            <p>Stanze:{{ $apartment->rooms }}</p>

            <div>Letti: {{ $apartment->beds }}</div>

            <div> Bagni:{{ $apartment->bathrooms }}</div>

            <div>Metri quadri:{{ $apartment->square_meters }}</div>

            <div>prezzo: {{ $apartment->price }}</div>

            <div>visibile: {{ $apartment->visible }}</div>

            {{-- amenities stampa show --}}
            <ul>

                @foreach ($apartment->amenities as $amenity)
                    <li class="text-info">{{ $amenity->title }}</li>
                @endforeach

            </ul>

        </div>
    @endsection
