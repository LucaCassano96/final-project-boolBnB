@extends('layouts.app')
@section('content')

<div class="container-fluid">

    @foreach ($users as $user)

        @if ($user->id === Auth::user()->id)
    
            {{-- CARD APPARTAMENTO --}}
            <div class="apartment border-white p-3 m-auto flex-row">
                    
                @foreach ($messages as $message)
                    <div class="card p-3 mb-3 d-flex flex-row">
                        <div class="p-2 rounded" style="background-color: #e0a458; max-width:200px">
                            <h4 class="text-uppercase fst-italic inline">
                                <a href="{{ route('apartment.show', $message->apartment_id) }}" class="text-black text-decoration-none">{{$message->apartment->title}}</a>
                            </h4>
                            <span class="d-block">
                                 Prezzo: {{$message->apartment->price}}€ / notte
                            </span>
                            {{-- <div class="picture mt-3" style="max-width:275px; height:200px">
                                <img class="rounded" style="max-width: 100%" src="{{asset('storage/' . $message->apartment->picture) }}" alt="{{ $message->apartment->title }}">
                            </div> --}}
                        </div>
                        
                        <div class="p-2 d-flex justify-content-between" style="width: 80%">
                            <div class="text">
                                
                                <div class="dati-mittente d-flex">
                                    <div class="mb-3 px-3">
                                        <span class="d-block fw-bold">Email Mittente</span>
                                        {{$message->sender_email}}
                                    </div>
                                    <div class="mb-3 px-3">
                                        <span class="d-block fw-bold">Dati Mittente</span>
                                        {{$message->sender_name}} {{$message->sender_surname}}
                                    </div>
                                </div>
                                <div class="mb-3 px-3">
                                    <p class="d-inline-flex gap-1">
                                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                          Messaggio
                                        </button>
                                      </p>
                                      <div class="collapse" id="collapseExample">
                                        <div class="card card-body">
                                          Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
                                        </div>
                                      </div>
                                      <a href="" type="button" class="btn btn-primary">Rispondi</a>
                                </div>                           
                            </div>
                            
                        </div>                           
                                        
                    </div>
                    
                @endforeach
                
            </div>
        @endif
        @endforeach
    </div>

@endsection
