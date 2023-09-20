@extends('layouts.app')

@section('content')

<div class="container container-fluid" style="background-color: #2d3047;">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card m-5 rounded text-center" style="background-color: #5c80bc">
                @if (Auth::check())
                    @foreach ($users as $user)
                        @if ($user->id === Auth::user()->id)

                            <div class="card-header border">
                                <div class="container">
                                    <div class="row justify-content-center align-items-center p-2">
                                        <div class="col">
                                            <h1 class="text-white"><strong>SPONSORSHIP</strong></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SEZIONE Selezione e pagamento sponsor -->
                            <div class="card-body border-white d-flex row">
                                <div class="col text-light">
                                    <h2>Applica uno sponsor per mettere in evidenza il tuo appartamento: </h2>
                                    <h2 class="p-2 my-4 border rounded-3"><strong>{{ $apartment->title }}</strong></h2>
                                </div>

                                <div class="row">
                                    <form action="{{ route('apply-sponsorship', $apartment->id) }}" id="form" method="POST">
                                        @csrf
                                        <div class="row form-group justify-content-center align-items-center">
                                            <div class="col col-sm-6 col-md-5 p-3">
                                                <label class="text-light" for="sponsor"><h4 class="m-0">Seleziona un livello di sponsorship: </h4></label>
                                            </div>
                                            <div class="col col-sm-6 col-md-4">
                                                <select class=" form-select form-select-lg" id="sponsor" name="sponsor_id" style="cursor:pointer;">
                                                    @foreach($sponsors as $sponsor)
                                                        <option value="{{ $sponsor->id }}">
                                                            {{ $sponsor->title }} - €{{ $sponsor->price }} for {{ $sponsor->duration }} hours
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Button trigger modal -->
                                        <div class="d-flex justify-content-center my-4">
                                            <button type="button" class="btn btn-primary rounded-3 py-3 px-5" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                ACQUISTA
                                            </button>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Pagamento per sponsor</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <!-- form pagamento -->
                                                <script src="https://js.braintreegateway.com/web/dropin/1.40.2/js/dropin.js"></script>
                                                <div id="dropin-container"></div>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn btn-danger" data-bs-dismiss="modal">Chiudi</button>
                                                <button type="button" id="submit-button" class="btn btn-success">Conferma</button>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</div>
<script>

//FORM DI PAGAMENTO
const button = document.getElementById('submit-button');
const form = document.getElementById('form');

braintree.dropin.create({
  authorization: 'sandbox_g42y39zw_348pk9cgf3bgyw2b',
  selector: '#dropin-container'
}, function (err, instance) {
  button.addEventListener('click', function () {
    instance.requestPaymentMethod(function (err, payload) {
        if (!err) {
        form.submit();
      }
    });
  })
});

</script>
@endsection
