<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    //
    protected $fillable = ['user_id', 'organization'];  
    public function user(){ 
        return $this->belongsTo(User::class);
    }


}
