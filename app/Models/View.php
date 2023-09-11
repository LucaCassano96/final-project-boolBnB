<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

    protected $fillable = [
       'view_id',
       'data',
       'ip_address',
    //    'apartment_id'
    ];

    /* Apartment--View */
    public function apartment() {

        return $this -> belongsTo(Apartment :: class);
    }
}
