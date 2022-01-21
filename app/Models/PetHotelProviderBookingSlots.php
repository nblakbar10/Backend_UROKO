<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetHotelProviderBookingSlots extends Model
{
    use HasFactory;
    public $table = "pethotel_provider_booking_slots"; 
    protected $fillable = [
        'pet_hotel_provider_id',
        'user_id', //id si user yg ngebooking
        'pet_type', // tipe pet yg dititipin
        'check_in_date',
        'check_out_date',
        'total_days',
        'status',
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
