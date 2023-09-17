<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use App\Models\Apartment;
use App\Models\Amenity;
use App\Models\User;
use App\Models\Message;
use App\Models\View;
use App\Models\Sponsor;

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

    /* ADDRESS RADIUS FUNCTION */
    private function geocodeRadius($lat, $lon, $radius) {
        $apiKey = config('services.tomtom.api_key');
        $apiUrl = "https://api.tomtom.com/search/2/nearbySearch/.json";

        return Http::get($apiUrl, [
            'key' => $apiKey,
            'lat' => $lat,
            'lon' => $lon,
            'limit' => 100,
            'radius' => $radius, // in meters
            'view' => 'Unified',
        ]);
    }

    /* SAME FIRST DIGITS */
    public function haveSameFirstDigits($number1, $number2, $numDigits) {
        // Convert the numbers to strings
        $number1Str = (string)$number1;
        $number2Str = (string)$number2;

        // Extract the first $numDigits digits from both strings
        $firstDigits1 = substr($number1Str, 0, $numDigits);
        $firstDigits2 = substr($number2Str, 0, $numDigits);

        // Compare the first digits
        return $firstDigits1 === $firstDigits2;
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
        $sponsors = Sponsor::all();
        $users = User :: all();

        return view("dashboard", compact("apartments", "users", 'sponsors'));
    }

    /* SHOW */
    public function show($id){

        $apartment = Apartment :: FindOrFail($id);

        return view("apartment.show", compact("apartment"));
    }

    /* SEARCH API*/
    public function searchApi(Request $request){

        $data =  $request -> all();
        $apartments = Apartment :: all();
        $amenities = Amenity :: all();
        $radius = 20000;
        if ($data['radius'] && $data['radius'] > 0 && $data['radius'] <= 50) {
            $radius = $data['radius'] * 1000;
        }

        $response = [];

        // Geocode the address using the TomTom Geocoding API
        $geocodingResponse = $this->geocodeAddress($data['address']);
        $geocodingData = $geocodingResponse->json();

        // Extract latitude and longitude from the geocoding response
        $searchLat = $geocodingData['results'][0]['position']['lat'];
        $searchLon = $geocodingData['results'][0]['position']['lon'];

        // Getting the addresses in a radius
        $geoRadiusResponse = $this->geocodeRadius($searchLat, $searchLon, $radius);
        $geoRadiusData = $geoRadiusResponse->json();
        $radiusApartments = $geoRadiusData['results'];

        //Position for every address from research (lat + lon)
        $apartmentsCoordinates = [];

        foreach ($radiusApartments as $radiusApartment) {
            array_push($apartmentsCoordinates, $radiusApartment['position']);
        }

        //Position for every apartment in DB (lat + lon + id)
        $apartmentsDbCoordinates = [];

        foreach ($apartments as $apartment) {

            $position = [
                "latitude" => $apartment->latitude,
                "longitude" => $apartment->longitude,
                "address" => $apartment->address,
                "id" => $apartment->id,
            ];

            $apartmentsDbCoordinates[] = $position;
        }

        // Initialize an empty result array
        $resultApartments = [];

        foreach ($apartmentsDbCoordinates as $apartmentsDbCoordinate) {
            foreach ($apartmentsCoordinates as $apartmentsCoordinate) {

                $lat = $apartmentsCoordinate["lat"];
                $latitude = $apartmentsDbCoordinate["latitude"];
                $lon = $apartmentsCoordinate["lon"];
                $longitude = $apartmentsDbCoordinate["longitude"];
                $numDigits = 3;

                if ($this->haveSameFirstDigits($lat, $latitude, $numDigits) && $this->haveSameFirstDigits($lon, $longitude, $numDigits))
                {
                    // Add the matching element to the result array
                    $resultApartments[] = $apartmentsDbCoordinate;
                    break; // Exit the inner loop since a match is found
                }
            }
        }

        $apts = [];

        foreach ($resultApartments as $resultApartment) {
            foreach ($apartments as $apartment) {
                if ($resultApartment["id"] == $apartment->id) {
                    $apts[] = $apartment;
                    break;
                }
            }
        }

        $response['apts'] = $apts;
        /* $response['amenities'] = $amenities; */
        $response['radius'] = $radius;

        return response()->json($response);
        /* dd($radius); */

    }

    /* SEARCH*/
    public function search(Request $request){

        $data =  $request -> all();
        $apartments = Apartment :: all();
        $amenities = Amenity :: all();
        $radius = 20000;
        // Geocode the address using the TomTom Geocoding API
        $geocodingResponse = $this->geocodeAddress($data['address']);
        $geocodingData = $geocodingResponse->json();

        // Extract latitude and longitude from the geocoding response
        $searchLat = $geocodingData['results'][0]['position']['lat'];
        $searchLon = $geocodingData['results'][0]['position']['lon'];

        // Getting the addresses in a radius
        $geoRadiusResponse = $this->geocodeRadius($searchLat, $searchLon, $radius);
        $geoRadiusData = $geoRadiusResponse->json();
        $radiusApartments = $geoRadiusData['results'];

        //Position for every address from research (lat + lon)
        $apartmentsCoordinates = [];

        foreach ($radiusApartments as $radiusApartment) {
            array_push($apartmentsCoordinates, $radiusApartment['position']);
        }
        //Position for every apartment in DB (lat + lon + id)
        $apartmentsDbCoordinates = [];

        foreach ($apartments as $apartment) {

            $position = [
                "latitude" => $apartment->latitude,
                "longitude" => $apartment->longitude,
                "address" => $apartment->address,
                "id" => $apartment->id,
            ];

            $apartmentsDbCoordinates[] = $position;
        }

        // Initialize an empty result array
        $resultApartments = [];

        foreach ($apartmentsDbCoordinates as $apartmentsDbCoordinate) {
            foreach ($apartmentsCoordinates as $apartmentsCoordinate) {

                $lat = $apartmentsCoordinate["lat"];
                $latitude = $apartmentsDbCoordinate["latitude"];
                $lon = $apartmentsCoordinate["lon"];
                $longitude = $apartmentsDbCoordinate["longitude"];
                $numDigits = 3;

                if ($this->haveSameFirstDigits($lat, $latitude, $numDigits) && $this->haveSameFirstDigits($lon, $longitude, $numDigits))
                {
                    // Add the matching element to the result array
                    $resultApartments[] = $apartmentsDbCoordinate;
                    break; // Exit the inner loop since a match is found
                }
            }
        }

        /* dd($resultApartments); */

        $apts = [];

        foreach ($resultApartments as $resultApartment) {
            foreach ($apartments as $apartment) {
                if ($resultApartment["id"] == $apartment->id) {
                    $apts[] = $apartment;
                    break;
                }
            }
        }


        return view("search", compact("apts", "amenities"));
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
        $apartment->sponsor()->detach();

        $apartment->delete();

        return redirect()->route("dashboard");
    }

    /* MESSAGE CREATE*/

    public function messagePage($id){

        $message = Message :: all();
        $apartment = Apartment :: FindOrFail($id);
        return view("messagePage", compact("message", "apartment"));


    }

    // message store related to apartment
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

    // // Prendere IP address di chi visita l'appartamento
    // public function getIp() {
    //     $ip = $_SERVER['REMOTE_ADDR'];
    //     return $ip;
    // }


    // // store view
    // public function storeView($id) {
    //     // prendi ip
    //     $ip = $this->getIp();
    //     // inserisci nella tabella views
    //     $view = View::create([
    //         'apartment_id' => $id,
    //         'ip_address' => $ip
    //     ]);
    //     return redirect()->route('apartment.show', $id, compact('view'));
    // }


    // // STATISTICS
    // public function statistics(){



    //     $apartments = Apartment :: all();
    //     $views = View :: all();
    //     $users = User :: all();

    //     return view("statistics", compact("apartments", "views", "users"));
    // }

        // SPONSOR
            // Show the sponsorship form
    public function showSponsorshipForm($id)
    {
        $apartment = Apartment::findOrFail($id);
        $sponsors = Sponsor::all();
        return view('sponsor', compact('apartment', 'sponsors'));
    }

    // Process the sponsorship form
    public function applySponsorship(Request $request, $id)
    {
        $apartment = Apartment::findOrFail($id);
        $sponsor = Sponsor::findOrFail($request->sponsor_id);



            // Prendi l'ultima sponsorizzazione per l'appartamento
        // Ottieni tutte le sponsorizzazioni per l'appartamento
        $sponsorships = $apartment->sponsor()->withPivot('end_date')->get();

        // Ordina la collezione in base alla end_date
        $lastSponsorship = $sponsorships->sortByDesc(function ($sponsorship) {
            return $sponsorship->pivot->end_date;
        })->first();


        // Se esiste una sponsorizzazione e la sua end_date è nel futuro,
        // usa quella come punto di partenza. Altrimenti, usa l'ora corrente.
        $now = ($lastSponsorship && $lastSponsorship->pivot->end_date > Carbon::now())
            ? Carbon::parse($lastSponsorship->pivot->end_date)
            : Carbon::now();

        $end_date = $now->copy()->addHours($sponsor->duration);
        $apartment->sponsor()->attach($sponsor->id, [
            'start_date' => $now,
            'end_date' => $end_date,
        ]);
                // Se la nuova end_date della sponsorizzazione è nel futuro, allora aggiorna la flag sponsor a 1
                if ($end_date > Carbon::now()) {
                    $apartment->sponsor = 1;
                    $apartment->save();
                }
                return redirect()->route('dashboard')->with('success', 'Sponsorship applied successfully!');
            }
    }

