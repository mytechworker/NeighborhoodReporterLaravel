<?php

namespace App\Http\Controllers\admin;

use App\Region;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $religionals = Religional::get();
        
        if ($request->ajax()) {
            $regions = Region::all();
            return datatables()->of($regions)
                ->addColumn('action', function ($row) {
                    $html = '<a href="regions/' . $row->id . '/edit" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a> ';
                    $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-xs btn-delete"><i class="fa fa-trash-o"></i> Delete </button>';
                    return $html;
                })->toJson();
        }
         return view('admin.region.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.region.create');
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
            'region_code' => 'required|max:2|unique:regions',
            'name' => 'required|unique:regions',
            'status' => 'required|not_in:0'
        ]);
        

        $region=new Region();
        $region->region_code = $request->region_code;
        $region->name = $request->name;
        $region->status = $request->status;
        $region->save();

        // Region::create($request->all());

        return redirect()->route('regions.index')->with('success', 'Region created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Religional  $religional
     * @return \Illuminate\Http\Response
     */
    public function show(Region $region)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Religional  $religional
     * @return \Illuminate\Http\Response
     */
    public function edit(Region $region)
    {
        return view('admin.region.edit', compact('region'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Religional  $religional
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $region)
    {
        $request->validate([
            'region_code' => 'required|max:2|unique:regions,region_code,'.$region->id.'',
            'name' => 'required|unique:regions,name,'.$region->id.'',
            'status' => 'required|not_in:0'
        ]);

        $region = Region::find($region->id);
        
        //$region->update($request->all());
        $region->region_code = $request->region_code;
        $region->name = $request->name;
        $region->status = $request->status;
        $region->save();
        return redirect()->route('regions.index')->with('success', 'Region updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Religional  $religional
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $region)
    {
        $region->delete();

        redirect()->route('regions.index');
        return ['success' => true, 'message' => 'Region Deleted Successfully']; 
            // ->with(['success' => true, 'message' => 'Deleted Successfully']);
    }
}
