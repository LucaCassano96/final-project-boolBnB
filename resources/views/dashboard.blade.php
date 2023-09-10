@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fs-4 text-secondary my-4">
            {{ __('Dashboard') }}
        </h2>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">{{ __('User Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div>
            <div class="text-end m-3">
                <a class="btn btn-primary border-white" href="{{ route('apartment.create') }}">Aggiungi Appartamento</a>
            </div>
        </div>
        @if (Auth::check())

            @foreach ($users as $user)
                @if ($user->id === Auth::user()->id)
                    <h2>Appartamenti di{{ $user->name }}</h2>
                    <ul class="list-unstyled">
                        @foreach ($user->apartments as $apartment)
                            <li>
                                {{ $apartment->title }}
                            </li>
                            <li>
                                {{ $apartment->price }}
                            </li>
                            <li>
                                <img src="{{ $apartment->picture }}" alt="{{ $apartment->title }}">
                            </li>
                        @endforeach
                    </ul>
                @endif
            @endforeach
        @endif

    </div>
@endsection
