<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'duration'
    ];

    /* Apartment--Sponsor */
    public function apartments() {

        return $this -> belongsToMany(Apartment :: class)
        ->withPivot('start_date', 'end_date');
    }
}
