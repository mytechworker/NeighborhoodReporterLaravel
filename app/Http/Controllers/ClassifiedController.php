<?php

namespace App\Http\Controllers;

use App\User;
use App\Communitie;
use App\UserCommunitie;
use App\Classified;
use App\ClasifiedComment;
use App\ClasifiedContact;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\File\File;
use Mail;
use App\Mail\ContactMail;
use Session;
use App\Mail\PostReplyMail;

class ClassifiedController extends Controller {

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
        $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
        $request->town = ucwords(str_replace(array('-'), array(' '), $request->town));
        $info['location'] = $request->location;
        $info['town'] = $request->town;
        return view('compose.classified', compact('info'));
    }

    /**
     * Show the post details view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function details(Request $request) {
        $request->name = str_replace('-', ' ', $request->name);
        $request->id = str_replace('-', ' ', $request->id);
        $postDetails = $this->post->getClassifiedById($request->id);
        $request->location = $postDetails->location;
        $request->town = $postDetails->town;
        $eventList = $this->post->getEvent($request->location, $request->town);
        $classifiedList = $this->post->getClassified($request->location, $request->town);

        $postDetails->userInfo = $this->user->getInfoById($postDetails['user_id']);
        if (Auth::check()) {
            $postDetails->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $postDetails['id'], 'classified');
        }

        $postDetails->reply = $this->post->getClasifiedReplyDetails($postDetails['id'], $postDetails['id']);

        foreach ($postDetails->reply as $key => $value) {
            $postDetails->reply[$key]->userInfo = $this->user->getInfoById($value['user_id']);
            if (Auth::check()) {
                $postDetails->reply[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'classified_reply');
            }
            $postDetails->reply[$key]->commentReply = $this->post->getClasifiedReplyDetails($postDetails['id'], $value['id']);
        }
        foreach ($postDetails->reply as $key => $rvalue) {
            foreach ($rvalue['commentReply'] as $key2 => $crvalue) {
                $postDetails->reply[$key]->commentReply[$key2]->userInfo = $this->user->getInfoById($crvalue['user_id']);
                if (Auth::check()) {
                    $postDetails->reply[$key]->commentReply[$key2]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $crvalue['id'], 'classified_reply');
                }
            }
        }
        $info = $postDetails;
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
        $info['eventList'] = $eventList;
        $info['classifiedList'] = $classifiedList;
        return view('details.classified', compact('info'));
    }

    public function search_community(Request $request) {
        if ($request->ajax()) {
            $data = Communitie::join('regions', 'regions.id', '=', 'communities.region_id')
                    ->select('communities.name', 'communities.id', 'regions.region_code', 'regions.name AS rname')
                    ->where('communities.name', 'LIKE', $request->communitie . '%')
                    ->limit(5)
                    ->get();
            $output = '';
            if (count($data) > 0) {
                $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
                foreach ($data as $row) {
                    $output .= '<li class="list-group-item" style="cursor: pointer;">' . $row->name . ', ' . $row->rname . '<input type="hidden" value="' . $row->id . '" name="communiti_id" class="cid"></li>';
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
            'community' => 'required',
            'category' => 'required',
            'classifiedTitle' => 'required',
        ]);
        $location_array = explode(',', $request->community);
        $image_name = uploadFile($request->file('images'));
        $classified = new Classified();
        $classified->user_id = Auth::id();
        $classified->title = $request->classifiedTitle;
        $classified->category = $request->category;
        $classified->description = $request->description;
        $classified->image = $image_name;
        $classified->location = trim($location_array[1]);
        $classified->town = trim($location_array[0]);
        $classified->like_count = '0';
        $classified->comment_count = '0';
        $classified->save();
        $routeLink = route('manage-classified-post');
        return Redirect::to($routeLink)->with('message', 'Classified created successfully.!');
    }

    public function edit($id) {
        if (!Auth::check()) {
            $route = route('user.register') . '?ru=' . url()->full();
            return Redirect::to($route);
        }
        $info = Classified::find($id);
        $info->edit = 1;
        return view('compose.classified', compact('info'));
    }

    public function update(Request $request) {
        $request->validate([
            'community' => 'required',
            'category' => 'required',
            'classifiedTitle' => 'required',
        ]);
        $location_array = explode(',', $request->community);
        $image_name = Classified::find($request->id);
        $ImageName = $image_name->image;
        if (null !== $request->file('images')) {
            \File::delete(base_path('public/images/' . date('Y/m/d/', strtotime($image_name->created_at)) . $image_name->image));
            $ImageName = uploadFile($request->file('images'), $image_name->created_at);
        }
        $classified = Classified::find($request->id);
        $classified->title = $request->classifiedTitle;
        $classified->category = $request->category;
        $classified->description = $request->description;
        $classified->image = $ImageName;
        $classified->location = trim($location_array[1]);
        $classified->town = trim($location_array[0]);
        if ($classified->save()) {
            $routeLink = route('manage-classified-post');
            return Redirect::to($routeLink)->with('message', 'Classified update successfully.!');
        } else {
            Session::flash('message', 'Data not updated!');
            Session::flash('alert-class', 'alert-danger');
        }
        return Back()->withInput();
    }

    public function destroy($id) {
        Classified::destroy($id);
        $routeLink = route('manage-classified-post');
        return Redirect::to($routeLink)->with('message', 'Classified delete successfully.!');
    }

    public function addComment(Request $request) {
        $image_name = '';
        $image_name = uploadFile($request->file('images'));
        $comment = ClasifiedComment::create(
                        [
                            'user_id' => $request->user_id,
                            'classified_id' => $request->post_id,
                            'parent_id' => $request->parent_id,
                            'description' => $request->message,
                            'image' => $image_name,
                            'like_count' => 0
                        ]
        );
        $id = $comment->id;
        Classified::where('deleted_at', null)->where('id', $request->post_id)->increment('comment_count', 1);
        $count = ClasifiedComment::where('classified_id', $request->post_id)->count();
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
                                                <button aria-label="thank" class="Button_ActionBar like_button-post" type="button" data-postid="' . $id . '" data-type="classified_reply">
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
        $post = Classified::find($request->post_id);
        $user = User::find($post->user_id);
        if ($user->replies_posts == 1) {
            if ($post->user_id != Auth::id()) {
                $data = [
                    'link' => route('home') . '/c/' . $post->id . '/' . sanitizeStringForUrl($post->title) . '#reply_block_article_nid',
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
        ClasifiedComment::updateOrCreate(
                [
                    'id' => $request->id
                ], [
            'description' => $request->comment,
                ]
        );
        $reply = $this->post->getEventReplyById($request->id);
        $body = '<div class="st_Card__Body body_remove_' . $request->id . '">
                    <p>' . $request->comment . '</p>
                </div>';
        $reply->body = $body;
        echo \GuzzleHttp\json_encode($reply);
    }

    public function deleteComment(Request $request) {
        ClasifiedComment::where('id', $request->id)->delete();
        Classified::where('id', $request->post_id)->decrement('comment_count', 1);
        $count = ClasifiedComment::where('classified_id', $request->post_id)->count();
        echo \GuzzleHttp\json_encode(array('status' => 'success', 'count' => $count));
    }

    public function sendContact(Request $request) {
        ClasifiedContact::create(
                [
                    'classified_id' => $request->classifiedId,
                    'email' => $request->email,
                    'description' => $request->message
                ]
        );
        $postDetails = $this->post->getClassifiedById($request->classifiedId);
        $postDetails->userInfo = $this->user->getInfoById($postDetails['user_id']);
        $data = [
            'message' => $request->message,
            'email' => $request->email,
            'title' => $postDetails->title
        ];
        Mail::to($postDetails->userInfo->email)->send(new ContactMail($data));
        echo \GuzzleHttp\json_encode(array('status' => 'success'));
    }

}
