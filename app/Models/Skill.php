<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function specializations()
    {
        return $this->belongsToMany(Specialization::class, 'specialization_skills', 'skill_id', 'specialization_id');
    }

      public function mentors()
    {
        return $this->belongsToMany(Mentor::class, 'mentor_specializations');
    }

    public function developer()
    {
        return $this->belongsToMany(Developer::class, 'developer_skills');
    }

        public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_skill');
    }

}
