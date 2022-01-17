<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetActivity extends Model
{
    use HasFactory;
    public $table = 'pet_activity';
    protected $fillable =[
        'pet_group_id',
        'user_id',
        'pet_id',
        'pet_activity_type',
        'pet_activity_detail',
        'pet_activity_date',
        'pet_activity_image'
    ];
    protected $casts = [
        'pet_activity_image' => 'array',
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
