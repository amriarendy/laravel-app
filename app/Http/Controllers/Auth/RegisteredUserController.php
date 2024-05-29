<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $rules = $request->validate(
            [
                'email' => 'required|string|lowercase|email|max:255|unique:users',
                'name' => 'required|string|max:255',
                'password' => 'required|confirmed', Rules\Password::defaults(),
                'password_confirm' => 'required|same:password',
                'captcha' => 'required|captcha',
            ],
            [
                'email.required' => 'email is required',
                'email.email' => 'email field must be a valid email address',
                'email.unique' => 'email has already been taken',
                'name.required' => 'full name is required',
                'password.required' => 'password is required',
                'password_confirm.required' => 'password confirm is required',
                'password_confirm.same' => 'password confirm must match password',
                'captcha.required' => 'captcha is required',
                'captcha.captcha' => 'captcha failed, reload captcha!',
            ]
        );
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'picture' => "default.png",
        ]);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Success created account!',
        ]);
        // event(new Registered($user));

        // Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);
    }
}
