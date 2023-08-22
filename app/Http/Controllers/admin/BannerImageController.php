<?php

namespace App\Http\Controllers\admin;

use App\BannerImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bannerimages = BannerImage::get();
            return datatables()->of($bannerimages)
                ->addColumn('action', function ($row) {
                    $html = '<a href="banner_images/' . $row->id . '/edit" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a> ';
                    return $html;
                })->toJson();
        }
         return view('admin.banner_image.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BannerImage  $bannerImage
     * @return \Illuminate\Http\Response
     */
    public function show(BannerImage $bannerImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BannerImage  $bannerImage
     * @return \Illuminate\Http\Response
     */
    public function edit(BannerImage $bannerImage)
    {
        return view('admin.banner_image.edit', compact('bannerImage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BannerImage  $bannerImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BannerImage $bannerImage)
    {
        $request->validate([
            'image' => 'mimes:jpg,png,jpeg,svg',
        ]);
        $files = $request->file('image');
        $filename = $files->getClientOriginalName();
        $files->move('images',$filename);
        $src = $filename;
        $bannerimage = BannerImage::find($bannerImage->id);
        $bannerimage->image = $src;
        $bannerimage->save();
        return redirect()->route('banner_images.index')->with('success', 'Banner Image updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BannerImage  $bannerImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(BannerImage $bannerImage)
    {
        //
    }
}
