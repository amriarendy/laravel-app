<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function captcha()
    {
        return response()->json(['captcha' => captcha_img('flat')]);
    }
}
