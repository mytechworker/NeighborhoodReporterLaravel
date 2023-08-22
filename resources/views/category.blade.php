@extends('layouts.app')
@section('title')
{{$info['town']}} {{$info['category']}} | {{$info['town']}}, {{$info['location']}}  Neighborhood Reporter
@endsection
@section('meta')
<!-- Primary Meta Tags -->
<meta name="title" content="{{$info['town']}} {{$info['category']}} | {{$info['town']}}, {{$info['location']}}  Neighborhood Reporter">
<meta name="description" content="{{$info['town']}},, {{$info['location']}} {{$info['category']}} schools and education news, updates, events and local {{$info['category']}}">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/calendar">
<meta property="og:title" content="{{$info['town']}} {{$info['category']}} | {{$info['town']}}, {{$info['location']}}  Neighborhood Reporter">
<meta property="og:description" content="{{$info['town']}},, {{$info['location']}} {{$info['category']}} and education news, updates, events and local {{$info['category']}}">
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
<meta property="twitter:title" content="{{$info['town']}} {{$info['category']}} | {{$info['town']}}, {{$info['location']}}  Neighborhood Reporter">
<meta property="twitter:description" content="{{$info['town']}}, {{$info['location']}} {{$info['category']}} and education news, updates, events and local {{$info['category']}}">
<meta property="twitter:image" content="{{asset('images/logo.png')}}">
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content-sec">
    <div class="container pad-0">
        <div class="row mar-mob">
            <div class="col-md-12 col-lg-8 pad-0">
                <main id="main" role="main" class="page__main">                    
                    <section class="block" data-nosnippet="true">
                        <header class="st_Section__header">
                            <h2>{{$info['town']}} {{$info['category']}}</h2>
                        </header>
                        <input type="hidden" id="login_user_id" value="{{Auth::id()}}">
                        <input type="hidden" id="login_url" value="{{ route("user.register") }}">
                        <input type="hidden" id="like_url" value="{{ route("post-like") }}">
                        <input type="hidden" id="report_url" value="{{ route("post-report") }}">
                        <input type="hidden" id="intrest_url" value="{{ route("event-intrest") }}">
                        <input type="hidden" id="location" value="{{$info['location']}}">
                        <input type="hidden" id="town" value="{{$info['town']}}">
                        <input type="hidden" id="category" value="{{$info['category']}}">
                        <div id="loadData">
                            @php $last_id = 0; @endphp
                            @if(count($info['postList']) > 0)
                            @foreach($info['postList'] as $lpost)
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
                                            <img class="avatar-img" src="{{getUserImageUrl($lpost['userInfo']->profile_image)}}" />
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
                                        <img alt="{{$lpost['post_title']}}" class="styles_Card__ThumbnailImage" src="{{postgetImageUrl($lpost['post_image'],$lpost['created_at'])}}"/>
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
                        @if(count($info['postList']) > 0)
                        <a class="st_Section__linkButton" href="javascript:void(0);" name="load_more_button" data-url="{{ route("category-load-data") }}" data-id="{{$last_id}}" id="load_more_button" style="{{($info['hidePostButton'] == 1?"display: none;":"")}}">See more local news</a> 
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
            data: {id: id, location: $("#location").val(), town: $("#town").val(), category: $("#category").val()},
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
    });
</script>
@endsection