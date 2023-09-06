<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'country',
        'city',
        "address",
        "latitude",
        "longitude",
        "apartment_id"
    ];

     public function apartment() {

        return $this -> belongsTo(Apartment :: class);
    }
}


