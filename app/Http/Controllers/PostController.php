<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use App\EventIntrest;
use App\Event;
use Auth;
use Redirect;

class PostController extends Controller {

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
        $request->guid = str_replace(array('-'), array(' '), $request->guid);
        return 'Location:- ' . $request->location . '   Town:- ' . $request->town . '   Guid:-' . $request->guid;
    }

    public function location(Request $request) {
        $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
        $request->town = ucwords(str_replace(array('-'), array(' '), $request->town));
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
//        echo 'Location:- ' . $request->location . '   Town:- ' . $request->town;
        return view('location', compact('info'));
    }

    public function marketplaceLocation(Request $request) {
        $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
        $request->town = ucwords(str_replace(array('-'), array(' '), $request->town));
        $postList = $this->post->locationPost($request->location, $request->town);
        $eventList = $this->post->getEvent($request->location, $request->town);
        $classifiedList = $this->post->getClassified($request->location, $request->town, 1);

        foreach ($postList as $key => $value) {
            $postList[$key]->userInfo = $this->user->getInfoById($value['post_author']);
            if (Auth::check()) {
                $postList[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'article');
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
        $info['location'] = $request->location;
        $info['town'] = $request->town;
        $info['category'] = '';
        $info['postList'] = $postList;
        $info['eventList'] = $eventList;
        $info['classifiedList'] = $classifiedList;
        return view('marketplace', compact('info'));
    }

    public function neighborLocation(Request $request) {
        $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
        $request->town = ucwords(str_replace(array('-'), array(' '), $request->town));
        $eventList = $this->post->getEvent($request->location, $request->town);
        $classifiedList = $this->post->getClassified($request->location, $request->town);
        $neighbourPostList = $this->post->getNeighbourPost($request->location, $request->town);

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
        }
        foreach ($classifiedList as $key => $value) {
            $classifiedList[$key]->userInfo = $this->user->getInfoById($value['user_id']);
            if (Auth::check()) {
                $classifiedList[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'classified');
            }
        }
        $info['location'] = $request->location;
        $info['town'] = $request->town;
        $info['eventList'] = $eventList;
        $info['classifiedList'] = $classifiedList;
        $info['neighbourPostList'] = $neighbourPostList;
        return view('neighbor', compact('info'));
    }

    public function categoryPost(Request $request) {
        $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
        $request->town = ucwords(str_replace(array('-'), array(' '), $request->town));
        $request->category = str_replace(array('-'), array(' '), ucwords($request->category));
        $postList = $this->post->locationCategoryPost($request->location, $request->town, $request->category);
        $eventList = $this->post->getEvent($request->location, $request->town);
        $classifiedList = $this->post->getClassified($request->location, $request->town);
        foreach ($postList as $key => $value) {
            $postList[$key]->userInfo = $this->user->getInfoById($value['post_author']);
            if (Auth::check()) {
                $postList[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'article');
            }
            $pid = $value['id'];
        }
        if (isset($pid)) {
            $nextPost = $this->post->loadMoreCategoryPost($pid, $request->location, $request->town, $request->category);
            if ($nextPost->isEmpty()) {
                $info['hidePostButton'] = 1;
            } else {
                $info['hidePostButton'] = 0;
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
        $info['location'] = $request->location;
        $info['town'] = $request->town;
        $info['category'] = $request->category;
        $info['postList'] = $postList;
        $info['eventList'] = $eventList;
        $info['classifiedList'] = $classifiedList;
        return view('category', compact('info'));
    }

    public function categoryClassified(Request $request) {
        $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
        $request->town = ucwords(str_replace(array('-'), array(' '), $request->town));
        $request->category = str_replace(array('-'), array(' '), ucwords($request->category));
        $postList = $this->post->locationPost($request->location, $request->town);
        $eventList = $this->post->getEvent($request->location, $request->town);
        $classifiedList = $this->post->getCategoryClassified($request->location, $request->town, $request->category);
        foreach ($postList as $key => $value) {
            $postList[$key]->userInfo = $this->user->getInfoById($value['post_author']);
            if (Auth::check()) {
                $postList[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'article');
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
        $info['location'] = $request->location;
        $info['town'] = $request->town;
        $info['category'] = $request->category;
        $info['postList'] = $postList;
        $info['eventList'] = $eventList;
        $info['classifiedList'] = $classifiedList;
        return view('marketplace', compact('info'));
    }

    /**
     * Show the application location page loadmore.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function loadMoreData(Request $request) {
        $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
        $request->town = ucwords(str_replace(array('-'), array(' '), $request->town));
        if ($request->id > 0) {
            $postList = $this->post->loadMoreLocationPost($request->id, $request->location, $request->town);
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
                                        <img alt="' . $lpost['post_title'] . '" class="styles_Card__ThumbnailImage" src="' . postgetImageUrl($lpost['post_image'], $lpost['post_date']) . '" />
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
                                        <a class="st_Card__ReplyLink" href="/p/' . $lpost['guid'] . '#reply_block_article_nid=' . $lpost['id'] . '">
                                            <i class="far fa-comment st_Card__ReplyLinkIcon"></i>
                                            Reply(' . $lpost['comment_count'] . ') 
                                        </a>
                                        <button class="Button_ActionBar share share-button" data-title="' . $lpost['post_title'] . '" data-url="' . $lpost['guid'] . '" type="button"> 
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
            $output .= '<a class="st_Section__linkButton" href="javascript:void(0);" name="load_more_button" data-url="' . route("location-load-data") . '" data-id="' . $last_id . '" id="load_more_button">See more local news</a>';
        } else {
            $output .= '';
        }
        return $output;
    }

    /**
     * Show the application category page loadmore.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function loadCategoryMoreData(Request $request) {
        $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
        $request->town = ucwords(str_replace(array('-'), array(' '), $request->town));
        $request->category = str_replace(array(' '), array('-'), ucwords($request->category));
        if ($request->id > 0) {
            $postList = $this->post->loadMoreCategoryPost($request->id, $request->location, $request->town, $request->category);
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
                                        <img alt="' . $lpost['post_title'] . '" class="styles_Card__ThumbnailImage" src="' . asset('images/' . $lpost['post_image']) . '" srcset="' . asset('images/' . $lpost['post_image']) . '?width=174 174w,' . asset('images/' . $lpost['post_image']) . '?width=600 600w" sizes="(min-width: 768px) 174px, calc(100vw - 32px)" />
                                        <noscript> <img alt="' . $lpost['post_title'] . '" class="st_Card__ThumbnailImage" src="' . asset('images/' . $lpost['post_image']) . '" /> </noscript>
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
                                        <a class="st_Card__ReplyLink" href="/p/' . $lpost['guid'] . '#reply_block_article_nid=' . $lpost['id'] . '">
                                            <i class="far fa-comment st_Card__ReplyLinkIcon"></i>
                                            Reply(' . $lpost['comment_count'] . ') 
                                        </a>
                                        <button class="Button_ActionBar share share-button" data-title="' . $lpost['post_title'] . '" data-url="' . $lpost['guid'] . '" type="button"> 
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
            $output .= '<a class="st_Section__linkButton" href="javascript:void(0);" name="load_more_button" data-url="' . route("category-load-data") . '" data-id="' . $last_id . '" id="load_more_button">See more local news</a>';
        } else {
            $output .= '';
        }
        return $output;
    }

    /**
     * Show the application event on location page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function eventMoreData(Request $request) {
        $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
        $request->town = ucwords(str_replace(array('-'), array(' '), $request->town));
        if ($request->id > 0) {
            $eventList = $this->post->loadMoreEventPost($request->id, $request->location, $request->town);
        }

        $output = '';
        $event_last_id = '';
        if (!$eventList->isEmpty()) {
            foreach ($eventList as $key => $value) {
                if (Auth::check()) {
                    $eventList[$key]->userIntrestInfo = $this->post->getIntrestedInfo(Auth::id(), $value['id']);
                }
            }
            foreach ($eventList as $epost) {
                $output .= '<article class="st_Card event_' . $epost['id'] . '" id="event_' . $epost['id'] . '">
                                <div class="st_Card__Content">
                                    <div class="st_Card__TextContentWrapper ">
                                        <h6 class="st_Card__LabelWrapper"><span>Local Event</span></h6>
                                        <div class="st_EventDetailsWrapper">
                                            <div class="calendar-icon">
                                                <div class="calendar-icon__date">
                                                    <strong class="calendar-icon__month">' . \Carbon\Carbon::parse($epost['date'])->format('M') . '</strong>
                                                    <strong class="calendar-icon__day">' . \Carbon\Carbon::parse($epost['date'])->format('d') . '</strong>
                                                </div>
                                            </div>
                                            <div class="st_TextWrapper">
                                                <h2 class="st_Card__Title">
                                                    <a href="/e/' . $epost['id'] . '/' . sanitizeStringForUrl($epost['title']) . '">
                                                        ' . $epost['title'] . '
                                                    </a>
                                                </h2>
                                                <p class="st_EventDateAndTime__eventDetails">
                                                    <time class="st_EventDateAndTime__eventDetail_1">
                                                        <i class="fa fa-clock"></i>' . \Carbon\Carbon::parse($epost['date'])->format('l') . ', ' . \Carbon\Carbon::parse($epost['time'])->format('h:i') . ' ' . $epost['am_pm'] . '
                                                    </time>
                                                    <span class="st_EventDateAndTime__eventDetail_1">
                                                        <i class="fa fa-map-marker-alt"></i>
                                                        <a title="' . $epost['town'] . ',' . $epost['location'] . '" href="/l/' . sanitizeStringForUrl($epost['location']) . '/' . sanitizeStringForUrl($epost['town']) . '">
                                                            <span class="st_EventDateAndTime__PatchName">' . $epost['town'] . ',' . $epost['location'] . '</span>
                                                        </a>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>';
                if ($epost['image'] != '') {
                    $output .= '<a class="st_Card__Thumbnail__1">
                        <img src="' . postgetImageUrl($epost['image'], $epost['created_at']) . '" />
                    </a>';
                }
                $output .= '</div>
                                <div class="st_ActionBar">
                                    <div class="st_ActionBar__BarLeft">
                                        <button class="Button_ActionBar intrest_button-post" data-postid="' . $epost['id'] . '" type="button"> <span class="Button_ActionBar__Icon">
                                                ' . (isset($epost['userIntrestInfo']) && !$epost['userIntrestInfo']->isEmpty() ? '<i class="fas fa-star red_start"></i>' : '<i class="far fa-star"></i>') . '
                                            </span> 
                                            <span class="Button_ActionBar__Label__2BXDN">Interested (' . $epost['intrest_count'] . ')</span> </button>
                                        <a class="st_Card__ReplyLink" href="/e/' . $epost['id'] . '/' . sanitizeStringForUrl($epost['title']) . '`#reply_block_article_nid=29727567"> <i class="far fa-comment st_Card__ReplyLinkIcon"></i> Reply (' . $epost['comment_count'] . ')</a>
                                        <button class="Button_ActionBar share share-button" data-title="' . $epost['title'] . '" data-url="/p/' . $epost['title'] . '" type="button"> 
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
                                                        <ul class="dropdown-menu dropdown-menu-right" data-postid="' . $epost['id'] . '" data-type="event">
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
                                <div class="st_Thread__3lAiJ st_Thread--collapsed__3gBro">
                                    <section data-nosnippet="true"></section>
                                </div>
                            </article>';
                $event_last_id = $epost->id;
            }
            $output .= '<a class="st_Section__linkButton" href="javascript:void(0);" name="load_more_button" data-url="' . route("event-load-data") . '" data-id="' . $event_last_id . '" id="load_more_event_button">See more events</a> ';
        } else {
            $output .= '';
        }
        return $output;
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
                        . '                 <time datetime="' . $cpost['created_at'] . '">' . getPostTime($cpost['created_at']) . '</time>
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

    /**
     * Show the application location page loadmore.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function neighbourMoreData(Request $request) {
        $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
        $request->town = ucwords(str_replace(array('-'), array(' '), $request->town));
        $postList = $this->post->loadMoreNeighbourLocationPost($request->id, $request->location, $request->town);

        $output = '';
        $last_id = '';
        if (!$postList->isEmpty()) {
            foreach ($postList as $key => $value) {
                $postList[$key]->userInfo = $this->user->getInfoById($value['post_author']);
                if (Auth::check()) {
                    $postList[$key]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value['id'], 'neighbour');
                }
                $postList[$key]->reply = $this->post->getReplyDetails($value['id'], $value['id']);
                foreach ($postList[$key]->reply as $key1 => $value1) {
                    $postList[$key]->reply[$key1]->userInfo = $this->user->getInfoById($value1['user_id']);
                    if (Auth::check()) {
                        $postList[$key]->reply[$key1]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $value1['id'], 'neighbour_reply');
                    }
                    $postList[$key]->reply[$key1]->commentReply = $this->post->getReplyDetails($value['id'], $value1['id']);
                }
                foreach ($postList[$key]->reply as $key3 => $rvalue) {
                    foreach ($rvalue['commentReply'] as $key4 => $crvalue) {
                        $postList[$key]->reply[$key3]->commentReply[$key4]->userInfo = $this->user->getInfoById($crvalue['user_id']);
                        if (Auth::check()) {
                            $postList[$key]->reply[$key3]->commentReply[$key4]->userLikeInfo = $this->post->getLikeInfo(Auth::id(), $crvalue['id'], 'neighbour_reply');
                        }
                    }
                }
            }
            foreach ($postList as $npost) {

                $output .= '<article class="st_Card">
                                <div class="st_Card__Content">
                                    <div class="st_Card__TextContentWrapper">
                                        <h6 class="st_Card__LabelWrapper">
                                            <a class="byline__secondary" title="' . $npost['town'] . ',' . $npost['location'] . '" href="/l/' . sanitizeStringForUrl($npost['location']) . '/' . sanitizeStringForUrl($npost['town']) . '">
                                                ' . $npost['town'] . ', ' . $npost['location'] . '
                                            </a>
                                            <span class="st_Card__LabelDivider">|</span>
                                            <span>Neighbor Post</span>
                                            <span class="st_Card__LabelDivider">|</span>
                                            <a class="byline__secondary">
                                                <time datetime="' . $npost['created_at'] . '">' . \Carbon\Carbon::parse($npost['created_at'])->format('M d') . '</time>
                                            </a>
                                        </h6>
                                        <div class="byline byline--avatar">
                                            <a>';
                if (!is_null($npost['userInfo']->profile_image) && $npost['userInfo']->profile_image != '') {
                    $output .= '<img class="avatar-img" src="' . getUserImageUrl($npost['userInfo']->profile_image) . '" />';
                } else {
                    $output .= '<i class="fa fa-user-circle avatar-icon--small"></i>';
                }
                $output .= '</a>
                                            <div class="byline__wrapper">
                                                <div>
                                                    <a class="byline__name byline__name--avatar">
                                                        <strong>' . $npost['userInfo']->name . '</strong>, Neighbor
                                                    </a>
                                                    <span class="st_Badges"></span>
                                                </div>
                                                <div class="byline__row"></div>
                                            </div>
                                        </div>
                                        <div class="st_Card__Body st_Card__Body--Truncated">
                                            <p>' . $npost['post_content'] . '</p>
                                        </div>
                                        <div>
                                            <button class="btn--link btn--link-base" type="button">Read more</button>
                                        </div>
                                    </div>';
                if ($npost['post_image'] != '') {
                    $output .= ' <a class="st_Card__Thumbnail__1" href="/n/' . sanitizeStringForUrl($npost['location']) . '/' . sanitizeStringForUrl($npost['town']) . '/' . $npost['id'] . '">
                                        <img src="' . postgetImageUrl($npost['post_image'], $npost['created_at']) . '" />
                                    </a>';
                }
                $output .= '</div>
                                <div class="st_ActionBar">
                                    <div class="st_ActionBar__BarLeft">
                                        <button aria-label="thank" class="Button_ActionBar like_button-post" data-postid="' . $npost['id'] . '" data-type="neighbour" type="button">
                                            <span class="Button_ActionBar__Icon">
                                                ' . (isset($npost['userLikeInfo']) && !$npost['userLikeInfo']->isEmpty() ? '<i class="fas fa-heart"></i>' : '<i class="far fa-heart"></i>') . '
                                            </span> 
                                            <span class="Button_ActionBar__Label">
                                                Thank(' . $npost['like_count'] . ')
                                            </span>
                                        </button>
                                        <a class="st_Card__ReplyLink" href="/n/' . sanitizeStringForUrl($npost['location']) . '/' . sanitizeStringForUrl($npost['town']) . '/' . $npost['id'] . '#reply_block_article_nid">
                                            <i class="far fa-comment st_Card__ReplyLinkIcon"></i>
                                            Reply(' . $npost['comment_count'] . ') 
                                        </a>
                                        <button class="Button_ActionBar share share-button" data-title="' . $npost['post_title'] . '" data-url="/n/' . sanitizeStringForUrl($npost['location']) . '/' . sanitizeStringForUrl($npost['town']) . '/' . $npost['id'] . '" type="button"> 
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
                                                        <ul class="dropdown-menu dropdown-menu-right" data-postid="' . $npost['id'] . '" data-type="neighbour">
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
                                ' . view('neighbor_comment', compact('npost'))->render() . '
                            </article>';
                $last_id = $npost->id;
            }
            $output .= '<a class="st_Section__linkButton" href="javascript:void(0);" name="load_more_button" data-url="' . route("neighbour-load-data") . '" data-id="' . $last_id . '" id="load_more_neighbour_button">See more neighbor posts</a> ';
        } else {
            $output .= '';
        }
        return $output;
    }

    public function eventIntrest(Request $request) {
        $user_id = Auth::id();
        $post_id = $request->post_id;
        $output = '';
        $PostLike = EventIntrest::where('user_id', $user_id)->where('event_id', $post_id)->get();
        if (!$PostLike->isEmpty()) {
            EventIntrest::where('user_id', $user_id)->where('event_id', $post_id)->delete();
            Event::where('deleted_at', null)->where('id', $post_id)->decrement('intrest_count', 1);
            $count = $this->post->getEventById($post_id)->intrest_count;
            $output = '<span class="Button_ActionBar__Icon"><i class="far fa-star"></i></span> 
                       <span>Interested (' . ($count) . ')</span>';
        } else {
            EventIntrest::Create(
                    [
                        'user_id' => $user_id,
                        'event_id' => $post_id,
                    ]
            );
            Event::where('deleted_at', null)->where('id', $post_id)->increment('intrest_count', 1);
            $count = $this->post->getEventById($post_id)->intrest_count;
            $output = '<span class="red_start"><i class="fas fa-star"></i></span> 
                       <span>Interested (' . ($count) . ')</span>';
        }
        return json_encode(array('html' => $output, 'count' => $count));
    }

}
