@extends('layouts.app')
@section('title')
{{$info['post_title']}} | Neighborhood Reporter
@endsection
@section('meta')
@php
if ($info['post_image'] != '') {
$image = postgetImageUrl($info['post_image'], $info['created_at']);
} else {
$image = asset('images/logo.png');
}
$link = route('home') . '/p/' . $info['guid'];
$info['post_title'] = str_replace('"', "'", $info['post_title']);
$info['post_subtitle'] = str_replace('"', "'", $info['post_subtitle']);
@endphp
<!-- Primary Meta Tags -->
<meta name="title" content="{{$info['post_title']}} | Neighborhood Reporter">
<meta name="description" content="{{$info['post_title']}} - {{$info['town']}},{{$info['location']}} - {{$info['post_subtitle']}} ">
<meta property="article:section" content="{{ $info['post_category'] }}">
<meta property="article:modified_time" content="{{$info['updated_at']}}">
<meta property="article:published_time" content="{{$info['created_at']}}">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{$link}}">
<meta property="og:title" content="{{$info['post_title']}} | Neighborhood Reporter">
<meta property="og:description" content="{{$info['post_title']}} - {{$info['town']}},{{$info['location']}} - {{$info['post_subtitle']}} ">
<meta property="og:image" content="{{$image}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="{{$info['town']}},{{$info['location']}} Neighborhood Reporter">
<meta property="og:updated_time" content="{{$info['updated_at']}}">
<meta property="fb:app_id" content="859635438272019">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{$link}}">
<meta property="twitter:title" content="{{$info['post_title']}} | Neighborhood Reporter">
<meta property="twitter:description" content="{{$info['post_title']}} - {{$info['town']}},{{$info['location']}} - {{$info['post_subtitle']}} ">
<meta property="twitter:image" content="{{$image}}">
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .compose-block.reply_btn1{
        display: none;
    }
