<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetProfile extends Model
{
    use HasFactory;
    public $table = 'pet_profile';
    protected $fillable = [
        'pet_name',
        'user_id',
        'pet_group_id',
        'pet_species',
        'pet_breed',
        'pet_morph',
        'pet_birthdate',
        'pet_age',
        'pet_description',
        'pet_picture',
        'pet_status',
    ];
    protected $casts = [
        'pet_picture' => 'array',
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
