<?php

namespace App\Http\Controllers\admin;

use App\Event;
use App\Region;
use App\PostReport;
use App\EventComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
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
                $event = Event::leftjoin('users','event.user_id','=','users.id')
                                ->select('users.name','event.*')
                                ->get();
                return datatables()->of($event)
                    ->addColumn('action', function ($row) {
                        $html = '<a href="event/' . $row->id . '" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View</a> ';
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-xs btn-delete"><i class="fa fa-trash-o"></i>Delete</button>';
                        $html .= '<a href="view_event_report/' . $row->id . '" class="btn btn-success btn-xs"><i class="fa fa-folder"></i> View Report</a> ';
                        return $html;
                    })->toJson();
            }
        }
        else
        {
            if ($request->ajax()) {
                // $region = Region::where('id',Auth::user()->region_id)->first();
                // $result1= Event::leftjoin('users','event.user_id','=','users.id')
                //         ->where('event.user_id', Auth::user()->id)
                //         ->where('event.location', '!=', $region->name)
                //         ->where('event.deleted_at', null)
                //         ->select('users.name','event.*')
                //         ->orderBy('event.id', 'ASC')
                //         ->get();
                // $result2= Event::leftjoin('users','event.user_id','=','users.id')
                //      ->where('event.location', $region->name)
                //      ->where('event.deleted_at', null)
                //      ->select('users.name','event.*')
                //      ->orderBy('event.id', 'ASC')
                //      ->get();
                     
                // $event = $result1->concat($result2);
                // $event->all();
                $user_region = Auth::user()->region_id;
                $exlodes = explode(",",$user_region);
                foreach($exlodes as $exlode)
                {
                    $region = Region::where('id',$exlode)->first();
                    $result1= Event::leftjoin('users','event.user_id','=','users.id')
                            ->where('event.user_id', Auth::user()->id)
                            ->where('event.location', '!=', $region->name)
                            ->where('event.deleted_at', null)
                            ->select('users.name','event.*')
                            ->orderBy('event.id', 'ASC')
                            ->get();
                    $result2= Event::leftjoin('users','event.user_id','=','users.id')
                            ->where('event.location', $region->name)
                            ->where('event.deleted_at', null)
                            ->select('users.name','event.*')
                            ->orderBy('event.id', 'ASC')
                            ->get();
                }
                $event = $result1->concat($result2);
                $event->all();
                return datatables()->of($event)
                    ->addColumn('action', function ($row) {
                        $html = '<a href="event/' . $row->id . '" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View</a> ';
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-xs btn-delete"><i class="fa fa-trash-o"></i>Delete</button>';
                        $html .= '<a href="view_event_report/' . $row->id . '" class="btn btn-success btn-xs"><i class="fa fa-folder"></i> View Report</a> ';
                        return $html;
                    })->toJson();
            }
        }
         return view('admin.event.index');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $eventcomments = EventComment::join('users','event_comments.user_id','=','users.id')
                        ->where('event_comments.event_id',$event->id)
                        ->select('event_comments.created_at','event_comments.user_id','event_comments.image','event_comments.description','users.name','users.profile_image')
                        ->get();

        $user = Event::join('users','event.user_id','=','users.id')
                        ->where('users.id',$event->user_id)
                        ->select('users.name','users.email')
                        ->first();    
       
        return view('admin.event.view',compact('eventcomments','event','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
        EventComment::where('event_id',$event->id)->delete();
        redirect()->route('event.index');
        return ['success' => true, 'message' => 'Event Deleted Successfully'];
    }

    public function view_report($id)
    {
       $post_title = Event::where('id',$id)->first();
       $user = Event::join('users','event.user_id','=','users.id')
                      ->where('users.id',$post_title->user_id)
                      ->select('users.name','users.email')
                      ->first();   
        $post_reports = PostReport::whereIn('type', ['event'])->where('post_id',$id)->get();
       return view('admin.event.view_report',compact('post_title','user','post_reports'));
    }
}
