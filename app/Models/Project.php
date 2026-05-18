<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'repository_link',
        'live_demo_link',
        'type'
    ];
    //teamrole
    public function member()
    {
        return $this->belongsToMany(User::class, 'TeamRole');
    }
    //watchlist
    public function watchers()
    {
        return $this->belongsToMany(User::class, 'project_user_watchlist');
    }
} 
