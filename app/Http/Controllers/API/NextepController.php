<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;

class NextepController extends Controller
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
            'email' => $user->email,
            'username' => $user->name,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'picture' => $user->picture,
            'creation_date' => $user->created_at,
            'last_logged_date' => $user->last_login,
            'wallet_address' => $user->wallet_address,
            'two_factor_auth' => $user->two_factor_auth,
            'description' => $user->description,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->input('_method') == 'PATCH') {
            try {
                $user = User::find(Auth::user()->user_id);
                $user->name = $request->has('username') ? $request->input('username') : $user->name;
                $user->email = $request->has('email') ? $request->input('email') : $user->email;
                $user->firstname = $request->has('firstname') ? $request->input('firstname') : $user->firstname;
                $user->lastname = $request->has('lastname') ? $request->input('lastname') : $user->lastname;
                $user->wallet_address = $request->has('wallet_address') ? $request->input('wallet_address') : $user->wallet_address;
                $user->two_factor_auth = $request->has('two_factor_auth') ? $request->input('two_factor_auth') : $user->two_factor_auth;
                $user->description = $request->has('description') ? $request->input('description') : $user->description;
                $user->save();
                return response("Ok",200);
            } catch (Exception $e) {
                return response('bad request',400);
            }
        } else {
            return response('Only PATCH method allowed', 405);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
