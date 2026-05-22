<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'user_id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
