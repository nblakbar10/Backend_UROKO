<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentItem extends Model
{
    use HasFactory;
    public $table = "rent_item";
    protected $fillable = [
        'user_id',
        'pet_id',
        // 'pet_picture',
        // 'pet_name',
        // 'pet_age',
        // 'pet_species',
        // 'pet_breed',
        'qty',
        'description',
        'merchant_id',
        // 'merchant_name',
        // 'merchant_location',
        'rent_item_price',
        'rent_item_status'
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
