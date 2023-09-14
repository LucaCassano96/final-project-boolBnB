@extends('layouts.app')
@section('content')

<div class="container">

    <div class="row d-flex justify-content-center ">


        <div class="col-11 col-md-8 col-xl-5 border border-primary p-3 shadow-sm p-3 mb-5 bg-body-tertiary rounded"
            style="margin: 100px">

            <h2 class="my-4">Invia un nuovo messaggio</h2>

            <form method="POST" id="form" action="{{ route('message.store', $apartment->id) }}">

                @csrf

                {{-- Nome mittente --}}
                <label for="sender_name">Inserisci il tuo nome:</label>
                <input type="text" class="form-control mb-4" id="sender_name" name="sender_name"
                    {{-- se autenticato inserisci il suo nome --}}
                    value=@auth
                    {{ Auth::user()->name }}
                    @endauth>


                {{-- Cognome mittente --}}
                <label for="sender_surname">Inserisci il tuo cognome:</label>
                <input type="text" class="form-control mb-4" id="sender_surname" name="sender_surname"
                    {{-- se autenticato inserisci il suo cognome --}}
                    value=@auth
                    {{ Auth::user()->surname }}
                    @endauth>


                {{-- Email mittente --}}
                <label for="sender_email">Inserisci la tua email:</label>
                <input type="email" class="form-control mb-4" id="sender_email" name="sender_email"
                    {{-- se autenticato inserisci la sua email --}}
                    value=@auth
                    {{ Auth::user()->email }}
                    @endauth>
                    @error('sender_email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                {{-- Contenuto messaggio --}}
                <label for="content">Inserisci il tuo messaggio:</label>
                <textarea class="form-control mb-4" id="content" name="content" rows="3"></textarea>
                @error('content')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                {{-- BUTTON CREAZIONE --}}
                <div class="button d-flex justify-content-end">
                    <a class="btn btn-danger mt-3 mx-2" href="{{ route('apartment.show', $apartment->id) }}">Annulla</a>
                    <button class="btn btn-primary mt-3" type="submit">Invia</button>
                </div>

            </form>

        </div>

    </div>

</div>
@endsection
