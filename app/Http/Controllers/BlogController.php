<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Archive;
use App\Models\Blog;

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
        return view('blog.index', compact('data'));
    }

    public function create()
    {
        $categories = DB::table('master_categories')->select('id', 'category')->orderBy('created_at', 'desc')->get();
        $keywords = DB::table('master_tags')->select('tag')->orderBy('created_at', 'desc')->get();
        return view('blog.add', compact('categories', 'keywords'));
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
            $imageName = uniqid() . '_' . Str::slug(pathinfo($request->title, PATHINFO_FILENAME), '-') . '.png';
            $filePath = public_path('uploads/thumb' . $imageName);
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
            ]);
        }
        
        $getID = $insert->id;
        $files = []; // Use an array to store file data
        if ($request->file('files')) {
            var_dump("ID: " . $getID . " files: " . $request->file('files')); die;
            foreach ($request->file('files') as $key => $file) {
                $originalFilename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . '_' . Str::slug(pathinfo($originalFilename, PATHINFO_FILENAME)) . '.' . $extension;
                $filePath = public_path('uploads/thumb' . $fileName);
                file_put_contents($filePath);
                // DB::table('archives')->insert([
                //     'file' => $fileName,
                //     'sort_by' => "article-file",
                //     'blog_id' => $getID,
                // ]);
                $files[] = [
                    'file' => $fileName,
                    'sort_by' => "article-file",
                    'blog_id' => $getID,
                ];
            }
            DB::table('archives')->insert($files);
        }

        $tags = $request->tag;
        if ($tags) {
            foreach ($tags as $tag) {
                DB::table('keywords')->insert([
                    'blog_id' => $getID,
                    'tag' => $tag,
                ]);
            }
        }
        
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Success create data',
        ]);
    }


    public function edit()
    {
        return view('blog.edit');
    }
}
