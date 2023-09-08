@extends('layouts.app')
@section('content')

<div class="container border border-primary rounded bg-primary d-flex flex-wrap">

    @foreach ($apartments as $apartment)
    
    <div class="card border border-primary m-2 p-2 bg-primary-subtle text-center align-items-center mx-auto my-3"    style="width:400px; height:500px;">           
            {{-- titolo appartamento --}}
            <h5 class="text-uppercase mt-3 mb-4" style="display:inline-block">
                <a class="
                text-decoration-none border border-black p-2 rounded"
                style="color: rgb(0, 0, 0)"
                href="{{ route('apartment.show', $apartment->id) }}"> {{ $apartment->title }}</a>
            </h5>

            {{-- immagine --}}
            <div class="img rounded" style="width: 350px; height: 350px ">
                <img class="rounded" src="{{$apartment -> picture}}" alt="" style="max-width: 100%;">
            </div>

            {{-- dati appartamento --}}
            <ul class="list-unstyled">
                <li> {{ $apartment->city }}</li> 
                <li> {{ $apartment->address }}</li>               
                <li> 
                    <h5 class="fw-bolder"> Prezzo:  {{ $apartment->price }}</h5>
                </li>
            </ul>
          
        </div>
    @endforeach




</div>

<div class="content">

</div>
@endsection
