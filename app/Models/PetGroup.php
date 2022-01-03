<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetGroup extends Model
{
    use HasFactory;
    public $table = 'pet_grouping';
    protected $fillable =[
        'user_id',
        'pet_group_name'
    ];
}
