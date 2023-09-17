@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Apply Sponsorship for Apartment: {{ $apartment->title }}</h2>

    <form action="{{ route('apply-sponsorship', $apartment->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="sponsor">Choose a Sponsorship Level</label>
            <select class="form-control" id="sponsor" name="sponsor_id">
                @foreach($sponsors as $sponsor)
                    <option value="{{ $sponsor->id }}">
                        {{ $sponsor->title }} - €{{ $sponsor->price }} for {{ $sponsor->duration }} hours
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Apply Sponsorship</button>
    </form>
</div>
@endsection
