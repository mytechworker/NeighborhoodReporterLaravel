@extends('layouts.manageApp')
@section('title')
My Neighborhood Reporter
@endsection
@section('meta')
<!-- Primary Meta Tags -->
<meta name="title" content="My Neighborhood Reporter">
<meta name="description" content="My Neighborhood Reporter Business Listing">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/content/bizpost">
<meta property="og:title" content="My Neighborhood Reporter">
<meta property="og:description" content="My Neighborhood Reporter Business Listing">
<meta property="og:image" content="{{asset('images/logo.png')}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/content/bizpost">
<meta property="twitter:title" content="My Neighborhood Reporter">
<meta property="twitter:description" content="My Neighborhood Reporter Business Listing">
<meta property="twitter:image" content="{{asset('images/logo.png')}}">
@endsection
@section('content')
<style>
    body {
        background: white !important; 
    }
    .back-white{
        background-color: white;
    }
    .border-bottom-solid {
        border-bottom: 1px solid #eee;
        margin-bottom: 15px;
        padding-bottom: 15px;
    }
    section.manage-posts ul.listings li {
        width: 100%;
        text-align: left;
        border: none;
    }
    section.manage-posts ul.listings li strong a {
        color: #d20000;
        cursor: pointer;
        text-decoration: none;
        padding: 0;
    }
    .manage-tab header.test-event-text a {
        font-weight: 400;
        margin-bottom: 5.25px;
        margin-top: 0;
        line-height: 24px;
        font-size: 19px;
        color: #d20000;
        cursor: pointer;
        text-decoration: none;
        font-weight: 700;
        padding: 0;
    }
    .text-success span {
        color: #333 !important;
        font-weight: 700;
    }
    .manage-tab .side-btn a.btn {
        padding: 5px 10px;
        font-size: 15px;
        line-height: 1.5;
        border-radius: 3px;
        max-width: 140px;
        width: 100%;
    }
    .manage-tab .side-btn a.btn-cta-alt {
        color: #fff;
        background-color: #d20000;
        border-color: #d20000;
        border-radius: 50px;
    }
    .manage-tab .side-btn a.btn.btn-outline-cta{
        color: #06C42A;
        background-color: transparent;
        background-image: none;
        border-color: #06C42A;
    }

    .manage-tab .side-btn a.btn.btn-outline-cta {
        color: #d20000;
        background-color: transparent;
        background-image: none;
        border-color: #d20000;
        border-radius: 50px;
        margin-top: 10px;
    }
    .d-inline-block.social-btn-icon a {
        display: inline-block;
    }
    .side-btn {
        text-align: right;
    }
    .facebook-link {
        color: #3B5998;
        cursor: pointer;
        text-decoration: none;
    }
    .twitter-link {
        color: #1DA1F2;
        cursor: pointer;
        text-decoration: none;
    }
    @media (min-width: 576px) {
        .flex-basis-sm-pct-80 {
            flex-basis: 80% !important;
        }
        .flex-basis-md-pct-15 {
            flex-basis: 20% !important;
        }
        .flex-basis-sm-pct-100 {
            flex-basis: 100% !important;
        }
    }

    @media (min-width: 768px) {
        .flex-basis-md-pct-65 {
            flex-basis: 65% !important;
        }
        .flex-basis-md-pct-15 {
            flex-basis: 15% !important;
        }
        .align-items-md-end {
            align-items: flex-end !important;
        }
        .flex-basis-md-pct-20 {
            flex-basis: 20% !important;
        }
        .flex-basis-md-pct-50 {
            flex-basis: 50% !important;
        }
    }

    @media (max-width: 767px){
        .manage-tab .side-btn a.btn.btn-outline-cta{
            margin-top: 0px;
        }
        .side-btn {
            text-align: right;
            flex-wrap: wrap;
        }
        .manage-tab .side-btn a.btn{
            margin-right: 10px;
        }
    }
