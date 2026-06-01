<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use HasFactory;

    protected $fillable = ['organization', 'user_id', 'experience_years','specialization_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function specializations()
    {
        return $this->hasone(Specialization::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'mentor_skills');
    }
}
