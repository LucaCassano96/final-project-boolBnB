@extends('layouts.app')
@section('content')

<div class="container" style="background-color: #2d3047">

    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <div class="card p-4 mt-4 rounded-4">
                <h1 class="my-5 text-center" style="color:#2d3047">Trova la tua prossima destinazione!</h1>
                <div class="">
                    <div class="search my-5 d-flex justify-content-center" style="width: 100%;">
                        <input type="text" class="col col-md-10 search-input p-3 mx-0 rounded-start-2 border border-3" placeholder="Cerca qui..." name="">
                        <a href="#" class="d-inline-block rounded-end-2 border border-3 border-start-0 p-3 mx-0" style="color: #e0a458; font-size: 25px;">
                            <i class="bi bi-search"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row mt-4">
        @foreach ($apartments as $apartment)
            <div class="col-md-6 col-lg-4 col-xl-3 p-3">
                <div class="card border text-center p-0" style="min-height:400px; background-color:#5c7fbc32; border-color:#fffdeb">

                    {{-- Card Header --}}
                    <div class="card-header p-2" style="border-color: #fffdeb;">
                        <h5 class="text-uppercase m-0">
                            <a class="d-inline-block
                            text-decoration-none border p-2 rounded my-3"
                            style="color: #fffdeb; border-color: #fffdeb;"
                            href="{{ route('apartment.show', $apartment->id) }}"> {{ $apartment->title }}</a>
                        </h5>
                    </div>

                    {{-- Card Body --}}
                    <div class="card-body p-4">
                        {{-- immagine --}}
                        <div class="img rounded" style="width: 100%;">
                            <img class="rounded" src="{{
                                asset(
                                    $apartment->picture
                                    ? 'storage/' . $apartment->picture
                                    : 'storage/images/apartment.jpg')
                                }}" alt="" style="width: 100%; border: 2px solid #e0a458;">
                        </div>
                        {{-- dati appartamento --}}
                        <div class="my-4">
                            <ul class="list-unstyled" style="color: #fffdeb">
                                <li> {{ $apartment->address }}</li>
                                <li class="p-0 mt-5">
                                    <span class="p-0 mt-5" style="font-size: 30px; font-weight:800;">{{ $apartment->price }} € </span><span><small>/ notte</small></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
