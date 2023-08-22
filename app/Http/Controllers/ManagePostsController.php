<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use App\Post;
use App\FeatureBusiness;
use App\Event;
use App\Classified;
use Auth;
use Redirect;

class ManagePostsController extends Controller {

    private $post;
    private $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PostRepository $postRepository, UserRepository $UserRepository) {
        $this->post = $postRepository;
        $this->user = $UserRepository;
    }

    public function index(Request $request) {
         if (!Auth::check()) {
            $route = route('user.register') . '?ru=' . url()->full();
            return Redirect::to($route);
        }
        else
        {
            $posts = Post::where('post_author', Auth::id())->where('post_type', 'article')->where('post_status', 'active')->orderBy('id', 'DESC')->get();
            $info['post'] = $posts;
            return view('manageposts.article_publish', compact('info'));
        }
    }

    public function draftArticle(Request $request) {
        $posts = Post::where('post_author', Auth::id())->where('post_type', 'article')->where('post_status', 'draft')->orderBy('id', 'DESC')->get();
        $info['post'] = $posts;
        return view('manageposts.article_draft', compact('info'));
    }

    public function events(Request $request) {
        if (!Auth::check()) {
            $route = route('user.register') . '?ru=' . url()->full();
            return Redirect::to($route);
        }
        else
        {
            $posts = Event::where('user_id', Auth::id())->orderBy('id', 'DESC')->get();
            $info['event'] = $posts;
            return view('manageposts.events', compact('info'));
        }
        
    }

    public function classified(Request $request) {
        if (!Auth::check()) {
            $route = route('user.register') . '?ru=' . url()->full();
            return Redirect::to($route);
        }
        else
        {
            $posts = Classified::where('user_id', Auth::id())->orderBy('id', 'DESC')->get();
            $info['classified'] = $posts;
            return view('manageposts.classified', compact('info'));
        }
        
    }

    public function bizpost(Request $request) {
        if (!Auth::check()) {
            $route = route('user.register') . '?ru=' . url()->full();
            return Redirect::to($route);
        }
        else
        {
            $posts = FeatureBusiness::where('user_id', Auth::id())->orderBy('id', 'DESC')->get();
            $info['bizpost'] = $posts;
            return view('manageposts.bizpost', compact('info'));
        }
    }

    public function destroy(Request $request) {
        Post::where('id', $request->id)->delete();
        return response()->json(['status' => "success"]);
    }

    public function deleteAll(Request $request) {
        $ids = $request->ids;
        Post::whereIn('id', explode(",", $ids))->delete();
        return response()->json(['status' => "success"]);
    }

}
