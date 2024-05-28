<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use App\Models\User;

class WelcomeController extends Controller
{
    public function captcha()
    {
        return response()->json(['captcha' => captcha_img('flat')]);
    }

    public function test(Request $request)
    {
        $rules = $request->validate(
            [
                'email' => 'required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class,
                'name' => 'required', 'string', 'max:255',
                'password' => 'required', 'confirmed', Rules\Password::defaults(),
                'password_confirm' => 'required|same:password',
                'captcha' => 'required|captcha',
            ],
            // [
            //     'email.required' => 'email is required',
            //     'email.unique' => 'email exist',
            //     'email.email' => 'valid email format',
            //     'name.required' => 'full name is required',
            //     'password.required' => 'password is required',
            //     'password_confirm.required' => 'password confirm is required',
            //     'password_confirm.same' => 'password confirm must match password',
            //     'captcha.required' => 'captcha is required',
            //     'captcha.captcha' => 'captcha failed, reload captcha!',
            // ]
        );
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Success created account!',
        ]);
    }
}
