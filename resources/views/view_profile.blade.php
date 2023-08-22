@extends('layouts.app')
@section('title')
Neighborhood Reporter User Profile for {{ Auth::user()->name }}
@endsection
@section('meta')
@php
if (Auth::user()->profile_image != ''){
$image = getUserImageUrl(Auth::user()->profile_image);
} else {
$image = asset('images/logo.png');
}
@endphp
<!-- Primary Meta Tags -->
<meta name="title" content="Neighborhood Reporter User Profile for {{Auth::user()->name}}">
<meta name="description" content="News, stories, photos and information by {{Auth::user()->name}} on Neighborhood Reporter">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/view_profile">
<meta property="og:title" content="Neighborhood Reporter User Profile for {{Auth::user()->name}}">
<meta property="og:description" content="News, stories, photos and information by {{Auth::user()->name}} on Neighborhood Reporter">
<meta property="og:image" content="{{$image}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/view_profile">
<meta property="twitter:title" content="Neighborhood Reporter User Profile for {{Auth::user()->name}}">
<meta property="twitter:description" content="News, stories, photos and information by {{Auth::user()->name}} on Neighborhood Reporter">
<meta property="twitter:image" content="{{$image}}">
@endsection
<style>
    .user-img img {
        border-radius: 50%;
        width: 93px;
        height: 93px;
    }
    .reply-sec .st_Card--Same-Vertical-Space {
        padding-bottom: 16px;
    }
    .reply-sec .st_ReplyCard__Header {
        border-bottom: 1px solid #ccc;
        padding-bottom: 16px;
        margin-bottom: 16px;
    }
    .reply-sec .byline__row {
        color: #686868;
        display: flex;
        flex-flow: nowrap;
        margin-top: 2px;
        flex-basis: 100%;
    }
