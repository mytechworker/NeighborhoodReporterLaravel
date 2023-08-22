<?php

namespace App\Http\Controllers;

use App\User;
use App\Communitie;
use App\UserCommunitie;
use App\Post;
use App\PostComment;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\File\File;
use App\Mail\PostReplyMail;
use Mail;

class ArticleController extends Controller {

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

    public function index() {
        if (!Auth::check()) {
            $route = route('user.register') . '?ru=' . url()->full();
            return Redirect::to($route);
        }
        return view('article.add');
    }

    /**
     * Show the post details view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function details(Request $request) {
        $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
        $request->town = ucwords(str_replace(array('-'), array(' '), $request->town));
        $postDetails = $this->post->postDetails($request->location, $request->town, $request->guid);
        $postList = $this->post->locationPost($request->location, $request->town);
        $eventList = $this->post->getEvent($request->location, $request->town);
        $classifiedList = $this->post->getClassified($request->location, $request->town);
        $neighbourPostList = $this->post->getNeighbourPost($request->location, $request->town);
        $top10Post = $this->post->getLiveLocationPost($request->location, $request->town);
        $postDetails->userInfo = $this->user->getInfoById($postDetails['post_author']);
        if (Auth::check()) {
            $postDetails->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $postDetails['id'], 'article');
        }
        $postDetails->reply = $this->post->getReplyDetails($postDetails['id'], $postDetails['id']);
        foreach ($postDetails->reply as $key => $value) {
            $postDetails->reply[$key]->userInfo = $this->user->getInfoById($value['user_id']);
            if (Auth::check()) {
                $postDetails->reply[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'reply');
            }
            $postDetails->reply[$key]->commentReply = $this->post->getReplyDetails($postDetails['id'], $value['id']);
        }
        foreach ($postDetails->reply as $key => $rvalue) {
            foreach ($rvalue['commentReply'] as $key2 => $crvalue) {
                $postDetails->reply[$key]->commentReply[$key2]->userInfo = $this->user->getInfoById($crvalue['user_id']);
                if (Auth::check()) {
                    $postDetails->reply[$key]->commentReply[$key2]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $crvalue['id'], 'reply');
                }
            }
        }
        $info = $postDetails;
        foreach ($postList as $key => $value) {
            $postList[$key]->userInfo = $this->user->getInfoById($value['post_author']);
            if (Auth::check()) {
                $postList[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'article');
            }
            if ($postDetails['id'] != $value['id']) {
                $pid = $value['id'];
            }
        }
        if (isset($pid)) {
            $nextPost = $this->post->loadMoreLocationPost($pid, $request->location, $request->town);
            if ($nextPost->isEmpty()) {
                $info['hidePostButton'] = 1;
            } else {
                $info['hidePostButton'] = 0;
            }
        }

        foreach ($neighbourPostList as $key => $value) {
            $neighbourPostList[$key]->userInfo = $this->user->getInfoById($value['post_author']);
            if (Auth::check()) {
                $neighbourPostList[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'neighbour');
            }
            $neighbourPostList[$key]->reply = $this->post->getReplyDetails($value['id'], $value['id']);
            foreach ($neighbourPostList[$key]->reply as $key1 => $value1) {
                $neighbourPostList[$key]->reply[$key1]->userInfo = $this->user->getInfoById($value1['user_id']);
                if (Auth::check()) {
                    $neighbourPostList[$key]->reply[$key1]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value1['id'], 'neighbour_reply');
                }
                $neighbourPostList[$key]->reply[$key1]->commentReply = $this->post->getReplyDetails($value['id'], $value1['id']);
            }
            foreach ($neighbourPostList[$key]->reply as $key3 => $rvalue) {
                foreach ($rvalue['commentReply'] as $key4 => $crvalue) {
                    $neighbourPostList[$key]->reply[$key3]->commentReply[$key4]->userInfo = $this->user->getInfoById($crvalue['user_id']);
                    if (Auth::check()) {
                        $neighbourPostList[$key]->reply[$key3]->commentReply[$key4]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $crvalue['id'], 'neighbour_reply');
                    }
                }
            }
            $nid = $value['id'];
        }
        if (isset($nid)) {
            $nextNeighbor = $this->post->loadMoreNeighbourLocationPost($nid, $request->location, $request->town);
            if ($nextNeighbor->isEmpty()) {
                $info['hideNeighborButton'] = 1;
            } else {
                $info['hideNeighborButton'] = 0;
            }
        }
        foreach ($eventList as $key => $value) {
            if (Auth::check()) {
                $eventList[$key]->userIntrestInfo = $this->post->getIntrestedInfo(Auth::id(), $value['id']);
            }
            $eid = $value['id'];
        }
        if (isset($eid)) {
            $nextEvent = $this->post->loadMoreEventPost($eid, $request->location, $request->town);
            if ($nextEvent->isEmpty()) {
                $info['hideEventButton'] = 1;
            } else {
                $info['hideEventButton'] = 0;
            }
        }
        foreach ($classifiedList as $key => $value) {
            $classifiedList[$key]->userInfo = $this->user->getInfoById($value['user_id']);
            if (Auth::check()) {
                $classifiedList[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'classified');
            }
            $cid = $value['id'];
        }
        if (isset($cid)) {
            $nextClassified = $this->post->loadMoreClassifiedPost($cid, $request->location, $request->town);
            if ($nextClassified->isEmpty()) {
                $info['hideClassifiedButton'] = 1;
            } else {
                $info['hideClassifiedButton'] = 0;
            }
        }

        $info['location'] = $request->location;
        $info['town'] = $request->town;
        $info['postList'] = $postList;
        $info['eventList'] = $eventList;
        $info['classifiedList'] = $classifiedList;
        $info['neighbourPostList'] = $neighbourPostList;
        $info['top10Post'] = $top10Post;
        return view('article.details', compact('info'));
    }

    /**
     * Show the post details view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function neighborDetails(Request $request) {
        $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
        $request->town = ucwords(str_replace(array('-'), array(' '), $request->town));
        $request->guid = str_replace(array(' '), array('-'), $request->guid);
        $postDetails = $this->post->getNeighborDetails($request->location, $request->town, $request->guid);
        $postList = $this->post->locationPost($request->location, $request->town);
        $eventList = $this->post->getEvent($request->location, $request->town);
        $classifiedList = $this->post->getClassified($request->location, $request->town);
        $neighbourPostList = $this->post->getNeighbourPost($request->location, $request->town);
        $top10Post = $this->post->getLiveLocationPost($request->location, $request->town);
        $postDetails->userInfo = $this->user->getInfoById($postDetails['post_author']);
        if (Auth::check()) {
            $postDetails->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $postDetails['id'], 'neighbour');
        }
        $postDetails->reply = $this->post->getReplyDetails($postDetails['id'], $postDetails['id']);
        foreach ($postDetails->reply as $key => $value) {
            $postDetails->reply[$key]->userInfo = $this->user->getInfoById($value['user_id']);
            if (Auth::check()) {
                $postDetails->reply[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'neighbour_reply');
            }
            $postDetails->reply[$key]->commentReply = $this->post->getReplyDetails($postDetails['id'], $value['id']);
        }
        foreach ($postDetails->reply as $key => $rvalue) {
            foreach ($rvalue['commentReply'] as $key2 => $crvalue) {
                $postDetails->reply[$key]->commentReply[$key2]->userInfo = $this->user->getInfoById($crvalue['user_id']);
                if (Auth::check()) {
                    $postDetails->reply[$key]->commentReply[$key2]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $crvalue['id'], 'neighbour_reply');
                }
            }
        }
        $info = $postDetails;
        foreach ($postList as $key => $value) {
            $postList[$key]->userInfo = $this->user->getInfoById($value['post_author']);
            if (Auth::check()) {
                $postList[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'article');
            }
            $pid = $value['id'];
        }
        if (isset($pid)) {
            $nextPost = $this->post->loadMoreLocationPost($pid, $request->location, $request->town);
            if ($nextPost->isEmpty()) {
                $info['hidePostButton'] = 1;
            } else {
                $info['hidePostButton'] = 0;
            }
        }

        foreach ($neighbourPostList as $key => $value) {
            $neighbourPostList[$key]->userInfo = $this->user->getInfoById($value['post_author']);
            if (Auth::check()) {
                $neighbourPostList[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'neighbour');
            }
            $neighbourPostList[$key]->reply = $this->post->getReplyDetails($value['id'], $value['id']);
            foreach ($neighbourPostList[$key]->reply as $key1 => $value1) {
                $neighbourPostList[$key]->reply[$key1]->userInfo = $this->user->getInfoById($value1['user_id']);
                if (Auth::check()) {
                    $neighbourPostList[$key]->reply[$key1]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value1['id'], 'neighbour_reply');
                }
                $neighbourPostList[$key]->reply[$key1]->commentReply = $this->post->getReplyDetails($value['id'], $value1['id']);
            }
            foreach ($neighbourPostList[$key]->reply as $key3 => $rvalue) {
                foreach ($rvalue['commentReply'] as $key4 => $crvalue) {
                    $neighbourPostList[$key]->reply[$key3]->commentReply[$key4]->userInfo = $this->user->getInfoById($crvalue['user_id']);
                    if (Auth::check()) {
                        $neighbourPostList[$key]->reply[$key3]->commentReply[$key4]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $crvalue['id'], 'neighbour_reply');
                    }
                }
            }
            if ($postDetails['id'] != $value['id']) {
                $nid = $value['id'];
            }
        }
        if (isset($nid)) {
            $nextNeighbor = $this->post->loadMoreNeighbourLocationPost($nid, $request->location, $request->town);
            if ($nextNeighbor->isEmpty()) {
                $info['hideNeighborButton'] = 1;
            } else {
                $info['hideNeighborButton'] = 0;
            }
        }
        foreach ($eventList as $key => $value) {
            if (Auth::check()) {
                $eventList[$key]->userIntrestInfo = $this->post->getIntrestedInfo(Auth::id(), $value['id']);
            }
            $eid = $value['id'];
        }
        if (isset($eid)) {
            $nextEvent = $this->post->loadMoreEventPost($eid, $request->location, $request->town);
            if ($nextEvent->isEmpty()) {
                $info['hideEventButton'] = 1;
            } else {
                $info['hideEventButton'] = 0;
            }
        }
        foreach ($classifiedList as $key => $value) {
            $classifiedList[$key]->userInfo = $this->user->getInfoById($value['user_id']);
            if (Auth::check()) {
                $classifiedList[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'classified');
            }
            $cid = $value['id'];
        }
        if (isset($cid)) {
            $nextClassified = $this->post->loadMoreClassifiedPost($cid, $request->location, $request->town);
            if ($nextClassified->isEmpty()) {
                $info['hideClassifiedButton'] = 1;
            } else {
                $info['hideClassifiedButton'] = 0;
            }
        }

        $info['location'] = $request->location;
        $info['town'] = $request->town;
        $info['postList'] = $postList;
        $info['eventList'] = $eventList;
        $info['classifiedList'] = $classifiedList;
        $info['neighbourPostList'] = $neighbourPostList;
        $info['top10Post'] = $top10Post;
        return view('details.neighbor', compact('info'));
    }

    public function search_community(Request $request) {
        if ($request->ajax()) {
            $data = Communitie::join('regions', 'regions.id', '=', 'communities.region_id')
                    ->select('communities.name', 'communities.id', 'regions.region_code')
                    ->where('communities.name', 'LIKE', $request->communitie . '%')
                    ->get();
            $output = '';
            if (count($data) > 0) {
                $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
                foreach ($data as $row) {
                    $output .= '<li class="list-group-item" style="cursor: pointer;">' . $row->name . ', ' . $row->region_code . '<input type="hidden" value="' . $row->id . '" name="communiti_id" class="cid"></li>';
                }
                $output .= '</ul>';
            } else {
                $output .= '<li class="list-group-item">' . 'No results' . '</li>';
            }
            return $output;
        }
    }

    public function store(Request $request) {
        $request->validate([
            'post_title' => 'required',
            'post_subtitle' => 'required',
            'post_category' => 'required',
            'post_content' => 'required'
        ]);
        $location_array = explode(',', $request->select_location_input);
        $path = storage_path('tmp/uploads/' . Auth::id());
        $path2 = base_path('public/images/' . date('Y/m/d/'));
        if (!file_exists($path2)) {
            mkdir($path2, 0777, true);
        }
        $image_name = '';
        foreach ($request->input('images', []) as $file) {
            \File::copy($path . '/' . $file, base_path('public/images/' . date('Y/m/d/') . $file));
            \File::delete($path . '/' . $file);
            \File::deleteDirectory(storage_path('tmp/uploads/') . Auth::id());
            $image_name = $file;
        }
        $article = new Post();
        $article->post_title = $request->post_title;
        $article->post_subtitle = $request->post_subtitle;
        $article->post_category = $request->post_category;
        $article->post_content = $request->post_content;
        $article->post_author = Auth::id();
        $article->post_date = date('Y-m-d H:i:s');
        $article->post_image = $image_name;
        $article->location = trim($location_array[1]);
        $article->town = trim($location_array[0]);
        $article->post_type = 'article';
        $article->post_status = $request->post_status;
        $article->like_count = '0';
        $article->comment_count = '0';
        $guid = sanitizeStringForUrl(trim($location_array[1])) . '/' . sanitizeStringForUrl(trim($location_array[0])) . '/' . sanitizeStringForUrl(trim($request->post_title));
        $article->guid = $guid;
        $article->save();
        if ($request->post_status == 'draft') {
            $routeLink = route('manage-draft-post');
        } else {
            $routeLink = route('manage-post');
        }
        return Redirect::to($routeLink)->with('success', 'Article created successfully.!');
    }

    public function edit($id) {
        if (!Auth::check()) {
            $route = route('user.register') . '?ru=' . url()->full();
            return Redirect::to($route);
        }
        $info = Post::find($id);
        $info->edit = 1;
        return view('article.add', compact('info'));
    }

    public function update(Request $request) {
        $request->validate([
            'post_title' => 'required',
            'post_subtitle' => 'required',
            'post_category' => 'required',
            'post_content' => 'required'
        ]);
        $location_array = explode(',', $request->select_location_input);
        $path = storage_path('tmp/uploads/' . Auth::id());
        $path2 = base_path('public/images/' . date('Y/m/d/'));
        if (!file_exists($path2)) {
            mkdir($path2, 0777, true);
        }
        $image_name = '';
        foreach ($request->input('images', []) as $file) {
            if (file_exists($path . '/' . $file)) {
                $imageName = Post::find($request->id);
                \File::delete(base_path('public/images/' . date('Y/m/d/', strtotime($imageName->created_at)) . $imageName->post_image));
                \File::copy($path . '/' . $file, base_path('public/images/' . date('Y/m/d/', strtotime($imageName->created_at)) . $file));
                \File::delete($path . '/' . $file);
                \File::deleteDirectory(storage_path('tmp/uploads/') . Auth::id());
            }
            $image_name = $file;
        }
        $article = Post::find($request->id);
        $article->post_title = $request->post_title;
        $article->post_subtitle = $request->post_subtitle;
        $article->post_category = $request->post_category;
        $article->post_content = $request->post_content;
        $article->post_author = Auth::id();
        $article->post_image = $image_name;
        $article->location = trim($location_array[1]);
        $article->town = trim($location_array[0]);
        $article->post_type = 'article';
        $article->post_status = $request->post_status;
        $article->like_count = '0';
        $article->comment_count = '0';
        $guid = sanitizeStringForUrl(trim($location_array[1])) . '/' . sanitizeStringForUrl(trim($location_array[0])) . '/' . sanitizeStringForUrl(trim($request->post_title));
        $article->guid = $guid;
        if ($article->save()) {
            if ($request->post_status == 'draft') {
                $routeLink = route('manage-draft-post');
            } else {
                $routeLink = route('manage-post');
            }
            return Redirect::to($routeLink)->with('message', 'Article update successfully.!');
        } else {
            Session::flash('message', 'Data not updated!');
            Session::flash('alert-class', 'alert-danger');
        }
        return Back()->withInput();
    }

    public function destroy($id) {
        Post::destroy($id);
        $routeLink = route('manage-post');
        return Redirect::to($routeLink)->with('message', 'Article delete successfully.!');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload_image(Request $request) {
        $path = storage_path('tmp/uploads/' . Auth::id());

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
                    'name' => $name,
                    'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function delete_image(Request $request) {
        $path = storage_path('tmp/uploads/' . Auth::id());
        if ($request->get('name')) {
            \File::delete($path . '/' . $request->get('name'));
        }
    }

    public function neighborCompose(Request $request) {
        if (!Auth::check()) {
            $route = route('user.register') . '?ru=' . url()->full();
            return Redirect::to($route);
        }
        $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
        $request->town = ucwords(str_replace(array('-'), array(' '), $request->town));
        $info['location'] = $request->location;
        $info['town'] = $request->town;
        return view('compose.compose', compact('info'));
    }

    public function storeNeighborPost(Request $request) {
        $request->validate([
            'post_content' => 'required'
        ]);
        $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
        $request->town = ucwords(str_replace(array('-'), array(' '), $request->town));
        $name = uploadFile($request->file('images'));
        $article = new Post();
        $article->post_title = '';
        $article->post_subtitle = '';
        $article->post_category = '';
        $article->post_content = $request->post_content;
        $article->post_author = Auth::id();
        $article->post_date = date('Y-m-d H:i:s');
        $article->post_image = $name;
        $article->location = trim($request->location);
        $article->town = trim($request->town);
        $article->post_type = 'neighbour';
        $article->post_status = 'active';
        $article->like_count = '0';
        $article->comment_count = '0';
        $article->guid = '';
        $article->save();
        if ($request->session()->has('user_home_rote')) {
            $routeLink = $request->session()->get('user_home_rote');
        } else {
            $routeLink = route('home');
        }
        return Redirect::to($routeLink)->with('success', 'Article created successfully.!');
    }

    public function dashboard() {
        return view('dashboard');
    }

    public function addComment(Request $request) {
        $image_name = '';
        foreach ($request->input('images', []) as $file) {
            \File::copy($path . '/' . $file, base_path('public/images/' . date('Y/m/d/') . $file));
            \File::delete($path . '/' . $file);
            \File::deleteDirectory(storage_path('tmp/uploads/') . Auth::id());
            $image_name = $file;
        }
        $comment = PostComment::create(
                        [
                            'user_id' => $request->user_id,
                            'post_id' => $request->post_id,
                            'parent_id' => $request->parent_id,
                            'comment' => $request->comment,
                            'image' => $image_name,
                            'like_count' => $request->like_count,
                            'type' => 'article'
                        ]
        );
        $id = $comment->id;
        Post::where('deleted_at', null)->where('id', $request->post_id)->increment('comment_count', 1);
        $count = PostComment::where('post_id', $request->post_id)->count();
        $body = '<div class="st_Thread st_Thread--collapsed styles_Thread__3lAiJ" id="reply_div_' . $id . '">
                                    <section>
                                        <div class="st_Card__Content">
                                            <div class="st_Card__TextContentWrapper reply_' . $id . '">
                                                <div class="byline byline--avatar">
                                                    <a href="javascript:void(0);">';
        if (!is_null(Auth::user()->profile_image) && Auth::user()->profile_image != '')
            $body .= '<img class = "avatar-img" src = "' . getUserImageUrl(Auth::user()->profile_image) . '" />';
        else
            $body .= '<i class = "fa fa-user-circle avatar-icon avatar-icon--base"></i>';
        $body .= '</a>
                                                    <div class="byline__wrapper">
                                                        <a class="byline__name byline__name--avatar">
                                                            <strong>' . Auth::user()->name . '</strong>, Neighbor
                                                        </a>
                                                        <div class="byline__row">
                                                            <a class="byline__secondary" href="javascript:void(0);">' . getLocationLink(1) . '</a>
                                                            <span class="st_Card__LabelDivider">|</span>
                                                            <a class="byline__secondary" href="javascript:void(0);" rel="nofollow">
                                                                <time datetime="now">Now</time>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="st_Card__Body body_remove_' . $id . '">
                                                    <p>' . $request->comment . '</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="st_ActionBar action_remove_' . $id . '">
                                            <div class="st_ActionBar__BarLeft">
                                                <button aria-label="thank" class="Button_ActionBar like_button-post" type="button" data-postid="' . $id . '" data-type="reply">
                                                    <span class="Button_ActionBar__Icon"><i class="far fa-heart"></i></span>
                                                    <span class="Button_ActionBar__Label"> Thank(0) </span>
                                                </button>
                                                ' . (!isset($request->reply_comment) ? '<a class="st_Card__ReplyLink comment_reply" data-postid="' . $id . '">
                                                    <i class="far fa-comment st_Card__ReplyLinkIcon"></i> Reply 
                                                </a>' : '') . '
                                            </div>
                                            <div class="st_ActionBar__BarRight">
                                                <div class="st_FlagMenu">
                                                    <div aria-label="flags" class="dropdown">
                                                        <div class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" id="js-content-flag-menu-article-29727567" disabled="">
                                                            <button aria-label="flag" class="Button--flag" type="button"> <span class="st_Button__Icon"><i class="fas fa-ellipsis-h"></i></span> </button>
                                                            <div class="flag-menu">
                                                                <ul class="dropdown-menu dropdown-menu-right" data-option="edit" data-postid="' . $id . '">
                                                                    <li class="st_FlagItem__link dropdown-item">
                                                                        <span>Edit</span><span></span></li>
                                                                    <li class="st_FlagItem__link dropdown-item">
                                                                        <span>Delete</span><span></span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>';
        $post = Post::find($request->post_id);
        $user = User::find($post->post_author);
        if ($user->replies_posts == 1) {
            if ($post->post_author != Auth::id()) {
                $data = [
                    'link' => route('home') . '/p/' . $post->guid . '#reply_block_article_nid',
                    'name' => Auth::user()->name,
                    'user_id' => Auth::id(),
                ];
                Mail::to($user->email)->send(new PostReplyMail($data));
            }
        }
        $dataStore = array();
        $dataStore['body'] = $body;

        $dataStore['author'] = Auth::user();
        $dataStore['count'] = $count;
        return json_encode($dataStore);
    }

    public function editComment(Request $request) {
        PostComment::updateOrCreate(
                [
                    'id' => $request->id
                ], [
            'comment' => $request->comment,
                ]
        );
        $reply = $this->post->getReplyById($request->id);
        $body = '<div class="st_Card__Body body_remove_' . $request->id . '">
                    <p>' . $request->comment . '</p>
                </div>';
        $reply->body = $body;
        echo \GuzzleHttp\json_encode($reply);
    }

    public function deleteComment(Request $request) {
        PostComment::where('id', $request->id)->delete();
        Post::where('id', $request->post_id)->decrement('comment_count', 1);
        $count = PostComment::where('post_id', $request->post_id)->count();
        echo \GuzzleHttp\json_encode(array('status' => 'success', 'count' => $count));
    }

    public function addNeighborComment(Request $request) {
        $image_name = '';
        $image_name = uploadFile($request->file('images'));
//        $comment = PostComment::create(
//                        [
//                            'user_id' => $request->user_id,
//                            'post_id' => $request->post_id,
//                            'parent_id' => $request->parent_id,
//                            'comment' => $request->message,
//                            'like_count' => 0,
//                            'type' => 'neighbor',
//                            'image' => $image_name,
//                        ]
//        );
//        $id = $comment->id;
//        Post::where('deleted_at', null)->where('id', $request->post_id)->increment('comment_count', 1);
        $count = PostComment::where('post_id', $request->post_id)->count();

        $body = '<div class="st_Thread st_Thread--collapsed styles_Thread__3lAiJ" id="reply_div_' . $id . '">
                                    <section>
                                        <div class="st_Card__Content">
                                            <div class="st_Card__TextContentWrapper reply_' . $id . '">
                                                <div class="byline byline--avatar">
                                                    <a href="javascript:void(0);">';
        if (!is_null(Auth::user()->profile_image) && Auth::user()->profile_image != '')
            $body .= '<img class = "avatar-img" src = "' . getUserImageUrl(Auth::user()->profile_image) . '" />';
        else
            $body .= '<i class = "fa fa-user-circle avatar-icon avatar-icon--base"></i>';
        $body .= '</a>
                                                    <div class="byline__wrapper">
                                                        <a class="byline__name byline__name--avatar">
                                                            <strong>' . Auth::user()->name . '</strong>, Neighbor
                                                        </a>
                                                        <div class="byline__row">
                                                            <a class="byline__secondary" href="javascript:void(0);">' . getLocationLink(1) . '</a>
                                                            <span class="st_Card__LabelDivider">|</span>
                                                            <a class="byline__secondary" href="javascript:void(0);" rel="nofollow">
                                                                <time datetime="now">Now</time>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="st_Card__Body body_remove_' . $id . '">
                                                    <p>' . $request->message . '</p>
                                                </div>
                                            </div>';

        if ($image_name != '') {
            $body .= '<figure class="styles_Card__Thumbnail__1-_Rw">
                                                        <img class="styles_Card__ThumbnailImage" src="' . postgetImageUrl($image_name, date('Y-m-d H:i:s')) . '">
                                                    </figure>';
        }
        $body .= '</div>
                                        <div class="st_ActionBar action_remove_' . $id . '">
                                            <div class="st_ActionBar__BarLeft">
                                                <button aria-label="thank" class="Button_ActionBar like_button-post" type="button" data-postid="' . $id . '" data-type="neighbour_reply">
                                                    <span class="Button_ActionBar__Icon"><i class="far fa-heart"></i></span>
                                                    <span class="Button_ActionBar__Label"> Thank(0) </span>
                                                </button>
                                                ' . (!isset($request->reply_comment) ? '<a class="st_Card__ReplyLink comment_reply" data-postid="' . $id . '"  data-nei="' . $request->post_id . '">
                                                    <i class="far fa-comment st_Card__ReplyLinkIcon"></i> Reply 
                                                </a>' : '') . '
                                            </div>
                                            <div class="st_ActionBar__BarRight">
                                                <div class="st_FlagMenu">
                                                    <div aria-label="flags" class="dropdown">
                                                        <div class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" id="js-content-flag-menu-article-29727567" disabled="">
                                                            <button aria-label="flag" class="Button--flag" type="button"> <span class="st_Button__Icon"><i class="fas fa-ellipsis-h"></i></span> </button>
                                                            <div class="flag-menu">
                                                                <ul class="dropdown-menu dropdown-menu-right" data-option="edit" data-postid="' . $id . '" data-nei="' . $request->post_id . '" >
                                                                    <li class="st_FlagItem__link dropdown-item">
                                                                        <span>Edit</span><span></span></li>
                                                                    <li class="st_FlagItem__link dropdown-item">
                                                                        <span>Delete</span><span></span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>';
        $post = Post::find($request->post_id);
        $user = User::find($post->post_author);
        if ($user->replies_posts == 1) {
            if ($post->post_author != Auth::id()) {
                $data = [
                    'link' => route('home') . '/n/' . sanitizeStringForUrl($post->location) . '/' . sanitizeStringForUrl($post->town) . '/' . $post->id . '#reply_block_article_nid',
                    'name' => Auth::user()->name,
                    'user_id' => Auth::id(),
                ];
                Mail::to($user->email)->send(new PostReplyMail($data));
            }
        }
        $dataStore = array();
        $dataStore['body'] = $body;
        $dataStore['postid'] = $request->post_id;
        $dataStore['author'] = Auth::user();
        $dataStore['count'] = $count;
        return json_encode($dataStore);
    }

}
