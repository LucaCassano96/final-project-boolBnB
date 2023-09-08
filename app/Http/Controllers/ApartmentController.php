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

}
