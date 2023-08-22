<?php

namespace App\Http\Controllers\admin;

use App\Region;
use App\Classified;
use App\PostReport;
use App\ClasifiedComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClassifiedController extends Controller
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
                $classified = Classified::leftjoin('users','classified.user_id','=','users.id')
                                ->select('users.name','classified.*')
                                ->get();
                return datatables()->of($classified)
                    ->addColumn('action', function ($row) {
                        $html = '<a href="classified/' . $row->id . '" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View</a> ';
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-xs btn-delete"><i class="fa fa-trash-o"></i>Delete</button>';
                        $html .= '<a href="view_classified_report/' . $row->id . '" class="btn btn-success btn-xs"><i class="fa fa-folder"></i> View Report</a> ';
                        return $html;
                    })->toJson();
            }
        }
        else
        {
            if ($request->ajax()) {
                // $region = Region::where('id',Auth::user()->region_id)->first();
                // $result1= Classified::leftjoin('users','classified.user_id','=','users.id')
                //         ->where('classified.user_id', Auth::user()->id)
                //         ->where('classified.location', '!=', $region->name)
                //         ->where('classified.deleted_at', null)
                //         ->select('users.name','classified.*')
                //         ->orderBy('classified.id', 'ASC')
                //         ->get();
                // $result2= Classified::leftjoin('users','classified.user_id','=','users.id')
                //      ->where('classified.location', $region->name)
                //      ->where('classified.deleted_at', null)
                //      ->select('users.name','classified.*')
                //      ->orderBy('classified.id', 'ASC')
                //      ->get();
                     
                // $classified = $result1->concat($result2);
                // $classified->all();
                $user_region = Auth::user()->region_id;
                $exlodes = explode(",",$user_region);
                foreach($exlodes as $exlode)
                {
                     $region = Region::where('id',$exlode)->first();
                     $result1= Classified::leftjoin('users','classified.user_id','=','users.id')
                            ->where('classified.user_id', Auth::user()->id)
                            ->where('classified.location', '!=', $region->name)
                            ->where('classified.deleted_at', null)
                            ->select('users.name','classified.*')
                            ->orderBy('classified.id', 'ASC')
                            ->get();
                    $result2= Classified::leftjoin('users','classified.user_id','=','users.id')
                            ->where('classified.location', $region->name)
                            ->where('classified.deleted_at', null)
                            ->select('users.name','classified.*')
                            ->orderBy('classified.id', 'ASC')
                            ->get();
                }
                $classified = $result1->concat($result2);
                $classified->all();
                return datatables()->of($classified)
                    ->addColumn('action', function ($row) {
                        $html = '<a href="classified/' . $row->id . '" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View</a> ';
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-xs btn-delete"><i class="fa fa-trash-o"></i>Delete</button>';
                        $html .= '<a href="view_classified_report/' . $row->id . '" class="btn btn-success btn-xs"><i class="fa fa-folder"></i> View Report</a> ';
                        return $html;
                    })->toJson();
            }
        }
         return view('admin.classified.index');
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
     * @param  \App\Classified  $classified
     * @return \Illuminate\Http\Response
     */
    public function show(Classified $classified)
    {
        $classifiedcomments = ClasifiedComment::join('users','classified_comments.user_id','=','users.id')
                        ->where('classified_comments.classified_id',$classified->id)
                        ->select('classified_comments.created_at','classified_comments.user_id','classified_comments.image','classified_comments.description','users.name','users.profile_image')
                        ->get();

        $user = Classified::join('users','classified.user_id','=','users.id')
                ->where('users.id',$classified->user_id)
                ->select('users.name','users.email')
                ->first();    
       
        return view('admin.classified.view',compact('classifiedcomments','classified','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Classified  $classified
     * @return \Illuminate\Http\Response
     */
    public function edit(Classified $classified)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Classified  $classified
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classified $classified)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Classified  $classified
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classified $classified)
    {
        $classified->delete();
        ClaasifiedComment::where('classified_id',$classified->id)->delete();
        redirect()->route('classified.index');
        return ['success' => true, 'message' => 'Classified Deleted Successfully'];
    }

    public function view_report($id)
    {
       $post_title = Classified::where('id',$id)->first();
       $user = Classified::join('users','classified.user_id','=','users.id')
                      ->where('users.id',$post_title->user_id)
                      ->select('users.name','users.email')
                      ->first();   
        $post_reports = PostReport::whereIn('type', ['classified'])->where('post_id',$id)->get();
       return view('admin.classified.view_report',compact('post_title','user','post_reports'));
    }
}
