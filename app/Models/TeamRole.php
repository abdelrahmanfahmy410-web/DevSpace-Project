<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamRole extends Model
{
    
    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_team_roles');
    }
    public function projects()
    {
        return $this->belongsToMany(Team::class, 'team_team_roles');
    }
}
