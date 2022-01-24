<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetGallery extends Model
{
    use HasFactory;
    public $table = 'pet_gallery';
    protected $fillable =[
        'user_id',
        'album_name',
        'album_picture',
        'album_picture2',
        'album_type'
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
