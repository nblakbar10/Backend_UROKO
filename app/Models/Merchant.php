<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;
    public $table = "merchant";
    protected $fillable = [
        'id_user',
        'merchant_name',
        'merchant_image',
    ];
   
}
