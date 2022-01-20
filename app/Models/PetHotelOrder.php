<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetHotelOrder extends Model
{
    use HasFactory;
    public $table = "pet_hotel_order"; //dari sisi pembeli/consumer
    protected $fillable = [
        'user_id',
        'pet_profile_id',
        'pet_hotel_provider_id', //diambil dari params pas consument melakukan order pethotel
        'cage',
        'pet_caring_note',
        'check_in_date',
        'check_out_date',
        'total_days',
        // 'pethotel_amminities_selected_id',
        'pethotel_order_status',
        'shipping_id',
        'payments_option_id',
        'pethotel_total_price'
      
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
