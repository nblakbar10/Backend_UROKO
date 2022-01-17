<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetHotelProviderExtraAmminities extends Model
{
    use HasFactory;
    public $table = "pethotel_provider_extraamminities"; 
    protected $fillable = [
        'pet_hotel_provider_id',
        'user_id', //id si user yg ngebooking
        'check_in_date',
        'check_out_date',
        'total_days',
        
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
