@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="row d-flex justify-content-center ">

            @if ($errors->any())
                <div class="alert alert-danger" style="margin-top: 120px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <div class="col-11 col-md-8 col-xl-5 border border-primary p-3 shadow-sm p-3 mb-5 bg-body-tertiary rounded"
                style="margin: 150px">

                <h2 class="my-4">Modifica appartamento</h2>

                <form method="POST" action="{{ route('apartment.update', $apartment->id) }}">

                    @csrf
                    @method('PUT')

                    <div class="form-floating mb-3">
                        <input value="{{$apartment->title}}" type="text" class="form-control" name="title" placeholder="nome appartamento">
                        <label for="floatingInput">Nome appartamento</label>
                    </div>

                    <div class="mb-3">
                        <label for="Descrizione appartamento" class="form-label">Descrizione appartamento</label>
                        <textarea class="form-control" name="description" rows="3">{{$apartment->description}}</textarea>
                    </div>


                    <div class="form-floating">
                        <input value="{{$apartment->picture}}" type="text" class="form-control" placeholder="inserisci un'immagine" name="picture">
                        <label for="image">Inserisci un'immagine</label>
                    </div>

                    <div class="my-3 input-group mb-3">
                        <span class="input-group-text"></span>
                        <input value="{{$apartment->rooms}}" type="number" name="rooms" placeholder="inserisci il numero di stanze"
                            class="form-control">
                    </div>

                    <div class="my-3 input-group mb-3">
                        <span class="input-group-text"></span>
                        <input value="{{$apartment->beds}}" type="number" name="beds" placeholder="inserisci il numero di letti"
                            class="form-control">
                    </div>

                    <div class="my-3 input-group mb-3">
                        <span class="input-group-text"></span>
                        <input value="{{$apartment->bathrooms}}" type="number" name="bathrooms" placeholder="inserisci il numero di bagni"
                            class="form-control">
                    </div>

                    <div class="my-3 input-group mb-3">
                        <span class="input-group-text"></span>
                        <input value="{{$apartment->square_meters}}" type="number" name="square_meters" placeholder="inserisci il numero di metri quadrati"
                            class="form-control">
                    </div>

                    <div class="my-3 input-group mb-3">
                        <span class="input-group-text">€</span>
                        <input value="{{$apartment->price}}" type="number" name="price" placeholder="inserisci il prezzo" class="form-control">
                    </div>

                    <div class="my-3 input-group mb-3">
                        <span class="input-group-text"></span>
                        <input value="{{$apartment->city}}" type="text" name="city" placeholder="inserisci la città" class="form-control">
                    </div>

                    <div class="my-3 input-group mb-3">
                        <span class="input-group-text"></span>
                        <input value="{{$apartment->address}}" type="text" name="address" placeholder="inserisci l'indirizzo" class="form-control">
                    </div>

                    <div class="my-3 input-group mb-3">
                        <span class="input-group-text"></span>
                        <input value="{{$apartment->latitude}}" type="number" name="latitude" placeholder="inserisci la latitudine" class="form-control">
                    </div>

                    <div class="my-3 input-group mb-3">
                        <span class="input-group-text"></span>
                        <input value="{{$apartment->longitude}}" type="number" name="longitude" placeholder="inserisci la longitudine" class="form-control">
                    </div>


                    <div class="mt-3 mb-3">
                        <div>
                            Seleziona i servizi del tuo appartamento
                        </div>
                        @foreach ($amenities as $amenity)
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" value="{{ $amenity->id }}"
                                    name="amenities[]" id="amenity-{{ $amenity->id }}"
                                    @foreach ($apartment->amenities as $apartmentAmenity)
                                        @if ($apartmentAmenity->id == $amenity->id)
                                            checked
                                        @endif

                                    @endforeach>
                                <label class="form-check-label" for="amenity-{{ $amenity->id }}">
                                    {{ $amenity->title }}
                                </label>
                            </div>
                        @endforeach

                    </div>


                    <label for="visible" class="form-label">Seleziona se rendere visibile o invisibile
                        l'appartamento</label>
                    <select value="{{$apartment->visible}}" class="form-select" id="visible" name="visible">
                        <option value="1">Visibile</option>
                        <option value="0">Non Visibile</option>
                    </select>

                    <button class="btn btn-primary mt-3" type="submit">Modifica</button>



                </form>

            </div>

        </div>




    </div>
@endsection

