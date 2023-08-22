<?php

namespace App\Http\Controllers\admin;

use App\Advertise;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdvertiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $advertises = Advertise::all();
            return datatables()->of($advertises)
                ->addColumn('action', function ($row) {
                    $html = '<a href="advertises/' . $row->id . '/edit" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a> ';
                    $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-xs btn-delete"><i class="fa fa-trash-o"></i> Delete </button>';
                    return $html;
                })->toJson();
        }
         return view('admin.advertise.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.advertise.create');
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
            'business_name' => 'required',
            'zip_code' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone_no' => 'required',
            'advertising_goal' => 'required',
            'about_your_business' => 'required',
            'status' => 'required|not_in:0'
        ]);
        
        $advertise=new Advertise();
        $advertise->business_name = $request->business_name;
        $advertise->zip_code = $request->zip_code;
        $advertise->first_name = $request->first_name;
        $advertise->last_name = $request->last_name;
        $advertise->email = $request->email;
        $advertise->phone_no = $request->phone_no;
        $advertise->advertising_goal = $request->advertising_goal;
        $advertise->about_your_business = $request->about_your_business;
        $advertise->status = $request->status;
        $advertise->save();

        return redirect()->route('advertises.index')->with('success', 'Advertise created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Advertise  $advertise
     * @return \Illuminate\Http\Response
     */
    public function show(Advertise $advertise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Advertise  $advertise
     * @return \Illuminate\Http\Response
     */
    public function edit(Advertise $advertise)
    {
        return view('admin.advertise.edit', compact('advertise'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Advertise  $advertise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Advertise $advertise)
    {
        $request->validate([
            'business_name' => 'required',
            'zip_code' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone_no' => 'required',
            'advertising_goal' => 'required',
            'about_your_business' => 'required',
            'status' => 'required|not_in:0'
        ]);
        
        $advertise=Advertise::find($advertise->id);
        $advertise->business_name = $request->business_name;
        $advertise->zip_code = $request->zip_code;
        $advertise->first_name = $request->first_name;
        $advertise->last_name = $request->last_name;
        $advertise->email = $request->email;
        $advertise->phone_no = $request->phone_no;
        $advertise->advertising_goal = $request->advertising_goal;
        $advertise->about_your_business = $request->about_your_business;
        $advertise->status = $request->status;
        $advertise->save();

        return redirect()->route('advertises.index')->with('success', 'Advertise updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Advertise  $advertise
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advertise $advertise)
    {
        $advertise->delete();

        redirect()->route('advertises.index');
        return ['success' => true, 'message' => 'Advertise Deleted Successfully']; 
    }
}
