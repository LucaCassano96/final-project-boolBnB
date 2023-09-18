@extends('layouts.app')
@section('content')

<div class="container-fluid p-5"  style="background-color: #2d3047;">
    <div class="card m-5 mb-0 rounded" style="background-color: #5c80bc">

        {{-- SEZIONE CARD-HEADER --}}
        <div class="card-header">
            <div class="container">
                <div class="row justify-content-center align-items-center p-2">
                    <div class="col col-lg-7">
                        <h2 class="text-white my-apartment">I tuoi messaggi</h2>
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

        @foreach ($users as $user)

            @if ($user->id === Auth::user()->id)
                <div class=" p-3  flex-row">
                    @foreach ($user->apartments as $apartment)

                        {{-- CARD APPARTAMENTO + MESSAGGIO --}}
                            <div class="card card-messaggio p-3 mb-3 d-flex flex-row">

                                {{-- APPARTMENTO --}}
                                <div class="p-2 rounded" style="background-color: #e0a458; max-width:200px">
                                    <h5 class="text-uppercase fst-italic inline">
                                        <a href="{{ route('apartment.show', $apartment->id) }}" class="text-black text-decoration-none">{{$apartment->title}}</a>
                                    </h5>
                                    <span class="d-block">
                                        Prezzo: {{$apartment->price}}€ / notte
                                    </span>
                                    <div class="rounded" style="width:100%; aspect-ratio: 16 / 10;">
                                        <img class="rounded" src="{{asset('storage/' . $apartment -> picture) }}" alt="{{ $apartment->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                </div>

                                @foreach ($apartment->messages as $message)
                                    {{-- MESSAGGIO --}}
                                    <div class="p-2 d-flex justify-content-between" style="width: 80%">
                                        <div class="text">

                                            <div class="dati-mittente d-flex">
                                                <div class="mb-3 px-3">
                                                    <span  class="d-block fw-bold">Email Mittente</span>
                                                    <a class="inviatore" href="mailto:{{$message->sender_email}}">{{$message->sender_email}}</a>
                                                </div>
                                                <div class="mb-3 px-3">
                                                    <span class="d-block fw-bold">Dati Mittente</span>
                                                    {{$message->sender_name}} {{$message->sender_surname}}
                                                </div>
                                            </div>
                                            <div class="mb-3 px-3 d-flex" >
                                                <p class="d-inline-flex gap-1 mx-2">
                                                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{$message->id}}" aria-expanded="false" aria-controls="collapse" style="height: 40px">
                                                    Messaggio
                                                    </button>
                                                </p>
                                                <div class="collapse" id="collapse-{{$message->id}}">
                                                    <div class="card card-body overflow-auto">
                                                    {{$message->content}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>


                    @endforeach
                </div>
            @endif

        @endforeach

    </div>
</div>

@endsection
