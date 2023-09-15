@extends('layouts.app')
@section('content')

<div class="container-fluid">

    @foreach ($users as $user)

        @if ($user->id === Auth::user()->id)
            <div class="border-white p-3 m-auto flex-row">
                @foreach ($user->apartments as $apartment)

                    {{-- CARD APPARTAMENTO + MESSAGGIO --}}
                        <div class="card p-3 mb-3 d-flex flex-row">

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
                                                <a href="mailto:{{$message->sender_email}}">{{$message->sender_email}}</a>
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

@endsection
