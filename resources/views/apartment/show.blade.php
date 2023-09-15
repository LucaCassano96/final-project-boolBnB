@extends('layouts.app')
@section('content')

<div class="container-fluid" style="background-color: #2d3047; height:100vh">

    {{-- Messaggio conferma invio messaggio --}}
    @if (session('success'))


        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
    @endif

        {{-- Bottoni edit/delete solo se loggato e proprietario --}}
        @auth
            @if (Auth::user()->id == $apartment->user_id)
            {{-- Buttons --}}
            <div class="d-flex justify-content-end p-4">

                {{-- Edit Appartamento --}}
                <a class="btn btn-primary mx-4" style="border: 2px solid #e0a458;" href="{{route('apartment.edit', $apartment -> id)}}">Modifica Appartamento</a>
                {{-- Messaggio conferma edit --}}
                @if (session('edit'))
                    <div class="alert alert-success">
                        {{ session('edit') }}
                    </div>
                @endif

                {{-- Delete Appartamento --}}
                <form action="{{route('apartment.delete', $apartment -> id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" style="border: 2px solid #e0a458;" type="submit">
                        Elimina Appartamento
                    </button>
                </form>
            </div>
            @endif
        @endauth


    <div class="apartment m-3 text-light d-flex rounded justify-content-center align-items-center" style="background-color: #5c80bc; border: 3px solid #e0a458;">

        {{-- CARD LEFT --}}
        <div class="card-left m-3 p-2">

            {{-- titolo appartamento --}}
            <h2 class="text-uppercase" >
                {{ $apartment->title }}
            </h2>

            {{-- indirizzo appartamento --}}
            <div class="mb-3">
                {{$apartment->address}}
            </div>

             {{-- immagine --}}
             <div class="img rounded" style="width: 350px;">
                <img class="rounded" src="{{
                    asset(
                        $apartment->picture
                        ? 'storage/' . $apartment->picture
                        : 'storage/images/apartment.jpg')

                    }}" alt="" style="width: 100%; border: 3px solid #e0a458;">
            </div>

        </div>

        {{-- CARD RIGHT --}}
        <div class="card-center m-3 p-2">

            {{-- descrizione appartamento --}}
            <div class="rounded p-2 m-2" style="border: 2px solid #e0a458;">
                {{ $apartment->description }}
            </div>

            {{-- dati appartamento --}}
            <ul>
                <li> Stanze: {{ $apartment->rooms }}</li>
                <li> Letti: {{ $apartment->beds }}</li>
                <li> Bagni: {{ $apartment->bathrooms }}</li>
                <li>Superficie: {{ $apartment->square_meters }} m<sup>2</sup></li>
            </ul>

            {{-- prezzo appartamento --}}
            <div class="fw-bold text-center rounded p-2" style="border: 2px solid #e0a458;">
                Prezzo: {{ $apartment->price }}€
            </div>
        </div>

        {{-- amenities stampa show --}}
        <div class="card-right m-3 p-2">
            <h3>SERVIZI</h3>
            <ul>
                @foreach ($apartment->amenities as $amenity)
                    <li class="">{{ $amenity->title }}</li>
                @endforeach
            </ul>
        </div>

        {{-- bottone invio messaggio --}}
        <a class="btn btn-primary" role="button" href="{{route('messagePage', $apartment -> id)}}">Invia messaggio</a>


    @endsection

    <script>
        // AL CLICK DEL TASTO INVIO MESSAGGIO

    </script>
