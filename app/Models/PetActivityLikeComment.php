<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetActivityLikeComment extends Model
{
    use HasFactory;
    public $table = 'likes_comments';
    protected $fillable =[
        'pet_activity_id',
        'user_id',
        'likes',
        'comments',
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
