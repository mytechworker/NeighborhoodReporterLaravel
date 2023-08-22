<?php

namespace App\Http\Controllers\admin;

use App\Region;
use App\PostReport;
use App\FeatureBusiness;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FeatureBusinessController extends Controller
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
                $featurebusiness = FeatureBusiness::leftjoin('users','feature_business.user_id','=','users.id')
                                ->select('users.name','feature_business.*')
                                ->get();
                return datatables()->of($featurebusiness)
                    ->addColumn('action', function ($row) {
                        $html = '<a href="feature_business/' . $row->id . '" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View</a> ';
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-xs btn-delete"><i class="fa fa-trash-o"></i>Delete</button>';
                        //$html .= '<a href="view_feature_business_report/' . $row->id . '" class="btn btn-success btn-xs"><i class="fa fa-folder"></i> View Report</a> ';
                        return $html;
                    })->toJson();
            }
        }
        else
        {
            if ($request->ajax()) {
                // $region = Region::where('id',Auth::user()->region_id)->first();
                // $result1= FeatureBusiness::leftjoin('users','feature_business.user_id','=','users.id')
                //         ->where('feature_business.user_id', Auth::user()->id)
                //         ->where('feature_business.location', '!=', $region->name)
                //         ->where('feature_business.deleted_at', null)
                //         ->select('users.name','feature_business.*')
                //         ->orderBy('feature_business.id', 'ASC')
                //         ->get();
                // $result2= FeatureBusiness::leftjoin('users','feature_business.user_id','=','users.id')
                //      ->where('feature_business.location', $region->name)
                //      ->where('feature_business.deleted_at', null)
                //      ->select('users.name','feature_business.*')
                //      ->orderBy('feature_business.id', 'ASC')
                //      ->get();
                     
                // $featurebusiness = $result1->concat($result2);
                // $featurebusiness->all();
                $user_region = Auth::user()->region_id;
                $exlodes = explode(",",$user_region);
                foreach($exlodes as $exlode)
                {
                    $region = Region::where('id',$exlode)->first();
                    $result1= FeatureBusiness::leftjoin('users','feature_business.user_id','=','users.id')
                            ->where('feature_business.user_id', Auth::user()->id)
                            ->where('feature_business.location', '!=', $region->name)
                            ->where('feature_business.deleted_at', null)
                            ->select('users.name','feature_business.*')
                            ->orderBy('feature_business.id', 'ASC')
                            ->get();
                     $result2= FeatureBusiness::leftjoin('users','feature_business.user_id','=','users.id')
                                ->where('feature_business.location', $region->name)
                                ->where('feature_business.deleted_at', null)
                                ->select('users.name','feature_business.*')
                                ->orderBy('feature_business.id', 'ASC')
                                ->get();
                }
                $featurebusiness = $result1->concat($result2);
                $featurebusiness->all();
                return datatables()->of($featurebusiness)
                    ->addColumn('action', function ($row) {
                        $html = '<a href="feature_business/' . $row->id . '" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View</a> ';
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-xs btn-delete"><i class="fa fa-trash-o"></i>Delete</button>';
                        //$html .= '<a href="view_feature_business_report/' . $row->id . '" class="btn btn-success btn-xs"><i class="fa fa-folder"></i> View Report</a> ';
                        return $html;
                    })->toJson();
            }
        }
         return view('admin.feature_business.index');
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
     * @param  \App\FeatureBusiness  $featureBusiness
     * @return \Illuminate\Http\Response
     */
    public function show(FeatureBusiness $featureBusiness)
    {
        $feature_business = FeatureBusiness::leftjoin('users','feature_business.user_id','=','users.id')
                            ->where('users.id','=',$featureBusiness->user_id)
                            ->select('users.name')
                            ->first();
        return view('admin.feature_business.view',compact('featureBusiness','feature_business'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FeatureBusiness  $featureBusiness
     * @return \Illuminate\Http\Response
     */
    public function edit(FeatureBusiness $featureBusiness)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FeatureBusiness  $featureBusiness
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeatureBusiness $featureBusiness)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FeatureBusiness  $featureBusiness
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeatureBusiness $featureBusiness)
    {
        $featureBusiness->delete();

        redirect()->route('feature_business.index');
        return ['success' => true, 'message' => 'Feature Business Deleted Successfully']; 
    }

    // public function view_report($id)
    // {
    //    $post_title = FeatureBusiness::where('id',$id)->first();
    //    $user = FeatureBusiness::join('users','feature_business.user_id','=','users.id')
    //                   ->where('users.id',$post_title->user_id)
    //                   ->select('users.name','users.email')
    //                   ->first();   
    //     $post_reports = PostReport::whereIn('type', ['business'])->where('post_id',$id)->get();
    //    return view('admin.feature_business.view_report',compact('post_title','user','post_reports'));
    // }
}
