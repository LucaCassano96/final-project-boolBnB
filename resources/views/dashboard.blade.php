@extends('layouts.app')

@section('content')
<div class="container-fluid" style="background-color: #2d3047;">

    <div class="row justify-content-center">
        <div class="col">
            <div class="card m-5 bordo-gradient rounded" style="background-color: #5c80bc">

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
                                                <a href="{{ route('messageApartment')}}" class="add-apartment">
                                                    <i class="bi bi-envelope"></i>
                                                </a>
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
                                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 p-3">
                                        <div class="card border text-center" style="background-color: #e0a458;">
                                            <div class="card-header d-flex align-items-center justify-content-center" style="min-height: 70px">
                                                <h5 class="text-uppercase fst-italic m-0">
                                                    <a href="{{ route('apartment.show', $apartment->id) }}" class="text-black text-decoration-none">{{ $apartment->title }}</a>
                                                </h5>
                                            </div>

                                            <div class="card-body p-2">
                                                {{-- immagine --}}
                                                <div class="rounded" style="width:100%; aspect-ratio: 16 / 10;">
                                                    <img class="rounded" src="{{asset('storage/' . $apartment -> picture) }}" alt="{{ $apartment->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                </div>
                                                <div class="my-2">
                                                    Prezzo: {{ $apartment->price }}€ / notte
                                                </div>
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
@endsection
