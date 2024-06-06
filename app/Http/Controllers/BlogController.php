<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Blog;
use Carbon\Carbon;
use DOMDocument;

class BlogController extends Controller
{
    public function index()
    {
        $data = DB::table('blogs')
            ->leftJoin('users', 'blogs.user_id', '=', 'users.id')
            ->leftJoin('master_categories', 'blogs.category_id', '=', 'master_categories.id')
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
                'master_categories.category AS category'
            )
            ->leftJoin('views', 'blogs.id', '=', 'views.blog_id') // Left join with views table
            ->selectRaw('COUNT(views.blog_id) AS view_count') // Select the count of views
            ->groupBy('blogs.id')
            ->orderBy('blogs.created_at', 'DESC') // Order by created_at column
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
        return view('blog.index', compact('data', 'meta'));
    }

    public function create()
    {
        $categories = DB::table('master_categories')->select('id', 'category')->orderBy('created_at', 'desc')->get();
        $keywords = DB::table('master_tags')->select('tag')->orderBy('created_at', 'desc')->get();
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
        return view('blog.add', compact('categories', 'keywords', 'meta'));
    }

    public function store(Request $request)
    {
        $rules = $request->validate(
            [
                'title' => 'required|min:5|max:255',
                'description' => 'required|max:255',
                'category' => 'required',
                'body' => 'required',
                'slug' => 'required|unique:blogs',
                'files.*' => 'nullable|mimes:jpeg,jpg,png,ppt,pptx,doc,docx,pdf,xls,xlsx|max:10000',
                'date_post' => 'required',
            ],
            [
                'title.required' => 'Title is required',
                'title.min' => 'min: 5 character',
                'title.max' => 'max: 255 character',
                'description.required' => 'Description is required',
                'description.max' => 'max: 255 character',
                'category.required' => 'Category is required',
                'body.required' => 'Content is required',
                'slug.required' => 'Slug is required',
                'slug.unique' => 'Data slug available',
                'files.mimes' => 'Allowed Ext: jpeg,jpg,png,ppt,pptx,doc,docx,pdf,xls,xlsx',
                'files.max' => 'File max: 10mb',
                'date_post.required' => 'Date is required',
            ]
        );

        if ($request->croppedImage) {
            $image_parts = explode(";base64,", $request->croppedImage);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $imageName = Str::slug(pathinfo($request->title, PATHINFO_FILENAME)) . '-' .  Str::random(5) . '.png';
            $filePath = public_path('uploads/thumb/' . $imageName);
            file_put_contents($filePath, $image_base64);
            $insert = Blog::create([
                'title' => $request->title,
                'description' => $request->description,
                'body' => $request->body,
                'image' => $imageName ?? null, // Use $imageName if available
                'slug' => $request->slug,
                'date_post' => $request->date_post,
                'category_id' => $request->category,
                'user_id' => Auth::user()->id,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        } else {
            $insert = Blog::create([
                'title' => $request->title,
                'description' => $request->description,
                'body' => $request->body,
                'slug' => $request->slug,
                'date_post' => $request->date_post,
                'category_id' => $request->category,
                'user_id' => Auth::user()->id,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        }

        $blogID = $insert->id;
        $files = [];
        if ($request->hasFile('archives')) {
            $archive = $request->file('archives');
            foreach ($archive as $file) {
                $title = $request->title;
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $fileName = Str::slug(pathinfo($filename, PATHINFO_FILENAME)) . "-" . time() . "." . $extension;
                $destinationPath = 'uploads/files' . '/';
                $file->move($destinationPath, $fileName);
                $files[] = [
                    'file' => $fileName,
                    'sort_by' => "article-file",
                    'blog_id' => $blogID,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];
            }
            DB::table('archives')->insert($files);
        }

        $tags = $request->tag;
        if ($tags) {
            foreach ($tags as $tag) {
                DB::table('keywords')->insert([
                    'blog_id' => $blogID,
                    'tag' => $tag,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            }
        }

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Success create data',
        ]);
    }

    public function edit(Request $request, $param)
    {
        $data = DB::table('blogs')
            ->leftJoin('users', 'blogs.user_id', '=', 'users.id')
            ->select(
                'blogs.id as id',
                'blogs.title',
                'blogs.description',
                'blogs.body',
                'blogs.image',
                'blogs.slug',
                'blogs.date_post',
                'blogs.category_id',
                'users.name',
            )
            ->where('blogs.id', decrypt($param))
            ->first();
        $categories = DB::table('master_categories')
            ->select('id', 'category')->orderBy('created_at', 'desc')
            ->get();
        $tags = DB::table('master_tags')
            ->select('tag')->orderBy('created_at', 'desc')
            ->get();
        $archives = DB::table('archives')
            ->select('file', 'id', 'blog_id')
            ->where('blog_id', decrypt($param))->orderBy('created_at', 'desc')
            ->get();
        $keywords = DB::table('keywords')
            ->select('id', 'tag', 'blog_id')
            ->where('blog_id', decrypt($param))
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
        return view('blog.edit', compact('data', 'categories', 'keywords', 'archives', 'tags', 'meta'));
    }

    public function update(Request $request)
    {
        if ($param = $request->id) {
            $where = DB::table('blogs')->select('*')->where('id', $param)->first();
            $rules = $request->validate(
                [
                    'title' => 'required|min:5|max:255',
                    'description' => 'required|max:255',
                    'category' => 'required',
                    'body' => 'required',
                    'slug' => 'required|unique:blogs',
                    'files.*' => 'nullable|mimes:jpeg,jpg,png,ppt,pptx,doc,docx,pdf,xls,xlsx|max:10000',
                    'date_post' => 'required',
                ],
                [
                    'title.required' => 'Title is required',
                    'title.min' => 'min: 5 character',
                    'title.max' => 'max: 255 character',
                    'description.required' => 'Description is required',
                    'description.max' => 'max: 255 character',
                    'category.required' => 'Category is required',
                    'body.required' => 'Content is required',
                    'slug.required' => 'Slug is required',
                    'slug.unique' => 'Data slug available',
                    'files.mimes' => 'Allowed Ext: jpeg,jpg,png,ppt,pptx,doc,docx,pdf,xls,xlsx',
                    'files.max' => 'File max: 10mb',
                    'date_post.required' => 'Date is required',
                ]
            );

            if ($request->croppedImage) {
                if (File::exists('uploads/thumb/' . $where->image)) {
                    File::delete('uploads/thumb/' . $where->image);
                }
                $image_parts = explode(";base64,", $request->croppedImage);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $imageName = Str::slug(pathinfo($request->title, PATHINFO_FILENAME)) . '-' .  Str::random(5) . '.png';
                $filePath = public_path('uploads/thumb/' . $imageName);
                file_put_contents($filePath, $image_base64);
                $update = DB::table('blogs')
                    ->where('id', $param)
                    ->update([
                        'title' => $request->title,
                        'description' => $request->description,
                        'body' => $request->body,
                        'image' => $imageName ?? null, // Use $imageName if available
                        'slug' => $request->slug,
                        'date_post' => $request->date_post,
                        'category_id' => $request->category,
                        'user_id' => Auth::user()->id,
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);
            } else {
                $update = DB::table('blogs')
                    ->where('id', $param)
                    ->update([
                        'title' => $request->title,
                        'description' => $request->description,
                        'body' => $request->body,
                        'slug' => $request->slug,
                        'date_post' => $request->date_post,
                        'category_id' => $request->category,
                        'user_id' => Auth::user()->id,
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);
            }

            $files = [];
            if ($request->hasFile('archives')) {
                $archive = $request->file('archives');
                foreach ($archive as $file) {
                    $title = $request->title;
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $fileName = Str::slug(pathinfo($filename, PATHINFO_FILENAME)) . "-" . time() . "." . $extension;
                    $destinationPath = 'uploads/files' . '/';
                    $file->move($destinationPath, $fileName);
                    $files[] = [
                        'file' => $fileName,
                        'sort_by' => "article-file",
                        'blog_id' => $param,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ];
                }
                DB::table('archives')->insert($files);
            }

            $tags = $request->tag;
            if ($tags) {
                DB::table('keywords')->where('blog_id', $param)->delete();
                foreach ($tags as $tag) {
                    DB::table('keywords')->insert([
                        'blog_id' => $param,
                        'tag' => $tag,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);
                }
            }

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => "Success update data",
            ]);
        }
        return response()->json([
            'code' => 500,
            'status' => 'error',
            'message' => "Internal server error: something problem from server!",
        ]);
    }

    public function destroy(Request $request)
    {
        if ($param = $request->id) {
            $where = DB::table('blogs')->select('*')->where('id', $param)->first();
            if ($param) {
                $files = DB::table('archives')
                    ->where('blog_id', $param)
                    ->get()
                    ->toArray();
                foreach ($files as $key => $file) {
                    if (File::exists('uploads/files/' . $file->file)) {
                        File::delete('uploads/files/' . $file->file);
                    }
                }
                DB::table('archives')->where('blog_id', $param)->delete();
                DB::table('keywords')->where('blog_id', $param)->delete();
            }
            $dom = new DOMDocument();
            $dom->loadHTML($where->body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $images = $dom->getElementsByTagName('img');
            foreach ($images as $key => $img) {
                $src = $img->getAttribute('src');
                $filename = basename($src);
                $path = 'uploads/posts/' . $filename;
                if (File::exists('uploads/posts/' . $filename)) {
                    File::delete('uploads/posts/' . $filename);
                }
            }
            if (File::exists('uploads/thumb/' . $where->image)) {
                File::delete('uploads/thumb/' . $where->image);
            }
            DB::table('blogs')->where('id', $param)->delete();
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => "Delete blog success"
            ]);
        }
        return response()->json([
            'code' => 400,
            'status' => 'error',
            'message' => "Bad Request"
        ]);
    }
}
