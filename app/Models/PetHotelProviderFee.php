<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetHotelProviderFee extends Model
{
    use HasFactory;
    use HasFactory;
    public $table = "pet_hotel_provider_fee"; 
    protected $fillable = [
        'pet_hotel_provider_id',
        'pet_type', 
        'pet_size',
        'slot_available',
        'price_per_day',
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
