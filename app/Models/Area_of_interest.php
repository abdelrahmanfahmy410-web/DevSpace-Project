<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area_of_interest extends Model
{
    //
    protected $fillable = ['user_id', 'interest'];
    public function user(){
        return $this->belongsTo(User::class);
        }

}
