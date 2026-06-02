<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title','description','repository_link','live_demo_link','type'];
    //teamrole
    public function team_roles()
    {
        return $this->belongsToMany(User::class, 'team_roles')->withPivot('role');
    }
    //watchlist
    public function watchers()
    {
        return $this->belongsToMany(User::class, 'project_user_watchlist');
    }

    public function skills()
     {
         return $this->belongsToMany(Skill::class, 'project_skills', 'project_id', 'skill_id');
    }
    
    public function specializations()
    {
        return $this->belongsToMany(Specialization::class, 'project_specializations', 'project_id', 'specialization_id');
    }

    public function media()
    {
        // ربطنا المشروع بموديل الـ ProjectMedia اللي عملناه في الخطوة 2
        return $this->hasMany(ProjectMedia::class, 'project_id'); 
    }


}
