<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Event;
use App\Classified;
use App\Communitie;
use App\SettingEmail;
use App\UserCommunitie;
use App\PostComment;
use App\EventComment;
use App\ClasifiedComment;
use App\Subscriber;
use Illuminate\Http\Request;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Redirect;
use App\Region;
use Mail;
use App\Mail\SubscribeMail;
use App\Mail\KeepWithMail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserController extends Controller {

    private $post;
    private $user;

    public function __construct(PostRepository $postRepository, UserRepository $UserRepository) {
        $this->post = $postRepository;
        $this->user = $UserRepository;
    }

    public function search_community(Request $request) {
        if ($request->ajax()) {

            $data = Communitie::join('regions', 'regions.id', '=', 'communities.region_id')
                    ->select('communities.name', 'communities.id', 'regions.region_code')
                    ->where('communities.name', 'LIKE', '%' . $request->communitie . '%')
                    ->get();

            $output = '';

            if (count($data) > 0) {

                $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';

                foreach ($data as $row) {

                    $output .= '<li data-id="' . $row->id . '" class="list-group-item" style="cursor: pointer;">' . $row->name . ', ' . $row->region_code . '</li>';
                }

                $output .= '</ul>';
            } else {

                $output .= '<li class="list-group-item">' . 'No results' . '</li>';
            }

            return $output;
        }
    }

    public function register(Request $request) {
        if (!Auth::check()) {
            if (null !== $request->location) {
                $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
                $request->town = ucwords(str_replace(array('-'), array(' '), $request->town));
                $info['location'] = $request->location;
                $info['town'] = $request->town;
                return view('register', compact('info'));
            } else {
                return view('register');
            }
        } else {
            if (Auth::user()->type == 'Superadmin' || Auth::user()->type == 'Admin') {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('home');
            }
        }
    }

    public function user_register(Request $request) {
        $input = $request->all();

        $this->validate($request, [
            'community' => 'required',
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->type = 'user';
        $user->company_news = 1;
        $user->replies_posts = 1;
        $user->provider = 'website';
        $user->save();

        $user_community = new UserCommunitie();
        $user_community->user_id = $user->id;
        $user_community->communitie_id = $request->community_id;
        $user_community->default = 1;
        $user_community->save();

        $settingemail = new SettingEmail();
        $settingemail->user_id = $user->id;
        $settingemail->community_id = $request->community_id;
        $settingemail->daily_news = 1;
        $settingemail->breacking_news = 1;
        $settingemail->community_cal = 1;
        $settingemail->neighbor_posts = 1;
        $settingemail->classifieds = 1;
        $settingemail->save();

        $community = Communitie::where('id', $user_community->communitie_id)->first();
        $user_region = Region::where('id', $community->region_id)->first();
        $data = [
            'user_community' => $community->name,
            'user_region' => $user_region->name,
            'user_id' => $settingemail->user_id,
        ];
        Mail::to($request->email)->send(new SubscribeMail($data));

        return redirect()->back()->with('message', 'Register Successfully!');
    }

    public function dashboard() {
        return view('dashboard');
    }

    public function view_profile(Request $request) {
        if (!Auth::check()) {
            $route = route('user.register') . '?ru=' . url()->full();
            return Redirect::to($route);
        } else {
            $segment = request()->segment(2);
            $getlocation = getLocationLink();
            $location = explode("/", $getlocation);
            $request->location = ucwords(str_replace(array('-'), array(' '), $location[0]));
            $request->town = ucwords(str_replace(array('-'), array(' '), $location[1]));
            $postList = $this->post->locationPost($request->location, $request->town);
            $eventList = $this->post->getEvent($request->location, $request->town);
            $classifiedList = $this->post->getClassified($request->location, $request->town);
            $neighbourPostList = $this->post->getNeighbourPost($request->location, $request->town);
            $top10Post = $this->post->getLiveLocationPost($request->location, $request->town);
            foreach ($postList as $key => $value) {
                $postList[$key]->userInfo = $this->user->getInfoById($value['post_author']);
                if (Auth::check()) {
                    $postList[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'article');
                }
            }
            foreach ($neighbourPostList as $key => $value) {
                $neighbourPostList[$key]->userInfo = $this->user->getInfoById($value['post_author']);
                if (Auth::check()) {
                    $neighbourPostList[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'neighbour');
                }
            }
            foreach ($eventList as $key => $value) {
                if (Auth::check()) {
                    $eventList[$key]->userIntrestInfo = $this->post->getIntrestedInfo(Auth::id(), $value['id']);
                }
            }
            foreach ($classifiedList as $key => $value) {
                $classifiedList[$key]->userInfo = $this->user->getInfoById($value['user_id']);
                if (Auth::check()) {
                    $classifiedList[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'classified');
                }
            }
            $neighbourpost = Post::where('post_author', Auth::user()->id)->where('post_status', 'active')->where('post_type', 'neighbour')->count();

            if ($segment == '' || empty($segment) || $segment == 'post') {
                $posts = Post::where('post_author', Auth::user()->id)->where('post_status', 'active')->where('post_type', 'neighbour')->get();
                foreach ($posts as $key => $value) {
                    $posts[$key]->userInfo = $this->user->getInfoById($value['post_author']);
                    if (Auth::check()) {
                        $posts[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'neighbour');
                    }
                    $pid = $value['id'];
                }
                if (isset($pid)) {
                    $nextPost = $this->post->loadMoreLocationPost($pid, $request->location, $request->town);
                    if ($nextPost->isEmpty()) {
                        $info['hideNeighborButton'] = 1;
                    } else {
                        $info['hideNeighborButton'] = 0;
                    }
                }
            } elseif ($segment == 'articles') {
                $posts = Post::where('post_author', Auth::user()->id)->where('post_status', 'active')->where('post_type', 'article')->get();
                foreach ($posts as $key => $value) {
                    $posts[$key]->userInfo = $this->user->getInfoById($value['post_author']);
                    if (Auth::check()) {
                        $posts[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'article');
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
            } elseif ($segment == 'events') {
                $events = Event::where('user_id', Auth::user()->id)->get();
                foreach ($events as $key => $value) {
                    // $events[$key]->userInfo = $this->user->getInfoById($value['post_author']);
                    // if (Auth::check()) {
                    //     $events[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'article');
                    // }
                    if (Auth::check()) {
                        $events[$key]->userIntrestInfo = $this->post->getIntrestedInfo(Auth::id(), $value['id']);
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
            } elseif ($segment == 'classifieds') {
                $classifieds = Classified::where('user_id', Auth::id())->get();
                foreach ($classifieds as $key => $value) {
                    $classifieds[$key]->userInfo = $this->user->getInfoById($value['user_id']);
                    if (Auth::check()) {
                        $classifieds[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'classified');
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
            } elseif ($segment == 'reply') {
                $reply = array();
                $reply['article'] = PostComment::where('user_id', Auth::id())->where('type', 'article')->orderBy('id', 'DESC')->get();
                $reply['neighbor'] = PostComment::where('user_id', Auth::id())->where('type', 'neighbor')->orderBy('id', 'DESC')->get();
                $reply['event'] = EventComment::where('user_id', Auth::id())->orderBy('id', 'DESC')->get();
                $reply['classified'] = ClasifiedComment::where('user_id', Auth::id())->orderBy('id', 'DESC')->get();
                foreach ($reply['article'] as $key => $value) {
                    $reply['article'][$key]->userInfo = $this->user->getInfoById($value['user_id']);
                }
                foreach ($reply['neighbor'] as $key => $value) {
                    $reply['neighbor'][$key]->userInfo = $this->user->getInfoById($value['user_id']);
                }
                foreach ($reply['event'] as $key => $value) {
                    $reply['event'][$key]->userInfo = $this->user->getInfoById($value['user_id']);
                }
                foreach ($reply['classified'] as $key => $value) {
                    $reply['classified'][$key]->userInfo = $this->user->getInfoById($value['user_id']);
                }
            }

            $info['location'] = $request->location;
            $info['town'] = $request->town;
            $info['postList'] = $postList;
            $info['eventList'] = $eventList;
            $info['classifiedList'] = $classifiedList;
            $info['neighbourPostList'] = $neighbourPostList;
            $info['top10Post'] = $top10Post;
            if ($segment == '' || empty($segment) || $segment == 'post') {
                $info['nposts'] = $posts;
            } else if ($segment == 'articles') {
                $info['posts'] = $posts;
            } elseif ($segment == 'events') {
                $info['events'] = $events;
            } elseif ($segment == 'classifieds') {
                $info['classifieds'] = $classifieds;
            } elseif ($segment == 'reply') {
                $info['reply'] = $reply;
            }
            return view('view_profile', compact('info', 'neighbourpost'));
        }
    }

    public function redirectPost(Request $request) {
        switch ($request->type) {
            case 'article':
                $post = $this->post->getInfoById($request->id);
                $link = route('home') . '/p/' . $post->guid . '#reply_block_article_nid';
                break;
            case 'neighbor':
                $post = $this->post->getInfoById($request->id);
                $link = route('home') . '/n/' . sanitizeStringForUrl($post->location) . '/' . sanitizeStringForUrl($post->town) . '/' . $post->id . '#reply_block_article_nid';
                break;
            case 'event':
                $post = $this->post->getEventById($request->id);
                $link = route('home') . '/e/' . $post->id . '/' . sanitizeStringForUrl($post->title) . '#reply_block_article_nid';
                break;
            case 'classified':
                $post = $this->post->getClassifiedById($request->id);
                $link = route('home') . '/c/' . $post->id . '/' . sanitizeStringForUrl($post->title) . '#reply_block_article_nid';
                break;
        }
        return Redirect::to($link);
    }

    public function myCommunity() {
        if (!Auth::check()) {
            $route = route('user.register') . '?ru=' . url()->full();
            return Redirect::to($route);
        } else {
            return view('mycommunity');
        }
    }

    public function addCommunity(Request $request) {
        $count = UserCommunitie::where('user_id', Auth::id())->count();
        $idArray = explode(',', $request->addIds);
        $removeIds = explode(',', $request->removeIds);
        if (null !== $request->community) {
            $user_community = Communitie::where('name', $request->community)->first();
            $idArray[] = $user_community->id;
        }
        if (count($idArray) > 0) {
            foreach ($idArray as $key => $value) {
                if ($value != '') {
                    UserCommunitie::updateOrCreate(
                            [
                                'user_id' => Auth::id(),
                                'communitie_id' => $value,
                            ], [
                        'user_id' => Auth::id(),
                        'communitie_id' => $value,
                        'default' => '0',
                        'deleted_at' => null
                            ]
                    );
                    $settingemail = new SettingEmail();
                    $settingemail->user_id = Auth::id();
                    $settingemail->community_id = $value;
                    $settingemail->daily_news = 1;
                    $settingemail->breacking_news = 1;
                    $settingemail->community_cal = 1;
                    $settingemail->neighbor_posts = 1;
                    $settingemail->classifieds = 1;
                    $settingemail->save();
                }
            }
        }
        if (count($removeIds) > 0) {
            foreach ($removeIds as $key => $value) {
                UserCommunitie::where('user_id', Auth::id())->where('communitie_id', $value)->delete();
                SettingEmail::where('user_id', Auth::id())->where('community_id', $value)->delete();
            }
        }
        if (null !== $request->community) {
            $user_region = Region::where('id', $user_community->region_id)->first();
            $data = [
                'user_community' => (isset($user_community->name) ? $user_community->name : ""),
                'user_region' => $user_region->name,
                'user_id' => Auth::id(),
            ];
            Mail::to(Auth::user()->email)->send(new SubscribeMail($data));
        }
        echo \GuzzleHttp\json_encode(array('status' => 'success'));
    }

    public function addFollower(Request $request) {
        if ($request->type == 'region') {
            $user_region = Region::where('name', 'like', "%" . $request->location . "%")->first();
            $Id = $user_region->id;
            $location = $user_region->name;
        } else {
            $l = $request->location;
            if (strpos($l, ',') !== false) {
                $request->location = explode(',', $request->location)[0];
            }
            $user_community = Communitie::where('name', 'like', "%" . $request->location . "%")->first();
            $user_region = Region::where('id', $user_community->region_id)->first();
            $Id = $user_community->id;
            $location = $user_community->name;
        }
        $subscriberCount = Subscriber::where('email', $request->email)->where('location_id', $Id)->where('type', $request->type)->count();
        if ($subscriberCount == 0) {
            $sub = Subscriber::where('email', $request->email)->first();
            if (empty($sub)) {
                $user = User::where('email', $request->email)->first();
                if (empty($user)) {
                    $uid = generateRandomNumeric(8);
                } else {
                    $uid = $user->id;
                }
            } else {
                $uid = $sub->user_id;
            }
            $settingemail = new SettingEmail();
            $settingemail->user_id = $uid;
            $settingemail->community_id = $Id;
            $settingemail->daily_news = 1;
            $settingemail->breacking_news = 1;
            $settingemail->community_cal = 1;
            $settingemail->neighbor_posts = 1;
            $settingemail->classifieds = 1;
            $settingemail->save();
            $subscriber = new Subscriber();
            $subscriber->email = $request->email;
            $subscriber->location_id = $Id;
            $subscriber->user_id = $settingemail->user_id;
            $subscriber->type = $request->type;
            $subscriber->status = 1;
            $subscriber->save();
            $data = [
                'user_community' => (isset($user_community->name) ? $user_community->name : ""),
                'user_region' => $user_region->name,
                'user_id' => $settingemail->user_id,
            ];
            Mail::to($request->email)->send(new SubscribeMail($data));
            Mail::to($request->email)->send(new KeepWithMail($data));
            if (strpos($l, ',') !== false) {
                echo \GuzzleHttp\json_encode(array('status' => 'success', 'url' => route('home') . '/' . sanitizeStringForUrl($user_community->name) . '/' . sanitizeStringForUrl($user_region->name) . '/register?&utm_source=invite-a-friend&utm_medium=web&utm_campaign=invite', 'message' => 'Subscribed successfully.!'));
            } else {
                echo \GuzzleHttp\json_encode(array('status' => 'success', 'message' => 'Subscribed successfully.!'));
            }
        } else {
            echo \GuzzleHttp\json_encode(array('status' => 'fail', 'message' => 'Look like you are already get updates from ' . $location . '!'));
        }
    }

    public function removeFollower(Request $request) {
        if (null !== $request->community) {
            $user_community = Communitie::where('name', $request->community)->first();
        }
        UserCommunitie::where('user_id', Auth::id())->where('communitie_id', $user_community->id)->delete();
        SettingEmail::where('user_id', Auth::id())->where('community_id', $user_community->id)->delete();
        echo \GuzzleHttp\json_encode(array('status' => 'success'));
    }

}
