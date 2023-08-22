@extends('layouts.app')
@section('title')
{{$info['town']}} Events Calendar for {{\Carbon\Carbon::parse(date('Y-m-d H:i:s'))->format('l, F j')}} - {{$info['town']}}, {{$info['location']}} Neighborhood Reporter
@endsection
@section('meta')
<!-- Primary Meta Tags -->
<meta name="title" content="{{$info['town']}} Events Calendar for {{\Carbon\Carbon::parse(date('Y-m-d H:i:s'))->format('l, F j')}} - {{$info['town']}}, {{$info['location']}} Neighborhood Reporter">
<meta name="description" content="{{\Carbon\Carbon::parse(date('Y-m-d H:i:s'))->format('l, F j')}} Calendar of free events, paid events, and things to do in {{$info['town']}}, {{$info['location']}}">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/calendar">
<meta property="og:title" content="{{$info['town']}} Events Calendar for {{\Carbon\Carbon::parse(date('Y-m-d H:i:s'))->format('l, F j')}} - {{$info['town']}}, {{$info['location']}} Neighborhood Reporter">
<meta property="og:description" content="{{\Carbon\Carbon::parse(date('Y-m-d H:i:s'))->format('l, F j')}} Calendar of free events, paid events, and things to do in {{$info['town']}}, {{$info['location']}}">
<meta property="og:image" content="{{asset('images/logo.png')}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="{{$info['town']}}, {{$info['location']}} Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/calendar">
<meta property="twitter:title" content="{{$info['town']}} Events Calendar for {{\Carbon\Carbon::parse(date('Y-m-d H:i:s'))->format('l, F j')}} - {{$info['town']}}, {{$info['location']}} Neighborhood Reporter">
<meta property="twitter:description" content="{{\Carbon\Carbon::parse(date('Y-m-d H:i:s'))->format('l, F j')}} Calendar of free events, paid events, and things to do in {{$info['town']}}, {{$info['location']}}">
<meta property="twitter:image" content="{{asset('images/logo.png')}}">
@endsection
@section('content')
<style>
    .styles_EventFeedSection__3KgsA {
        margin: 32px 0;
        margin-bottom: 0;
    }
    #home ul li {
        width: unset;
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content-sec">
    <div class="container pad-0">
        <div class="row mar-mob">
            <div class="col-md-12 col-lg-8 pad-0">
                <main id="main" role="main" class="page__main event-page calendar-sec">                    
                    <header class="st_Section__header">
                        <h2>{{$info['town']}} {{$info['location']}} Community Calendar</h2>
                    </header>
                    <div class="tab-section-calendar">
                        <ul class="nav nav-tabs"> 
                            <a class="st_Button" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/event" rel="nofollow">+ Add your event</a>
                            <li class="active calendar-filter">
                                <a data-toggle="tab" href="#home">All</a>
                            </li>
                            <li class="calendar-filter">
                                <a data-toggle="tab" data-startDate="{{date('Y-m-d')}}" data-endDate="{{date('Y-m-d', strtotime('+7 days'))}}" href="#menu1">This Week</a>
                            </li>
                            <li class="calendar-filter">
                                <a data-toggle="tab" data-startDate="{{date('Y-m-d', strtotime('next week Monday'))}}" data-endDate="{{date("Y-m-d", strtotime(date('Y-m-d', strtotime('next week Monday')) . " +1 week"))}}" href="#menu2">Next week</a>
                            </li>
                            <li class="calendar-filter">
                                <a data-toggle="tab" data-startDate="{{date('Y-m-d')}}" data-endDate="{{date('Y-m-d', strtotime('first day of next month'))}}" href="#menu3">This month</a>
                            </li>
                            <li class="calendar-filter">
                                <a data-toggle="tab" data-startDate="{{date('Y-m-d', strtotime('first day of next month'))}}" data-endDate="{{date("Y-m-d", strtotime(date('Y-m-d', strtotime('first day of next month')) . " +1 month"))}}" href="#menu4">Next month</a>
                            </li>
                        </ul>
                        <input type="hidden" id="login_user_id" value="{{Auth::id()}}">
                        <input type="hidden" id="login_url" value="{{ route("user.register") }}">
                        <input type="hidden" id="like_url" value="{{ route("post-like") }}">
                        <input type="hidden" id="report_url" value="{{ route("post-report") }}">
                        <input type="hidden" id="intrest_url" value="{{ route("event-intrest") }}">
                        <input type="hidden" id="location" value="{{$info['location']}}">
                        <input type="hidden" id="town" value="{{$info['town']}}">
                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active show">
                                <section data-nosnippet="true" class="event-card-detail event-sec">
                                    <div class="m-50">

                                        <div id="loadEventData">
                                            @if(count($info['calendarEvent']) > 0)
                                            @foreach($info['calendarEvent'] as $key => $vpost)
                                            <section class="styles_EventFeedSection__3KgsA">
                                                <h4 class="st_EventFeedSection">{{\Carbon\Carbon::parse(date('Y-m-d H:i:s',$key))->format('l, F j')}}</h4>
                                                @foreach($vpost as $epost)
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
                                                            <a class="st_Card__ReplyLink" href="/e/{{$epost['id']}}/{{sanitizeStringForUrl($epost['title'])}}#reply_block_article_nid"> <i class="far fa-comment st_Card__ReplyLinkIcon"></i> Reply ({{$epost['comment_count']}})</a>
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
                                                @endforeach
                                            </section>
                                            @endforeach
                                            @else
                                            <section class="st_FeaturedModule__ModuleLabel">
                                                <h4 class="st_FeaturedModule__Title">No event available.</h4>
                                            </section>
                                            @endif
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
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
                    <div class="st_ModuleFooter">
                        <a href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/event" class="add_post_link" rel="nofollow">+ Add your event</a>
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
    var pager = 1;
    var working = false;
    var startTime = '';
    var endTime = '';
    function loadMore() {
        $("#loadEventData").append('<p id="loading"><i class="fas fa-spinner icon icon--space-right fa-spin"></i>Loading more events....</p>');
        if (startTime != '' && endTime != '') {
            formData = {pager: pager, location: $("#location").val(), town: $("#town").val(), startTime: startTime, endTime: endTime, last_date: $('.st_EventFeedSection:last').text()};
        } else {
            formData = {pager: pager, location: $("#location").val(), town: $("#town").val(), last_date: $('.st_EventFeedSection:last').text()};
        }
        $.ajax({
            type: 'POST',
            url: "{{route('calendar-filter-data')}}",
            data: formData,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $("#loading").remove();
                $("#loadEventData").append(data.html);
                if (data.more == 1) {
                    working = false;
                }
            }
        });
    }

    jQuery(document).ready(function () {
        var $ = jQuery;
        $(document).scroll(function () {
            var bottom = (($(document).height()) - ($(window).height()));
            scrollat = scrollat = $(document).scrollTop();
            if (scrollat >= bottom - 600) {
                if (!working) {
                    working = true;
                    pager++;
                    loadMore();
                }
            }
        });
        $(document).on('click', '.calendar-filter', function () {
            pager = 1;
            working = false;
            if ($(this).find('a').text() == 'All') {
                startTime = '';
                endTime = '';
            } else {
                startTime = $(this).find('a').data('startdate');
                endTime = $(this).find('a').data('enddate');
            }

            $('.calendar-filter').removeClass('active');
            $(this).addClass('active');
            $("#loadEventData").html('<p id="loading"><i class="fas fa-spinner icon icon--space-right fa-spin"></i>Loading more events....</p>');
            $.ajax({
                type: 'POST',
                url: "{{route('calendar-filter-data')}}",
                data: {pager: pager, location: $("#location").val(), town: $("#town").val(), startTime: $(this).find('a').data('startdate'), endTime: $(this).find('a').data('enddate')},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $("#loadEventData").html(data.html);
                }
            });
        });
        $(document).on("click", ".st_FlagMenu .dropdown-toggle", function () {
            $(this).parent().find(".flag-menu ul.dropdown-menu.dropdown-menu-right").toggle();
            return false;
        });
        $(document).on("click", "body", function () {
            $('.st_FlagMenu .dropdown-toggle').parent().find(".flag-menu ul.dropdown-menu.dropdown-menu-right").hide();
//            return false;
        });

        $(document).on("click", ".st_FlagItem__link", function () {
            $(this).parent().hide();
            var $this = $(this);
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
        });
        $(document).on("click", function (e) {
            if ($(e.target).is(".st_EventDetails__Item .dropdown .dropdown-menu.open-menu") === false) {
                $('.st_EventDetails__Item .dropdown .dropdown-menu.open-menu').removeClass('open-menu');
            }
        });
        $(document).on("click", "body", function () {
            $('.st_FlagMenu .dropdown-toggle').parent().find(".flag-menu ul.dropdown-menu.dropdown-menu-right").hide();
//            return false;
        });
        $(document).on("click", ".add_post_link", function () {
            if ($('#login_user_id').val() == '') {
                window.location.href = $('#login_url').val() + "?ru={{route('home')}}" + $(this).attr('href');
                return false;
            }
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

        $(document).on('click', '#load_more_event_button', function () {
            var id = $(this).data('id');
            var url = $(this).data('url');
            //console.log(id);
            $(this).html('<b>Loading...</b>');
            loadMoreData(id, url, 'loadEventData', $(this));
        });

        $(document).on('click', '.like_button-post', function () {
            var URL = $('#like_url').val();
            var $this = $(this);
            if ($('#login_user_id').val() == '') {
                window.location.href = $('#login_url').val() + '?home=1';
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
                window.location.href = $('#login_url').val() + '?home=1';
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
</script>
@endsection