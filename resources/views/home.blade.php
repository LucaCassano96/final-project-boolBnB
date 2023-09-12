@extends('layouts.app')
@section('content')

<div class="container rounded d-flex flex-wrap" style="background-color: #2d3047">

    @foreach ($apartments as $apartment)

    <div class="card border my-3  text-center align-items-center mx-auto my-3"    style="width:400px; height:500px; background-color:#2d3047; border-color:#fffdeb">
            {{-- titolo appartamento --}}
            <h5 class="text-uppercase mt-3 mb-4" style="display:inline-block">
                <a class="
                text-decoration-none border p-2 rounded"
                style="color: #fffdeb; border-color: #fffdeb;"
                href="{{ route('apartment.show', $apartment->id) }}"> {{ $apartment->title }}</a>
            </h5>

            {{-- immagine --}}


            <div class="img rounded" style="width: 350px;">
                <img class="rounded" src="{{asset('storage/' . $apartment -> picture)  }}" alt="" style="width: 100%; border: 3px solid #e0a458;">
            </div>




            {{-- dati appartamento --}}
            <ul class="list-unstyled" style="color: #fffdeb">
                <li> {{ $apartment->city }}</li>
                <li> {{ $apartment->address }}</li>
                <li>
                    <span class="p-0 my-5" style="font-size: 30px; font-weight:800;">{{ $apartment->price }} € </span><span><small>/ notte</small></span>
                </li>
            </ul>

        </div>
    @endforeach




</div>

<div class="content">

</div>
@endsection
