@extends('layouts.app')
@section('title')
@if(!empty($info['category']))
{{$info['town']}}, {{$info['location']}} Marketplace - {{$info['category']}} - Neighborhood Reporter
@else
{{$info['town']}}, {{$info['location']}} Marketplace - Neighborhood Reporter
@endif
@endsection
@section('meta')
<!-- Primary Meta Tags -->
<meta name="title" content="{{$info['town']}}, {{$info['location']}} Local Marketplace">
<meta name="description" content="Local market ads for gigs & services, free stuff, for sale, announcements, housing, job listings and lost and found in {{$info['town']}}, {{$info['location']}}">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/marketplace">
<meta property="og:title" content="{{$info['town']}}, {{$info['location']}} Local Marketplace">
<meta property="og:description" content="Local market ads for gigs & services, free stuff, for sale, announcements, housing, job listings and lost and found in {{$info['town']}}, {{$info['location']}}">
<meta property="og:image" content="{{asset('images/logo.png')}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/marketplace">
<meta property="twitter:title" content="{{$info['town']}}, {{$info['location']}} Local Marketplace">
<meta property="twitter:description" content="Local market ads for gigs & services, free stuff, for sale, announcements, housing, job listings and lost and found in {{$info['town']}}, {{$info['location']}}">
<meta property="twitter:image" content="{{asset('images/logo.png')}}">
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .not_show_other_pages{display: none;}
</style>
<div class="mp-first">
    <article class="hero-marketplace">
        <h1 class="hero-marketplace-title">{{$info['town']}}<br><span>Marketplace</span></h1>
    </article>
    <div class="st-FeaturedBusinesses local-businesses">
        <div class="st-FeaturedBusinesses-title">
            <h3>Featured Local Businesses <i class="fa fa-award"></i></h3>
            <a class="st-Section-composeButton st-Section-composeButton-bizpost st-Section-composeButton-small" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/bizpost" rel="nofollow">+ Feature My Business</a>
        </div>
        @if(isset($info['bizPost']) && count($info['bizPost']) == 0)
        <div class="st-FeaturedBusinesses-Empty-content">
            <h2 class="st-FeaturedBusinesses-Empty-header">Businesses and deals are coming soon<br class="st-FeaturedBusinesses-Empty-break">to your local Marketplace!</h2>
            <img class="st-FeaturedBusinesses-Empty-image" src="{{asset('images/empty-marketplace.png')}}?format=webply&amp;dpr=2">
            <h3 class="st-FeaturedBusinesses-Empty-subheader">Put your business on the Neighborhood Reporter</h3>
            <p class="st-FeaturedBusinesses-Empty-copy">Feature your business in the local Marketplace and get prime placement in daily
                <br class="st-FeaturedBusinesses-Empty-break">newsletters, on local home pages, Neighborhood Reporter articles and on Neighbor Posts pages.
                <br><a class="btn st-FeaturedBusinesses-Empty-feature-btn" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/bizpost">Feature My Business</a></p>
        </div>
        @else
        <div class="local-businesses-box">
            @foreach($info['bizPost'] as $bpost)
            <div class="box-busb">
                <div class="st_CarouselCard__Wrapper">
                    <a class="st_BusinessCard__Button" href="/b/{{$bpost['id']}}/{{sanitizeStringForUrl($bpost['business_name'])}}" tabindex="0">
                        <figure class="st_Card__Thumbnail">
                            @if($bpost['image'] != '')
                            <img class="st_Card__ThumbnailImage" src="{{postgetImageUrl($bpost['image'],$bpost['created_at'])}}">
                            @else
                            <img class="st_Card__ThumbnailImage" src="{{asset('images/local-business-placeholder.png')}}">
                            @endif
                        </figure>
                        <div class="st_Card__TextContentWrapper reg-2-text">
                            <h2>{{$bpost['business_name']}}</h2>
                            <div class="des-text">
                                <p>{{$bpost['headline']}}</p>
                            </div>

                        </div>
                    </a>
                </div>
            </div>
            @endforeach
            <div class="box-busb">   
                <div class="st_CarouselCard__Wrapper">
                    <div class="st_BusinessCard__Button" href="#" tabindex="0">
                        <figure class="st_Card__Thumbnail">
                            <img class="st_Card__ThumbnailImage" src="{{asset('images/feature-business.png')}}">
                        </figure>
                        <div class="st_Card__TextContentWrapper list-cost reg-2-text">
                            <h2>List your business here</h2>
                            <div class="des-text">
                                <a class="btn btn-primary styles_BusinessCTA-btn" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/bizpost">Start now</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>   
        </div>
        @endif
    </div>
