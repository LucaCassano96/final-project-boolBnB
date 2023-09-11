<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
       'content',
       'sender_name',
       'sender_email',
       'sender_surname',
       'apartment_id'
    ];

    /* Apartment--Message */
    public function apartment() {

        return $this -> belongsTo(Apartment :: class);
    }
}
