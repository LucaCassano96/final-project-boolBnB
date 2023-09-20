@extends('layouts.app')
@section('content')

<div class="container-fluid px-xl-5" style="background-color: #2d3047">

    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <div class="card p-4 mt-4 rounded-4">
                <h1 class="my-3 text-center fw-bold" style="color:#2d3047">Trova la tua prossima destinazione!</h1>
                <form method="POST" action="{{ route('search') }}">

                    @csrf

                    {{-- SEARCH BAR --}}
                    <div class="search mt-3 d-flex justify-content-center" style="width: 100%;">
                        <input type="text" id="searchInput" autocomplete="off" required class="col col-md-10 search-input p-3 mx-0 rounded-start-2 border border-3" placeholder="Cerca qui..." name="address">
                        <button type="submit" class="col-md-2 d-inline-block rounded-end-2 border border-3 border-start-0 p-3 mx-0 text-center" style="color: #e0a458; font-size: 25px;">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    {{-- Hidden select --}}
                    <select id="autocompleteSelect" class="form-select" size="5" style="display: none; cursor: pointer;"></select>
                </form>
            </div>
        </div>
    </div>

    <!--Tutti gli appartamenti-->
    <div class="row mt-4 mx-md-4 mx-lg-5">
        @php $sponsoredApartments = []; @endphp
        @foreach ($apartments as $apartment)
            @foreach ($apartment->sponsor as $sponsor)
            {{-- <p>End Date: {{ $sponsor->pivot->end_date }}</p> --}}
            @if ($apartment->visible && $sponsor->pivot->end_date > now())
            @php $sponsoredApartments[] = $apartment; @endphp
            @endif
            @endforeach
        @endforeach

        <!--Appartamenti in evidenza-->
        @foreach ($sponsoredApartments as $apartment)
            <div class="col-md-6 col-lg-4 col-xl-2 order-1 p-3">
                {{-- card --}}
                <div class="card border border-3 border-warning rounded-2 text-center p-0" style="position:relative; min-height:430px; background-color:#353f5c; border-color:#fffdeb">
                    {{-- logo sponsor - position absolute top right --}}
                    <i class="bi bi-badge-ad text-warning" style="position: absolute; bottom:-1%; right:2%; font-size:30px;"></i>

                    {{-- Card Body --}}
                    <div class="card-body p-2">
                        {{-- immagine --}}
                        <div class="rounded mb-2" style="width:100%; aspect-ratio: 1 / 1; border: 2px solid #e0a458;">
                            <img class="rounded" loading="lazy" src="{{
                                asset(
                                    $apartment->picture
                                    ? 'storage/' . $apartment->picture
                                    : 'storage/images/apartment.jpg')
                                }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>

                        {{-- dati appartamento --}}
                        <div class="my-2" style="color: #fffdeb">
                            {{-- titolo --}}
                            <h6 class="text-uppercase m-0">
                                <a class="d-flex justify-content-center align-items-center
                                text-decoration-none border p-2 rounded"
                                style="height:60px; color: #fffdeb; border-color: #fffdeb; width: 100% overflow:ellipsis;"
                                href="{{ route('apartment.show', $apartment->id) }}"> {{ $apartment->title }}</a>
                            </h6>
                            {{-- indirizzo --}}
                            <div class="d-flex justify-content-center align-items-center p-1 my-2" style="height:60px; overflow:hidden;">
                                <span style="text-overflow:'(...)';">{{ $apartment->address }}</span>
                            </div>
                            <div class="p-1">
                                <span class="p-0" style="font-size: 25px; font-weight:800;">{{ $apartment->price }} € </span>
                                <span><small>/ notte</small></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!--Appartamenti non in evidenza-->
        @foreach ($apartments as $apartment )
            @if ($apartment->visible && !in_array($apartment, $sponsoredApartments))
                <div class="col-md-6 col-lg-4 col-xl-2 order-2 p-3 d-flex align-items-end">
                    <div class="card border text-center p-0" style="min-height:430px; background-color:#5c7fbc32; border-color:#fffdeb">

                        {{-- Card Body --}}
                        <div class="card-body p-2">
                            {{-- immagine --}}
                            <div class="rounded mb-2" style="width:100%; aspect-ratio: 1 / 1; border: 2px solid #e0a458;">
                                <img class="rounded" loading="lazy" src="{{
                                    asset(
                                        $apartment->picture
                                        ? 'storage/' . $apartment->picture
                                        : 'storage/images/apartment.jpg')
                                    }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>

                            {{-- dati appartamento --}}
                            <div class="my-2" style="color: #fffdeb">
                                {{-- titolo --}}
                                <h6 class="text-uppercase m-0">
                                    <a class="d-flex justify-content-center align-items-center
                                    text-decoration-none border p-2 rounded"
                                    style="height:60px; color: #fffdeb; border-color: #fffdeb; width: 100% overflow:ellipsis;"
                                    href="{{ route('apartment.show', $apartment->id) }}"> {{ $apartment->title }}</a>
                                </h6>
                                {{-- indirizzo --}}
                                <div class="d-flex justify-content-center align-items-center p-1 my-2" style="height:60px; overflow:hidden;">
                                    <span style="text-overflow:'(...)';">{{ $apartment->address }}</span>
                                </div>
                                <div class="p-1">
                                    <span class="p-0" style="font-size: 25px; font-weight:800;">{{ $apartment->price }} € </span>
                                    <span><small>/ notte</small></span>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach



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
