<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {        
        $data = DB::table('master_tags')
        ->select(
            'master_tags.id',
            'master_tags.tag',
        )->orderBy('created_at', 'desc')
        ->get();
        return view('master.tag', compact('data'));
    }
    
    public function store(Request $request)
    {
        $request->validate(
            [
                'tag' => 'required|unique:master_tags'
            ],
            [
                'tag.required' => 'Tag is required',
                'tag.unique' => 'Data already exist',
            ]
        );
        $insert = DB::table('master_tags')->insert([
            'tag' => $request->input('tag')
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
                'tag' => 'required|unique:master_tags'
            ],
            [
                'tag.required' => 'Input tidak boleh kosong',
                'tag.unique' => 'Data already exist',
            ]
        );
        $update = DB::table('master_tags')
        ->where('id', $request->input('id'))
        ->update([
            'tag' => $request->input('tag')
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
        $delete = DB::table('master_tags')->where('id', $request->input('id'))->delete();
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => "Success delete data"
        ]);
    }
}