</style>
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="content-sec">

    <div class="container pad-0">
        <div class="row mar-mob">
            <div class="col-md-12 col-lg-8 pad-0">
                <main id="main" role="main" class="page__main viewpro-page">

                    <section class="st_Card viewpro">
                        <header class="st_Card__header">
                            <aside class="st_Card__avatarContainer">
                                @if(Auth::user()->profile_image == '')
                                <i class="fa fa-user-circle avatar-icon"></i>
                                @elseif (Auth::user()->profile_image && (substr(Auth::user()->profile_image, 0, 7) == "http://" || substr(Auth::user()->profile_image, 0, 8) == "https://"))
                                <div class="user-img">
                                    <img class="avatar-icon" src="{{ Auth::user()->profile_image }}" alt="{{ Auth::user()->name }}"/>
                                </div>
                                @else
                                <div class="user-img">
                                    <img class="avatar-icon" src="{{asset('images/'.Auth::user()->profile_image)}}" />
                                </div>
                                @endif
                            </aside>
                            <ul class="st_Card__details">
                                <li>
                                    <h1 class="st_Card__title">
                                        <strong>{{Auth::user()->name}},&nbsp;</strong>
                                        Neighbor <span class="st_Badges">
                                        </span>
                                    </h1>
                                </li>
                                @php
                                $getlocation =getLocationLink();
                                $location = explode("/",$getlocation);
                                @endphp 
                                <li>{{ucwords(str_replace('-', ' ', $location[0]))}}, {{ucwords(str_replace('-', ' ', $location[1]))}}</li>
                                @if(!empty($neighbourpost))
                                <li>{{$neighbourpost}}  Neighbor Points
                                    <i class="fa fa-info-circle" style="
                                       display: none;
                                       "></i>
                                    @else
                                <li>0  Neighbor Points
                                    <i class="fa fa-info-circle" style="
                                       display: none;
                                       "></i>
                                    @endif
                                </li>
                                @if(last(request()->segments()) == 'view_profile')
                                <script>sessionStorage.setItem("label", 'Posts');</script>
                                @endif
                            </ul>
                        </header>
                    </section>

                    <div class="page-title-wrapper classifieds">
                        <h2 class="page-title page-title-feed">Posting Activity</h2>

                        <div class="dropdown">
                            <button id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle--outlined dropdown-toggle btn">
                                <span id="drop-down-labe">Posts</span>
                                <i class="fa fa-caret-down icon icon--space-left"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li class="dropdown-item" id="list">
                                    <a class="card__link" id="articles" href="{{route('view_profile','articles')}}">
                                        <i class="far fa-newspaper icon--space-right"></i>Articles
                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a class="card__link" id="events" href="{{route('view_profile','events')}}">
                                        <i class="far fa-calendar-alt icon--space-right"></i>Events
                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a class="card__link" id="classifieds" href="{{route('view_profile','classifieds')}}">
                                        <i class="fas fa-clipboard-list icon--space-right"></i>Classifieds
                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a class="card__link" id="reply" href="{{route('view_profile','reply')}}">
                                        <i class="far fa-comment icon--space-right"></i>Replies
                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a class="card__link" id="post" style="display:none;" href="{{route('view_profile','post')}}">
                                        <i class="fas fa-pencil-alt icon--space-right"></i>Posts
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>

                    <section class="st_Section NeighborPosts-sec" data-nosnippet="true">
                        <input type="hidden" id="like_url" value="{{ route("post-like") }}">
                        <input type="hidden" id="intrest_url" value="{{ route("event-intrest") }}">

                        @if(isset($info['posts']))
                        <div id="loadData">
                            @php $last_id = 0; @endphp
                            @if(count($info['posts']) > 0)
                            @foreach($info['posts'] as $post)
                            <article class="st_Card article_{{$post['id']}}" id="article_{{$post['id']}}">
                                <div class="st_Card__Content">
                                    <div class="st_Card__TextContentWrapper">
                                        <h6 class="st_Card__LabelWrapper">
                                            <a class="byline__secondary" href="/l/{{sanitizeStringForUrl($post['location'])}}/{{sanitizeStringForUrl($post['town'])}}" title="{{$post['town']}},{{$post['location']}}">{{$post['town']}},{{$post['location']}}</a>
                                            <span class="st_Card__LabelDivider">|</span>
                                            <span>{{ucfirst($post['post_category'])}}</span>
                                            <span class="st_Card__LabelDivider">|</span>

                                            <a class="byline__secondary">
                                                <time datetime="{{$post['created_at']}}">{{getPostTime($post['created_at'])}}</time>
                                            </a>
                                        </h6>
                                        <h2 class="st_Card__Title">
                                            <a class="st_Card__TitleLink" title="{{$post['post_title']}}" href="/p/{{$post['guid']}}">
                                                {{$post['post_title']}}
                                            </a>
                                        </h2>
                                        <p class="st_Card__Description">{{$post['post_subtitle']}}</p>
                                    </div>
                                    @if($post['post_image'] != '')
                                    <a class="st_Card__Thumbnail" title="{{$post['post_title']}}" href="/p/{{$post['guid']}}">
                                        <img alt="{{$post['post_title']}}" class="styles_Card__ThumbnailImage" src="{{postgetImageUrl($post['post_image'],$post['created_at'])}}" />
                                    </a>
                                    @endif
                                </div>
                                <div class="st_ActionBar">
                                    <div class="st_ActionBar__BarLeft">
                                        <button aria-label="thank" class="Button_ActionBar like_button-post" data-postid="{{$post['id']}}" data-type="article" type="button">
                                            <span class="Button_ActionBar__Icon">
                                                <?php
                                                if (isset($post['userLikeInfo']) && !$post['userLikeInfo']->isEmpty()) {
                                                    echo '<i class="fas fa-heart"></i>';
                                                } else {
                                                    echo '<i class="far fa-heart"></i>';
                                                }
                                                ?> 
                                                <span class="Button_ActionBar__Label">
                                                    Thank({{$post['like_count']}})
                                                </span>
                                        </button>
                                        <a class="st_Card__ReplyLink" href="/p/{{$post['guid']}}#reply_block_article_nid={{$post['id']}}">
                                            <i class="far fa-comment st_Card__ReplyLinkIcon"></i>
                                            Reply({{$post['comment_count']}}) 
                                        </a>
                                        <button class="Button_ActionBar share share-button" data-title="{{$post['post_title']}}" data-url="/n/{{sanitizeStringForUrl($post['location'])}}/{{sanitizeStringForUrl($post['town'])}}/{{$post['id']}}" type="button"> 
                                            <span class="Button_ActionBar__Icon">
                                                <i class="fas fa-share"></i></span><span class="Button_ActionBar__Label">Share</span> </button>
                                    </div>

                                </div>
                            </article>
                            @php $last_id = $post['id']; @endphp
                            @endforeach

                            @endif
                        </div>
                        @if(count($info['posts']) > 0)
                        <a class="st_Section__linkButton" href="javascript:void(0);" name="load_more_button" data-url="{{ route("neighbour-load-data") }}" data-id="{{$last_id}}" id="load_more_neighbour_button" style="{{($info['hidePostButton'] == 1?"display: none;":"")}}">See more</a> 
                        @endif
                        @endif
                        @if(isset($info['nposts']))
                        <div id="neighbourLoadData">
                            @php $neigh_last_id = 0; @endphp
                            @if(count($info['nposts']) > 0)
                            @foreach($info['nposts'] as $npost)
                            <article class="st_Card">
                                <div class="st_Card__Content">
                                    <div class="st_Card__TextContentWrapper">
                                        <h6 class="st_Card__LabelWrapper">
                                            <a class="byline__secondary" title="{{$npost['town']}},{{$npost['location']}}" href="/l/{{sanitizeStringForUrl($npost['location'])}}/{{sanitizeStringForUrl($npost['town'])}}">
                                                {{$npost['town']}}, {{$npost['location']}}
                                            </a>
                                            <span class="st_Card__LabelDivider">|</span>
                                            <span>Neighbor Post</span>
                                            <span class="st_Card__LabelDivider">|</span>
                                            <a class="byline__secondary">
                                                <time datetime="{{$npost['created_at']}}">{{ \Carbon\Carbon::parse($npost['created_at'])->format('M d') }}</time>
                                            </a>
                                        </h6>
                                        <div class="byline byline--avatar">
                                            <a>
                                                @if (!is_null($npost['userInfo']->profile_image) && $npost['userInfo']->profile_image != '')
                                                <img class="avatar-img" src="{{getUserImageUrl($npost['userInfo']->profile_image)}}" />
                                                @else
                                                <i class="fa fa-user-circle avatar-icon--small"></i>
                                                @endif                                                
                                            </a>
                                            <div class="byline__wrapper">
                                                <div>
                                                    <a class="byline__name byline__name--avatar">
                                                        <strong>{{$npost['userInfo']->name}}</strong>, Neighbor
                                                    </a>
                                                    <span class="st_Badges"></span>
                                                </div>
                                                <div class="byline__row"></div>
                                            </div>
                                        </div>
                                        <div class="st_Card__Body st_Card__Body--Truncated">
                                            <p>{!! nl2br($npost['post_content']) !!}</p>
                                        </div>
                                        <div>
                                            <button class="btn--link btn--link-base" type="button">Read more</button>
                                        </div>
                                    </div>
                                    @if($npost['post_image'] != '')
                                    <a class="st_Card__Thumbnail__1">
                                        <img src="{{postgetImageUrl($npost['post_image'],$npost['created_at'])}}" />
                                        <noscript> 
                                        <img class="st_Card__ThumbnailImage" src="{{postgetImageUrl($npost['post_image'],$npost['created_at'])}}" /> 
                                        </noscript>
                                    </a>
                                    @endif
                                </div>
                                <div class="st_ActionBar">
                                    <div class="st_ActionBar__BarLeft">
                                        <button aria-label="thank" class="Button_ActionBar like_button-post" data-postid="{{$npost['id']}}" data-type="neighbour" type="button">
                                            <span class="Button_ActionBar__Icon">
                                                <?php
                                                if (isset($npost['userLikeInfo']) && !$npost['userLikeInfo']->isEmpty()) {
                                                    echo '<i class="fas fa-heart"></i>';
                                                } else {
                                                    echo '<i class="far fa-heart"></i>';
                                                }
                                                ?>
                                            </span> 
                                            <span class="Button_ActionBar__Label">
                                                Thank({{$npost['like_count']}})
                                            </span>
                                        </button>
                                        <a class="st_Card__ReplyLink" href="/n/{{sanitizeStringForUrl($npost['location'])}}/{{sanitizeStringForUrl($npost['town'])}}/{{$npost['id']}}/#reply_block_article_nid">
                                            <i class="far fa-comment st_Card__ReplyLinkIcon"></i>
                                            Reply({{$npost['comment_count']}}) 
                                        </a>
                                        <button class="Button_ActionBar share share-button" data-title="{{$npost['post_title']}}" data-url="/n/{{sanitizeStringForUrl($npost['location'])}}/{{sanitizeStringForUrl($npost['town'])}}/{{$npost['id']}}" type="button"> 
                                            <span class="Button_ActionBar__Icon">
                                                <i class="fas fa-share"></i>
                                            </span>
                                            <span class="Button_ActionBar__Label">Share</span> 
                                        </button>
                                    </div>
                                </div>                   
                            </article>
                            @php $neigh_last_id = $npost['id']; @endphp
                            @endforeach
                            @if(count($info['neighbourPostList']) > 0)
                            <a class="st_Section__linkButton" href="javascript:void(0);" name="load_more_button" data-url="{{ route("neighbour-load-data") }}" data-id="{{$neigh_last_id}}" id="load_more_neighbour_button" style="{{($info['hideNeighborButton'] == 1?"display: none;":"")}}">See more neighbor posts</a> 
                            @endif
                            @endif
                        </div>
                        @endif
                        @if(isset($info['events']))
                        <div id="loadEventData" class="st_Section__1bIk_ event-sec">
                            @php $event_last_id = 0; @endphp
                            @if(count($info['events']) > 0)
                            @foreach($info['events'] as $epost)
                            <article class="st_Card event_{{$epost['id']}}" id="event_{{$epost['id']}}">
                                <div class="st_Card__Content">
                                    <div class="st_Card__TextContentWrapper ">
                                        <h6 class="st_Card__LabelWrapper"><span>Local Event</span></h6>
                                        <div class="st_EventDetailsWrapper">
                                            <div class="calendar-icon">
                                                <div class="calendar-icon__date">
                                                    <strong class="calendar-icon__month">{{ \Carbon\Carbon::parse($epost['date'])->format('M') }}</strong>
                                                    <strong class="calendar-icon__day">{{ \Carbon\Carbon::parse($epost['date'])->format('d') }}</strong>
                                                </div>
                                            </div>
                                            <div class="st_TextWrapper">
                                                <h2 class="st_Card__Title">
                                                    <a href="/e/{{$epost['id']}}/{{sanitizeStringForUrl($epost['title'])}}">
                                                        {{$epost['title']}}
                                                    </a>
                                                </h2>
                                                <p class="st_EventDateAndTime__eventDetails">
                                                    <time class="st_EventDateAndTime__eventDetail_1">
                                                        <i class="fa fa-clock"></i>{{ \Carbon\Carbon::parse($epost['date'])->format('l') }}, {{ \Carbon\Carbon::parse($epost['time'])->format('h:i') }} {{$epost['am_pm']}}
                                                    </time>
                                                    <span class="st_EventDateAndTime__eventDetail_1">
                                                        <i class="fa fa-map-marker-alt"></i>
                                                        <a title="{{$epost['town']}},{{$epost['location']}}" href="/l/{{sanitizeStringForUrl($epost['location'])}}/{{sanitizeStringForUrl($epost['town'])}}">
                                                            <span class="st_EventDateAndTime__PatchName">{{$epost['town']}}, {{$epost['location']}}</span>
                                                        </a>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @if($epost['image'] != '')
                                    <a class="st_Card__Thumbnail__1">
                                        <img src="{{postgetImageUrl($epost['image'],$epost['created_at'])}}" />
                                        <noscript> <img class="st_Card__ThumbnailImage" src="{{postgetImageUrl($epost['image'],$epost['created_at'])}}" /> </noscript>
                                    </a>
                                    @endif
                                </div>
                                <div class="st_ActionBar">
                                    <div class="st_ActionBar__BarLeft">
                                        <button class="Button_ActionBar interested-labe intrest_button-post" data-postid="{{$epost['id']}}" data-type="event" type="button"> 
                                            <span class="Button_ActionBar__Icon">
                                                <?php
                                                if (isset($epost['userIntrestInfo']) && !$epost['userIntrestInfo']->isEmpty()) {
                                                    echo '<i class="fas fa-star red_start"></i>';
                                                } else {
                                                    echo '<i class="far fa-star"></i>';
                                                }
                                                ?>
                                            </span> 
                                            <span class="Button_ActionBar__Label__2BXDN">Interested ({{$epost['intrest_count']}})</span> 
                                        </button>
                                        <a class="st_Card__ReplyLink" href="/e/{{$epost['id']}}/{{sanitizeStringForUrl($epost['title'])}}#reply_block_article_nid"> <i class="far fa-comment st_Card__ReplyLinkIcon"></i> Reply ({{$epost['comment_count']}})</a>
                                        <button class="Button_ActionBar share share-button" data-title="{{$epost['title']}}" data-url="/e/{{$epost['id']}}/{{sanitizeStringForUrl($epost['title'])}}" type="button"> 
                                            <span class="Button_ActionBar__Icon">
                                                <i class="fas fa-share"></i>
                                            </span>
                                            <span class="Button_ActionBar__Label">Share</span> 
                                        </button>
                                    </div>
                                </div>
                                <div class="st_Thread__3lAiJ st_Thread--collapsed__3gBro">
                                    <section data-nosnippet="true"></section>
                                </div>
                            </article>
                            @php $event_last_id = $epost['id']; @endphp
                            @endforeach
                            @else
                            <section class="st_FeaturedModule__ModuleLabel">
                                <h4 class="st_FeaturedModule__Title">No event available.</h4>
                            </section>
                            @endif
                        </div>
                        @if(count($info['events']) > 0)
                        <a class="st_Section__linkButton" href="javascript:void(0);" name="load_more_button" data-url="{{ route("event-load-data") }}" data-id="{{$event_last_id}}" id="load_more_event_button" style="{{($info['hideEventButton'] == 1?"display: none;":"")}}">See more</a> 
                        @endif
                        @endif
                        @if(isset($info['classifieds']))
                        <div id="loadClassifiedData">
                            @php $classified_last_id = 0; @endphp
                            @if(count($info['classifieds']) > 0)
                            @foreach($info['classifieds'] as $cpost)
                            <article class="st_Card st_Card--FeaturedClassified classified_{{$cpost['id']}}" id="classified_{{$cpost['id']}}">
                                <div class="st_Card__Content">
                                    <div class="st_Card__TextContentWrapper">
                                        <h6 class="st_Card__LabelWrapper">
                                            <a class="byline__secondary" title="{{$cpost['town']}},{{$cpost['location']}}" href="/l/{{sanitizeStringForUrl($cpost['location'])}}/{{sanitizeStringForUrl($cpost['town'])}}">
                                                {{$cpost['town']}}, {{$cpost['location']}}
                                            </a>
                                            <span class="st_Card__LabelDivider">|</span>
                                            <span>Local Classified</span>
                                            <span class="st_Card__LabelDivider">|</span>
                                            <span>{{$cpost['category']}}</span>
                                            <span class="st_Card__LabelDivider">|</span>

                                            <a class="byline__secondary" href="/c/{{$cpost['id']}}/{{sanitizeStringForUrl($cpost['title'])}}">
                                                <time datetime="{{$cpost['created_at']}}">{{getPostTime($cpost['created_at'])}}</time>
                                            </a>
                                        </h6>
                                        <div class="byline byline--avatar">
                                            @if($cpost['userInfo']->profile_image == '')
                                            <a><i class="fa fa-user-circle avatar-icon--base"></i></a>
                                            @else
                                            <img alt="{{$cpost['userInfo']->name}} profile picture" class="avatar-img" src="{{getUserImageUrl($cpost['userInfo']->profile_image)}}?width=36" />
                                            @endif
                                            <div class="byline__wrapper">
                                                <div>
                                                    <a class="byline__name byline__name--avatar">
                                                        <strong>{{$cpost['userInfo']->name}}</strong>, Neighbor
                                                    </a>
                                                    <span class="st_Badges"></span>
                                                </div>
                                                <div class="byline__row"></div>
                                            </div>
                                        </div>
                                        <h2 class="st_Card__Title">
                                            <a class="st_Card__TitleLink" title="Peach Festival 2021" href="/c/{{$cpost['id']}}/{{sanitizeStringForUrl($cpost['title'])}}">{{$cpost['title']}}</a>
                                        </h2>
                                    </div>
                                    @if($cpost['image'] != '')
                                    <a class="st_Card__Thumbnail__1" href="/c/{{$cpost['id']}}/{{sanitizeStringForUrl($cpost['title'])}}">
                                        <img src="{{postgetImageUrl($cpost['image'],$cpost['created_at'])}}" />
                                    </a>
                                    @endif
                                </div>
                                <div class="st_ActionBar">
                                    <div class="st_ActionBar__BarLeft">
                                        <button aria-label="thank" class="Button_ActionBar like_button-post" data-postid="{{$cpost['id']}}" data-type="classified" type="button">
                                            <span class="Button_ActionBar__Icon">
                                                <?php
                                                if (isset($cpost['userLikeInfo']) && !$cpost['userLikeInfo']->isEmpty()) {
                                                    echo '<i class="fas fa-heart"></i>';
                                                } else {
                                                    echo '<i class="far fa-heart"></i>';
                                                }
                                                ?>
                                            </span> 
                                            <span class="Button_ActionBar__Label">
                                                Thank({{$cpost['like_count']}})
                                            </span>
                                        </button>
                                        <a class="st_Card__ReplyLink" href="/c/{{$cpost['id']}}/{{sanitizeStringForUrl($cpost['title'])}}#reply_block_article_nid">
                                            <i class="far fa-comment st_Card__ReplyLinkIcon"></i>
                                            Reply
                                            ({{$cpost['comment_count']}})
                                        </a>
                                        <button class="Button_ActionBar share share-button" data-title="{{$cpost['title']}}" data-url="/c/{{$cpost['id']}}/{{sanitizeStringForUrl($cpost['title'])}}" type="button"> 
                                            <span class="Button_ActionBar__Icon">
                                                <i class="fas fa-share"></i>
                                            </span>
                                            <span class="Button_ActionBar__Label">Share</span> 
                                        </button>
                                    </div>
                                </div>
                            </article>
                            @php $classified_last_id = $cpost['id']; @endphp
                            @endforeach
                            @else
                            <section class="st_FeaturedModule__ModuleLabel">
                                <h4 class="st_FeaturedModule__Title">No classified available.</h4>
                            </section>
                            @endif
                        </div>
                        @if(count($info['classifieds']) > 0)
                        <a class="st_Section__linkButton" href="javascript:void(0);" name="load_more_button" data-url="{{ route("classified-load-data") }}" data-id="{{$classified_last_id}}" id="load_more_classified_button" style="{{($info['hideClassifiedButton'] == 1?"display: none;":"")}}">See more</a> 
                        @endif
                        @endif
                        @if(isset($info['reply']))
                        <div class="reply-sec my-5">
                            @foreach($info['reply']['article'] as $value)
                            <article class="st_Card st_Card--Same-Vertical-Space">
                                <section class="st_ReplyCard__Header">
                                    <i class="far fa-comment icon icon--space-right"></i>Replying to an
                                    <a href="/reply/{{$value['post_id']}}/article/nodx" rel="nofollow">article</a>
                                </section>
                                <div class="st_Card__Content">
                                    <div class="st_Card__TextContentWrapper">
                                        <div class="byline byline--avatar">
                                            <a>
                                                @if (!is_null($value['userInfo']->profile_image) && $value['userInfo']->profile_image != '')
                                                <img class="avatar-img avatar-img--base is-lazy-loaded" src="{{getUserImageUrl($value['userInfo']->profile_image)}}" />
                                                @else
                                                <i class="fa fa-user-circle avatar-icon"></i>
                                                @endif
                                            </a>
                                            <div class="byline__wrapper">
                                                <a class="byline__name byline__name--avatar">
                                                    <strong>{{$value['userInfo']->name}}</strong>, Neighbor </a>
                                                <div class="byline__row">
                                                    <a class="byline__secondary" href="/l/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}">{{ucfirst($info['town'])}}, {{ucfirst($info['location'])}}</a>
                                                    <span class="st_Card__LabelDivider">|</span>

                                                    <a class="byline__secondary" href="/reply/{{$value['post_id']}}/article/nodx" rel="nofollow">
                                                        <time datetime="{{$value['created_at']}}">{{getPostTime($value['created_at'])}}</time>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="st_Card__Body">
                                            <p>{{$value['comment']}}</p>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            @endforeach
                            @foreach($info['reply']['neighbor'] as $value)
                            <article class="st_Card st_Card--Same-Vertical-Space">
                                <section class="st_ReplyCard__Header">
                                    <i class="far fa-comment icon icon--space-right"></i>Replying to an
                                    <a href="/reply/{{$value['post_id']}}/neighbor/nodx" rel="nofollow">neighbor</a>
                                </section>
                                <div class="st_Card__Content">
                                    <div class="st_Card__TextContentWrapper">
                                        <div class="byline byline--avatar">
                                            <a>
                                                @if (!is_null($value['userInfo']->profile_image) && $value['userInfo']->profile_image != '')
                                                <img class="avatar-img avatar-img--base is-lazy-loaded" src="{{getUserImageUrl($value['userInfo']->profile_image)}}" />
                                                @else
                                                <i class="fa fa-user-circle avatar-icon"></i>
                                                @endif
                                            </a>
                                            <div class="byline__wrapper">
                                                <a class="byline__name byline__name--avatar">
                                                    <strong>{{$value['userInfo']->name}}</strong>, Neighbor </a>
                                                <div class="byline__row">
                                                    <a class="byline__secondary" href="/l/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}">{{ucfirst($info['town'])}}, {{ucfirst($info['location'])}}</a>
                                                    <span class="st_Card__LabelDivider">|</span>

                                                    <a class="byline__secondary" href="/reply/{{$value['post_id']}}/neighbor/nodx" rel="nofollow">
                                                        <time datetime="{{$value['created_at']}}">{{getPostTime($value['created_at'])}}</time>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="st_Card__Body">
                                            <p>{{$value['comment']}}</p>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            @endforeach
                            @foreach($info['reply']['event'] as $value)
                            <article class="st_Card st_Card--Same-Vertical-Space">
                                <section class="st_ReplyCard__Header">
                                    <i class="far fa-comment icon icon--space-right"></i>Replying to an
                                    <a href="/reply/{{$value['event_id']}}/event/nodx" rel="nofollow">event</a>
                                </section>
                                <div class="st_Card__Content">
                                    <div class="st_Card__TextContentWrapper">
                                        <div class="byline byline--avatar">
                                            <a>
                                                @if (!is_null($value['userInfo']->profile_image) && $value['userInfo']->profile_image != '')
                                                <img class="avatar-img avatar-img--base is-lazy-loaded" src="{{getUserImageUrl($value['userInfo']->profile_image)}}" />
                                                @else
                                                <i class="fa fa-user-circle avatar-icon"></i>
                                                @endif
                                            </a>
                                            <div class="byline__wrapper">
                                                <a class="byline__name byline__name--avatar">
                                                    <strong>{{$value['userInfo']->name}}</strong>, Neighbor </a>
                                                <div class="byline__row">
                                                    <a class="byline__secondary" href="/l/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}">{{ucfirst($info['town'])}}, {{ucfirst($info['location'])}}</a>
                                                    <span class="st_Card__LabelDivider">|</span>

                                                    <a class="byline__secondary" href="/reply/{{$value['event_id']}}/event/nodx" rel="nofollow">
                                                        <time datetime="{{$value['created_at']}}">{{getPostTime($value['created_at'])}}</time>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="st_Card__Body">
                                            <p>{{$value['description']}}</p>
                                        </div>
                                    </div>
                                    @if($value['image'] != '')
                                    <figure class="styles_Card__Thumbnail__1-_Rw">
                                        <img class="styles_Card__ThumbnailImage" src="{{postgetImageUrl($value['image'],$value['created_at'])}}">
                                    </figure>
                                    @endif
                                </div>
                            </article>
                            @endforeach
                            @foreach($info['reply']['classified'] as $value)
                            <article class="st_Card st_Card--Same-Vertical-Space">
                                <section class="st_ReplyCard__Header">
                                    <i class="far fa-comment icon icon--space-right"></i>Replying to an
                                    <a href="/reply/{{$value['classified_id']}}/classified/nodx" rel="nofollow">classified</a>
                                </section>
                                <div class="st_Card__Content">
                                    <div class="st_Card__TextContentWrapper">
                                        <div class="byline byline--avatar">
                                            <a>
                                                @if (!is_null($value['userInfo']->profile_image) && $value['userInfo']->profile_image != '')
                                                <img class="avatar-img avatar-img--base is-lazy-loaded" src="{{getUserImageUrl($value['userInfo']->profile_image)}}" />
                                                @else
                                                <i class="fa fa-user-circle avatar-icon"></i>
                                                @endif
                                            </a>
                                            <div class="byline__wrapper">
                                                <a class="byline__name byline__name--avatar">
                                                    <strong>{{$value['userInfo']->name}}</strong>, Neighbor </a>
                                                <div class="byline__row">
                                                    <a class="byline__secondary" href="/l/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}">{{ucfirst($info['town'])}}, {{ucfirst($info['location'])}}</a>
                                                    <span class="st_Card__LabelDivider">|</span>

                                                    <a class="byline__secondary" href="/reply/{{$value['classified_id']}}/classified/nodx" rel="nofollow">
                                                        <time datetime="{{$value['created_at']}}">{{getPostTime($value['created_at'])}}</time>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="st_Card__Body">
                                            <p>{{$value['description']}}</p>
                                        </div>
                                    </div>
                                    @if($value['image'] != '')
                                    <figure class="styles_Card__Thumbnail__1-_Rw">
                                        <img class="styles_Card__ThumbnailImage" src="{{postgetImageUrl($value['image'],$value['created_at'])}}">
                                    </figure>
                                    @endif
                                </div>
                            </article>
                            @endforeach
                        </div>
                        @endif
                    </section>

                </main>
            </div>
            <div class="right-sec">
                <div class="vertical-slider m-20">
                    <div class="st_ModuleLabel">
                        <h4 class="st_ModuleLabel__Text__8quJk">Featured Events</h4>
                        <button class="btn btn--info-modal" type="button"> <i class="fa fa-info-circle st_ModuleLabel__Icon__mtBVa"></i> </button>
                    </div>
                    <section class="regular slider">
                        @if(count($info['eventList']) > 0)
                        @foreach($info['eventList'] as $epost)
                        <div>
                            <article class="st_CardCompact">
                                <div class="st_ContentLeft">
                                    <span><time datetime="{{$epost['created_at']}}">{{ \Carbon\Carbon::parse($epost['created_at'])->format('M d, Y') }}</time></span>
                                    <div class="st_TitleWrapper">
                                        <h5 class="styles_CardCompact__Title__3Et5F">
                                            <a class="styles_CardCompact__TitleLink__2PtcE" title="{{$epost['title']}}" href="/e/{{$epost['id']}}/{{sanitizeStringForUrl($epost['title'])}}">{{$epost['title']}}</a>
                                        </h5>
                                    </div>
                                </div>
                                @if($epost['image'] != '')
                                <a class="st_CardCompact__ImageLink" href="/e/{{$epost['id']}}/{{$epost['title']}}">
                                    <img src="{{postgetImageUrl($epost['image'],$epost['created_at'])}}">
                                </a>
                                @endif
                            </article>
                        </div>
                        @endforeach
                        @endif
                    </section>
                    <div class="st_ModuleFooter">
                        <a href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/event" rel="nofollow">+ Add your event</a>
                    </div>
                </div>
                <div class="vertical-slider m-20">
                    <div class="st_ModuleLabel__Wrapper st_ModuleLabel__Wrapper--Classified">
                        <h4 class="st_ModuleLabel__Text">
                            Featured Classifieds
                        </h4>
                        <button class="btn btn--info-modal" type="button"><i class="fa fa-info-circle st_ModuleLabel__Icon"></i></button>
                    </div>
                    <section class="regular slider">
                        @if(count($info['classifiedList']) > 0)
                        @foreach($info['classifiedList'] as $cpost)
                        <div>
                            <article class="st_CardCompact">
                                <div class="st_ContentLeft">
                                    <span class="st_Description">{{$cpost['category']}}</span> 
                                    <div class="st_TitleWrapper">
                                        <h5 class="st_CardCompact__Title">
                                            <a class="st_CardCompact__TitleLink" title="{{$cpost['title']}}" href="/c/{{$cpost['id']}}/{{sanitizeStringForUrl($cpost['title'])}}">{{$cpost['title']}}</a>
                                        </h5>
                                    </div>
                                </div>
                                @if($cpost['image'] != '')
                                <a class="st_CardCompact__ImageLink" href="/c/{{$cpost['id']}}/{{$cpost['title']}}">
                                    <img src="{{postgetImageUrl($cpost['image'],$cpost['created_at'])}}">
                                </a>
                                @endif
                            </article>
                        </div>
                        @endforeach
                        @endif
                    </section>
                    <div class="st_ModuleFooter__Wrapper">
                        <a class="btn btn--text-primary st_ModuleFooter__Text st_ModuleFooter__Text--Classified add_post_link" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/classified" rel="nofollow">+ Add your classified</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function loadMoreData(id = 0, url, html_id, $this) {
        $.ajax({
            type: 'POST',
            url: url,
            data: {id: id, location: $("#location").val(), town: $("#town").val()},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $this.remove();
                $('#' + html_id).append(data);
            }
        });
    }
    jQuery(document).ready(function () {
        var $ = jQuery;
        $(document).on("click", ".st_FlagMenu .dropdown-toggle", function () {
            $(this).parent().find(".flag-menu ul.dropdown-menu.dropdown-menu-right").toggle();
            return false;
        });
        $(document).on("click", ".st_FlagItem__link", function () {
            $(this).parent().hide();
            var URL = $('#report_url').val();
            if ($('#login_user_id').val() == '') {
                window.location.href = $('#login_url').val() + '?ru=' + window.location.href;
            } else {
                $.ajax({
                    type: 'POST',
                    url: URL,
                    data: {post_id: $(this).parent().data('postid'), type: 'article', 'report': $(this).find('span').text()},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        alert('Your report successfully submited.');
                    }
                });
            }
        });
        $(document).on("click", "body", function () {
            $('.st_FlagMenu .dropdown-toggle').parent().find(".flag-menu ul.dropdown-menu.dropdown-menu-right").hide();
            //            return false;
        });

        $(".regular").slick({
            dots: false,
            arrows: false,
            infinite: true,
            slidesToShow: 3,
            autoplay: true,
            autoplaySpeed: 2000,
            slidesToScroll: 1,
            vertical: true,
            verticalSwiping: true,
            pauseOnHover: false,
            pauseOnFocus: false
        });
        $(document).on("click", ".header-hamburger-btn", function () {
            $(".h-hamburger-line").toggleClass('hamburger__line--open');
            $(".mob-menu").toggleClass("show-mob-menu");
        });
        $(document).on("click", ".secondary-nav__list-item", function () {
            $(this).find('.secondary-nav__menu').toggleClass('show');
        });
        var prevScrollpos = window.pageYOffset;
        window.onscroll = function () {
            var currentScrollPos = window.pageYOffset;
            if (prevScrollpos > currentScrollPos) {
                jQuery(".header").removeClass('header--sticky-condensed');
                jQuery(".header").addClass('header--sticky-full');
            } else {
                jQuery(".header").addClass('header--sticky-condensed');
                jQuery(".header").removeClass('header--sticky-full');
            }
            prevScrollpos = currentScrollPos;
        };
        $(document).on("click", ".header-hamburger-btn", function () {
            $('.header').toggleClass('header--fixed');
            $('.header').removeClass("header--sticky-full");
            $('.header').removeClass("header--sticky-condensed");
            $('body').toggleClass("over-class");
        });
        $(document).on("click", ".autocomplete input", function () {
            $('.fp-helper__wrapper.fp-helper--closed').show();
        });
        $(document).mouseup(function (e) {
            var container = $(".fp-helper__wrapper.fp-helper--closed");
            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0)
            {
                container.hide();
            }
        });
        $(document).on('click', '.share-button', function () {
            $this = $(this);
            if (navigator.share) {
                navigator.share({
                    title: $this.data('title'),
                    url: "{{URL::to('/')}}" + $this.data('url') + '?utm_source=share-mobile&utm_medium=web&utm_campaign=share'
                }).then(() => {
                    console.log('Thanks for sharing!');
                })
                        .catch(console.error);
            }
        });
        $(document).on('click', '#load_more_button', function () {
            var id = $(this).data('id');
            var url = $(this).data('url');
            //console.log(id);
            $(this).html('<b>Loading...</b>');
            loadMoreData(id, url);
        });
        $(document).on('click', '#load_more_event_button', function () {
            var id = $(this).data('id');
            var url = $(this).data('url');
            //console.log(id);
            $(this).html('<b>Loading...</b>');
            loadMoreData(id, url, 'loadEventData', $(this));
        });
        $(document).on('click', '#load_more_classified_button', function () {
            var id = $(this).data('id');
            var url = $(this).data('url');
            //console.log(id);
            $(this).html('<b>Loading...</b>');
            loadMoreData(id, url, 'loadClassifiedData', $(this));
        });
        $(document).on('click', '#load_more_neighbour_button', function () {
            var id = $(this).data('id');
            var url = $(this).data('url');
            //console.log(id);
            $(this).html('<b>Loading...</b>');
            loadMoreData(id, url, 'loadData', $(this));
        });
        $(document).on('click', '.like_button-post', function () {
            var URL = $('#like_url').val();
            var $this = $(this);
            if ($('#login_user_id').val() == '') {
                window.location.href = $('#login_url').val() + '?ru=' + window.location.href;
            } else {
                $.ajax({
                    type: 'POST',
                    url: URL,
                    data: {post_id: $(this).data('postid'), type: $(this).data('type')},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        $this.html(data.html);
                    }
                });
            }
        });

        $("#list li").click(function () {
            var query = $(this).text();
            console.log(query);
            var url = '{{ route("view_profile", ":slug") }}';
            url = url.replace(':slug', query);
            console.log(url);
            $.ajax({
                url: url,
                type: "GET",
                data: {'query': query},
                success: function (data) {
                    //$('#faq_category_list').html(data);
                }
            })
            // end of ajax call
        });

        $(document).on('click', '.btn--link-base', function () {
            $(this).parents('.st_Card__TextContentWrapper').find('.st_Card__Body').toggleClass('st_Card__Body--Truncated');
            if ($(this).text() == 'Read more') {
                $(this).text('See less');
            } else {
                $(this).text('Read more');
            }
        });

        $(document).on('click', '.intrest_button-post', function () {
            var URL = $('#intrest_url').val();
            var $this = $(this);
            if ($('#login_user_id').val() == '') {
                window.location.href = $('#login_url').val() + '?ru=' + window.location.href;
            } else {
                $.ajax({
                    type: 'POST',
                    url: URL,
                    data: {post_id: $(this).data('postid')},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        $this.html(data.html);
                    }
                });
            }
        });
    });


    $(".card__link").on("click", function (e) {
        var getlabel = $(this).text();
        sessionStorage.setItem("label", getlabel);
    });

    var label = sessionStorage.getItem("label");
    if (label == '' || label === null) {
        label = $('#post').text();
    }
    var articles = $('#articles').text();
    var events = $('#events').text();
    var classifieds = $('#classifieds').text();
    var post = $('#post').text();
    var reply = $('#reply').text();
    $('#drop-down-labe').text(label);

    if (label == articles) {
        $('#articles').css('display', 'none');
        $('#post').css('display', 'block');
    } else if (label == events) {
        $('#events').css('display', 'none');
        $('#post').css('display', 'block');
    } else if (label == classifieds) {
        $('#classifieds').css('display', 'none');
        $('#post').css('display', 'block');
    } else if (label == reply) {
        $('#reply').css('display', 'none');
        $('#post').css('display', 'block');
    } else if (label == post) {
        $('#post').css('display', 'none');
    }


</script>
@endsection