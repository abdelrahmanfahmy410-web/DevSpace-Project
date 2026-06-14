<?php

namespace App\Models;
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    use HasFactory;

    protected $fillable = ['follower_id', 'following_id'];
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }
    public function following()
    {
        return $this->belongsTo(User::class, 'following_id');
    }

    class FollowController extends Controller
{
    public function toggle(Request $request, $id)
    {
  
        $userToFollow = User::findOrFail($id);

        
        $status = auth()->user()->following()->toggle($userToFollow->id);

        return response()->json([
            'status' => count($status['attached']) > 0 ? 'followed' : 'unfollowed',
        ]);
    }
    
}
