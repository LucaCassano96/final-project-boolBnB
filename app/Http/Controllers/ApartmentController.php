<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Models\Apartment;
use App\Models\Amenity;
use App\Models\User;
use App\Models\Message;
use App\Models\View;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApartmentController extends Controller
{

    /* ADDRESS FUNCTION */
    private function geocodeAddress($address) {
        $apiKey = config('services.tomtom.api_key');
        $apiUrl = 'https://api.tomtom.com/search/2/geocode/' . urlencode($address) . '.json';

        return Http::get($apiUrl, [
            'key' => $apiKey,
        ]);
    }

    /* SEARCH API*/
    public function searchApi(Request $request){

        $data =  $request -> all();
        $address = $data['address'];
        $amenities = Amenity :: all();

        $response = [];

        // Geocode the address using the TomTom Geocoding API
        $geocodingResponse = $this->geocodeAddress($address);
        $geocodingData = $geocodingResponse->json();

        // Extract latitude and longitude from the geocoding response
        $searchLat = $geocodingData['results'][0]['position']['lat'];
        $searchLon = $geocodingData['results'][0]['position']['lon'];

        //Radius for the apartment search (in km)
        $radius = $data['radius'];

        // Query apartments within the specified radius
        $apartments = DB::table('apartments')
            ->select('*')
            ->selectRaw(
                '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
                [$searchLat, $searchLon, $searchLat]
            )
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->get();

        $response['apartments'] = $apartments;
        /* $response['amenities'] = $amenities; */
        $response['radius'] = $radius;

        return response()->json($response);
        /* dd($radius); */
    }

    /* SEARCH*/
    public function search(Request $request){

        $data =  $request -> all();
        $address = $data['address'];
        $apartments = Apartment::with('amenities')->get();
        $amenities = Amenity::all();

        // Geocode the address using the TomTom Geocoding API
        $geocodingResponse = $this->geocodeAddress($address);
        $geocodingData = $geocodingResponse->json();

        // Extract latitude and longitude from the geocoding response
        $searchLat = $geocodingData['results'][0]['position']['lat'];
        $searchLon = $geocodingData['results'][0]['position']['lon'];

        //Radius for the apartment search (in km)
        $radius = 20;

        // Query apartments within the specified radius
        $apartments = DB::table('apartments')
            ->select('*')
            ->selectRaw(
                '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
                [$searchLat, $searchLon, $searchLat]
            )
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->get();


        return view("search", compact("apartments", "amenities"));
    }

    /* HOME */
    public function index(){

        $apartments = Apartment :: all();
        $apartments = Apartment::orderBy('created_at', 'desc')->get();

        return view("home", compact("apartments"));
    }

    /* DASHBOARD */
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

    /* STORE */
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
            "picture" => "required|image|file|max:2048",
            "price" => "required|integer",
            "amenities" => "required|array|min:1",

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

        $img_path = Storage::put("uploads", $data["picture"]);
        $data["picture"] = $img_path;

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
         }
    }

    /* EDIT */
    public function edit($id){

        $amenities = Amenity :: all();
        $apartment = Apartment :: FindOrFail($id);
        return view("apartment.edit", compact("apartment", "amenities"));
    }

    /* UPDATE */
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


            "picture" => "nullable",
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

            'price.required'=> "È necessario inserire un prezzo",
            'price.integer'=> "È necessario inserire un numero intero",

            'amenities.required'=> "È necessario selezionare almeno un servizio",
            'amenities.min'=> "È necessario selezionare almeno un servizio",
        ]
     );

        $data = $request -> all();

        $apartment = Apartment :: FindOrFail($id);

        if (!array_key_exists("picture", $data)) {
            $data["picture"] = $apartment -> picture;

        }else{
            $oldImgPath = $apartment -> picture;

            if ($oldImgPath) {
                Storage :: delete($oldImgPath);
            }

            $img_path = Storage::put("uploads", $data["picture"]);
            $data["picture"] = $img_path;
        }


        $apartment -> update($data);

        if(array_key_exists("amenities", $data))
        $apartment -> amenities() -> sync($data["amenities"]);
        else
        $apartment -> amenities() -> detach();

        return redirect() -> route("apartment.show", $apartment -> id);

    }

    /* DELETE */
    public function delete($id) {

        $apartment = Apartment::findOrFail($id);

        $apartment->amenities()->detach();
        $apartment->messages()->delete();
        $apartment->view()->delete();

        $apartment->delete();

        return redirect()->route("dashboard");
    }

    /* MESSAGE CREATE*/
    public function messagePage($id){

        $message = Message :: all();
        $apartment = Apartment :: FindOrFail($id);
        return view("messagePage", compact("message", "apartment"));
    }

    /* MESSAGE STORE RELATED TO APARTMENT */
    public function messageStore(Request $request, $id){

        // validazioni backend messaggio
        $request -> validate([
            "sender_email" => "required|email|max:255",
            "content" => "required",
        ],
        // messaggi validazioni personalizzati
        [
            'sender_email.required'=> "È necessario inserire una email",
            'sender_email.email'=> "È necessario inserire una email valida",
            'sender_email.max'=> "La email non può superare i 255 caratteri",

            'content.required'=> "È necessario inserire un messaggio",
        ]
        );

        $data = $request -> all();
        $data['apartment_id'] = $id;
        Message :: create($data);




        return redirect() -> route("apartment.show", $id) -> with('success', 'Messaggio inviato con successo!');
    }

    /* MESSAGE APARTMENT */
    public function messageApartment(){

        $apartments = Apartment :: all();
        $messages = Message :: all();
        $users = User :: all();

        return view("messageApartment", compact("apartments", "messages", "users"));
    }

}



