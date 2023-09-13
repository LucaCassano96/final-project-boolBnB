@extends('layouts.app')
@section('content')

<div  class="container pt-4" style="background-color: #2d3047;">

    <div class="row d-flex justify-content-center">
        <div class="col">
            <div class="card p-4 mt-4 rounded-4">
                <h1 class="my-5 text-center" style="color:#2d3047">Seleziona i tuoi filtri o rinnova la ricerca</h1>

                <form method="POST" action="{{ route('search') }}">

                    @csrf

                    <div class="search mt-5 d-flex justify-content-center" style="width: 100%;">
                        <input type="text" id="searchInput" class="col col-md-10 search-input px-3 mx-0 rounded-start-2 border border-3" placeholder="Cerca qui..." name="address">
                        <button type="submit" class="col-md-2 d-inline-block rounded-end-2 border border-3 border-start-0 px-3 mx-0 text-center" style="color: #e0a458; font-size: 25px;">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    {{-- Hidden select --}}
                    <select id="autocompleteSelect" class="form-select" size="5" style="display: none; cursor: pointer;"></select>
                </form>
            </div>
        </div>
    </div>

    <div class="row d-flex justify-content-center">
        {{-- Filters --}}
        <div class="col mb-lg-5">
            <div class="card p-4 mt-4 rounded-4">
                <h3 class="my-3 text-center" style="color:#2d3047">Filtri di ricerca</h3>

                <form method="POST" id="form" action="">

                    @csrf

                    {{-- NUMERO STANZE --}}
                    <div class="my-3 input-group mb-3">
                        <span class="input-group-text"></span>
                        <input type="number" id="rooms" name="rooms" placeholder="stanze"
                            class="form-control">
                        </div>
                    {{-- @error('rooms')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror --}}

                    {{-- NUMERO LETTI --}}
                    <div class="my-3 input-group mb-3">
                        <span class="input-group-text"></span>
                        <input type="number" id="beds" name="beds" placeholder="letti"
                            class="form-control">
                        </div>
                    {{-- @error('beds')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror --}}

                    {{-- NUMERO BAGNI --}}
                    <div class="my-3 input-group mb-3">
                        <span class="input-group-text"></span>
                        <input type="number" id="bathrooms" name="bathrooms" placeholder="bagni"
                            class="form-control">
                        </div>
                    {{-- @error('bathrooms')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror --}}

                    {{-- METRI QUADRATI --}}
                    <div class="my-3 input-group mb-3">
                        <span class="input-group-text"></span>
                        <input type="number" id="square_meters" name="square_meters" placeholder="metri quadrati"
                            class="form-control">
                        </div>
                    {{-- @error('square_meters')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror --}}

                    {{-- PREZZO --}}
                    <div class="my-3 input-group mb-3">
                        <span class="input-group-text">€</span>
                        <input type="number" id="price" name="price" placeholder="prezzo" class="form-control">
                    </div>
                    {{-- @error('price')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror --}}

                    {{-- SERVIZI --}}
                    <div class="mt-3 mb-3">
                        <div>
                            Seleziona i servizi
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
                            {{-- @error('amenities')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror --}}
                    </div>
                </form>
            </div>
        </div>

        {{-- Apartments Preview --}}
        <div class="col-12 col-lg-9 col-xl-9">
            <div class="row mt-4">
                @foreach ($apts as $apt)
                    <div class="col-12 col-md-6 col-lg-5 col-xl-4 p-3">
                        <div class="card border text-center p-0" style="min-height:530px; background-color:#5c7fbc32; border-color:#fffdeb">
                            {{-- Card Header --}}
                            <div class="d-flex card-header p-2 align-items-center justify-content-center" style="border-color: #fffdeb; min-height: 130px">
                                <h5 class="text-uppercase m-0">
                                    <a class="d-inline-block
                                    text-decoration-none border p-2 rounded my-3"
                                    style="color: #fffdeb; border-color: #fffdeb; width: 100%"
                                    href="{{ route('apartment.show', $apt->id) }}"> {{ $apt->title }}</a>
                                </h5>
                            </div>
                            {{-- Card Body --}}
                            <div class="card-body p-4">
                                {{-- immagine --}}
                                <div class="rounded" style="width:100%; aspect-ratio: 16 / 10; border: 2px solid #e0a458;">
                                    <img class="rounded" src="{{
                                        asset(
                                            $apt->picture
                                            ? 'storage/' . $apt->picture
                                            : 'storage/images/apartment.jpg')
                                        }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                {{-- dati appartamento --}}
                                <div class="my-4">
                                    <ul class="list-unstyled" style="color: #fffdeb">
                                        <li> {{ $apt->address }}</li>
                                        <li class="p-0 mt-5">
                                            <span class="p-0 mt-5" style="font-size: 30px; font-weight:800;">{{ $apt->price }} € </span><span><small>/ notte</small></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


</div>

<script>
    //TomTom Autocomplete con fuzzy search

    //Richiamo gli elementi del form
    const searchInput = document.getElementById('searchInput');
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
</script>

@endsection
