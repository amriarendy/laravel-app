<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $data = DB::table('users')
            ->select(
                'users.id',
                'users.name',
                'users.email',
            )->orderBy('created_at', 'desc')
            ->get();
        return view('user', compact('data'));
    }

    public function store(Request $request)
    {
        $rules = $request->validate(
            [
                'email' => 'required|string|lowercase|email|max:255|unique:users',
                'name' => 'required|string|max:255',
                'password' => 'required', Rules\Password::defaults(),
                'password_confirm' => 'required|same:password',
            ],
            [
                'email.required' => 'email is required',
                'email.email' => 'email field must be a valid email address',
                'email.unique' => 'email has already been taken',
                'name.required' => 'full name is required',
                'password.required' => 'password is required',
                'password_confirm.required' => 'password confirm is required',
                'password_confirm.same' => 'password confirm must match password',
            ]
        );
        if ($request->hasFile('picture')) {
            $picture = $request->file('picture');
            $email = $request->email;
            $pictureName = Str::slug(pathinfo(time() . "_" . $email, PATHINFO_FILENAME), '-') . '.' . $picture->getClientOriginalExtension();
            $path = 'public/uploads/picture';
            $picture->move($path, $pictureName);
        } else {
            $pictureName =  null;
        }
        $insert = DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'picture' => $pictureName,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => "Success create data",
        ]);
    }

    public function update(Request $request)
    {
        $rules = $request->validate(
            [
                'email' => 'required|string|lowercase|email|max:255|unique:users',
                'name' => 'required|string|max:255',
            ],
            [
                'email.required' => 'email is required',
                'email.email' => 'email field must be a valid email address',
                'email.unique' => 'email has already been taken',
                'name.required' => 'full name is required',
            ]
        );
        if ($request->hasFile('picture')) {
            $picture = $request->file('picture');
            $email = $request->email;
            $data = DB::table('users')->where('id', $request->input('id'))->first();
            $picturePath = 'public/uploads/picture/' . $data->picture;
            if (File::exists($picturePath)) {
                File::delete($picturePath);
            }
            $pictureName = Str::slug(pathinfo(time() . "_" . $email, PATHINFO_FILENAME), '-') . '.' . $picture->getClientOriginalExtension();
            $path = 'public/uploads/picture';
            $picture->move($path, $pictureName);
        } else {
            $pictureName =  null;
        }
        $insert = DB::table('users')
            ->where('id', $request->input('id'))
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'picture' => $pictureName,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => "Success update data",
        ]);
    }

    public function destroy(Request $request)
    {
        if (!$request->isMethod('post')) {
            abort(404);
        }
        $data = DB::table('users')->where('id', $request->input('id'))->first();
        $picturePath = 'public/uploads/picture/' . $data->picture;
        if (File::exists($picturePath)) {
            File::delete($picturePath);
        }
        $delete = DB::table('users')->where('id', $request->input('id'))->delete();
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => "Success delete data"
        ]);
    }

    public function update_password(Request $request)
    {
        $rules = $request->validate(
            [
                'password' => 'required', Rules\Password::defaults(),
                'password_confirm' => 'required|same:password',
            ],
            [
                'password.required' => 'password is required',
                'password_confirm.required' => 'password confirm is required',
                'password_confirm.same' => 'password confirm must match password',
            ]
        );
        $updatePassword = DB::table('users')
            ->where('id', $request->input('id'))
            ->update([
                'password' => Hash::make($request->password),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => "Success update password",
        ]);
    }
}
