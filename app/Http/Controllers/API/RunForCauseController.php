<?php

namespace App\Http\Controllers\API;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use mysql_xdevapi\Exception;

class RunForCauseController extends Controller
{
    public function mytoken(Request $request)
    {
        if (Auth::attempt(['email' => $request->input('username'), 'password' => $request->input('password')])) {
            return Auth::user()->apiClient->api_token;
        } else {
            return response('bad credentials',401);
        }
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
     * Store a waypoint.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find(Auth::user()->user_id);
        $lat = $request->input('lat');
        $long = $request->input('long');
        return $user->name." @ $lat / $long";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    public function showCurrentUser()
    {
        return Helpers::trim(User::find(Auth::user()->user_id)->toArray(),["id", "name", "phone", "email", "phone", "picture"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->input('_method') == 'PATCH') {
            try {
                $user = User::find(Auth::user()->user_id);
                $user->name = $request->has('name') ? $request->input('name') : $user->name;
                $user->email = $request->has('email') ? $request->input('email') : $user->email;
                $user->phone = $request->has('phone') ? $request->input('phone') : $user->phone;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
