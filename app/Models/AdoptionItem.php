<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionItem extends Model
{
    use HasFactory;
    public $table = "adoption_item";
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
        'adoption_item_price'
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
