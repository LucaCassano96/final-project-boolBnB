@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="row d-flex justify-content-center">


            <div class="col-11 col-md-8 col-xl-5 border border-primary p-3 shadow-sm p-3 mb-5 bg-body-tertiary rounded"
                style="margin: 150px">

                <h2 class="my-4">Crea un nuovo appartamento</h2>

                <form method="POST" id="form" action="{{ route('apartment.store') }}" enctype="multipart/form-data">

                    @csrf

                    {{-- NOME --}}
                    <div class="form-floating mb-3">
                        <input type="text" id="title" class="form-control" name="title" placeholder="nome appartamento">
                        <label for="floatingInput">Nome appartamento</label>
                    </div>
                    @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    {{-- DESCRIZIONE --}}
                    <div class="mb-3">
                        <label for="Descrizione appartamento" class="form-label">Descrizione appartamento</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    {{-- IMMAGINE --}}
                    <div class="py-2" style="width: 40%" for="picture">Inserisci un'immagine </div>
                    <div class="input-group mb-3">
                        <input type="file" id="picture" class="form-control" name="picture">
                    </div>
                    @error('picture')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    {{-- NUMERO STANZE --}}
                    <div class="my-3 input-group">
                        <span class="input-group-text" style="width:90px;">Stanze</span>
                        <input type="number" id="rooms" name="rooms" placeholder="inserisci il numero di stanze"
                            class="form-control" min="0">
                        </div>
                    @error('rooms')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    {{-- NUMERO LETTI --}}
                    <div class="my-3 input-group">
                        <span class="input-group-text" style="width:90px;">Letti</span>
                        <input type="number" id="beds" name="beds" placeholder="inserisci il numero di letti"
                            class="form-control" min="0">
                        </div>
                    @error('beds')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    {{-- NUMERO BAGNI --}}
                    <div class="my-3 input-group" >
                        <span class="input-group-text" style="width:90px;">Bagni</span>
                        <input type="number" id="bathrooms" name="bathrooms" placeholder="inserisci il numero di bagni"
                            class="form-control" min="0">
                        </div>
                    @error('bathrooms')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    {{-- METRI QUADRATI --}}
                    <div class="my-3 input-group">
                        <span class="input-group-text" style="width:90px;">M <sup>2</sup> </span>
                        <input type="number" id="square_meters" name="square_meters" placeholder="inserisci il numero di metri quadrati"
                            class="form-control" min="10">
                        </div>
                    @error('square_meters')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    {{-- PREZZO --}}
                    <div class="my-3 input-group">
                        <span class="input-group-text" style="width:90px;">€ / notte</span>
                        <input type="number" id="price" name="price" placeholder="inserisci il prezzo" class="form-control" min="0">
                    </div>
                    @error('price')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    {{-- INDIRIZZO --}}
                    <div class=" mt-3 input-group">
                        <span class="input-group-text" style="width:90px;">Indirizzo</span>
                        <input type="text" id="address" name="address" placeholder="inserisci l'indirizzo" class="form-control" autocomplete="off">
                    </div>
                    {{-- Hidden select --}}
                    <select id="autocompleteSelect" class="form-select" size="5" style="display: none; cursor: pointer;"></select>

                    @error('address')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    {{-- SERVIZI --}}
                    <div class="mt-3 mb-3">
                        <div>
                            Seleziona i servizi del tuo appartamento
                        </div>
                        @foreach ($amenities as $amenity)
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" value="{{ $amenity->id }}"
                                    name="amenities[]" id="amenity-{{ $amenity->id }}">
                                <label class="form-check-label" for="amenity-{{ $amenity->id }}">
                                    {{ $amenity->title }}
                                </label>
                            </div>
                        @endforeach
                            @error('amenities')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror

                    </div>

                    {{-- VISIBILITA' --}}
                    <label for="visible" class="form-label">Seleziona se rendere visibile o invisibile
                        l'appartamento</label>
                    <select class="form-select" id="visible" name="visible">
                        <option value="1">Visibile</option>
                        <option value="0">Non Visibile</option>
                    </select>

                    {{-- BUTTON CREAZIONE --}}
                    <button class="btn btn-primary mt-3" type="submit">Crea </button>

                </form>

            </div>

        </div>

    </div>

    <script>
        //TomTom Autocomplete con fuzzy search

        //Richiamo gli elementi del form
        const searchInput = document.getElementById('address');
        const autocompleteSelect = document.getElementById('autocompleteSelect');

        //Prendo il contenuto dell'input
        searchInput.addEventListener('input', debounce(function () {
        const query = searchInput.value.trim();

        if (query.length === 0) {
            autocompleteSelect.style.display = 'none';
            return;
        }
        //Chiamata axios alla rotta autocomplete + query (testo input)
        axios.get(`/autocomplete?query=${encodeURIComponent(query)}`)
            .then(response => {
                const suggestions = response.data.results;

                autocompleteSelect.innerHTML = '';
                //per ogni risultato della chiamata creo una option per la select
                suggestions.forEach(suggestion => {
                    const option = document.createElement('option');
                    option.textContent = suggestion.address.freeformAddress;
                    option.value = suggestion.address.freeformAddress;
                    autocompleteSelect.appendChild(option);
                });
                //rendo la select visibile
                autocompleteSelect.style.display = 'block';
            })
            .catch(error => {
                console.error('Autocomplete request failed', error);
            });
    }, 100));
    //Il valore della option selezionata diventa il valore dell'input e la select torna a essere nascosta
    autocompleteSelect.addEventListener('change', function () {
        searchInput.value = autocompleteSelect.value;
        autocompleteSelect.style.display = 'none';
    });

    //Funzione di delay per limitare la frequenza di chiamate axios (per non appesantire toppo la pagina)
    function debounce(func, wait) {
        let timeout;
        return function () {
            clearTimeout(timeout);
            timeout = setTimeout(func, wait);
        };
    }

//VALIDATION CLIENT-SIDE

    const form = document.getElementById('form');
    const title = document.getElementById('title');
    const picture = document.getElementById('picture');
    const rooms = document.getElementById('rooms');
    const beds = document.getElementById('beds');
    const bathrooms = document.getElementById('bathrooms');
    const square_meters = document.getElementById('square_meters');
    const price = document.getElementById('price');
    const address = document.getElementById('address');

    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the form from submitting

        if (!validateTitle() || !validatePic() || !validateRooms() || !validateBeds() || !validateBathrooms() || !validateSqMeters() || !validatePrice() || !validateAddress() ) {

            return false; // Stop form submission if validation fails
        }
        // If validation passes, submit the form
        this.submit();
    });

    function validateTitle() {

        const titleValue = title.value.trim();

        if (titleValue === '') {
            alert('Inserire un titolo');
            title.focus();
            return false;
        }

        return true;
    }

    function validatePic() {

        const pictureValue = picture.value.trim();

        if (pictureValue === '') {
            alert("Inserire un'immagine");
            picture.focus();
            return false;
        }

        return true;
    }

    function validateRooms() {

        const roomsValue = rooms.value.trim();

        if (roomsValue === '') {
            alert('Inserire il numero di stanze');
            rooms.focus();
            return false;

        }else if (roomsValue <= 0 || roomsValue > 30) {
            alert("Il numero di stanze dev'essere compreso tra 0 e 30");
            rooms.focus();
            return false;
        }

        return true;
    }

    function validateBeds() {

        const bedsValue = beds.value.trim();

        if (bedsValue === '') {
            alert('Inserire il numero di letti');
            beds.focus();
            return false;

        }else if (bedsValue <= 0 || bedsValue > 80) {
            alert("Il numero di stanze dev'essere compreso tra 0 e 80");
            beds.focus();
            return false;
        }

        return true;
    }

    function validateBathrooms() {

        const bathroomsValue = bathrooms.value.trim();

        if (bathroomsValue === '') {
            alert('Inserire il numero di bagni');
            bathrooms.focus();
            return false;

        }else if (bathroomsValue <= 0 || bathroomsValue > 10) {
            alert("Il numero di bagni dev'essere compreso tra 0 e 10");
            bathrooms.focus();
            return false;
        }

        return true;
    }

    function validateSqMeters() {

        const sqMetersValue = square_meters.value.trim();

        if (sqMetersValue === '') {
            alert('Inserire il numero di metri quadrati');
            square_meters.focus();
            return false;

        }else if (sqMetersValue <= 10 || sqMetersValue > 5000) {
            alert("Il numero di metri quadrati dev'essere compreso tra 10 e 5000");
            square_meters.focus();
            return false;
        }

        return true;
    }

    function validatePrice() {

        const priceValue = price.value.trim();

        if (priceValue === '') {
            alert('Inserire il prezzo');
            price.focus();
            return false;

        }else if (priceValue <= 0) {
            alert("Il prezzo dev'essere superiore a 0");
            price.focus();
            return false;
        }

        return true;
    }

    function validateAddress() {

        const addressValue = address.value.trim();

        if (addressValue === '') {
            alert('Selezionare un indirizzo');
            address.focus();
            return false;

        }
        return true;
    }
    </script>
@endsection
