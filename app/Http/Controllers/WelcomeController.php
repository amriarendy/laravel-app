<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WelcomeController extends Controller
{
    public function index()
    {
        $latest = DB::table('blogs')
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
            ->limit(6)
            ->get();
        $tranding = DB::table('blogs')
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
        ->whereDate('views.created_at', date('Y-m-d')) // Filter by date
        ->groupBy('blogs.id', 'blogs.title', 'blogs.description', 'blogs.body', 'blogs.image', 'blogs.slug', 'blogs.date_post', 'blogs.category_id', 'blogs.created_at', 'users.name', 'master_categories.category')
        ->orderBy('view_count', 'desc')
        ->limit(6)
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
        return view('welcome', compact('meta', 'latest', 'tranding', 'categories'));
    }

    public function blog(Request $request, $param=null)
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
        if ($param) {
            $data = DB::table('blogs')
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
                ->paginate(12);
        } else {
            $data = DB::table('blogs')
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
                ->paginate(12);
        }
        $view = DB::table('views')->insert([
            'blog_id' => null,
            'route' => URL::current(),
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);
        return view('content.index', compact('meta', 'data', 'categories'));
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
        $keywords = DB::table('keywords')
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
        $tranding = DB::table('blogs')
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
        ->whereDate('views.created_at', date('Y-m-d')) // Filter by date
        ->groupBy('blogs.id', 'blogs.title', 'blogs.description', 'blogs.body', 'blogs.image', 'blogs.slug', 'blogs.date_post', 'blogs.category_id', 'blogs.created_at', 'users.name', 'master_categories.category')
        ->orderBy('view_count', 'desc')
        ->limit(6)
        ->get();
        $view = DB::table('views')->insert([
            'blog_id' => null,
            'route' => URL::current(),
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);
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
        return view('content.detail', compact('meta', 'data', 'files', 'categories', 'keywords', 'tranding'));
    }

    public function captcha()
    {
        return response()->json(['captcha' => captcha_img('flat')]);
    }
}
