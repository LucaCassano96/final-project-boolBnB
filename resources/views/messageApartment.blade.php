@extends('layouts.app')
@section('content')

@foreach ($users as $user)
    @if ($user->id === Auth::user()->id)



        {{-- CARD APPARTAMENTO --}}
        <div class="apartment border-white p-3 m-auto d-flex" style="flex-direction:row;">

            @foreach ($user->apartments as $apartment)

            <div class="card border m-3 p-2" style="background-color: #e0a458; max-width:300px">
                <h3 class="text-uppercase fst-italic">
                    <a href="{{ route('apartment.show', $apartment->id) }}" class="text-black text-decoration-none">{{ $apartment->title }}</a>
                </h3>

                <span>
                    Prezzo: {{ $apartment->price }}€ / notte
                </span>

                <div class="picture mt-3" style="max-width:275px; height:200px">
                    <img class="rounded" style="max-width: 100%" src="{{asset('storage/' . $apartment -> picture) }}" alt="{{ $apartment->title }}">
                </div>
            </div>

        @endforeach
    </div>
@endif
@endforeach

@endsection
