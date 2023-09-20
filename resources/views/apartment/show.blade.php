@extends('layouts.app')
@section('content')

    <div class="container pb-5" style="background-color: #2d3047;" style="position:relative">

        {{-- Messaggio conferma invio messaggio --}}
        @if (session('success'))
            <div id="div_message" class="alert alert-success alert-dismissible fade show" role="alert" style="position:absolute; top: 10%; left: 50%; transform: translate(-50%, -50%);">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Bottoni edit/delete solo se loggato e proprietario --}}
        @auth
            @if (Auth::user()->id == $apartment->user_id)
                {{-- Buttons --}}
                <div class="d-flex justify-content-end py-3">

                    {{-- Delete Appartamento --}}
                    <form action="{{ route('apartment.delete', $apartment->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="button" class="btn btn-danger" style="border: 2px solid #e0a458;"data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Elimina appartamento
                        </button>

                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Vuoi eliminare
                                            definitivamente l'appartamento?</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                                        <button class="btn btn-danger" type="submit">
                                            Elimina appartamento
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    {{-- Edit Appartamento --}}
                    <a class="btn btn-primary mx-4" style="border: 2px solid #e0a458;"
                        href="{{ route('apartment.edit', $apartment->id) }}">Modifica Appartamento</a>
                    {{-- Messaggio conferma edit --}}
                    @if (session('edit'))
                        <div class="alert alert-success">
                            {{ session('edit') }}
                        </div>
                    @endif

                </div>
            @endif
        @endauth


        <div class="mt-2 text-light p-3 pt-0" style="background-color: #5c80bc; border: 3px solid #e0a458;">

            {{-- se sei proprietario dell'appartamento visualizzi i diversi bottoni --}}
            @auth
                @if (Auth::user()->id == $apartment->user_id)
                    <div class="container-button col-12 d-flex justify-content-end">
                        <div class="row d-flex justify-content-end mb-3 col-xs-12 col-6">
                            <div class="col px-3 d-flex justify-content-center">

                                @foreach ($apartment->sponsor as $sponsor)
                                    {{-- se l'appartamento è gia sponsorizzato --}}
                                @if ($sponsor->pivot->end_date > now())
                                    <div class="text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-2 send-button d-flex align-items-center mt-3 px-3 py-1">
                                        Sponsorizzato
                                    </div>
                                {{-- se l'appartamento non è sponzorizzato --}}
                                @else
                                    <div class="text-primary-emphasis rounded-3 d-flex align-items-center mt-3 px-2">
                                        <a href="{{ route('sponsor-form', $apartment->id) }}" class="py-1 btn" style="background-color: #e0a458;">Sponsorizza</a>
                                    </div>
                                @endif
                                @endforeach

                            </div>

                            {{-- link/button appartamenti --}}
                            <div class="col px-3 d-flex justify-content-center">
                                <div class="send-button pt-3">
                                    <a class="btn text-white" style="background-color: #2d3047" role="button"
                                        href="{{ route('dashboard') }}">I tuoi appartamenti</a>
                                </div>
                            </div>

                            {{-- link/button i tuoi messaggi --}}
                            <div class="col px-3 d-flex justify-content-center">
                                <div class="send-button pt-3">
                                    <a class="btn text-white px-2" style="background-color: #2d3047" role="button"
                                        href="{{ route('messageApartment') }}"><i class="bi bi-envelope mx-1"></i> I tuoi messaggi</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- se non sei proprietare dell'appartamento ma sei loggato --}}
                @else
                    <div class="send-button d-flex pt-3">
                        <a class="btn text-white" style="background-color: #2d3047" role="button"
                            href="{{ route('messagePage', $apartment->id) }}">Invia messaggio</a>
                    </div>
                @endif

            @endauth

            {{-- se non sei loggato --}}
            @guest
                <div class="send-button d-flex justify-content-end pt-3">
                    <a class="btn text-white" style="background-color: #2d3047" role="button"
                        href="{{ route('messagePage', $apartment->id) }}">Invia messaggio</a>
                </div>
            @endguest


                {{-- IMMAGINE E DESCRIZIONE --}}
            <div class="row">
                {{-- TITOLO - IMMAGINE --}}
                <div class="col-12 p-3 mb-3 text-center">

                    {{-- titolo appartamento --}}
                    <h1 class="text-uppercase" style="color: #2d3047">
                        {{ $apartment->title }}
                    </h1>

                    {{-- indirizzo appartamento --}}
                    <div class="mb-3 fw-bold" style="color: #2d3047">
                        {{ $apartment->address }}
                    </div>

                    {{-- immagine --}}
                    <div class="rounded" style="max-width:800px; margin:auto">
                        <img class="rounded"
                            src="{{ asset($apartment->picture ? 'storage/' . $apartment->picture : 'storage/images/apartment.jpg') }}"
                            alt="{{ $apartment->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>

            </div>
            {{-- prezzo appartamento --}}
            <div class="row justify-content-center">
                <div class="fw-bold col-6 text-center rounded p-2 mt-3"
                    style="border: 2px solid #e0a458; background-color:#2d3047">
                    Prezzo: {{ $apartment->price }}€
                </div>
            </div>
            {{-- DESCRIZIONE - PREZZO --}}
            <div class="row mt-3">
                <div class="col-12 col-lg-6 p-3 border-2">

                    {{-- descrizione appartamento --}}
                    <div class="rounded p-3" style="border:2px solid #e0a458; background-color:#2d3047; max-height:400px; overflow:auto;">
                        <h5>
                            DESCRIZIONE APPARTAMENTO
                        </h5>
                        {{ $apartment->description }}
                    </div>

                </div>

                {{-- DATI - AMENITY --}}
                <div class="col-12 col-lg-6 p-3">
                    <div class="d-flex p-3 rounded justify-content-center" style="border: 2px solid #e0a458; background-color:#2d3047">
                        {{-- dati appartamento --}}
                        <div class="p-3">
                            <h3>STRUTTURA</h3>
                            <ul class="p-3">
                                <li> Stanze: {{ $apartment->rooms }}</li>
                                <li> Letti: {{ $apartment->beds }}</li>
                                <li> Bagni: {{ $apartment->bathrooms }}</li>
                                <li>Superficie: {{ $apartment->square_meters }} m<sup>2</sup></li>
                            </ul>
                        </div>

                        {{-- amenity --}}
                        <div class="p-3">
                            <h3>SERVIZI</h3>
                            <ul class="p-3">
                                @foreach ($apartment->amenities as $amenity)
                                    <li class="">{{ $amenity->title }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            {{-- VISIBLE --}}
            <div class="row justify-content-center justify-content-lg-start">
                <div class="col-12 col-lg-6 mt-2">
                    {{-- se sei proprietario dell'appartamento visualizzi il messaggio --}}
                        @auth
                            @if (Auth::user()->id == $apartment->user_id)
                                @if ($apartment->visible === 1)
                                <div class="text-uppercase text-center" style="color: #2d3047">
                                    <h4>
                                        Il tuo appartamento è visibile <i class="bi bi-eye"></i>
                                    </h4>
                                </div>
                                @else
                                <div class="text-uppercase text-center" style="color: #2d3047">
                                <h4>
                                    Il tuo appartamento non è visibile <i class="bi bi-eye-slash"></i>
                                </h4>
                                </div>
                                @endif
                            @endif
                        @endauth
                </div>
            </div>




<script>

const divMessage = document.getElementById('div_message');
let opacity = 1;
let fadeOutInterval = 20;
let fadeOutDuration = 3500;

function fadeOut() {
    if (opacity > 0) {
        opacity -= 0.01;
        divMessage.style.opacity = opacity;
        setTimeout(fadeOut, fadeOutInterval);
    } else {
        divMessage.style.display = 'none';
    }
}

setTimeout(fadeOut, fadeOutDuration);

</script>
@endsection
