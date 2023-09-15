@extends('layouts.app')
@section('content')

<div class="container" style="background-color: #2d3047;">

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
            <div class="d-flex justify-content-end py-3">

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


    <div class="mt-2 text-light p-3 pt-0" style="background-color: #5c80bc; border: 3px solid #e0a458;">

        <div class="send-button d-flex justify-content-end pt-3">
            <a class="btn text-white" style="background-color: #2d3047" role="button" href="{{route('messagePage', $apartment -> id)}}">Invia messaggio</a>
        </div>

        <div class="row rounded">
            {{-- CARD LEFT --}}
            <div class="col col-md-4 p-3">

                {{-- titolo appartamento --}}
                <h3 class="text-uppercase" style="color: #2d3047">
                    {{ $apartment->title }}
                </h3>

                {{-- indirizzo appartamento --}}
                <div class="mb-3">
                    {{$apartment->address}}
                </div>

                {{-- immagine --}}
                <div class="rounded" style="width:100%; aspect-ratio: 16 / 10;">
                    <img class="rounded" src="{{
                        asset(
                            $apartment->picture
                            ? 'storage/' . $apartment->picture
                            : 'storage/images/apartment.jpg')

                        }}" alt="{{ $apartment->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>

            {{-- CARD CENTER --}}
            <div class="col-12 col-md-4 p-3 border-2 border-start border-end">

                {{-- descrizione appartamento --}}
                <div class="rounded p-2 mb-2" style="border: 2px solid #e0a458; background-color:#2d3047">
                    {{ $apartment->description }}
                </div>

                {{-- dati appartamento --}}
                <ul class="p-3">
                    <li> Stanze: {{ $apartment->rooms }}</li>
                    <li> Letti: {{ $apartment->beds }}</li>
                    <li> Bagni: {{ $apartment->bathrooms }}</li>
                    <li>Superficie: {{ $apartment->square_meters }} m<sup>2</sup></li>
                </ul>

                {{-- prezzo appartamento --}}
                <div class="fw-bold text-center rounded p-2 mb-5" style="border: 2px solid #e0a458; background-color:#2d3047">
                    Prezzo: {{ $apartment->price }}€
                </div>
            </div>

            {{-- CARD RIGHT --}}
            <div class="col col-md-4 p-3">
                <h3>SERVIZI</h3>
                <ul class="p-3">
                    @foreach ($apartment->amenities as $amenity)
                        <li class="">{{ $amenity->title }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

    @endsection

