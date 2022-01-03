<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionItem extends Model
{
    use HasFactory;
    public $table = "auction_item";
    protected $fillable = [
        'pet_id',
        'pet_picture',
        'pet_name',
        'pet_age',
        'pet_species',
        'pet_breed',
        'qty',
        'description',
        'merchant_id',
        'merchant_name',
        'merchant_location',
        'auction_bid_start'
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
