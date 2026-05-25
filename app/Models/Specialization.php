<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $fillable = ['name'];
    //area of interset
    //select * from users where id in (select user_id from area_of_interests where specialization_id = 1)
    public function users()
    {
        return $this->belongsToMany(User::class, 'area_of_interests');
    }
    //deve
    public function developers()
    {
        return $this->belongsToMany(Developer::class);
    }
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'specialization_skills');
    }
    //metor
    public function mentors()
    {
        return $this->hasMany(Mentor::class);
    }
            public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_specializations');
    }

  
}

