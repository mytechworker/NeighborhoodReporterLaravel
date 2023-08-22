<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use App\Region;
//use App\Classified;
use App\PostLike;
use App\PostReport;
use Auth;
use Illuminate\Support\Facades\Redirect;

//use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use Session;

class HomeController extends Controller {

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

    /**
     * Show the application home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request) {
        if (Auth::check()) {
            $route = $request->session()->get('user_home_rote');
            return Redirect::to($route);
        }
        if ($request->session()->has('last_id')) {
            $last_id = $request->session()->get('last_id');
            $postList = $this->post->paginationMorePost($last_id);
        } else {
            $postList = $this->post->all();
        }
        $top10Post = $this->post->getLivePost();
        $tradingPost = $this->post->getTradingPost();
        foreach ($postList as $key => $value) {
            $postList[$key]->userInfo = $this->user->getInfoById($value['post_author']);
            if (Auth::check()) {
                $postList[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'article');
            }
            $pid = $value['id'];
        }

        if (isset($pid)) {
            $nextPost = $this->post->loadMorePost($pid);
            if ($nextPost->isEmpty()) {
                $info['hidePostButton'] = 1;
            } else {
                $info['hidePostButton'] = 0;
            }
        }
        foreach ($top10Post as $key => $value) {
            $top10Post[$key]->regionInfo = Region::where('name', $value['location'])->first();
        }
        $info['postList'] = $postList;
        $info['top10Post'] = $top10Post;
        $info['tradingPost'] = $tradingPost;
        return view('home', compact('info'));
    }

    /**
     * Show the application region.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function region(Request $request) {
        $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
        if ($request->session()->has('last_id')) {
            $last_id = $request->session()->get('last_id');
            $postList = $this->post->paginationMoreRegionPost($last_id, $request->location);
        } else {
            $postList = $this->post->allRegionPost($request->location);
        }
        $top10Post = $this->post->getLivePost();
        $tradingPost = $this->post->getTradingPost();
        foreach ($postList as $key => $value) {
            $postList[$key]->userInfo = $this->user->getInfoById($value['post_author']);
            if (Auth::check()) {
                $postList[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'article');
            }
            $pid = $value['id'];
        }
        if (isset($pid)) {
            $nextPost = $this->post->loadMoreRegionPost($pid, $request->location);
            if ($nextPost->isEmpty()) {
                $info['hidePostButton'] = 1;
            } else {
                $info['hidePostButton'] = 0;
            }
        }
        $info['location'] = $request->location;
        $info['postList'] = $postList;
        $info['top10Post'] = $top10Post;
        $info['tradingPost'] = $tradingPost;
        return view('region', compact('info'));
    }

    /**
     * Show the application home page loadmore.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function loadMoreData(Request $request) {
        if ($request->id > 0) {
            if (isset($request->location) && !empty($request->location)) {
                $postList = $this->post->loadMoreRegionPost($request->id, $request->location);
            } else {
                $postList = $this->post->loadMorePost($request->id);
            }
        }
        $output = '';
        $last_id = '';
        if (!$postList->isEmpty()) {
            foreach ($postList as $key => $value) {
                $postList[$key]->userInfo = $this->user->getInfoById($value['post_author']);
                if (Auth::check()) {
                    $postList[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'article');
                }
            }
            foreach ($postList as $lpost) {
                $output .= '<article class="st_Card article_' . $lpost['id'] . '" id="article_' . $lpost['id'] . '">
                                <div class="st_Card__Content">
                                    <div class="st_Card__TextContentWrapper">
                                        <h6 class="st_Card__LabelWrapper">
                                            <a class="st_Card__CommunityName" title="' . $lpost['town'] . ',' . $lpost['location'] . '" href="/l/' . sanitizeStringForUrl($lpost['location']) . '/' . sanitizeStringForUrl($lpost['town']) . '">
                                                <i class="fa fa-map-marker-alt"></i>
                                                <span>' . $lpost['town'] . ',' . $lpost['location'] . '</span>
                                            </a>
                                            <span class="st_Card__LabelDivider">|</span>
                                            <time datetime="' . $lpost['created_at'] . '">' . getPostTime($lpost['created_at']) . '</time>
                                        </h6>
                                        <h2 class="st_Card__Title">
                                            <a class="st_Card__TitleLink" title="' . $lpost['post_title'] . '" href="/p/' . $lpost['guid'] . '">
                                                ' . $lpost['post_title'] . '
                                            </a>
                                        </h2>
                                        <p class="st_Card__Description">' . $lpost['post_subtitle'] . '</p>
                                        <div class="st_Card__BylineWrapper">
                                            <img alt="' . $lpost['userInfo']->name . ' profile picture" class="avatar-img" src="' . asset('images/' . $lpost['userInfo']->profile_image) . '?width=36" />
                                            <noscript>
                                            <img alt="' . $lpost['userInfo']->name . ' profile picture" class="avatar-img" src="' . asset('images/' . $lpost['userInfo']->profile_image) . '?width=36" />
                                            </noscript>
                                            <span class="st_Card__Byline">
                                                ' . $lpost['userInfo']->name . ',
                                                Neighborhood Reporter Staff
                                            </span>
                                            <span class="st_Badges">
                                                <img alt="Verified Patch Staff Badge" src="' . asset('images/nr-logo.svg') . '" />
                                                <noscript><img alt="Verified Patch Staff Badge" src="' . asset('images/nr-logo.svg') . '" /></noscript>
                                            </span>
                                        </div>
                                    </div>
                                    <a class="st_Card__Thumbnail" title="' . $lpost['post_title'] . '" href="/p/' . $lpost['guid'] . '">
                                        <img alt="' . $lpost['post_title'] . '" class="styles_Card__ThumbnailImage" src="' . postgetImageUrl($lpost['post_image'], $lpost['post_date']) . '"/>
                                        <noscript> <img alt="' . $lpost['post_title'] . '" class="st_Card__ThumbnailImage" src="' . postgetImageUrl($lpost['post_image'], $lpost['post_date']) . '" /> </noscript>
                                    </a>
                                </div>
                                <div class="st_ActionBar">
                                    <div class="st_ActionBar__BarLeft">
                                        <button aria-label="thank" class="Button_ActionBar like_button-post" data-postid="' . $lpost['id'] . '" type="button">
                                            <span class="Button_ActionBar__Icon">
                                            ' . (isset($lpost['userLikeInfo']) && !$lpost['userLikeInfo']->isEmpty() ? '<i class="fas fa-heart"></i>' : '<i class="far fa-heart"></i>') . '
                                            </span> 
                                            <span class="Button_ActionBar__Label">
                                                Thank(' . $lpost['like_count'] . ')
                                            </span>
                                        </button>
                                        <a class="st_Card__ReplyLink" href="/p/' . $lpost['guid'] . '#reply_block_article_nid=29727567">
                                            <i class="far fa-comment st_Card__ReplyLinkIcon"></i>
                                            Reply(' . $lpost['comment_count'] . ') 
                                        </a>
                                        <button class="Button_ActionBar share share-button" data-title="' . $lpost['post_title'] . '" data-url="/p/' . $lpost['guid'] . '" type="button"> 
                                            <span class="Button_ActionBar__Icon">
                                                <i class="fas fa-share"></i>
                                            </span>
                                            <span class="Button_ActionBar__Label">Share</span> 
                                        </button>
                                    </div>
                                    <div class="st_ActionBar__BarRight">
                                        <div class="st_FlagMenu">
                                            <div aria-label="flags" class="dropdown">
                                                <div class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" id="js-content-flag-menu-article-29727567" disabled="">
                                                    <button aria-label="flag" class="Button--flag" type="button"> <span class="st_Button__Icon"><i class="far fa-flag"></i></span> </button>
                                                    <div class="flag-menu">
                                                        <ul class="dropdown-menu dropdown-menu-right">
                                                            <li class="st_FlagMenu__label">Reason for reporting:</li>
                                                            <li class="st_FlagItem__link dropdown-item"><span>Spam</span><span></span></li>
                                                            <li class="st_FlagItem__link dropdown-item"><span>Promotional</span><span></span></li>
                                                            <li class="st_FlagItem__link dropdown-item"><span>Disagree</span><span></span></li>
                                                            <li class="st_FlagItem__link dropdown-item"><span>Not Local</span><span></span></li>
                                                            <li class="st_FlagItem__link dropdown-item"><span>Unverified</span><span></span></li>
                                                            <li class="st_FlagItem__link dropdown-item"><span>Offensive</span><span></span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>';
                $last_id = $lpost->id;
            }
            session(['last_id' => $last_id]);
            $output .= '<a class="st_Section__linkButton" href="javascript:void(0);" name="load_more_button" data-url="' . route("load-data") . '" data-id="' . $last_id . '" id="load_more_button">See more local news</a>';
        } else {
            $output .= '';
        }
        return $output;
    }

    public function postLike(Request $request) {
        $user_id = Auth::id();
        $post_id = $request->post_id;
        $type = $request->type;
        $output = '';
        $PostLike = PostLike::where('user_id', $user_id)->where('post_id', $post_id)->where('type', $type)->get();
        if (!$PostLike->isEmpty()) {
            PostLike::where('user_id', $user_id)->where('post_id', $post_id)->where('type', $type)->delete();
            $count = getDecrementLikeCount($type, $post_id);
            $output = '<span class="Button_ActionBar__Icon"><i class="far fa-heart"></i></span> 
                       <span class="Button_ActionBar__Label">Thank(' . ($count) . ')</span>';
        } else {
            PostLike::Create(
                    [
                        'user_id' => $user_id,
                        'post_id' => $post_id,
                        'type' => $type
                    ]
            );
            $count = getIncrementLikeCount($type, $post_id);
            $output = '<span class="Button_ActionBar__Icon"><i class="fas fa-heart"></i></span> 
                       <span class="Button_ActionBar__Label">Thank(' . ($count) . ')</span>';
        }
        return json_encode(array('html' => $output, 'count' => $count));
    }

    public function postReport(Request $request) {
        $user_id = Auth::id();
        $post_id = $request->post_id;
        $type = $request->type;
        $report = $request->report;
        $output = '';
        PostReport::updateOrCreate(
                [
                    'user_id' => $user_id,
                    'post_id' => $post_id,
                    'type' => $type
                ], [
            'report_type' => $report
                ]
        );
        return json_encode(array('status' => 'success'));
    }

}
