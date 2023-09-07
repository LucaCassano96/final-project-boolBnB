@extends('layouts.app')
@section('content')

<h1>ciao</h1>


<div class="container">

    <h2>New Comic</h2>

    <form class="d-flex flex-column text-center"
    method="POST"
    action="{{route("apartment.store")}}"
    enctype="multipart/form-data">


        @csrf

        <label for="user_id">User ID</label>
        <input type="number" name="user_id">

        <label for="title">Nome appartamento</label>
        <input type="text" name="title">

        <label for="description">descrizione appartamento</label>
        <textarea name="description" cols="30" rows="10"></textarea>

        <label for="rooms">Numero di stanze</label>
        <input type="number" name="rooms">

        <label for="beds">Numero di letti</label>
        <input type="number" name="beds">

        <label for="bathrooms">Numero di bagni</label>
        <input type="number" name="bathrooms">

        <label for="square_meters">Metri quadrati appartamento</label>
        <input type="number" name="square_meters">

        <label for="picture">Foto appartamento</label>
        <input type="text" name="picture">

        <label for="price">Prezzo appartamento</label>
        <input type="number" name="price">

        {{-- Location --}}

      {{--   <label for="{{$location->country}}">Paese</label>
        <input type="text" name="{{$location->country}}">

        <label for="{{$location->city}}">Città</label>
        <input type="text" name="{{$location->city}}">

        <label for="{{$location->address}}">Indirizzo</label>
        <input type="text" name="{{$location->address}}"> --}}

        {{-- Amenities checkbox --}}

        @foreach ($amenities as $amenity)
            <div class="border-bottom p-2 text-start">
                <input class="form-check-input" type="checkbox" value="{{ $amenity->id }}"
                    name="amenities[]" id="{{ $amenity->id }}">
                <label class="form-check-label" for="{{ $amenity->id }}">
                    {{ $amenity->title }}
                    <img src="{{$amenity->icon}}" alt="icon">
                </label>
            </div>
            <br>
        @endforeach

        <label for="visible">Visibile</label>
        <input type="checkbox" name="visible">

        <input class="send" type="submit" value="Create">

    </form>

</div>


@endsection
