<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Amenity;
use App\Models\User;



class ApartmentController extends Controller
{

    /* HOME */
    public function index(){

        $apartments = Apartment :: all();
        $apartments = Apartment::orderBy('created_at', 'desc')->get();

        return view("home", compact("apartments"));
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
            "latitude" => "numeric",
            "longitude" => "numeric",


            "image" => "required|image",
            "price" => "required|numeric",
            "amenities" => "required|array",
            // "amenities.*" => "exists:amenities,id"
        ]);
        $data =  $request -> all();
        $data['user_id'] = Auth::id();
        $apartment = Apartment :: create($data);
        $apartment -> amenities() -> attach($data["amenities"]);

        return redirect() -> route("apartment.show", $apartment -> id);
 }

    //  /* EDIT */
    public function edit($id){

        $amenities = Amenity :: all();
        $apartment = Apartment :: FindOrFail($id);
        return view("apartment.edit", compact("apartment", "amenities"));
        }

    //  /* UPDATE */
    public function update(Request $request, $id){

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
        $apartment->delete();

        return redirect()->route("dashboard");
    }


}
