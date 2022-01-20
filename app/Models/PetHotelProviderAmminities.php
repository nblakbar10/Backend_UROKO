<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetHotelProviderAmminities extends Model
{
    use HasFactory;
    public $table = "pet_hotel_provider_amminities"; 
    protected $fillable = [
        'pet_hotel_provider_id',
        'food',
        'basking',
        'cleaning',
        'bedding',
        'grooming'
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
