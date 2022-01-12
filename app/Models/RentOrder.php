<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentOrder extends Model
{
    use HasFactory;
    public $table = "rent_order";
    protected $fillable = [
        'user_id',
        // 'username',
        // 'phone_number',
        // 'address',
        'merchant_id',
        // 'merchant_name',
        'pet_id',

        'rent_item_id',
        // 'rent_item_price',
        'rent_order_start',
        'rent_order_return',
        'rent_order_duration',
        'rent_order_notes',

        'shipping_id',
        // 'shipping_type',
        // 'shipping_fee',
        'grand_total_order',
        'payments_option_id',
        'rent_order_status'
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
