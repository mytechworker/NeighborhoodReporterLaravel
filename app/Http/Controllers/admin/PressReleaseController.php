<?php

namespace App\Http\Controllers\admin;

use App\PressRelease;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PressReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $press_releases = PressRelease::all();
            return datatables()->of($press_releases)
                ->addColumn('action', function ($row) {
                    $html = '<a href="press_releases/' . $row->id . '/edit" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a> ';
                    $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-xs btn-delete"><i class="fa fa-trash-o"></i> Delete </button>';
                    return $html;
                })->toJson();
        }
         return view('admin.press_release.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.press_release.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'date' => 'required',
        ]);

        $pressrelase=new PressRelease();
        $pressrelase->title = $request->title;
        $pressrelase->date = date("Y-m-d H:i:s", strtotime($request->date));
        $pressrelase->external_link = $request->external_link;
        $pressrelase->save();

        return redirect()->route('press_releases.index')->with('success', 'Press Release created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PressRelease  $pressRelease
     * @return \Illuminate\Http\Response
     */
    public function show(PressRelease $pressRelease)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PressRelease  $pressRelease
     * @return \Illuminate\Http\Response
     */
    public function edit(PressRelease $pressRelease)
    {
        return view('admin.press_release.edit',compact('pressRelease'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PressRelease  $pressRelease
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PressRelease $pressRelease)
    {
        $request->validate([
            'title' => 'required',
            'date' => 'required',
        ]);

        $pressrelase=PressRelease::find($pressRelease->id);
        $pressrelase->title = $request->title;
        $pressrelase->date = date("Y-m-d H:i:s", strtotime($request->date));
        $pressrelase->external_link = $request->external_link;
        $pressrelase->save();

        return redirect()->route('press_releases.index')->with('success', 'Press Release updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PressRelease  $pressRelease
     * @return \Illuminate\Http\Response
     */
    public function destroy(PressRelease $pressRelease)
    {
        $pressRelease->delete();

        redirect()->route('press_releases.index');
        return ['success' => true, 'message' => 'Press Release Deleted Successfully'];
    }
}
