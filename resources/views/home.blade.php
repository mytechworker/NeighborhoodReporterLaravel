@extends('layouts.app')
@section('title')
Home
@endsection
@section('meta')
<!-- Primary Meta Tags -->
<meta name="title" content="Neighborhood Reporter - Everything Local: Breaking News, Events, Discussions">
<meta name="description" content="The best breaking news, stories, and events from the Neighborhood Reporter network of local news sites">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}">
<meta property="og:title" content="Neighborhood Reporter - Everything Local: Breaking News, Events, Discussions">
<meta property="og:description" content="The best breaking news, stories, and events from the Neighborhood Reporter network of local news sites">
<meta property="og:image" itemprop="image" content="{{asset('images/logo.png')}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}">
<meta property="twitter:title" content="Neighborhood Reporter - Everything Local: Breaking News, Events, Discussions">
<meta property="twitter:description" content="The best breaking news, stories, and events from the Neighborhood Reporter network of local news sites">
<meta property="twitter:image" itemprop="image" content="{{asset('images/logo.png')}}">
@endsection
@section('content')
<link itemprop="thumbnailUrl" href="{{asset('images/logo.png')}}"> 
<span itemprop="thumbnail" itemscope itemtype="http://schema.org/ImageObject"> 
    <link itemprop="url" href="{{asset('images/logo.png')}}"> 
</span>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content-sec">
    <div class="container pad-0">
        <div class="row mar-mob">
            <div class="col-md-12 col-lg-8 pad-0">
                <main id="main" role="main" class="page__main">                    
                    <section class="block" data-nosnippet="true">
                        <header class="st_Section__header">
                            <h2>Today's Top Local News</h2>
                        </header>
                        <input type="hidden" id="login_user_id" value="{{Auth::id()}}">
                        <input type="hidden" id="login_url" value="{{ route("user.register") }}">
                        <input type="hidden" id="like_url" value="{{ route("post-like") }}">
                        <input type="hidden" id="report_url" value="{{ route("post-report") }}">
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
                                        <img alt="{{$lpost['post_title']}}" class="styles_Card__ThumbnailImage" src="{{postgetImageUrl($lpost['post_image'],$lpost['created_at'])}}" />
                                    </a>
                                    @endif
                                </div>
                                <div class="st_ActionBar">
                                    <div class="st_ActionBar__BarLeft">
                                        <button aria-label="thank" class="Button_ActionBar like_button-post" data-postid="{{$lpost['id']}}" type="button">
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
                                        <a class="st_Card__ReplyLink" href="/p/{{$lpost['guid']}}#reply_block_article_nid">
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
                                                        <ul class="dropdown-menu dropdown-menu-right" data-postid="{{$lpost['id']}}">
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
                        <a class="st_Section__linkButton" href="javascript:void(0);" name="load_more_button" data-url="{{ route("load-data") }}" data-id="{{$last_id}}" id="load_more_button" style="{{($info['hidePostButton'] == 1?"display: none;":"")}}">See more local news</a> 
                    </section>

                </main>
            </div>
            <div class="right-sec home_page_slider">
                <section class="st_FeaturedModule__ModuleLabel">
                    <h4 class="st_FeaturedModule__Title">Live on Neighborhood Reporter</h4>
                </section>
                <div class="vertical-slider m-20">
                    <section class="regular slider">
                        @if(count($info['top10Post']) > 0)
                        @foreach($info['top10Post'] as $t10post)
                        <div>
                            <article class="st_CardCompact">
                                @if($t10post['post_image'] != '')
                                <a class="st_CardCompact__ImageLink" href="/p/{{$t10post['guid']}}">
                                    <img src="{{postgetImageUrl($t10post['post_image'],$t10post['created_at'])}}">
                                </a>
                                @endif

                                <div class="st_ContentLeft">
                                    <a class="styles_CardCompact__TitleLink__2PtcE" href="/l/{{sanitizeStringForUrl($t10post['location'])}}/{{sanitizeStringForUrl($t10post['town'])}}">
                                        <span>
                                            <i class="fa fa-map-marker-alt st_CardMini__LocationIcon"></i>
                                            <span>{{$t10post['town']}}, {{$t10post->regionInfo['region_code']}}</span>
                                        </span>
                                    </a>
                                    <div class="st_TitleWrapper">
                                        <h5 class="styles_CardCompact__Title__3Et5F">
                                            <a class="styles_CardCompact__TitleLink__2PtcE" title="{{$t10post['post_title']}}" href="/p/{{$t10post['guid']}}">{{$t10post['post_title']}}</a>
                                        </h5>
                                    </div>
                                </div>
                            </article>
                        </div>
                        @endforeach
                        @else
                        <section class="st_FeaturedModule__ModuleLabel">
                            <h4 class="st_FeaturedModule__Title">No data available.</h4>
                        </section>
                        @endif
                    </section>
                </div>
                <section class="st_FeaturedModule__ModuleLabel">
                    <h4 class="st_FeaturedModule__Title">Trending on Social</h4>
                </section>
                <section class="st_Wrapper location-sec" data-nosnippet="true">
                    <ol class="st_List">
                        @if(count($info['tradingPost']) > 0)
                        @foreach($info['tradingPost'] as $tpost)
                        <li class="st_CardMini">
                            <h5 class="st_CardMini__Title"><a class="st_CardMini__TitleLink" href="/p/{{$tpost['guid']}}">{{$tpost['post_title']}}</a></h5>
                        </li>
                        @endforeach
                        @else
                        <section class="st_FeaturedModule__ModuleLabel">
                            <h4 class="st_FeaturedModule__Title">No data available.</h4>
                        </section>
                        @endif
                    </ol>
                </section>


            </div>
            <div> 
            </div>
        </div>
    </div>
