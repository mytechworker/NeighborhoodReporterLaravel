<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Redirect;

class MarketplaceController extends Controller {

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
     * Show the post details view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request) {
        $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
        $request->town = ucwords(str_replace(array('-'), array(' '), $request->town));
        $eventList = $this->post->getEvent($request->location, $request->town);
        $classifiedList = $this->post->getClassified($request->location, $request->town, 1);
        $businessList = $this->post->getBizPost($request->location, $request->town);
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
        $info['category'] = '';
        $info['eventList'] = $eventList;
        $info['classifiedList'] = $classifiedList;
        $info['bizPost'] = $businessList;
        return view('marketplace', compact('info'));
    }

    public function categoryClassified(Request $request) {
        $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
        $request->town = ucwords(str_replace(array('-'), array(' '), $request->town));
        $request->category = str_replace(array('-'), array(' '), ucwords($request->category));

        $eventList = $this->post->getEvent($request->location, $request->town);
        $classifiedList = $this->post->getCategoryClassified($request->location, $request->town, $request->category);
        $businessList = $this->post->getBizPost($request->location, $request->town);
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
            $cid = $value['id'];
        }
        if (isset($cid)) {
            $nextClassified = $this->post->loadMoreCategoryClassifiedPost($cid, $request->location, $request->town, $request->category);
            if ($nextClassified->isEmpty()) {
                $info['hideClassifiedButton'] = 1;
            } else {
                $info['hideClassifiedButton'] = 0;
            }
        }
        $info['location'] = $request->location;
        $info['town'] = $request->town;
        $info['category'] = $request->category;
        $info['eventList'] = $eventList;
        $info['classifiedList'] = $classifiedList;
        $info['bizPost'] = $businessList;
        return view('marketplace', compact('info'));
    }

    /**
     * Show the application classified page loadmore.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function classifiedMoreData(Request $request) {
        $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
        $request->town = ucwords(str_replace(array('-'), array(' '), $request->town));
        if ($request->id > 0) {
            if (isset($request->category) && !empty($request->category)) {
                $classifiedList = $this->post->loadMoreCategoryClassifiedPost($request->id, $request->location, $request->town, $request->category);
            } else {
                $classifiedList = $this->post->loadMoreClassifiedPost($request->id, $request->location, $request->town);
            }
        }

        $output = '';
        $last_id = '';
        if (!$classifiedList->isEmpty()) {
            foreach ($classifiedList as $key => $value) {
                $classifiedList[$key]->userInfo = $this->user->getInfoById($value['user_id']);
                if (Auth::check()) {
                    $classifiedList[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'classified');
                }
            }
            foreach ($classifiedList as $cpost) {
                $output .= '<article class="st_Card st_Card--FeaturedClassified classified_' . $cpost['id'] . '" id="classified_' . $cpost['id'] . '">
                            <div class="st_Card__Content">
                                <div class="st_Card__TextContentWrapper">
                                    <h6 class="st_Card__LabelWrapper">
                                        <a class="byline__secondary" title="' . $cpost['town'] . ',' . $cpost['location'] . '" href="/l/' . sanitizeStringForUrl($cpost['location']) . '/' . sanitizeStringForUrl($cpost['town']) . '">
                                            ' . $cpost['town'] . ', ' . $cpost['location'] . '
                                        </a>
                                        <span class="st_Card__LabelDivider">|</span>
                                        <span>Local Classified</span>
                                        <span class="st_Card__LabelDivider">|</span>
                                        <span>' . $cpost['category'] . '</span>
                                        <span class="st_Card__LabelDivider">|</span>
                                        
                                        <a class="byline__secondary" href="/c/' . $cpost['id'] . '/' . sanitizeStringForUrl($cpost['title']) . '">'
                        . '                   <time datetime="' . $cpost['created_at'] . '">' . getPostTime($cpost['created_at']) . '</time>
                                        </a>
                                    </h6>
                                    <div class="byline byline--avatar">';
                if ($cpost['userInfo']->profile_image == '') {
                    $output .= '<a><i class = "fa fa-user-circle avatar-icon--base"></i></a>';
                } else {
                    $output .= '<img alt = "' . $cpost['userInfo']->name . ' profile picture" class = "avatar-img" src = "' . asset('images/' . $cpost['userInfo']->profile_image) . '?width=36" />';
                }
                $output .= '<div class="byline__wrapper">
                                            <div>
                                                <a class="byline__name byline__name--avatar">
                                                    <strong>' . $cpost['userInfo']->name . '</strong>, Neighbor
                                                </a>
                                                <span class="st_Badges"></span>
                                            </div>
                                            <div class="byline__row"></div>
                                        </div>
                                    </div>
                                    <h2 class="st_Card__Title">
                                        <a class="st_Card__TitleLink" title="Peach Festival 2021" href="/c/' . $cpost['id'] . '/' . sanitizeStringForUrl($cpost['title']) . '">' . $cpost['title'] . '</a>
                                    </h2>
                                </div>';
                if ($cpost['image'] != '') {
                    $output .= '<a class = "st_Card__Thumbnail__1" href="/c/' . $cpost['id'] . '/' . sanitizeStringForUrl($cpost['title']) . '">
                <img src = "' . postgetImageUrl($cpost['image'], $cpost['created_at']) . '" />
                <noscript> <img class = "st_Card__ThumbnailImage" src = "' . postgetImageUrl($cpost['image'], $cpost['created_at']) . '" /> </noscript>
                </a>';
                }

                $output .= ' </div>
                            <div class="st_ActionBar">
                                <div class="st_ActionBar__BarLeft">
                                    <button aria-label="thank" class="Button_ActionBar like_button-post" data-postid="' . $cpost['id'] . '" data-type="classified" type="button">
                                        <span class="Button_ActionBar__Icon">
                                            ' . (isset($cpost['userLikeInfo']) && !$cpost['userLikeInfo']->isEmpty() ? '<i class="fas fa-heart"></i>' : '<i class="far fa-heart"></i>') . '
                                            </span> 
                                        <span class="Button_ActionBar__Label">
                                            Thank(' . $cpost['like_count'] . ')
                                        </span>
                                    </button>
                                    <a class="st_Card__ReplyLink" href="/c/' . $cpost['id'] . '/' . sanitizeStringForUrl($cpost['title']) . '#reply_block_article_nid=' . $cpost['id'] . '">
                                        <i class="far fa-comment st_Card__ReplyLinkIcon"></i>
                                        Reply
                                        (' . $cpost['comment_count'] . ')
                                    </a>
                                    <button class="Button_ActionBar share share-button" data-title="' . $cpost['title'] . '" data-url="/c/' . $cpost['id'] . '/' . sanitizeStringForUrl($cpost['title']) . '" type="button"> 
                                        <span class="Button_ActionBar__Icon">
                                            <i class="fas fa-share"></i>
                                        </span>
                                        <span class="Button_ActionBar__Label">Share</span> 
                                    </button>
                                </div>
                                <div class="st_ActionBar__BarRight">
                                    <div class="st_FlagMenu">
                                        <div aria-label="flags" class="dropdown">
                                            <div class="js-content-flag-menu" aria-haspopup="true" aria-expanded="false" disabled="">
                                                <button aria-label="flag" class="Button--flag dropdown-toggle" type="button"> 
                                                    <span class="st_Button__Icon"><i class="far fa-flag"></i></span> 
                                                </button>
                                                <div class="flag-menu">
                                                    <ul class="dropdown-menu dropdown-menu-right" data-postid="' . $cpost['id'] . '" data-type="classified">
                                                        <li class="st_FlagMenu__label">Reason for reporting:</li>
                                                        <li class="st_FlagItem__link dropdown-item"><span>Spam</span></li>
                                                        <li class="st_FlagItem__link dropdown-item"><span>Promotional</span></li>
                                                        <li class="st_FlagItem__link dropdown-item"><span>Disagree</span></li>
                                                        <li class="st_FlagItem__link dropdown-item"><span>Not Local</span></li>
                                                        <li class="st_FlagItem__link dropdown-item"><span>Unverified</span></li>
                                                        <li class="st_FlagItem__link dropdown-item"><span>Offensive</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>';
                $last_id = $cpost->id;
            }
            $output .= '<a class="st_Section__linkButton" href="javascript:void(0);" name="load_more_button" data-url="' . route("classified-load-data") . '" data-id="' . $last_id . '" id="load_more_classified_button">See more Classifieds</a> ';
        } else {
            $output .= '';
        }
        return $output;
    }

}
