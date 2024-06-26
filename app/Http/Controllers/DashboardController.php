<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use DOMDocument;

class DashboardController extends Controller
{
    public function index()
    {
        $m = date('m');
        $dataOnYear = '';
        for ($m = 1; $m <= 12; $m++) {
            $year = date('Y');
            $query = DB::table('views')
                ->whereMonth('created_at', '=', $m)
                ->whereYear('created_at', '=', $year)
                ->where('route', '=', url('/'))
                ->count();
            $dataOnYear .= "$query" . ", ";
        }

        $today = date('Y-m-d');
        $year = date('Y', strtotime($today));
        $month = date('m', strtotime($today));
        $day = date('d', strtotime($today));
        $dataOnToday = DB::table('views')
            ->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->whereDay('created_at', '=', $day)
            ->where('route', '=', url('/'))
            ->count();
        $dataTotal = DB::table('views')
            ->where('route', '=', url('/'))
            ->count();
        $totalBlog = DB::table('blogs')
            ->count();
        $totalTag = DB::table('master_tags')
            ->count();
        $trends = DB::table('blogs')
            ->leftJoin('users', 'blogs.user_id', '=', 'users.id')
            ->leftJoin('master_categories', 'blogs.category_id', '=', 'master_categories.id')
            ->leftJoin('views', 'blogs.id', '=', 'views.blog_id') // Left join with views table
            ->select(
                'blogs.id',
                'blogs.title',
                'blogs.description',
                'blogs.body',
                'blogs.image',
                'blogs.slug',
                'blogs.date_post',
                'blogs.category_id',
                'blogs.created_at',
                'users.name AS name',
                'master_categories.category AS category',
                DB::raw('COUNT(views.blog_id) AS view_count'), // Select the count of views
            )
            ->whereDate('views.created_at', date('Y-m-d')) // Filter by 
            ->groupBy('blogs.id', 'blogs.title', 'blogs.description', 'blogs.body', 'blogs.image', 'blogs.slug', 'blogs.date_post', 'blogs.category_id', 'blogs.created_at', 'users.name', 'master_categories.category')
            ->orderBy('view_count', 'desc')
            ->limit(10)
            ->get();
        $setting = DB::table('metas')->where('id', 1)->first();
        $meta = [
            'title' => "Dashboard - " . $setting->title ?? '',
            'description' => $setting->description ?? '',
            'favicon' => asset($setting->favicon) ?? '',
            'keywords' => $setting->keywords ?? '',
            'author' => $setting->author ?? '',
            'image' => asset($setting->image) ?? '',
            'copyright' => $setting->copyright ?? '',
            'canonical' => URL::current() ?? '',
            'robots' => $setting->robots ?? '',
            'googlebot' => $setting->googlebot ?? '',
            'googlebotnews' => $setting->googlebotnews ?? '',
            'sitename' => $setting->sitename ?? '',
        ];
        return view('dashboard', compact('dataOnYear', 'dataOnToday', 'dataTotal', 'totalBlog', 'totalTag', 'trends', 'meta'));
    }

    public function profile()
    {
        $data = DB::table('users')
            ->select(
                'users.id',
                'users.email',
                'users.name',
                'users.picture',
            )
            ->where('users.id', Auth::user()->id)
            ->first();
            $setting = DB::table('metas')->where('id', 1)->first();
            $meta = [
                'title' => "Dashboard - " . $setting->title ?? '',
                'description' => $setting->description ?? '',
                'favicon' => asset($setting->favicon) ?? '',
                'keywords' => $setting->keywords ?? '',
                'author' => $setting->author ?? '',
                'image' => asset($setting->image) ?? '',
                'copyright' => $setting->copyright ?? '',
                'canonical' => URL::current() ?? '',
                'robots' => $setting->robots ?? '',
                'googlebot' => $setting->googlebot ?? '',
                'googlebotnews' => $setting->googlebotnews ?? '',
                'sitename' => $setting->sitename ?? '',
            ];
        return view('profile', compact('data', 'meta'));
    }

    public function profile_update(Request $request)
    {
        $rules = $request->validate(
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Name is required',
            ]
        );
            if ($request->cropped) {
                if (File::exists('uploads/profile/' . Auth::user()->picture)) {
                    if (Auth::user()->picture !== "default.svg") {
                        File::delete('uploads/profile/' . Auth::user()->picture);
                    }
                }
                $image_parts = explode(";base64,", $request->cropped);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $imageName = Str::slug(pathinfo(Auth::user()->email, PATHINFO_FILENAME)) . '-' .  Str::random(5) . '.png';
                $filePath = public_path('uploads/profile/' . $imageName);
                file_put_contents($filePath, $image_base64);
                $update = User::where('id', Auth::user()->id)->update([
                    'name' => $request->name,
                    'picture' => $imageName,
                ]);
            } else {
                $update = User::where('id', Auth::user()->id)->update([
                    'name' => $request->name,
                ]);
            }
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Data berhasil di update',
            ]);
    }

    public function change_password(Request $request)
    {
        $rules = $request->validate(
            [
                'password' => 'required',
                'password_confirm' => 'required|same:password',
            ],
            [
                'password.required' => 'Input password tidak boleh kosong',
                'password_confirm.required' => 'Input konfirmasi password tidak boleh kosong',
                'password_confirm.same' => 'Konfirmasi password harus sama',
            ]
        );
            $change_password = User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($request->password),
            ]);
            return response()->json([
                'code' => 201,
                'status' => 'success',
                'message' => 'Data berhasil di input',
            ]);
    }

    function delete_file($param)
    {
        if ($param) {
            $data = DB::table('archives')->where('id', $param)->first();
            $picturePath = 'uploads/files/' . $data->file;
            if (File::exists($picturePath)) {
                File::delete($picturePath);
                DB::table('archives')->where('id', $param)->delete();
            }
        }
        return response()->json(['success' => true, 'li' => 'li_' . $param]);
    }

    function image_upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::slug(pathinfo(time(), PATHINFO_FILENAME), '-') . '.' . $image->getClientOriginalExtension();
            $path = 'uploads/posts/';
            $image->move(public_path($path), $imageName); // Use public_path() to get the full server path
            $imageUrl = url($path . $imageName); // Generate full URL using url() helper
            return response()->json(['url' => $imageUrl]);
        }
        return response()->json(['error' => 'No image uploaded.'], 400);
    }

    function image_delete(Request $request)
    {
        $filename = $request->input('filename');
        $path = 'uploads/posts/' . $filename;
        if ($filename && File::exists($path)) {
            File::delete($path);

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Image deleted successfully.'
            ]);
        }
        return response()->json([
            'code' => 400,
            'status' => 'error',
            'message' => 'Bad Request'
        ]);
    }
}
