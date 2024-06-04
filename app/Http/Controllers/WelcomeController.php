<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WelcomeController extends Controller
{
    public function index()
    {
        $blog_latest = DB::table('blogs')
            ->select(
                'blogs.id',
                'blogs.title',
                'blogs.description',
                'blogs.image',
                'blogs.slug',
                'blogs.date_post',
                'blogs.category_id',
                'blogs.created_at',
                'users.name',
            )
            ->join('users', 'blogs.user_id', '=', 'users.id')
            ->where('category_id', 'berita')
            ->orderBy('date_post', 'desc')
            ->limit(6)
            ->get();
        $blog_trending = DB::table('blogs')
            ->select(
                'blogs.id',
                'blogs.title',
                'blogs.description',
                'blogs.image',
                'blogs.slug',
                'blogs.date_post',
                'blogs.category_id',
                'blogs.created_at',
                'users.name',
            )
            ->join('users', 'blogs.user_id', '=', 'users.id')
            ->where('category_id', 'berita')
            ->orderBy('date_post', 'desc')
            ->limit(3)
            ->get();
        $view = DB::table('views')->insert([
            'blog_id' => null,
            'route' => URL::current(),
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);
        $categories = DB::table('master_categories')->get();
        $setting = DB::table('metas')->where('id', 1)->first();
        $meta = [
            'title' => $setting->title ?? '',
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
        return view('welcome', compact('meta', 'blog_latest', 'blog_trending', 'categories'));
    }

    public function blog()
    {
        $categories = DB::table('master_categories')->get();
        $setting = DB::table('metas')->where('id', 1)->first();
        $meta = [
            'title' => $setting->title ?? '',
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
        $blog = DB::table('blogs')
            ->select(
                'blogs.id',
                'blogs.title',
                'blogs.description',
                'blogs.image',
                'blogs.slug',
                'blogs.date_post',
                'blogs.category_id',
                'blogs.created_at',
                'users.name',
            )
            ->join('users', 'blogs.user_id', '=', 'users.id')
            ->orderBy('date_post', 'desc')
            ->limit(12)
            ->get();
        $view = DB::table('views')->insert([
            'blog_id' => null,
            'route' => URL::current(),
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);
        return view('content.index', compact('meta', 'blog', 'categories'));
    }

    public function blog_category(Request $request, $param)
    {
        $blog = DB::table('blogs')
            ->select(
                'blogs.id',
                'blogs.title',
                'blogs.description',
                'blogs.image',
                'blogs.slug',
                'blogs.date_post',
                'blogs.category_id',
                'blogs.created_at',
                'users.name',
            )
            ->where('category_id', $param)
            ->join('users', 'blogs.user_id', '=', 'users.id')
            ->orderBy('date_post', 'desc')
            ->limit(12)
            ->get();
    }

    public function detail(Request $request, $param)
    {
        $data = DB::table('blogs')
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
                'users.name',
            )
            ->join('users', 'blogs.user_id', '=', 'users.id')
            ->where('slug', $param)
            ->first();
        $files = DB::table('archives')
            ->where('blog_id', $data->id)
            ->get();
        $view = DB::table('views')->insert([
            'blog_id' => $data->id,
            'route' => URL::current(),
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);
        $categories = DB::table('master_categories')->get();
        $setting = DB::table('metas')->where('id', 1)->first();
        $meta = [
            'title' => $setting->title ?? '',
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
        return view('content.detail', compact('meta', 'data', 'files', 'categories'));
    }

    public function captcha()
    {
        return response()->json(['captcha' => captcha_img('flat')]);
    }
}
