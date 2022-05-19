<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FiameController extends Controller
{
    public function mytoken(Request $request)
    {
        if (Auth::attempt(['email' => $request->input('username'), 'password' => $request->input('password')])) {
            return Auth::user()->apiClient->api_token;
        } else {
            return response('bad credentials', 401);
        }
    }

    public function profile()
    {
        $user = User::findOrFail(Auth::user()->user_id);
        return [
            'id' => $user->id,
            'username' => $user->name,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'picture' => $user->picture,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];
    }

    public function mypurchases()
    {
        return User::find(Auth::user()->id)->batches;
    }
}
