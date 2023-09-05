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
        "visible"
    ];
}


