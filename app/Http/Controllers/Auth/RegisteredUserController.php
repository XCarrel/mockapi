<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ApiClient;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // assume fname.lnname@some.com
        $parts = explode('@', $request->email);
        $parts = explode('.',$parts[0]);
        $fname = $parts[0] ?: '???';
        $lname = $parts[1] ?: '???';
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'firstname' => $fname,
            'lastname' => $lname,
            'phone' => '07'.rand(70000000, 99999999),
            'picture' => 'g'.(rand(1,8)).'.png',
            'password' => Hash::make($request->password),
        ]);

        $api = new ApiClient();
        $api->api_token = Str::random(60);
        $api->user()->associate($user);
        $api->save();

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
