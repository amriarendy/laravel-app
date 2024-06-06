<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        return view('setting', compact('data', 'meta'));
    }

    public function update(Request $request)
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
                'title.required' => 'input is required',
                'title.min' => 'max: 5 character',
                'title.max' => 'max: 255 character',
                'description.required' => 'input is required',
                'description.min' => 'max: 5 character',
                'description.max' => 'max: 255 character',
                'keywords.required' => 'input is required',
                'keywords.min' => 'max: 5 character',
                'keywords.max' => 'max: 255 character',
                'author.required' => 'input is required',
                'author.min' => 'max: 5 character',
                'author.max' => 'max: 100 character',
                'copyright.required' => 'input is required',
                'copyright.min' => 'max: 5 character',
                'copyright.max' => 'max: 100 character',
                'robots.required' => 'input is required',
                'robots.min' => 'max: 5 character',
                'robots.max' => 'max: 100 character',
                'googlebot.required' => 'input is required',
                'googlebot.min' => 'max: 5 character',
                'googlebot.max' => 'max: 100 character',
                'googlebotnews.required' => 'input is required',
                'googlebotnews.min' => 'max: 5 character',
                'googlebotnews.max' => 'max: 100 character',
            ]
        );
        $update = DB::table('metas')->where('id', 1)->update([
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
            'code' => 200,
            'status' => 'success',
            'message' => 'Data berhasil di update',
        ]);
    }

    public function favicon(Request $request)
    {
        $rules = $request->validate(
            [
                'favicon' => 'required|mimes:jpeg,jpg,png,gif|max:1024',
            ],
            [
                'favicon.required' => 'Input tidak boleh kosong',
                'favicon.mimes' => 'Extension Cover: jpeg, jpg, png',
                'favicon.max' => 'File max: 1mb',
            ]
        );
        $data = DB::table('metas')->where('id', 1)->first();
        $filename = $data->favicon;
        $filePath = public_path("/{$filename}");
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
        if ($request->hasFile('favicon')) {
            $folderPath = public_path('/');
            $favicon = $request->file('favicon');
            $originalFilename = $favicon->getClientOriginalName();
            $extension = $favicon->getClientOriginalExtension();
            $imageName = "favicon.{$extension}";
            $favicon->move($folderPath, $imageName);
            $update = DB::table('metas')->where('id', 1)->update([
                'favicon' => $imageName,
            ]);
        }
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'File berhasil di upload',
        ]);
    }

    public function image(Request $request)
    {
        $rules = $request->validate(
            [
                'image' => 'required|mimes:jpeg,jpg,png,gif|max:1024',
            ],
            [
                'image.required' => 'Input tidak boleh kosong',
                'image.mimes' => 'Extension Cover: jpeg, jpg, png',
                'image.max' => 'File max: 1mb',
            ]
        );
        $data = DB::table('metas')->where('id', 1)->first();
        $filename = $data->image;
        $filePath = public_path("/{$filename}");
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
        if ($request->hasFile('image')) {
            $folderPath = public_path('/');
            $image = $request->file('image');
            $originalFilename = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $imageName = "image.{$extension}";
            $image->move($folderPath, $imageName);
            $update = DB::table('metas')->where('id', 1)->update([
                'image' => $imageName,
            ]);
        }
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'File berhasil di upload',
        ]);
    }

    public function information()
    {
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
        return view('information', compact('meta'));
    }
}
