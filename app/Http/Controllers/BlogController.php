<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function index()
    {
        return view('blog.index');
    }

    public function create()
    {
        return view('blog.add');
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
        $blogInsert = DB::table('blogs')->insert([
            'category' => $request->input('category'),
            'slug' => Str::slug($request->input('slug')),
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);
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
