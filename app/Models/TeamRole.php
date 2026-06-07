<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamRole extends Model
{
    use HasFactory;

    protected $fillable = ['role', 'project_id', 'user_id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_team_roles');
    }
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_team_roles');
    }
}
