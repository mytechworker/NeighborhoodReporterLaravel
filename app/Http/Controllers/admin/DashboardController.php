<?php

namespace App\Http\Controllers\admin;

use App\Post;
use App\User;
use App\Event;
use App\Region;
use App\Classified;
use App\FeatureBusiness;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        if(Auth::user()->type=='Superadmin')
        {
            $admin = User::where('type','Admin')->where('status','Active')->count();
            $user = User::where('type','user')->where('status','Active')->count();
            $total_user = $admin+$user;
            $users=[
                'admin' => $admin,
                'user' => $user,
                'total_user' =>$total_user
            ];

            $article_post  = Post::where('post_type','article')->where('post_status','active')->count();
            $neighbour_post = Post::where('post_type','neighbour')->where('post_status','active')->count();
            $event = Event::count();
            $classified = Classified::count();
            $feature_business = FeatureBusiness::count();
            return view('admin.dashboard',compact('users','article_post','neighbour_post','event','classified','feature_business'));
        }
        else
        {
            $user_region = Auth::user()->region_id;
            $total_regions = explode(",",$user_region);
            $total_user=0;
            $article_post=0;
            $neighbour_post=0;
            $event=0;
            $classified=0;
            $feature_business=0;
            foreach($total_regions as $total_region)
            {
                $user=User::where('region_id','LIKE','%'.$total_region.'%')->where('type','Admin')->where('status','Active')->count();
                $total_user = $total_user + $user;
            }
            
            foreach($total_regions as $total_region)
            {
                $region = Region::where('id',$total_region)->first();
                $post=Post::where('location', '=', $region->name)->where('post_type','article')->where('post_status','active')->count();
                $article_post = $article_post + $post;
            }

            foreach($total_regions as $total_region)
            {
                $region = Region::where('id',$total_region)->first();
                $post1=Post::where('location', '=', $region->name)->where('post_type','neighbour')->where('post_status','active')->count();
                $neighbour_post = $neighbour_post + $post1;
            }

            foreach($total_regions as $total_region)
            {
                $region = Region::where('id',$total_region)->first();
                $post2=Event::where('location', '=', $region->name)->count();
                $event = $event + $post2;
            }

            foreach($total_regions as $total_region)
            {
                $region = Region::where('id',$total_region)->first();
                $post3=Classified::where('location', '=', $region->name)->count();
                $classified = $classified + $post3;
            }

            foreach($total_regions as $total_region)
            {
                $region = Region::where('id',$total_region)->first();
                $post4=FeatureBusiness::where('location', '=', $region->name)->count();
                $feature_business = $feature_business + $post4;
            }
           
            return view('admin.dashboard',compact('total_user','article_post','neighbour_post','event','classified','feature_business'));
        }
            
    }

}
