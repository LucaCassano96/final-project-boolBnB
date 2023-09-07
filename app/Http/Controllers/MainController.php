<?php

namespace App\Http\Controllers;
use App\Models\Apartment;
use App\Models\Location;
use App\Models\Amentity;



use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){

        $apartments = Apartment :: all();

        return view("home", compact("apartments"));

    }


    /* Apartment create */

    public function create(){

        $apartments = Apartment :: all();
        $locations = Location :: all();
        $amenities = Amenity :: all();

        return view("apartment.create", compact("apartments", "locations", "amenities"));

        }



    public function store(Request $request){

        $data =  $request -> all();

        $apartment = Apartment :: create($data);
        return redirect() -> route("home", $apartment -> id);
    }

}
