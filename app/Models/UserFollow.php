<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model
{
    protected $table = 'user_follow';

    protected $fillable = [
        'user_id',
        'user_yg_difollow_id', 

    // public function users(){
    //     return $this->belongsToMany(User::class, 'user_id');
    // }
    ];  
    
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i'
    ];
}
