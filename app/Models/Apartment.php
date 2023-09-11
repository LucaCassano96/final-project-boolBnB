<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'rooms',
        'beds',
        "bathrooms",
        "square_meters",
        "picture",
        "price",
        "visible",
        "city",
        "address",
        "latitude",
        "longitude",
        "user_id"

    ];


    /* apartments--amenities */

    public function amenities() {

        return $this -> belongsToMany(Amenity :: class);
    }


    /* User--Apartment */

    public function user() {

        return $this -> belongsTo(User :: class);
    }

    /* Apartment--Message */

    public function messages() {

        return $this -> hasMany(Message :: class);
    }
}


