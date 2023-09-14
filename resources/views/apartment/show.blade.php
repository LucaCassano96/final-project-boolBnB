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
        <a href="{{route('messagePage', $apartment -> id)}}">Invia messaggio</a>
        <!-- bottone messaggio -->
        <!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Invia messaggio
  </button>

  <!-- Modale Bootstrap Invio Messaggio -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-black" id="exampleModalLabel">Messaggio</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            {{-- FORM INVIO MESSAGGIO --}}
            {{-- <form class="text-black" id="messageForm" action="{{ route('send.message', $apartment->id) }}" method="POST">
                @csrf

                {{-- name --}}
                {{-- <label for="name">Inserisci qui il tuo nome:</label>
                <br>
                <input type="text" name="name" id="sender_name" value=@auth
                    {{Auth::user()->name}}
                @endauth>
                <br> --}}

                {{-- email --}}
                {{-- <label for="email">Inserisci qui la tua mail:</label>
                <br>
                <input type="email" name="email" id="sender_email " value=@auth
                    {{Auth::user()->email}}
                @endauth>
                <br> --}}

                {{-- Contenuto --}}
                {{-- <label for="testo-messaggio">Inserisci qui il tuo messaggio:</label>
                <br>
                <textarea name="testo-messaggio" id="">
                </textarea>
            </form>

        </div> --}}

        {{-- BOTTONI INVIO MESSAGGIO --}}
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
          <button type="submit" id="showMessageForm" class="btn btn-primary">Invia</button>
        </div>

      </div>

    </div>

  </div>


</div> --}}

    @endsection

    <script>
        // AL CLICK DEL TASTO INVIO MESSAGGIO

    </script>
