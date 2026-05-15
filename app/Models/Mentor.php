<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    //
    protected $fillable = ['organization', 'user_id', 'experience_years'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function specializations()
    {
        return $this->belongsTo(Specialization::class, 'mentor_specializations');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'mentor_skills');
    }
}