</div>
<div class="content-sec">
    <div class="container pad-0">
        <div class="row mar-mob">
            <div class="col-md-12 col-lg-8 pad-0">
                <main id="main" role="main" class="page__main">                    
                    <section class="block" data-nosnippet="true">
                        <div class="page-title-wrapper classifieds">
                            <h2 class="page-title page-title-feed">Classifieds</h2>
                            <div class="dropdown">
                                <?php
                                $categoryArray = array('Announcements', 'For Sale', 'Free Stuff', 'Gigs & Services', 'Housing', 'Job Listing', 'Lost & Found', 'Other');
                                ?>
                                @if(!empty($info['category']))
                                <button id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle--outlined dropdown-toggle btn">
                                    {{$info['category']}}<i class="fa fa-caret-down icon icon--space-left"></i>
                                </button>
                                @else
                                <button id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle--outlined dropdown-toggle btn">
                                    All<i class="fa fa-caret-down icon icon--space-left"></i>
                                </button>
                                @endif

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if(!empty($info['category']))
                                    <li class="dropdown-item">
                                        <a class="card__link" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/marketplace">
                                            <i class="fa fa-list icon icon--space-right"></i>All
                                        </a>
                                    </li>
                                    @else
                                    @foreach($categoryArray as $key => $value)
                                    <li class="dropdown-item">
                                        <a class="card__link" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/classifieds/{{sanitizeStringForUrl($value)}}">
                                            <span>@php echo getClassifiedIcon($value); @endphp</span> {{$value}}
                                        </a>
                                    </li>
                                    @endforeach
                                    @endif
                                    @foreach($categoryArray as $key => $value)
                                    <?php
                                    $search = $info['category'];
                                    if (!preg_match("/{$search}/i", $value)) {
                                        ?>
                                        <li class="dropdown-item">
                                            <a class="card__link" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/classifieds/{{sanitizeStringForUrl($value)}}">
                                                <span>@php echo getClassifiedIcon($value); @endphp</span> {{$value}}
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <a class="compose-block" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/classified" rel="nofollow"> 
                            <i class="fas fa-user-circle avatar-icon"></i>
                            <span class="compose-block__label">post a classified</span>
                            <i class="compose-block__image-icon fas fa-camera"></i>
                            <span class="compose-block__post">Post</span>
                        </a>

                        <input type="hidden" id="login_user_id" value="{{Auth::id()}}">
                        <input type="hidden" id="login_url" value="{{ route("user.register") }}">
                        <input type="hidden" id="like_url" value="{{ route("post-like") }}">
                        <input type="hidden" id="report_url" value="{{ route("post-report") }}">
                        <input type="hidden" id="intrest_url" value="{{ route("event-intrest") }}">
                        <input type="hidden" id="location" value="{{$info['location']}}">
                        <input type="hidden" id="town" value="{{$info['town']}}">
                        <input type="hidden" id="category" value="{{$info['category']}}">

                    </section>

                    <section class="st_Section__1bIk_ Classifieds-sec" data-nosnippet="true">
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
                                    <a class="st_Card__Thumbnail__1" href="/c/{{$cpost['id']}}/{{sanitizeStringForUrl($cpost['title'])}}">
                                        <img src="{{postgetImageUrl($cpost['image'],$cpost['created_at'])}}" />
                                        <noscript> <img class="st_Card__ThumbnailImage" src="{{postgetImageUrl($cpost['image'],$cpost['created_at'])}}" /> </noscript>
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
                    <div class="st-calltoaction">
                        <a class="st-calltoaction-title" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/classified" rel="nofollow">Need something near you?</a>
                        <p class="st-calltoaction-description">Find what you're looking for in your community.</p><a class="st-calltoaction-button" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/classified" rel="nofollow">Post a classified on Neighbothood Reporter</a>
                    </div>
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
    function loadMoreData(id = 0, url, html_id, $this) {
        $.ajax({
            type: 'POST',
            url: url,
            data: {id: id, location: $("#location").val(), town: $("#town").val(), category: $('#category').val()},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $this.remove();
                $('#' + html_id).append(data);
            }
        });
    }
    function formatText(icon) {
        return $('<span><i class="' + $(icon.element).data('icon') + ' icon icon--space-right"></i> ' + icon.text + '</span>');
    }
    jQuery(document).ready(function () {
        var $ = jQuery;
        $('.select2-icon').select2({
            templateSelection: formatText,
            templateResult: formatText
        });
        $(document).on("click", ".st_FlagMenu .dropdown-toggle", function () {
            $(this).parent().find(".flag-menu ul.dropdown-menu.dropdown-menu-right").toggle();
            return false;
        });
        $(document).on("click", ".st_FlagItem__link", function () {
            $(this).parent().hide();
            var URL = $('#report_url').val();
            if ($('#login_user_id').val() == '') {
                window.location.href = $('#login_url').val();
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
                window.location.href = $('#login_url').val() + '?ru='+window.location.href;
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
                window.location.href = $('#login_url').val() + '?ru='+window.location.href;
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