</style>
<section class="manage-posts">
    <div class="container">
        <div class="manage-tab">

            <ul class="nav nav-tabs" role="tablist">
                <li><a href="/content">Articles</a></li>
                <li><a href="/content/events">Events</a></li>
                <li><a href="/content/classified">Classifieds</a></li>
                <li><a class="active" href="/content/bizpost">Business Listings</a></li>
            </ul>

            <div class="tab-content">
                <div id="menu1" class="tab-pane fade active show">
                    <div id="listings-wrapper">
                        <form id="js-listing-page-form" method="post">
                            <ul class="listings list-unstyled">
                                @if(count($info['bizpost']) > 0)
                                @foreach($info['bizpost'] as $lpost)
                                <li>
                                    <article class="node-listing border-bottom-solid clearfix">
                                        <div class="d-flex flex-sm-row flex-column flex-sm-wrap ">
                                            <div class="flex-basis-md-pct-15 flex-basis-sm-pct-20 flex-shrink-0 d-none d-sm-block pr-3 small">
                                                @if($lpost['image'] != '')
                                                <a href="/b/{{$lpost['id']}}/{{sanitizeStringForUrl($lpost['business_name'])}}" class="thumbnail w100px">
                                                    <img src="{{postgetImageUrl($lpost['image'],$lpost['created_at'])}}" width="100px" height="75px" alt="Test" title="Test" class="img-responsive">
                                                </a>
                                                @else
                                                No image uploaded. 
                                                <strong>
                                                    <a href="/bizpost/{{$lpost['id']}}/edit">[add image]</a>
                                                </strong>
                                                @endif
                                            </div>
                                            <div class="flex-basis-md-pct-65 flex-basis-sm-pct-80">
                                                <header class="test-event-text">
                                                    <a href="/b/{{$lpost['id']}}/{{sanitizeStringForUrl($lpost['business_name'])}}" class="bold">{{$lpost['business_name']}}</a>
                                                </header>
                                                <p>
                                                    {{$lpost['headline']}}
                                                </p>
                                                <div class="d-flex flex-md-row flex-column flex-sm-wrap small">
                                                    <p class="flex-basis-md-pct-50 pr-1 text-success">
                                                        <span aria-hidden="true" class="text-standard fas fa-award"></span> 
                                                        <span class="text-standard bold">Business Listing</span> posted {{\Carbon\Carbon::parse($lpost['created_at'])->format('D, M j Y g:i a')}}
                                                    </p>
                                                    <p class="flex-basis-md-pct-50">
                                                        <span class="fas fa fa-map-marker-alt"></span> 
                                                        <span class="text-muted">{{$lpost['town']}}, {{$lpost['location']}}</span>
                                                    </p>
                                                </div>
                                                <p class="small"><span class="promoted-text uppercase"></span></p>
                                            </div>
                                            <div class="flex-basis-md-pct-20 side-btn flex-basis-sm-pct-100 d-flex flex-md-column align-items-md-end"> 
                                                <a href="#" class="btn btn-cta-alt pill-btn" style="display: none;">
                                                    <span class="fas fa fa-chart-line pr-2">

                                                    </span>Promote
                                                </a> 
                                                <a href="/bizpost/{{$lpost['id']}}/edit" class="btn btn-outline-cta">
                                                    <i class="fas fa-pencil-alt pr-2"></i>Manage
                                                </a>
                                            </div>
                                        </div>
                                    </article>
                                </li>
                                @endforeach
                                @else
                                Your content will show up here after saving.
                                @endif
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $(".st_FlagMenu .dropdown-toggle").click(function () {
            $(this).find(".flag-menu ul.dropdown-menu.dropdown-menu-right").toggle();
        });
        
        $(".header-hamburger-btn").click(function () {
            $(".h-hamburger-line").toggleClass('hamburger__line--open');
            $(".navbar-collapse").toggleClass('show');
        });
        $(".secondary-nav__list-item").click(function () {
            $(this).find('.secondary-nav__menu').toggleClass('show');
        });
        $(".header-hamburger-btn").click(function () {
            $('.header').removeClass("header--sticky-full");
            $('.header').removeClass("header--sticky-condensed");
            $('body').toggleClass("over-class");
        });
    });

</script>
@endsection