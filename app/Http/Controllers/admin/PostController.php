<?php

namespace App\Http\Controllers\admin;

use App\Post;
use App\User;
use App\PostReport;
use App\PostComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Region;

class PostController extends Controller
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
                $posts = Post::all();
                return datatables()->of($posts)
                    ->addColumn('action', function ($row) {
                        $html = '<a href="post/' . $row->id . '" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View</a> ';
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-xs btn-delete"><i class="fa fa-trash-o"></i>Delete</button>';
                        $html .= '<a href="view_post_report/' . $row->id . '" class="btn btn-success btn-xs"><i class="fa fa-folder"></i> View Report</a> ';
                        return $html;
                    })->toJson();
            }
        }
        else
        {
            if ($request->ajax()) {
                $user_region = Auth::user()->region_id;
                $exlodes = explode(",",$user_region);
                foreach($exlodes as $exlode)
                {
                    // $region = Region::where('id',Auth::user()->region_id)->first();
                    // $result1= Post::where('post_author', Auth::user()->id)
                    //         ->where('location', '!=', $region->name)
                    //         ->where('deleted_at', null)
                    //         ->orderBy('id', 'ASC')
                    //         ->get();
                    // $result2= Post::where('location', $region->name)
                    //     ->where('deleted_at', null)
                    //     ->orderBy('id', 'ASC')
                    //     ->get();
                        
                    // $posts = $result1->concat($result2);
                    // $posts->all();

                    $region = Region::where('id',$exlode)->first();
                    $result1= Post::where('post_author', Auth::user()->id)
                            ->where('location', '!=', $region->name)
                            ->where('deleted_at', null)
                            ->orderBy('id', 'ASC')
                            ->get();
                    $result2= Post::where('location', $region->name)
                        ->where('deleted_at', null)
                        ->orderBy('id', 'ASC')
                        ->get();
                }
                $posts = $result1->concat($result2);
                $posts->all();
                return datatables()->of($posts)
                    ->addColumn('action', function ($row) {
                        $html = '<a href="post/' . $row->id . '" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View</a> ';
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-xs btn-delete"><i class="fa fa-trash-o"></i>Delete</button>';
                        $html .= '<a href="view_post_report/' . $row->id . '" class="btn btn-success btn-xs"><i class="fa fa-folder"></i> View Report</a> ';
                        return $html;
                    })->toJson();
            }
        }
         return view('admin.post.index');
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
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $postcomments = PostComment::join('users','post_comment.user_id','=','users.id')
                        ->where('post_comment.post_id',$post->id)
                        ->select('post_comment.created_at','post_comment.user_id','post_comment.comment','post_comment.image','users.name','users.profile_image')
                        ->get();

        $user = Post::join('users','post.post_author','=','users.id')
                      ->where('users.id',$post->post_author)
                      ->select('users.name','users.email')
                      ->first();    
       
        return view('admin.post.view',compact('postcomments','post','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        PostComment::where('post_id',$post->id)->delete();
        redirect()->route('post.index');
        return ['success' => true, 'message' => 'Post Deleted Successfully'];
    }

    public function view_report($id)
    {
       $post_title = Post::where('id',$id)->first();
       $user = Post::join('users','post.post_author','=','users.id')
                      ->where('users.id',$post_title->post_author)
                      ->select('users.name','users.email')
                      ->first();   
        $post_reports = PostReport::whereIn('type', ['article','neighbour'])->where('post_id',$id)->get();
       return view('admin.post.view_report',compact('post_title','user','post_reports'));
    }

}
