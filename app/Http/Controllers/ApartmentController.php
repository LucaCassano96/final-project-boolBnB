<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Apartment;
use App\Models\Amenity;
use App\Models\User;
use App\Models\Message;
use App\Models\View;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApartmentController extends Controller
{

    /* HOME */
    public function index(){

        $apartments = Apartment :: all();
        $apartments = Apartment::orderBy('created_at', 'desc')->get();

        return view("home", compact("apartments"));
    }


    /* HOME */
    public function dashboard(){

        $apartments = Apartment :: all();
        $users = User :: all();

        return view("dashboard", compact("apartments", "users"));
    }



/* SHOW */
    public function show($id){

        $apartment = Apartment :: FindOrFail($id);

        return view("apartment.show", compact("apartment"));
    }


/* CREATE */
    public function create(){

        $amenities = Amenity :: all();

        return view("apartment.create", compact("amenities"));

    }

/* STORE APARTMENT */

    public function store(Request $request){


        // validazioni backend appartamento


        $request -> validate([
            "title" => "required|max:255",
            "description" => "required",
            "rooms" => "required|integer|max:30",
            "beds" => "required|integer|max:80",
            "bathrooms" => "required|integer|max:10",
            "square_meters" => "required|integer|min:10|max:5000",
            "address" => "required|max:255",

            // DA MODIFICARE
            // "latitude" => "numeric",
            // "longitude" => "numeric",


            "picture" => "required",
            "price" => "required|integer",
            "amenities" => "required|array|min:1",
            // "amenities.*" => "exists:amenities,id"
        ],

        // MODIFICA MESSAGGI VALIDATE
        [
            'title.required'=> "È necessario inserire un titolo",
            'title.max'=> "Il titolo non può superare i 255 caratteri",

            'description.required'=> "È necessario inserire una descrizione",


            'rooms.required'=> "È necessario inserire un numero di stanze",
            'rooms.integer'=> "È necessario inserire un numero intero",
            'rooms.max'=> "Il numero di stanze non può superare i 30",

            'beds.required'=> "È necessario inserire un numero di letti",
            'beds.integer'=> "È necessario inserire un numero intero",
            'beds.max'=> "Il numero di letti non può superare gli 80",

            'bathrooms.required'=> "È necessario inserire un numero di bagni",
            'bathrooms.integer'=> "È necessario inserire un numero intero",
            'bathrooms.max'=> "Il numero di bagni non può superare i 10",

            'square_meters.required'=> "È necessario inserire i metri quadrati",
            'square_meters.integer'=> "È necessario inserire un numero intero",
            'square_meters.min'=> "I metri quadrati non possono essere inferiori a 10",
            'square_meters.max'=> "I metri quadrati non possono superare i 5000",

            'address.required'=> "È necessario inserire un indirizzo",
            'address.max'=> "L'indirizzo non può superare i 255 caratteri",

            'picture.required'=> "È necessario inserire un'immagine",

            'price.required'=> "È necessario inserire un prezzo",
            'price.integer'=> "È necessario inserire un numero intero",

            'amenities.required'=> "È necessario selezionare almeno un servizio",
            'amenities.min'=> "È necessario selezionare almeno un servizio",
        ]
     );


        $data =  $request -> all();
        $data['user_id'] = Auth::id();

        // Geocode the address using the TomTom Geocoding API
         $geocodingResponse = $this->geocodeAddress($data['address']);

         if ($geocodingResponse && $geocodingResponse->successful()) {
             $geocodingData = $geocodingResponse->json();

             // Extract latitude and longitude from the geocoding response
             $data['latitude'] = $geocodingData['results'][0]['position']['lat'];
             $data['longitude'] = $geocodingData['results'][0]['position']['lon'];

             // Create the apartment with geocoded data
            $apartment = Apartment::create($data);
            $apartment->amenities()->attach($data["amenities"]);

            return redirect()->route("apartment.show", $apartment->id);
         } else {
             // Handle geocoding API request failure
             throw ValidationException::withMessages(['address' => 'Geocoding failed. Please check the address.']);
         }
  }

  private function geocodeAddress($address) {
     $apiKey = config('services.tomtom.api_key');
     $apiUrl = 'https://api.tomtom.com/search/2/geocode/' . urlencode($address) . '.json';

     return Http::get($apiUrl, [
         'key' => $apiKey,
     ]);
 }

    //  /* EDIT */
    public function edit($id){

        $amenities = Amenity :: all();
        $apartment = Apartment :: FindOrFail($id);
        return view("apartment.edit", compact("apartment", "amenities"));
        }

    //  /* UPDATE */
    public function update(Request $request, $id){

        // validazioni update
        $request -> validate([
            "title" => "required|max:255",
            "description" => "required",
            "rooms" => "required|integer|max:30",
            "beds" => "required|integer|max:80",
            "bathrooms" => "required|integer|max:10",
            "square_meters" => "required|integer|min:10|max:5000",
            "address" => "required|max:255",

            // DA MODIFICARE
            // "latitude" => "numeric",
            // "longitude" => "numeric",


            "picture" => "required",
            "price" => "required|integer",
            "amenities" => "required|array|min:1",
            // "amenities.*" => "exists:amenities,id"
        ],

        // MODIFICA MESSAGGI VALIDATE
        [
            'title.required'=> "È necessario inserire un titolo",
            'title.max'=> "Il titolo non può superare i 255 caratteri",

            'description.required'=> "È necessario inserire una descrizione",


            'rooms.required'=> "È necessario inserire un numero di stanze",
            'rooms.integer'=> "È necessario inserire un numero intero",
            'rooms.max'=> "Il numero di stanze non può superare i 30",

            'beds.required'=> "È necessario inserire un numero di letti",
            'beds.integer'=> "È necessario inserire un numero intero",
            'beds.max'=> "Il numero di letti non può superare gli 80",

            'bathrooms.required'=> "È necessario inserire un numero di bagni",
            'bathrooms.integer'=> "È necessario inserire un numero intero",
            'bathrooms.max'=> "Il numero di bagni non può superare i 10",

            'square_meters.required'=> "È necessario inserire i metri quadrati",
            'square_meters.integer'=> "È necessario inserire un numero intero",
            'square_meters.min'=> "I metri quadrati non possono essere inferiori a 10",
            'square_meters.max'=> "I metri quadrati non possono superare i 5000",

            'address.required'=> "È necessario inserire un indirizzo",
            'address.max'=> "L'indirizzo non può superare i 255 caratteri",

            'picture.required'=> "È necessario inserire un'immagine",

            'price.required'=> "È necessario inserire un prezzo",
            'price.integer'=> "È necessario inserire un numero intero",

            'amenities.required'=> "È necessario selezionare almeno un servizio",
            'amenities.min'=> "È necessario selezionare almeno un servizio",
        ]
     );

        $data = $request -> all();
        $apartment = Apartment :: FindOrFail($id);
        $apartment -> update($data);
        $apartment -> amenities() -> sync($data["amenities"]);

        return redirect() -> route("apartment.show", $apartment -> id);
    }

    // /* DELETE */
    public function delete($id) {

        $apartment = Apartment::findOrFail($id);

        $apartment->amenities()->detach();
        $apartment->messages()->delete();
        $apartment->view()->delete();

        $apartment->delete();

        return redirect()->route("dashboard");
    }



}



