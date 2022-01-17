<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetHotelProvider extends Model
{
    use HasFactory;
    public $table = "pet_hotel_provider"; //dari sisi provider/penyedia jasa
    protected $fillable = [
        'user_id',
        'merchant_id', //jika penyedianya dari user, maka ini dinullkan saja
        'address',
        'phone',
        'desciption',
        'pet_hotel_provider_photo',

    ];
   
    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s', strtotime($value));
    }
    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s', strtotime($value));
    }
}