@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="background-color: #2d3047; height:100vh">
        {{-- <h2 class="fs-4 text-secondary my-4 text-white">
            {{ __('Dashboard') }}
        </h2> --}}
        <div class="row justify-content-center">
            <div class="col">
                <div class="card m-5 p-3 border-white border border-3 rounded" style="background-color: #5c80bc">
                    {{-- <div class="card-header">{{ __('User Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div> --}}


                    @if (Auth::check())

                    @foreach ($users as $user)
                        @if ($user->id === Auth::user()->id)

                        <div class="text-end m-3 d-flex justify-content-between">
                                <h2 class="text-white mt-3" style="display:inline">I tuoi appartamenti</h2>
                                <a class="border-white border border-3 p-2 text-white rounded-pill text-decoration-none d-flex align-items-center hover-black" style="background-color: #419d78;" href="{{ route('apartment.create') }}">Aggiungi Appartamento</a>
                        </div>

                        {{-- CARD APPARTAMENTO --}}
                        <div class="apartment border-white border border-3 rounded p-3 m-auto d-flex" style="background-color: #2d3047; flex-direction:row;">

                            @foreach ($user->apartments as $apartment)

                            <div class="card border m-3 p-2" style="background-color: #e0a458; max-width:300px">
                                <h3 class="text-uppercase fst-italic">
                                    <a href="{{ route('apartment.show', $apartment->id) }}" class="text-black text-decoration-none">{{ $apartment->title }}</a>
                                </h3>

                                <span>
                                    Prezzo Appartamento: {{ $apartment->price }}€
                                </span>

                                <div class="picture mt-3" style="max-width:275px; height:200px">
                                    <img class="rounded" style="max-width: 100%" src="{{asset('storage/' . $apartment -> picture) }}" alt="{{ $apartment->title }}">
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
@endsection
