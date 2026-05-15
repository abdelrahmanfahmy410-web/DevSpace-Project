<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $fillable = ['name'];
    public function users()
    {
        return $this->belongsToMany(User::class, 'area_of_interests');
    }
    
    public function developers()
    {
        return $this->belongsToMany(Developer::class);
    }
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'specialization_skills');
    }

    public function mentors()
    {
        return $this->hasMany(Mentor::class, 'mentor_specializations');
    }

  
}

