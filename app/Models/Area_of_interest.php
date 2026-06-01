<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area_of_interest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'specializations_id'];

}
