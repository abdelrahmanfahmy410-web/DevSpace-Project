<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Search users by name or email
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
      
    $q = $request->input('q', '');

    $users = User::where('name', 'LIKE', "%{$q}%")
        ->orWhere('email', 'LIKE', "%{$q}%")
        ->limit(10)
        ->get()
        ->map(fn($u) => [
            'value' => $u->id,
            'text'  => $u->name . ' (' . $u->email . ')',
        ]);

    return response()->json($users);
    }
}

