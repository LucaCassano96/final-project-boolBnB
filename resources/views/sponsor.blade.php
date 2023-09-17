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
        <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    acquista sponsor
  </button>

  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        {{-- form pagamento --}}
        <script src="https://js.braintreegateway.com/web/dropin/1.40.2/js/dropin.js"></script>

        <div id="dropin-container"></div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn btn-danger" data-bs-dismiss="modal">Chiudi</button>
          <button type="submit" id="submit-button" class="btn btn-success">Conferma</button>
        </div>
      </div>
    </div>
  </div>
    </form>
</div>

<script>

//FORM DI PAGAMENTO
var button = document.querySelector('#submit-button');

braintree.dropin.create({
  authorization: 'sandbox_g42y39zw_348pk9cgf3bgyw2b',
  selector: '#dropin-container'
}, function (err, instance) {
  button.addEventListener('click', function () {
    instance.requestPaymentMethod(function (err, payload) {
      // Submit payload.nonce to your server
    });
  })
});

</script>

@endsection
