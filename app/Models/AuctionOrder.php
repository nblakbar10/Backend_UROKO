<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionOrder extends Model
{
    use HasFactory;
    public $table = "auction_order";
    protected $fillable = [
        'user_id',
        // 'username',
        // 'phone_number',
        // 'address',
        'merchant_id',
        // 'merchant_name',
        'auction_item_id',
        'pet_id',
        'bid_order_set',
        'bid_status',
        'bid_comments',
        'shipping_id',
        // 'shipping_type',
        // 'shipping_fee',
        'grand_total_order',
        'payments_option',
        'auction_order_status'
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