</div>
<script>
    function loadMoreData(id = 0, url) {
        $.ajax({
            type: 'POST',
            url: url,
            data: {id: id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $('#load_more_button').remove();
                $('#loadData').append(data);
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
                window.location.href = $('#login_url').val() + '?back=home&p=' + $(this).parents('.st_Card').attr('id');
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
        $('#community').on('keyup', function () {
            var query = $(this).val();
            if (query != '') {
                $.ajax({
                    url: "{{ route('search_event_community') }}",
                    type: "GET",
                    data: {'communitie': query},
                    success: function (data) {
                        $('#community_list').html(data);
                    }
                });
            } else {
                $('#community_list').html('');
            }
        });
        $(document).on('click', '.list-group-item', function () {
            var value = $(this).text();
            var cid = $(this).data('id');
            $('#community').val(value);
            $('#community_id').val(cid);
            $('#community_list').html("");
        });
        $(document).on("click", "body", function () {
            $('.st_FlagMenu .dropdown-toggle').parent().find(".flag-menu ul.dropdown-menu.dropdown-menu-right").hide();
//            return false;
        });

        $(".regular").slick({
            dots: false,
            arrows: false,
            infinite: true,
            slidesToShow: 5,
            autoplay: true,
            autoplaySpeed: 3000,
            slidesToScroll: 1,
            vertical: true,
            verticalSwiping: true,
            pauseOnHover: true,
            pauseOnFocus: true
        });
        $(document).on("click", ".header-hamburger-btn", function () {
            $(".h-hamburger-line").toggleClass('hamburger__line--open');
            $(".mob-menu").toggleClass("show-mob-menu");
            $('.header').toggleClass('header--fixed');
            $('.header').removeClass("header--sticky-full");
            $('.header').removeClass("header--sticky-condensed");
            $('body').toggleClass("over-class");
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
            $('#load_more_button').html('<b>Loading...</b>');
            loadMoreData(id, url);
        });
        $(document).on('click', '.like_button-post', function () {
            var URL = $('#like_url').val();
            var $this = $(this);
            if ($('#login_user_id').val() == '') {
                window.location.href = $('#login_url').val() + '?back=home&p=' + $(this).parents('.st_Card').attr('id');
            } else {
                $.ajax({
                    type: 'POST',
                    url: URL,
                    data: {post_id: $(this).data('postid'), type: 'article'},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        $this.html(data.html);
                        $this.attr('data-likecount', data.count);
                    }
                });
            }
        });
    });
</script>
@endsection