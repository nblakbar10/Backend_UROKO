<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionOrder extends Model
{
    use HasFactory;
    public $table = "adoption_order";
    protected $fillable = [
        'user_id',
        // 'username',
        // 'phone_number',
        // 'address',
        'merchant_id',
        // 'merchant_name',
        'adoption_item_id',
        'pet_id',
        // 'adoption_item_price',
        'adoption_order_notes',
        'shipping_id',
        // 'shipping_type',
        // 'shipping_fee',
        'grand_total_order',
        'payments_option',
        'adoption_order_status'
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
