<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $data = DB::table('metas')
            ->select(
                'metas.title',
                'metas.description',
                'metas.favicon',
                'metas.keywords',
                'metas.author',
                'metas.image',
                'metas.copyright',
                'metas.robots',
                'metas.googlebot',
                'metas.googlebotnews',
            )
            ->where('id', 1)
            ->first();
        return view('setting.setting', compact('data'));
    }

    public function meta()
    {
        $request->validate(
            [
                'title' => 'required|min:5|max:100',
                'description' => 'required|min:5|max:255',
                'keywords' => 'required|min:5|max:200',
                'author' => 'required|min:5|max:100',
                'copyright' => 'required|min:5|max:100',
                'robots' => 'required|min:5|max:100',
                'googlebot' => 'required|min:5|max:100',
                'googlebotnews' => 'required|min:5|max:100',
            ],
            [
                'title.required' => 'Input tidak boleh kosong',
                'title.min' => 'Input judul tidak boleh kuran dari 5 karakter',
                'title.max' => 'Input judul tidak boleh lebih dari 100 karakter',
                'description.required' => 'Input tidak boleh kosong',
                'description.min' => 'Input judul tidak boleh kuran dari 5 karakter',
                'description.max' => 'Input judul tidak boleh lebih dari 255 karakter',
                'keywords.required' => 'Input tidak boleh kosong',
                'keywords.min' => 'Input judul tidak boleh kuran dari 5 karakter',
                'keywords.max' => 'Input judul tidak boleh lebih dari 200 karakter',
                'author.required' => 'Input tidak boleh kosong',
                'author.min' => 'Input judul tidak boleh kuran dari 5 karakter',
                'author.max' => 'Input judul tidak boleh lebih dari 100 karakter',
                'copyright.required' => 'Input tidak boleh kosong',
                'copyright.min' => 'Input judul tidak boleh kuran dari 5 karakter',
                'copyright.max' => 'Input judul tidak boleh lebih dari 100 karakter',
                'robots.required' => 'Input tidak boleh kosong',
                'robots.min' => 'Input judul tidak boleh kuran dari 5 karakter',
                'robots.max' => 'Input judul tidak boleh lebih dari 100 karakter',
                'googlebot.required' => 'Input tidak boleh kosong',
                'googlebot.min' => 'Input judul tidak boleh kuran dari 5 karakter',
                'googlebot.max' => 'Input judul tidak boleh lebih dari 100 karakter',
                'googlebotnews.required' => 'Input tidak boleh kosong',
                'googlebotnews.min' => 'Input judul tidak boleh kuran dari 5 karakter',
                'googlebotnews.max' => 'Input judul tidak boleh lebih dari 100 karakter',
            ]
        );
        $update = Setting::where('id', 1)->update([
            'title' => $request->title,
            'description' => $request->description,
            'keywords' => $request->keywords,
            'author' => $request->author,
            'copyright' => $request->copyright,
            'robots' => $request->robots,
            'googlebot' => $request->googlebot,
            'googlebotnews' => $request->googlebotnews,
        ]);
        return response()->json([
            'code' => 201,
            'status' => 'success',
            'message' => 'Data berhasil di update',
        ]);
    }

    public function favicon(Request $request)
    {

    }

    public function image(Request $request)
    {
        
    }
}
