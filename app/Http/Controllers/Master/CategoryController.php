<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CategoryController extends Controller
{
    public function index()
    {
        $data = DB::table('master_categories')
            ->select(
                'master_categories.id',
                'master_categories.category',
                'master_categories.slug',
            )->orderBy('created_at', 'desc')
            ->get();
        return view('master.category', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'category' => 'required',
                'slug' => 'required|unique:master_categories',
            ],
            [
                'category.required' => 'Category is required',
                'slug.required' => 'Slug is required',
                'slug.unique' => 'Data already exist'
            ]
        );
        $insert = DB::table('master_categories')->insert([
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

    public function update(Request $request)
    {
        $request->validate(
            [
                'category' => 'required|unique:master_categories',
                'slug' => 'required|unique:master_categories',
            ],
            [
                'category.required' => 'Input tidak boleh kosong',
                'slug.required' => 'Slug is required',
            ]
        );
        $update = DB::table('master_categories')
            ->where('id', $request->input('id'))
            ->update([
                'category' => $request->input('category'),
                'slug' => Str::slug($request->input('slug')),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Success update data',
        ]);
    }

    public function destroy(Request $request)
    {
        if (!$request->isMethod('post')) {
            abort(404);
        }
        $delete = DB::table('master_categories')->where('id', $request->input('id'))->delete();
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => "Success delete data"
        ]);
    }
}
