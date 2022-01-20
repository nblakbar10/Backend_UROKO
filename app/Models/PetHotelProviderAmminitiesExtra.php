<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetHotelProviderAmminitiesExtra extends Model
{
    use HasFactory;
    public $table = "pet_hotel_provider_amminities_extra"; 
    protected $fillable = [
        'pet_hotel_provider_id',
        'extra_amminities_name', 
        'extra_amminities_price_per_day',
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

