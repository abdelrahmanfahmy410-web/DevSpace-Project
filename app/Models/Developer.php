<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'portfolio_url','specialization_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function specialization()
    {
        return $this->belongsTo(Specialization::class, 'specialization_id');
    }   

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'developer_skills');
    }

}
