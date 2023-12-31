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
        "address",
        "latitude",
        "longitude",
        "activeSponsor",
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

    /* Apartment--View */
    public function view() {

        return $this -> hasOne(View :: class);
    }

    /* Apartment--Sponsor */
    public function sponsor() {

        return $this->belongsToMany(Sponsor::class, 'apartment_sponsor')->withTimestamps()
        ->withPivot('start_date', 'end_date');
    }
}
