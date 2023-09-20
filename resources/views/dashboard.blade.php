@extends('layouts.app')

@section('content')
<div class="container" style="background-color: #2d3047;">

    <div class="row justify-content-center">
        <div class="col">
            <div class="card rounded" style="background-color: #5c80bc">

                {{-- Messaggio conferma invio messaggio --}}
                @if (session('success'))
                    <div id="paymentConfirm" class="alert alert-success alert-dismissible fade show" role="alert" style="position:absolute; top: 10%; left: 50%; transform: translate(-50%, -50%);">
                        <strong>{{ session('success') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (Auth::check())

                    @foreach ($users as $user)
                        @if ($user->id === Auth::user()->id)

                            <div class="card-header">
                                <div class="container">
                                    <div class="row justify-content-center align-items-center p-2">
                                        <div class="col col-lg-7">
                                            <h2 class="text-white my-apartment">I tuoi appartamenti</h2>
                                        </div>

                                        {{-- Icone --}}
                                        <div class="col-md-4">
                                            <div class="d-flex justify-content-around align-items-center">
                                                {{-- Messaggi --}}
                                                <a href="{{ route('messageApartment')}}" class="add-apartment">
                                                    <i class="bi bi-envelope"></i>
                                                </a>
                                                {{-- Statistiche --}}
                                                {{-- <a class="add-apartment d-flex justify-content-center align-items-center text-decoration-none" href="{{ route('statistics') }}">
                                                    <i class="bi bi-graph-up"></i>
                                                </a> --}}
                                                {{-- Aggiungi --}}
                                                <a class="add-apartment d-flex justify-content-center align-items-center text-decoration-none" href="{{ route('apartment.create') }}">
                                                    <i class="bi bi-plus-circle" style="font-size: 50px;"></i>
                                                </a>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- SEZIONE APPARTAMENTI --}}
                            <div class="card-body border-white d-flex row">

                                @foreach ($user->apartments as $apartment)
                                    {{-- Card APPARTAMENTO --}}
                                    <div class="col-md-6 col-lg-4 col-xl-2 p-3 d-flex align-items-end">
                                        <div class="card border text-center p-0" style="min-height:430px; background-color:#2d3047; border-color:#fffdeb">

                                            {{-- Card Body --}}
                                            <div class="card-body p-2">
                                                {{-- immagine --}}
                                                <div class="rounded mb-2" style="width:100%; aspect-ratio: 1 / 1; border: 2px solid #e0a458;">
                                                    <img class="rounded" loading="lazy" src="{{
                                                        asset(
                                                            $apartment->picture
                                                            ? 'storage/' . $apartment->picture
                                                            : 'storage/images/apartment.jpg')
                                                        }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                                                </div>

                                                {{-- dati appartamento --}}
                                                <div class="my-2" style="color: #fffdeb">
                                                    {{-- titolo --}}
                                                    <h6 class="text-uppercase m-0">
                                                        <a class="d-flex justify-content-center align-items-center
                                                        text-decoration-none border p-2 rounded"
                                                        style="height:60px; color: #fffdeb; border-color: #fffdeb; width: 100% overflow:ellipsis;"
                                                        href="{{ route('apartment.show', $apartment->id) }}"> {{ $apartment->title }}</a>
                                                    </h6>
                                                    {{-- indirizzo --}}
                                                    <div class="d-flex justify-content-center align-items-center p-1 my-2" style="height:60px; overflow:hidden;">
                                                        <span style="text-overflow:'(...)';">{{ $apartment->address }}</span>
                                                    </div>

                                                </div>
                                                <div class="my-2 text-white">
                                                    Prezzo: {{ $apartment->price }}€ / notte
                                                </div>
                                            </div>
                                            <div class="card-footer">

                                                @if ($apartment->sponsor->isNotEmpty())
                                                    @foreach ($apartment->sponsor as $sponsor)
                                                    @if ($sponsor->pivot->end_date > now())
                                                        <div class="text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 py-1">
                                                            Sponsorizzato
                                                        </div>
                                                    @else
                                                        <a href="{{ route('sponsor-form', $apartment->id) }}" class="py-1 btn btn-secondary">Sponsorizza</a>
                                                    @endif

                                                    @endforeach
                                                @else
                                                    <a href="{{ route('sponsor-form', $apartment->id) }}" class="py-1 btn btn-secondary">Sponsorizza</a>
                                                @endif






                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @endif

            </div>
        </div>
    </div>

</div>
<script>
    const paymentConfirm = document.getElementById('paymentConfirm');
let opacity = 1;
let fadeOutInterval = 20;
let fadeOutDuration = 3500;

function fadeOut() {
    if (opacity > 0) {
        opacity -= 0.01;
        paymentConfirm.style.opacity = opacity;
        setTimeout(fadeOut, fadeOutInterval);
    } else {
        paymentConfirm.style.display = 'none';
    }
}

setTimeout(fadeOut, fadeOutDuration);

</script>
@endsection
