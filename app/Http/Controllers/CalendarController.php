<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use App\EventIntrest;
use App\Event;
use Auth;
use Redirect;

class CalendarController extends Controller {

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
        $getCalendarEvent = $this->post->getCalendarEvent($request->location, $request->town);
        $eventList = $this->post->getEvent($request->location, $request->town);
        $classifiedList = $this->post->getClassified($request->location, $request->town);
        foreach ($getCalendarEvent as $key => $value) {
            if (Auth::check()) {
                $getCalendarEvent[$key]->userIntrestInfo = $this->post->getIntrestedInfo(Auth::id(), $value['id']);
            }
        }
        $final = array();
        foreach ($getCalendarEvent as $key => $value) {
            $final[strtotime($value['date'])][] = $value;
        }
        $info['location'] = $request->location;
        $info['town'] = $request->town;
        $info['calendarEvent'] = $final;
        $info['eventList'] = $eventList;
        $info['classifiedList'] = $classifiedList;
        return view('calendar', compact('info'));
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
                                        <a class="st_Card__ReplyLink" href="/e/' . $epost['id'] . '/' . sanitizeStringForUrl($epost['title']) . '`#reply_block_article_nid=29727567"> <i class="far fa-comment st_Card__ReplyLinkIcon"></i> Reply (' . $epost['comment_count'] . ') </a>
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
            $output .= '<a class="st_Section__linkButton" href="javascript:void(0);" name="load_more_button">No data found</a>';
        }
        return $output;
    }

    public function getFilterData(Request $request) {
        $request->location = ucwords(str_replace(array('-'), array(' '), $request->location));
        $request->town = ucwords(str_replace(array('-'), array(' '), $request->town));
        if (null !== $request->startTime) {
            $eventList = $this->post->getCalendarFilterEvent($request->location, $request->town, $request->startTime, $request->endTime, $request->pager);
        } else {
            $eventList = $this->post->getCalendarEvent($request->location, $request->town, $request->pager);
        }
        $output = '';
        if (!$eventList->isEmpty()) {
            foreach ($eventList as $key => $value) {
                if (Auth::check()) {
                    $eventList[$key]->userIntrestInfo = $this->post->getIntrestedInfo(Auth::id(), $value['id']);
                }
            }
            $final = array();
            foreach ($eventList as $key => $value) {
                $final[strtotime($value['date'])][] = $value;
            }
            foreach ($final as $key => $vpost) {
                $date = \Carbon\Carbon::parse(date('Y-m-d H:i:s', $key))->format('l, F j');
                if ($request->last_date != $date) {
                    $output .= '<section class="styles_EventFeedSection__3KgsA">
                            <h4 class="st_EventFeedSection">' . $date . '</h4>';
                }
                foreach ($vpost as $epost) {
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
                }
                if ($request->last_date != $date) {
                    $output .= '</section>';
                }
            }
            $more = 1;
        } else {
            $output .= '<h4 class="st_EventFeedSection">That’s all!</h4>
                            <div class="st-calltoaction">
                                <a class="st-calltoaction-title" href="/' . sanitizeStringForUrl($request->location) . '/' . sanitizeStringForUrl($request->town) . '/compose/event" rel="nofollow">Promoting an event?</a>
                                <p class="st-calltoaction-description">Make your event the talk of the town.</p><a class="st-calltoaction-button" href="/' . sanitizeStringForUrl($request->location) . '/' . sanitizeStringForUrl($request->town) . '/compose/event" rel="nofollow">Post your event on Neighborhood Reporter</a>
                            </div>';
            $more = 0;
        }
        $dataStore['more'] = $more;
        $dataStore['html'] = $output;
        return \GuzzleHttp\json_encode($dataStore);
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
