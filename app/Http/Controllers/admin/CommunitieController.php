<?php

namespace App\Http\Controllers\admin;

use App\Region;
use App\Communitie;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommunitieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->type=="Superadmin")
        {
            if ($request->ajax()) {
                $communities = Communitie::leftjoin('regions','communities.region_id','=','regions.id')
                            ->select('communities.id','communities.name','communities.status','regions.name as rname')
                            ->get();
                return datatables()->of($communities)
                    ->addColumn('action', function ($row) {
                        $html = '<a href="communities/' . $row->id . '/edit" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a> ';
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-xs btn-delete"><i class="fa fa-trash-o"></i> Delete </button>';
                        return $html;
                    })->toJson();
            }
        }
        else
        {
            if ($request->ajax()) {
                $user_region = Auth::user()->region_id;
                $exlodes = explode(",",$user_region);
                $communities=[];
                foreach($exlodes as $exlode)
                {
                    $data = Communitie::leftjoin('regions','communities.region_id','=','regions.id')
                               //->leftjoin('users','communities.user_id','=','users.id')
                               ->where('communities.region_id',$exlode)
                            ->select('communities.id','communities.name','communities.status','regions.name as rname')
                            ->get();
                            foreach($data as $datas){
                                $communities[] = $datas;
                            }
                }
                return datatables()->of($communities)
                    ->addColumn('action', function ($row) {
                        $html = '<a href="communities/' . $row->id . '/edit" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a> ';
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-xs btn-delete"><i class="fa fa-trash-o"></i> Delete </button>';
                        return $html;
                    })->toJson();
            }
        }
        
         return view('admin.communitie.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regionlists      = Region::where('status','Active')->get();
        return view('admin.communitie.create',compact('regionlists'));
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
            'name' => 'required|unique:communities',
            'region_name' => 'required|not_in:0',
            'status' => 'required|not_in:0'
        ]);
        
        $communitie=new Communitie();
        $communitie->name = $request->name;
        $communitie->region_id = $request->region_name;
        $communitie->status = $request->status;
        $communitie->save();

        return redirect()->route('communities.index')->with('success', 'Community created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Communitie  $communitie
     * @return \Illuminate\Http\Response
     */
    public function show(Communitie $communitie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Communitie  $communitie
     * @return \Illuminate\Http\Response
     */
    public function edit(Communitie $community)
    {
        $regionlists      = Region::where('status','Active')->get();
        return view('admin.communitie.edit', compact('community','regionlists'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Communitie  $communitie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Communitie $community)
    {
        $request->validate([
            'name' => 'required|unique:communities,name,'.$community->id.'',
            'region_name' => 'required|not_in:0',
            'status' => 'required|not_in:0'
        ]);

        $communitie = Communitie::find($community->id);
        $communitie->name = $request->name;
        $communitie->region_id = $request->region_name;
        $communitie->status = $request->status;
        $communitie->save();
        return redirect()->route('communities.index')->with('success', 'Community updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Communitie  $communitie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Communitie $community)
    {
        $community->delete();

        redirect()->route('communities.index');
        return ['success' => true, 'message' => 'Community Deleted Successfully']; 
    }
}
