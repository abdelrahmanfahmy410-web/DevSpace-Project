<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    //
    protected $fillable = ['user_id', 'portfolio_url','specialization_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function specialization()
    {
        return $this->hasone(Specialization::class);
    }   

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'developer_skills');
    }

}
