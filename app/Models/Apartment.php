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
        "user_id"

    ];


    /* View */

    public function view() {

        return $this -> hasOne(View :: class);
    }


    /* Location */

    public function location() {

        return $this -> hasOne(location :: class);
    }

    /* User--Apartment */

    public function user() {

        return $this -> belongsTo(User :: class);
    }

    /* Apartment--Message */
    public function messages() {

        return $this -> hasMany(Message :: class);
    }

    /* apartments--amenities */

    public function amenities() {

        return $this -> belongsToMany(Amenity :: class);
    }


    /* apartments--sponsors */

    public function sponsors() {

        return $this -> belongsToMany(Sponsor :: class);
    }


}
