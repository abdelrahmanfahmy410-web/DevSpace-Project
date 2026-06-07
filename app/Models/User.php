<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Project;
use App\Models\TeamRole;


#[Fillable(['name', 'email', 'password','bio', 'linkedin_url', 'phonenumber', 'profile_picture'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    //mennea.aml,abderahman,rehab
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    protected $fillable = ['name', 'email', 'password', 'bio', 'linkedin_url', 'phonenumber', 'profile_picture'];
    
    public function roles()
    {
       return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }
    //watchlist
    public function watchlist()
    {
        return $this->hasMany(Project::class, 'watchlist');
    }
    //
    public function areaOfInterests()
    {
        return $this->hasMany(Specialization::class, 'area_of_interests');
    }
    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    } 
   public function teamProjects()
    {
        return $this->belongsToMany(Project::class, 'team_roles', 'user_id', 'project_id')
            ->withPivot('role')
            ->withTimestamps();
    }
    
    //is -a
     public function mentor()
    {
        return $this->hasOne(Mentor::class);
    }
    public function developer()
    {
        return $this->hasOne(Developer::class);
    }
    public function investor(){
        return $this->hasOne(Investor::class);
        
    } 

    public function wishlist()
{
    return $this->belongsToMany(Project::class, 'project_user_watchlist');
}
    
 public function teamRoles()
{
    return $this->hasMany(TeamRole::class);
} 

}