</style>
<div class="content-sec">
    <div class="container pad-0">
        <div class="row mar-mob">
            <div class="col-md-12 col-lg-8 pad-0">
                <main id="main" role="main" class="page__main blog-sec">
                    <section class="st_Section">
                        <div class="st_SocialShare st_SocialShare--IsHidden st_SocialShare--IsSticky">
                            <a class="st_SocialShare__Action st_SocialShare__Action--facebook" target="_blank"
                               alt="Share on Facebook" title="Share on Facebook"
                               href="https://www.facebook.com/sharer/sharer.php?u={{route('home')}}/p/{{$info['guid']}}?utm_source=facebook&utm_medium=web&utm_campaign=share">
                                <i class="fab fa-facebook-f st_SocialShare__Icon"></i>
                            </a>
                            <a class="st_SocialShare__Action st_SocialShare__Action--twitter" target="_blank" alt="Tweet"
                               title="Tweet"
                               href="https://twitter.com/intent/tweet?text={{$info['post_title']}}&amp;url={{route('home')}}/p/{{$info['guid']}}?utm_source=twitter&utm_medium=web&utm_campaign=share">
                                <i class="fab fa-twitter st_SocialShare__Icon"></i>
                            </a>
                            <a class="st_SocialShare__Action st_SocialShare__Action--linkedin" target="_blank"
                               alt="Post on LinkedIn" title="Post on LinkedIn"
                               href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{route('home')}}/p/{{$info['guid']}}?utm_source=linkedin&utm_medium=web&utm_campaign=share">
                                <i class="fab fa-linkedin-in st_SocialShare__Icon"></i>
                            </a>
                            <a class="st_SocialShare__Action st_SocialShare__Action--reddit" target="_blank"
                               alt="Post on Reddit" title="Post on Reddit"
                               href="http://www.reddit.com/submit?title={{$info['post_title']}}&amp;url={{route('home')}}/p/{{$info['guid']}}?utm_source=reddit&utm_medium=web&utm_campaign=share">
                                <i class="fab fa-reddit-alien st_SocialShare__Icon"></i>
                            </a>
                            <a class="st_SocialShare__Action st_SocialShare__Action--email" target="_blank" alt="Send email"
                               title="Send email"
                               href="mailto:?subject={{$info['post_title']}}&amp;body={{$info['post_subtitle']}}%0A%0A{{route('home')}}/p/{{$info['guid']}}?utm_source=shared-email&utm_medium=email&utm_campaign=share">
                                <i class="fas fa-envelope st_SocialShare__Icon"></i>
                            </a>
                            <button class="st_SocialShare__Action st_SocialShare__Action--replies reply_btn" type="button">
                                <i class="fas fa-comments st_SocialShare__Icon"></i>
                                <strong class="st_SocialShare__Label"><span class="reply_count_number">{{$info['comment_count']}}</span></strong>
                            </button>
                        </div>
                        <article class="st_Section__card">
                            <div class="st_CardDetail__Header">
                                <h6>
                                    <a class="Label_CardDetail__topicLabel" href="/l/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/{{sanitizeStringForUrl($info['post_category'])}}">
                                        {{ucfirst($info['post_category'])}}
                                    </a>
                                </h6>
                                <a class="Label_CardDetail__sharedLabel" href="/l/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}">Shared from
                                    {{ucfirst($info['town'])}}, {{ucfirst($info['location'])}}
                                </a>
                                <h1 class="Title_CardDetail__Title">{{$info['post_title']}}</h1>
                                <h2 class="st_CardDetail__Description">{{$info['post_subtitle']}}</h2>
                                <div class="Byline_CardDetail__BylineWrapper">
                                    <h6 class="Byline_CardDetail__Byline">
                                        <aside class="Byline_CardDetail__avatarContainer">
                                            @if (!is_null($info['userInfo']->profile_image) && $info['userInfo']->profile_image != '')
                                            <img class="avatar-img avatar-img--base is-lazy-loaded" src="{{getUserImageUrl($info['userInfo']->profile_image)}}" />
                                            @else
                                            <i class="fa fa-user-circle avatar-icon--small"></i>
                                            @endif                                            
                                        </aside>
                                        <ul class="Byline_CardDetail__BylineList">
                                            <li class="Byline_CardDetail__EditBylineListItem">
                                                <a class="Byline_CardDetail__BylineLink">
                                                    <strong> {{$info['userInfo']->name}},</strong> Neighborhood Reporter Staff 
                                                </a>
                                                <span class="st_Badges st_Badges--small">
                                                    <img class="st_Badge__w3v27 is-lazy-loaded" alt="Verified Neighborhood Reporter Staff Badge" src="{{asset('images/nr-logo.svg')}}" />
                                                </span>
                                            </li>
                                            <li class="Byline_CardDetail__DateByline">
                                                <h6 class="Byline_CardDetail__BylineInfo">
                                                    <div class="Byline_CardDetail__DateInfo">
                                                        <time datetime="{{$info['created_at']}}"> Posted {{\Carbon\Carbon::parse($info['created_at'])->format('D, M j Y g:i a')}}</time>
                                                    </div>
                                                </h6>
                                            </li>
                                        </ul>
                                    </h6>
                                </div>
                                <div class="Row_CardDetail__Row">
                                    <button class="HeaderReplyButton_CardDetail__HeaderReplyButton reply_btn" type="button">
                                        <i class="fa fa-comments icon icon--space-right-sm"></i>Reply 
                                    </button>
                                </div>
                            </div>
                            @if($info['post_image'] != '')
                            <div class="st_FeaturedMedia">
                                <figure> 
                                    <img class="st_CardDetail__FeaturedImage"
                                         src="{{postgetImageUrl($info['post_image'],$info['created_at'])}}">
                                </figure>
                            </div>
                            @endif
                            <div class="st_HTMLContent about-us-details-block">
                                {!!$info['post_content']!!}
                            </div>


                            <div class="ContentBlocks_CardDetail__ContentBlock">
                                <div></div>
                            </div>
                            <div class="st_CardDetail__Footer">
                                <div class="st_ActionBar">
                                    <div class="st_ActionBar__BarLeft">
                                        <button aria-label="thank" class="Button_ActionBar like_button-post" data-postid="{{$info['id']}}" data-type="article" type="button">
                                            <span class="Button_ActionBar__Icon">
                                                <?php
                                                if (isset($info['userLikeInfo']) && !$info['userLikeInfo']->isEmpty()) {
                                                    echo '<i class="fas fa-heart"></i>';
                                                } else {
                                                    echo '<i class="far fa-heart"></i>';
                                                }
                                                ?>
                                            </span> 
                                            <span class="Button_ActionBar__Label">
                                                Thank({{$info['like_count']}})
                                            </span>
                                        </button>
                                        <a class="st_Card__ReplyLink reply_btn" href="javascript:void(0);">
                                            <i class="far fa-comment st_Card__ReplyLinkIcon"></i>
                                            Reply(<span class="reply_count_number">{{$info['comment_count']}}</span>) 
                                        </a>
                                        <button class="Button_ActionBar share share-button" data-title="{{$info['post_title']}}" data-url="/p/{{$info['guid']}}" type="button"> 
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
                                                        <ul class="dropdown-menu dropdown-menu-right" data-postid="{{$info['id']}}" data-type="article">
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
                            </div>
                        </article>
                        <div class="tab-content" id="pills-tabContent" style="display: none;">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                                <div class="">
                                    <div class="st_Header">
                                        <h5 class="st_Header__title">The rules of replying:</h5>
                                    </div>
                                    <ul class="fa-ul st_List">
                                        <li class="st_List__item">
                                            <span class="fa-li">
                                                <i class="fa fal fa-check"></i>
                                            </span>
                                            <strong class="st_List__emphasizedText">Be respectful.</strong> This is a space for friendly local discussions. No racist, discriminatory, vulgar or threatening language will be tolerated.
                                        </li>
                                        <li class="st_List__item">
                                            <span class="fa-li">
                                                <i class="fa fal fa-check"></i>
                                            </span>
                                            <strong class="st_List__emphasizedText">Be transparent.</strong> Use your real name, and back up your claims.
                                        </li>
                                        <li class="st_List__item">
                                            <span class="fa-li">
                                                <i class="fa fal fa-check"></i>
                                            </span>
                                            <strong class="st_List__emphasizedText">Keep it local and relevant.</strong> Make sure your replies stay on topic.
                                        </li>                                
                                        <li class="st_List__item">
                                            <span class="fa-li">
                                                <i class="fa fal fa-check"></i>
                                            </span>
                                            Review the <a href="{{url('community-guidelines')}}">Neighborhood Reporter Community Guidelines</a></li>
                                    </ul>
                                </div>
                                <div class="styles_ArticleThreadBlock__elevatedForm__38Z58">
                                    <form class="styles_ReplyForm__3YbUI styles_ReplyForm--floating__1Mv71" method="POST" action="#" accept-charset="UTF-8">
                                        @csrf
                                        <div class="styles_ReplyForm__fieldContainer__3cNzb">
                                            <i class="fa fa-user-circle avatar-icon avatar-icon--base"></i>
                                            <label class="text-field text-field--no-border">
                                                <textarea class="text-field__input styles_TextEditor__l92NA styles_TextEditor--is-small__36ivx" name="message" id="replay_message-box" placeholder="Reply to this article" rows="4" spellcheck="false"></textarea>
                                            </label>
                                        </div>
                                        <footer class="styles_ReplyForm__footer__vKEul">
                                            <!--<button class="styles_ReplyForm__cancel__1bzbN" type="button">Cancel</button>-->
                                            <button class="styles_ReplyForm__submit__11sYc" id="comment_replay-btn" type="button">Reply<i class="fas fa-spinner icon icon--space-left fa-spin" style="display: none;"></i></button>
                                        </footer>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="st_ArticleThreadBlock__container" id="reply_block_article_nid">
                            <button class="st_ArticleThreadBlock__toggle" type="button" data-toggle="collapse" data-target="#collapseReply" aria-expanded="false" aria-controls="collapseReply">
                                <i class="fas fa-chevron-right icon icon--space-right-sm st_ArticleThreadBlock__toggleIcon"></i>
                                <strong>Replies({{$info['comment_count']}})</strong>
                            </button>
                            <div class="collapse" id="collapseReply">
                                @foreach($info['reply'] as $rvalue)
                                <div class="st_Thread st_Thread--collapsed styles_Thread__3lAiJ" id="reply_div_{{$rvalue['id']}}">
                                    <section>
                                        <div class="st_Card__Content">
                                            <div class="st_Card__TextContentWrapper reply_{{$rvalue['id']}}">

                                                <div class="byline byline--avatar">
                                                    <a>
                                                        @if (!is_null($rvalue['userInfo']->profile_image) && $rvalue['userInfo']->profile_image != '')
                                                        <img class="avatar-img" src="{{getUserImageUrl($rvalue['userInfo']->profile_image)}}" />
                                                        @else
                                                        <i class="fa fa-user-circle avatar-icon avatar-icon--base"></i>
                                                        @endif
                                                    </a>
                                                    <div class="byline__wrapper">
                                                        <a class="byline__name byline__name--avatar">
                                                            <strong>{{$rvalue['userInfo']->name}}</strong>, Neighbor
                                                        </a>
                                                        <div class="byline__row">
                                                            <a class="byline__secondary">{{getLocationLink(1,$rvalue['user_id'])}}</a>
                                                            <span class="st_Card__LabelDivider">|</span>
                                                            <a class="byline__secondary">
                                                                <time datetime="{{$rvalue['created_at']}}">{{getPostTime($rvalue['created_at'])}}</time>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="st_Card__Body body_remove_{{$rvalue['id']}}">
                                                    <p>{{$rvalue['comment']}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="st_ActionBar action_remove_{{$rvalue['id']}}">
                                            <div class="st_ActionBar__BarLeft">
                                                <button aria-label="thank" class="Button_ActionBar like_button-post" data-postid="{{$rvalue['id']}}" data-type="reply" type="button">
                                                    <span class="Button_ActionBar__Icon">
                                                        <?php
                                                        if (isset($rvalue['userLikeInfo']) && !$rvalue['userLikeInfo']->isEmpty()) {
                                                            echo '<i class="fas fa-heart"></i>';
                                                        } else {
                                                            echo '<i class="far fa-heart"></i>';
                                                        }
                                                        ?>
                                                    </span>
                                                    <span class="Button_ActionBar__Label"> Thank({{$rvalue['like_count']}}) </span>
                                                </button>
                                                <a class="st_Card__ReplyLink comment_reply" data-postid="{{$rvalue['id']}}">
                                                    <i class="far fa-comment st_Card__ReplyLinkIcon"></i> Reply({{count($rvalue['commentReply'])}})
                                                </a>

                                            </div>
                                            <div class="st_ActionBar__BarRight">
                                                <div class="st_FlagMenu">
                                                    <div aria-label="flags" class="dropdown">
                                                        @if(Auth::id() != $rvalue['user_id'])
                                                        <div class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" disabled="">
                                                            <button aria-label="flag" class="Button--flag dropdown-toggle" type="button"> 
                                                                <span class="st_Button__Icon"><i class="far fa-flag"></i></span> 
                                                            </button>
                                                            <div class="flag-menu">
                                                                <ul class="dropdown-menu dropdown-menu-right" data-option='report' data-postid="{{$rvalue['id']}}" data-type="reply">
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
                                                        @else
                                                        <div class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" id="js-content-flag-menu-article-{{$rvalue['id']}}" disabled="">
                                                            <button aria-label="flag" class="Button--flag dropdown-toggle" type="button">
                                                                <span class="st_Button__Icon">
                                                                    <i class="fas fa-ellipsis-h"></i>
                                                                </span> 
                                                            </button>
                                                            <div class="flag-menu">
                                                                <ul class="dropdown-menu dropdown-menu-right" data-option='edit' data-postid="{{$rvalue['id']}}">
                                                                    <li class="st_FlagItem__link dropdown-item">
                                                                        <span>Edit</span>
                                                                    </li>
                                                                    <li class="st_FlagItem__link dropdown-item">
                                                                        <span>Delete</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    @foreach($rvalue['commentReply'] as $crvalue)
                                    <div class="st_Thread st_Thread--collapsed styles_Thread__3lAiJ" id="reply_div_{{$crvalue['id']}}">
                                        <section>
                                            <div class="st_Card__Content">
                                                <div class="st_Card__TextContentWrapper reply_{{$crvalue['id']}}">

                                                    <div class="byline byline--avatar">
                                                        <a>
                                                            @if (!is_null($crvalue['userInfo']->profile_image) && $crvalue['userInfo']->profile_image != '')
                                                            <img class="avatar-img" src="{{getUserImageUrl($crvalue['userInfo']->profile_image)}}" />
                                                            @else
                                                            <i class="fa fa-user-circle avatar-icon avatar-icon--base"></i>
                                                            @endif
                                                        </a>
                                                        <div class="byline__wrapper">
                                                            <a class="byline__name byline__name--avatar">
                                                                <strong>{{$crvalue['userInfo']->name}}</strong>, Neighbor
                                                            </a>
                                                            <div class="byline__row">
                                                                <a class="byline__secondary">{{getLocationLink(1,$crvalue['user_id'])}}</a>
                                                                <span class="st_Card__LabelDivider">|</span>
                                                                <a class="byline__secondary">
                                                                    <time datetime="{{$crvalue['created_at']}}">{{getPostTime($crvalue['created_at'])}}</time>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="st_Card__Body body_remove_{{$crvalue['id']}}">
                                                        <p>{{$crvalue['comment']}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="st_ActionBar action_remove_{{$crvalue['id']}}">
                                                <div class="st_ActionBar__BarLeft">
                                                    <button aria-label="thank" class="Button_ActionBar like_button-post" data-postid="{{$crvalue['id']}}" data-type="reply" type="button">
                                                        <span class="Button_ActionBar__Icon">
                                                            <?php
                                                            if (isset($crvalue['userLikeInfo']) && !$crvalue['userLikeInfo']->isEmpty()) {
                                                                echo '<i class="fas fa-heart"></i>';
                                                            } else {
                                                                echo '<i class="far fa-heart"></i>';
                                                            }
                                                            ?>
                                                        </span>
                                                        <span class="Button_ActionBar__Label"> Thank({{$crvalue['like_count']}}) </span>
                                                    </button>
                                                </div>
                                                <div class="st_ActionBar__BarRight">
                                                    <div class="st_FlagMenu">
                                                        <div aria-label="flags" class="dropdown">
                                                            @if(Auth::id() != $crvalue['user_id'])
                                                            <div class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" disabled="">
                                                                <button aria-label="flag" class="Button--flag dropdown-toggle" type="button"> 
                                                                    <span class="st_Button__Icon"><i class="far fa-flag"></i></span> 
                                                                </button>
                                                                <div class="flag-menu">
                                                                    <ul class="dropdown-menu dropdown-menu-right" data-option='report' data-postid="{{$crvalue['id']}}" data-type="reply">
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
                                                            @else
                                                            <div class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" id="js-content-flag-menu-article-{{$crvalue['id']}}" disabled="">
                                                                <button aria-label="flag" class="Button--flag dropdown-toggle" type="button">
                                                                    <span class="st_Button__Icon">
                                                                        <i class="fas fa-ellipsis-h"></i>
                                                                    </span> 
                                                                </button>
                                                                <div class="flag-menu">
                                                                    <ul class="dropdown-menu dropdown-menu-right" data-option='edit' data-postid="{{$crvalue['id']}}">
                                                                        <li class="st_FlagItem__link dropdown-item">
                                                                            <span>Edit</span>
                                                                        </li>
                                                                        <li class="st_FlagItem__link dropdown-item">
                                                                            <span>Delete</span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </section>

                    <section class="block" data-nosnippet="true">
                        @if(count($info['postList']) > 1)
                        <header class="st_Section__header">
                            <h2>Today's Top Local News</h2>
                        </header>
                        @endif
                        <input type="hidden" id="login_user_id" value="{{Auth::id()}}">
                        <input type="hidden" id="login_url" value="{{ route("user.register") }}">
                        <input type="hidden" id="like_url" value="{{ route("post-like") }}">
                        <input type="hidden" id="report_url" value="{{ route("post-report") }}">
                        <input type="hidden" id="intrest_url" value="{{ route("event-intrest") }}">
                        <input type="hidden" id="location" value="{{$info['location']}}">
                        <input type="hidden" id="town" value="{{$info['town']}}">
                        <div id="loadData">
                            @php $last_id = 0; @endphp
                            @if(count($info['postList']) > 0)
                            @foreach($info['postList'] as $lpost)
                            @if($info['id'] == $lpost['id'])
                            @php continue; @endphp
                            @endif
                            <article class="st_Card article_{{$lpost['id']}}" id="article_{{$lpost['id']}}">
                                <div class="st_Card__Content">
                                    <div class="st_Card__TextContentWrapper">
                                        <h6 class="st_Card__LabelWrapper">
                                            <a class="st_Card__CommunityName" title="{{$lpost['town']}},{{$lpost['location']}}" href="/l/{{sanitizeStringForUrl($lpost['location'])}}/{{sanitizeStringForUrl($lpost['town'])}}">
                                                <i class="fa fa-map-marker-alt"></i>
                                                <span>{{$lpost['town']}},{{$lpost['location']}}</span>
                                            </a>
                                            <span class="st_Card__LabelDivider">|</span>
                                            <span class="">{{ucfirst($lpost['post_category'])}}</span>
                                            <span class="st_Card__LabelDivider">|</span>

                                            <time datetime="{{$lpost['created_at']}}">{{getPostTime($lpost['created_at'])}}</time>
                                        </h6>
                                        <h2 class="st_Card__Title">
                                            <a class="st_Card__TitleLink" title="{{$lpost['post_title']}}" href="/p/{{$lpost['guid']}}">
                                                {{$lpost['post_title']}}
                                            </a>
                                        </h2>
                                        <p class="st_Card__Description">{{$lpost['post_subtitle']}}</p>
                                        <div class="st_Card__BylineWrapper">
                                            @if (!is_null($lpost['userInfo']->profile_image) && $lpost['userInfo']->profile_image != '')
                                            <img class="avatar-img" src="{{asset('images/'.$lpost['userInfo']->profile_image)}}" />
                                            @else
                                            <i class="fa fa-user-circle avatar-icon--small"></i>
                                            @endif
                                            <span class="st_Card__Byline">
                                                {{$lpost['userInfo']->name}},
                                                Neighborhood Reporter Staff
                                            </span>
                                            <span class="st_Badges">
                                                <img class="avatar-img" alt="Verified Neighborhood Reporter Staff Badge" src="{{asset('images/nr-logo.svg')}}" />
                                                <noscript><img alt="Verified Neighborhood Reporter Staff Badge" src="{{asset('images/nr-logo.svg')}}" /></noscript>
                                            </span>
                                        </div>
                                    </div>
                                    @if($lpost['post_image'] != '')
                                    <a class="st_Card__Thumbnail" title="{{$lpost['post_title']}}" href="/p/{{$lpost['guid']}}">
                                        <img alt="{{$lpost['post_title']}}" class="styles_Card__ThumbnailImage" src="{{postgetImageUrl($lpost['post_image'],$lpost['created_at'])}}" />
                                    </a>
                                    @endif
                                </div>
                                <div class="st_ActionBar">
                                    <div class="st_ActionBar__BarLeft">
                                        <button aria-label="thank" class="Button_ActionBar like_button-post" data-postid="{{$lpost['id']}}" data-type="article" type="button">
                                            <span class="Button_ActionBar__Icon">
                                                <?php
                                                if (isset($lpost['userLikeInfo']) && !$lpost['userLikeInfo']->isEmpty()) {
                                                    echo '<i class="fas fa-heart"></i>';
                                                } else {
                                                    echo '<i class="far fa-heart"></i>';
                                                }
                                                ?>
                                            </span> 
                                            <span class="Button_ActionBar__Label">
                                                Thank({{$lpost['like_count']}})
                                            </span>
                                        </button>
                                        <a class="st_Card__ReplyLink" href="/p/{{$lpost['guid']}}#reply_block_article_nid={{$lpost['id']}}">
                                            <i class="far fa-comment st_Card__ReplyLinkIcon"></i>
                                            Reply({{$lpost['comment_count']}}) 
                                        </a>
                                        <button class="Button_ActionBar share share-button" data-title="{{$lpost['post_title']}}" data-url="/p/{{$lpost['guid']}}" type="button"> 
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
                                                        <ul class="dropdown-menu dropdown-menu-right" data-postid="{{$lpost['id']}}" data-type="article">
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
                            </article>
                            @php $last_id = $lpost['id']; @endphp
                            @endforeach
                            @else
                            <section class="st_FeaturedModule__ModuleLabel">
                                <h4 class="st_FeaturedModule__Title">No article available.</h4>
                            </section>
                            @endif
                        </div>
                        @if(count($info['postList']) > 1)
                        <a class="st_Section__linkButton" href="javascript:void(0);" name="load_more_button" data-url="{{ route("location-load-data") }}" data-id="{{$last_id}}" id="load_more_button" style="{{($info['hidePostButton'] == 1?"display: none;":"")}}">See more local news</a> 
                        @endif
                    </section>
                    <section class="st_Section__1bIk_ event-sec" data-nosnippet="true">
                        @if(count($info['eventList']) > 0)
                        <header class="st_Section__header">
                            <h2>Local Events</h2>
                            <a href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/event" rel="nofollow">+ Post event</a> 
                        </header>
                        @endif
                        <div id="loadEventData">
                            @php $event_last_id = 0; @endphp
                            @if(count($info['eventList']) > 0)
                            @foreach($info['eventList'] as $epost)
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
                                    <a class="st_Card__Thumbnail__1" href="/l/{{sanitizeStringForUrl($epost['location'])}}/{{sanitizeStringForUrl($epost['town'])}}">
                                        <img src="{{postgetImageUrl($epost['image'],$epost['created_at'])}}" />
                                    </a>
                                    @endif
                                </div>
                                <div class="st_ActionBar">
                                    <div class="st_ActionBar__BarLeft">
                                        <button class="Button_ActionBar interested-labe intrest_button-post" data-postid="{{$epost['id']}}" type="button"> 
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
                                        <a class="st_Card__ReplyLink" href="/e/{{$epost['id']}}/{{sanitizeStringForUrl($epost['title'])}}#reply_block_article_nid=29727567"> <i class="far fa-comment st_Card__ReplyLinkIcon"></i> Reply ({{$epost['comment_count']}})</a>
                                        <button class="Button_ActionBar share share-button" data-title="{{$epost['title']}}" data-url="/e/{{$epost['id']}}/{{sanitizeStringForUrl($epost['title'])}}" type="button"> 
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
                                                        <ul class="dropdown-menu dropdown-menu-right" data-postid="{{$epost['id']}}" data-type="event">
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
                            </article>
                            @php $event_last_id = $epost['id']; @endphp
                            @endforeach
                            @else
                            <section class="st_FeaturedModule__ModuleLabel">
                                <h4 class="st_FeaturedModule__Title">No event available.</h4>
                            </section>
                            @endif
                        </div>
                        @if(count($info['eventList']) > 0)
                        <a class="st_Section__linkButton" href="javascript:void(0);" name="load_more_button" data-url="{{ route("event-load-data") }}" data-id="{{$event_last_id}}" id="load_more_event_button" style="{{($info['hideEventButton'] == 1?"display: none;":"")}}">See more events</a> 
                        @endif
                    </section>
                    <section class="st_Section__1bIk_ NeighborPosts-sec" data-nosnippet="true">
                        <header class="st_Section__header">
                            <h2>Neighbor Posts</h2>
                            <a href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose" rel="nofollow">+ Ask a question</a> 
                        </header>
                        <div id="neighbourLoadData">
                            @php $neigh_last_id = 0; @endphp
                            @if(count($info['neighbourPostList']) > 0)
                            @foreach($info['neighbourPostList'] as $npost)
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
                                                <img class="avatar-img" src="{{asset('images/'.$npost['userInfo']->profile_image)}}" />
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
                                            <p>{!!nl2br($npost['post_content'])!!}</p>
                                        </div>
                                        <div>
                                            <button class="btn--link btn--link-base" type="button">Read more</button>
                                        </div>
                                    </div>
                                    @if($npost['post_image'] != '')
                                    <a class="st_Card__Thumbnail__1" href="/n/{{sanitizeStringForUrl($npost['location'])}}/{{sanitizeStringForUrl($npost['town'])}}/{{$npost['id']}}">
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
                                        <a class="st_Card__ReplyLink" href="/n/{{sanitizeStringForUrl($npost['location'])}}/{{sanitizeStringForUrl($npost['town'])}}/{{$npost['id']}}#reply_block_article_nid">
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
                                    <div class="st_ActionBar__BarRight">
                                        <div class="st_FlagMenu">
                                            <div aria-label="flags" class="dropdown">
                                                <div class="js-content-flag-menu" aria-haspopup="true" aria-expanded="false" disabled="">
                                                    <button aria-label="flag" class="Button--flag dropdown-toggle" type="button"> 
                                                        <span class="st_Button__Icon"><i class="far fa-flag"></i></span> 
                                                    </button>
                                                    <div class="flag-menu">
                                                        <ul class="dropdown-menu dropdown-menu-right" data-postid="{{$npost['id']}}" data-type="neighbour">
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
                                @php $link = 1; @endphp
                                @include('neighbor_comment')
                            </article>
                            @php $neigh_last_id = $npost['id']; @endphp
                            @endforeach
                            @else
                            <section class="st_FeaturedModule__ModuleLabel">
                                <h4 class="st_FeaturedModule__Title">No neighbor's post available.</h4>
                            </section>
                            @endif
                        </div>
                        @if(count($info['neighbourPostList']) > 0)
                        <a class="st_Section__linkButton" href="javascript:void(0);" name="load_more_button" data-url="{{ route("neighbour-load-data") }}" data-id="{{$neigh_last_id}}" id="load_more_neighbour_button" style="{{($info['hideNeighborButton'] == 1?"display: none;":"")}}">See more neighbor posts</a> 
                        @endif
                    </section>
                    <section class="st_Section__1bIk_ Classifieds-sec" data-nosnippet="true">
                        <header class="st_Section__header">
                            <h2>Local Classifieds</h2>
                            <a href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/classified" rel="nofollow">+ Post classified</a> 
                        </header>
                        <div id="loadClassifiedData">
                            @php $classified_last_id = 0; @endphp
                            @if(count($info['classifiedList']) > 0)
                            @foreach($info['classifiedList'] as $cpost)
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
                                    <a class="st_Card__Thumbnail__1">
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
                                        <a class="st_Card__ReplyLink" href="/c/{{$cpost['id']}}/{{sanitizeStringForUrl($cpost['title'])}}#reply_block_article_nid={{$cpost['id']}}">
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
                                    <div class="st_ActionBar__BarRight">
                                        <div class="st_FlagMenu">
                                            <div aria-label="flags" class="dropdown">
                                                <div class="js-content-flag-menu" aria-haspopup="true" aria-expanded="false" disabled="">
                                                    <button aria-label="flag" class="Button--flag dropdown-toggle" type="button"> 
                                                        <span class="st_Button__Icon"><i class="far fa-flag"></i></span> 
                                                    </button>
                                                    <div class="flag-menu">
                                                        <ul class="dropdown-menu dropdown-menu-right" data-postid="{{$cpost['id']}}" data-type="classified">
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
                            </article>
                            @php $classified_last_id = $cpost['id']; @endphp
                            @endforeach
                            @else
                            <section class="st_FeaturedModule__ModuleLabel">
                                <h4 class="st_FeaturedModule__Title">No classified's available.</h4>
                            </section>
                            @endif
                        </div>
                        @if(count($info['classifiedList']) > 0)
                        <a class="st_Section__linkButton" href="javascript:void(0);" name="load_more_button" data-url="{{ route("classified-load-data") }}" data-id="{{$classified_last_id}}" id="load_more_classified_button" style="{{($info['hideClassifiedButton'] == 1?"display: none;":"")}}">See more Classifieds</a> 
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
                                <a class="st_CardCompact__ImageLink" href="/e/{{$epost['title']}}">
                                    <img src="{{postgetImageUrl($epost['image'],$epost['created_at'])}}">
                                </a>
                                @endif
                            </article>
                        </div>
                        @endforeach
                        @endif
                    </section>
                    <div class="st_ModuleFooter"><a href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/event" rel="nofollow">+ Add your event</a></div>
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
//    $('.about-us-details-block h1,h3,p,li,h4,div').removeAttr('style');
    var body = '';
    var action_bar = '';
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
            console.log('dd');
            $(this).parent().find(".flag-menu ul.dropdown-menu.dropdown-menu-right").toggle();
//            return false;
        });
        $(document).on("click", ".reply_btn", function () {
            if ($('#login_user_id').val() == '') {
                window.location.href = $('#login_url').val() + "?ru=" + window.location.href;
            } else {
                $("#pills-tabContent").show();
                $('html, body').animate({
                    'scrollTop': $("#pills-tabContent").position().top
                });
                if ($('.st_ArticleThreadBlock__toggle').attr('aria-expanded') == 'false') {
                    $('.st_ArticleThreadBlock__toggle').trigger('click');
                }
            }
        });
        $(document).on("click", "#comment_replay-btn", function () {
            var $this = $(this);
            if ($("#replay_message-box").val() == '') {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                };
                toastr.error("Your reply is too short.");
            } else {
                if ($('#login_user_id').val() == '') {
                    window.location.href = $('#login_url').val() + "?ru=" + window.location.href;
                } else {
                    $(this).find('i').show();
                    var formData = {
                        'post_id': "{{$info['id']}}",
                        'user_id': '{{Auth::id()}}',
                        'parent_id': "{{$info['id']}}",
                        'comment': $("#replay_message-box").val(),
                        'like_count': '0',
                        'reply_count': '0'
                    };
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('add-article-comment') }}",
                        data: formData,
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            $("#collapseReply").prepend(data.body);
                            $("#replay_message-box").val('');
                            $this.find('i').hide();
                            toastr.options = {
                                "closeButton": true,
                                "progressBar": true
                            };
                            toastr.info("Your reply sent successfully.!");
                            $('.st_ArticleThreadBlock__toggle').find('strong').text('Replies(' + data.count + ')');
                            if ($('.st_ArticleThreadBlock__toggle').attr('aria-expanded') == 'false') {
                                $('.st_ArticleThreadBlock__toggle').trigger('click');
                            }
                            $('.reply_count_number').text(data.count);
                        }
                    });
                }
            }
        });
        $(document).on("click", ".st_FlagItem__link", function () {
            $(this).parent().hide();
            var $this = $(this);
            if ($(this).parent().data('option') == 'edit') {
                if ($(this).find('span').text() == 'Edit') {
                    body = action_bar = '';
                    var text = $('.body_remove_' + $(this).parent().data('postid')).find('p').text();
                    body = $('.body_remove_' + $(this).parent().data('postid'));
                    action_bar = $('.action_remove_' + $(this).parent().data('postid'));
                    $('.body_remove_' + $(this).parent().data('postid')).remove();
                    $('.action_remove_' + $(this).parent().data('postid')).remove();
                    var html = '<form class="styles_ReplyForm__3YbUI">' +
                            '<div class="styles_ReplyForm__fieldContainer__3cNzb">' +
                            '<label class="text-field text-field--no-border">' +
                            '<textarea class="text-field__input styles_TextEditor__l92NA styles_TextEditor--is-editing__GrQTN styles_TextEditor--is-small__36ivx" id="edit_message-box" name="message" placeholder="Write your reply" rows="4">' + text + '</textarea>' +
                            '</label>' +
                            '</div>' +
                            '<footer class="styles_ReplyForm__footer__vKEul">' +
                            '<button class="styles_ReplyForm__cancel__1bzbN" data-id="' + $(this).parent().data('postid') + '" type="button">Cancel</button>' +
                            '<button class="styles_ReplyForm__submit__11sYc" data-id="' + $(this).parent().data('postid') + '" type="button" id="edit_replay-btn">Update</button>' +
                            '</footer>' +
                            '</form>';
                    $('.reply_' + $(this).parent().data('postid')).append(html);
                } else {
                    if (confirm('Are you sure you want to delete this reply?')) {
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('delete-article-comment') }}",
                            data: {id: $(this).parent().data('postid'), post_id: "{{$info['id']}}"},
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (data) {
                                toastr.options = {
                                    "closeButton": true,
                                    "progressBar": true
                                };
                                toastr.info("Your reply delete successfully.!");
                                $('.st_ArticleThreadBlock__toggle').find('strong').text('Replies(' + data.count + ')');
                                $('#reply_div_' + $this.parent().data('postid')).remove();
                                $('.reply_count_number').text(data.count);
                            }
                        });
                    }
                }
                $this.parent().hide();
            } else {
                var URL = $('#report_url').val();
                if ($('#login_user_id').val() == '') {
                    window.location.href = $('#login_url').val() + "?ru=" + window.location.href;
                } else {
                    $.ajax({
                        type: 'POST',
                        url: URL,
                        data: {post_id: $(this).parent().data('postid'), type: $(this).parent().data('type'), 'report': $(this).find('span').text()},
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            alert('Your report successfully submited.');
                        }
                    });
                }
            }
        });
        $(document).on('click', '.comment_reply', function () {
            var html = '<form class="styles_ReplyForm__3YbUI" style="border-top: 1px solid #ccc;">' +
                    '<div class="styles_ReplyForm__fieldContainer__3cNzb">' +
                    '<i class="fa fa-user-circle avatar-icon avatar-icon--base"></i>' +
                    '<label class="text-field text-field--no-border">' +
                    '<textarea class="text-field__input styles_TextEditor__l92NA styles_TextEditor--is-small__36ivx" name="message" id="comment_message-box" placeholder="Reply to this article" rows="4" spellcheck="false"></textarea>' +
                    '</label>' +
                    '</div>' +
                    '<footer class="styles_ReplyForm__footer__vKEul">' +
                    '<button class="styles_ReplyForm__cancel__1bzbN" data-id="' + $(this).data('postid') + '" type="button">Cancel</button>' +
                    '<button class="styles_ReplyForm__submit__11sYc" data-id="' + $(this).data('postid') + '" type="button" id="comment_replay-btn2">Reply<i class="fas fa-spinner icon icon--space-left fa-spin loader" style="display: none;"></i></button>' +
                    '</footer>' +
                    '</form>';
            $('.action_remove_' + $(this).data('postid')).after(html);
        });
        $(document).on("click", "#edit_replay-btn", function () {
            if ($("#edit_message-box").val() == '') {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                };
                toastr.error("Your reply is too short.");
            } else {
                if ($('#login_user_id').val() == '') {
                    window.location.href = $('#login_url').val() + "?ru=" + window.location.href;
                } else {
                    var $this = $(this);
                    var formData = {
                        'id': $(this).data('id'),
                        'comment': $("#edit_message-box").val()
                    };
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('edit-article-comment') }}",
                        data: formData,
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            body = data.body;
                            $('.reply_' + $this.data('id')).append(data.body);
                            $('.reply_' + $this.data('id')).parent().parent().append(action_bar);
                            $this.parents('.styles_ReplyForm__3YbUI').remove();
                            toastr.options = {
                                "closeButton": true,
                                "progressBar": true
                            };
                            toastr.info("Your reply edit successfully.!");
                        }
                    });
                }
            }
        });
        $(document).on("click", "#comment_replay-btn2", function () {

            if ($("#comment_message-box").val() == '') {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                };
                toastr.error("Your reply is too short.");
            } else {
                if ($('#login_user_id').val() == '') {
                    window.location.href = $('#login_url').val() + "?ru=" + window.location.href;
                } else {
                    $(".loader").show();
                    var $this = $(this);
                    var formData = {
                        'post_id': "{{$info['id']}}",
                        'user_id': '{{Auth::id()}}',
                        'parent_id': $(this).data('id'),
                        'comment': $("#comment_message-box").val(),
                        'like_count': '0',
                        'reply_count': '0',
                        'reply_comment': '1'
                    };
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('add-article-comment') }}",
                        data: formData,
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            $("#reply_div_" + $this.data('id')).append(data.body);
                            $("#replay_message-box").val('');
                            $(".loader").hide();
                            toastr.options = {
                                "closeButton": true,
                                "progressBar": true
                            };
                            toastr.info("Your reply sent successfully.!");
                            $('.st_ArticleThreadBlock__toggle').find('strong').text('Replies(' + data.count + ')');
                            $this.parents('.styles_ReplyForm__3YbUI').remove();
                        }
                    });
                }
            }
        });
        $(document).on("click", ".styles_ReplyForm__cancel__1bzbN", function () {
            $('.reply_' + $(this).data('id')).append(body);
            $('.reply_' + $(this).data('id')).parent().parent().append(action_bar);
            $(this).parents('.styles_ReplyForm__3YbUI').remove();
        });
        $(document).on("click", "body", function () {
//            $('.st_FlagMenu .dropdown-toggle').parent().find(".flag-menu ul.dropdown-menu.dropdown-menu-right").hide();
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
            pauseOnHover: true,
            pauseOnFocus: true
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
        $(".st_ArticleThreadBlock__toggle").click(function () {
            $(".st_ArticleThreadBlock__toggle .st_ArticleThreadBlock__toggleIcon").toggleClass("chevron-rotate");
        });
        $(document).on('click', '#load_more_button', function () {
            var id = $(this).data('id');
            var url = $(this).data('url');
            //console.log(id);
            $(this).html('<b>Loading...</b>');
            loadMoreData(id, url, 'loadData', $(this));
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
            loadMoreData(id, url, 'neighbourLoadData', $(this));
        });
        $(document).on('click', '.like_button-post', function () {
            var URL = $('#like_url').val();
            var $this = $(this);
            if ($('#login_user_id').val() == '') {
                window.location.href = $('#login_url').val() + "?ru=" + window.location.href;
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
        $(document).on('click', '.intrest_button-post', function () {
            var URL = $('#intrest_url').val();
            var $this = $(this);
            if ($('#login_user_id').val() == '') {
                window.location.href = $('#login_url').val() + "?ru=" + window.location.href;
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
        $(document).on('click', '.btn--link-base', function () {
            $(this).parents('.st_Card__TextContentWrapper').find('.st_Card__Body').toggleClass('st_Card__Body--Truncated');
            if ($(this).text() == 'Read more') {
                $(this).text('See less');
            } else {
                $(this).text('Read more');
            }
        });
    });
</script>
@endsection