@extends('layouts.manageApp')
@section('title')
My Neighborhood Reporter
@endsection
@section('meta')
<!-- Primary Meta Tags -->
<meta name="title" content="My Neighborhood Reporter">
<meta name="description" content="My Neighborhood Reporter Publish Articles">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/content">
<meta property="og:title" content="My Neighborhood Reporter">
<meta property="og:description" content="My Neighborhood Reporter Publish Articles">
<meta property="og:image" content="{{asset('images/logo.png')}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/content">
<meta property="twitter:title" content="My Neighborhood Reporter">
<meta property="twitter:description" content="My Neighborhood Reporter Publish Articles">
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
    .article_posted ul.listings {
        margin-top: 20px;
    }
    #home .article_posted ul li {
        width: 100%;
        border: none;
        text-align: inherit;
    }
    .border-bottom-solid {
        border-bottom: 1px solid #eee;
        margin-bottom: 15px;
        padding-bottom: 15px;
    }
    #home .article_posted .thumbnail {
        display: block;
        padding: 10px;
        margin-bottom: inherit;
        margin-right: 20px;
        line-height: 1.42857;
        border: 1px solid #eee;
        border-radius: 2px;
        transition: none;
    }
    .article_posted .thumbnail.w100px {
        max-width: 120px;
    }
    .article_posted .text-success {
        color: #d20000 !important;
    }
    .article_posted p {
        margin: 0 0 5.25px;
    }
    .article_posted .text-standard {
        color: #333;
    }
    #home .article_posted header.h4 a {
        font-size: 19px;
        color: #d20000;
    }
    .article_posted .btn-outline-cta {
        color: #d20000;
        background-color: transparent;
        background-image: none;
        border-color: #d20000;
    }
    #home .article_posted .btn-sm-max-140 {
        padding: 5px 10px;
        font-size: 15px;
        line-height: 1.5;
        border-radius: 3px;
        max-width: 140px;
        width: 100%;
        margin-bottom: 10px;
        display: inline-block;
    }
    #home .article_posted .actions-share a {
        display: inline-block;
        font-size: 20px;
    }
    .article_posted .facebook-link {
        color: #3B5998;
        cursor: pointer;
        text-decoration: none;
    }
    .article_posted .twitter-link {
        color: #1DA1F2;
        cursor: pointer;
        text-decoration: none;
    }
    #home .add-img-artical strong a {
        color: #007bff;
        cursor: pointer;
        text-decoration: none;
        font-size: 15px;
    }
    @media (max-width: 767px){
        .article_posted .col-sm-2, .article_posted .col-sm-7, .article_posted .col-sm-3 {
            margin-bottom: 20px;
        }
    }
    @media (max-width: 576px) {
        .article_posted .actions-section.col-sm-3.text-right {
            text-align: left !important;
        }
    }
</style>
<section class="manage-posts">
    <div class="container">
        <div class="manage-tab">

            <ul class="nav nav-tabs" role="tablist">
                <li><a  class="active" href="/content">Articles</a></li>
                <li><a  href="/content/events">Events</a></li>
                <li><a  href="/content/classified">Classifieds</a></li>
                <li><a  href="/content/bizpost">Business Listings</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade active show">
                    <ul class="nav nav-tabs" role="tablist">
                        <li><a  class="active" href="/content">Posted</a></li>
                        <li><a  href="/content/articles/draft">Draft</a></li>
                    </ul>
                    <div class="tab-content article_posted">
                        <div id="home5" class="tab-pane fade active show">
                            <div id="listings-wrapper">
                                <form id="js-listing-page-form" method="post">
                                    <ul class="listings list-unstyled">
                                        @if(count($info['post']) > 0)
                                        @foreach($info['post'] as $lpost)
                                        <li>
                                            <article class="row node-listing border-bottom-solid clearfix">
                                                <div class="col-sm-2 col-xs-3 add-img-artical">
                                                    @if($lpost['post_image'] != '')
                                                    <a href="/p/{{$lpost['guid']}}" target="_blank" class="thumbnail w100px">
                                                        <img src="{{postgetImageUrl($lpost['post_image'],$lpost['created_at'])}}" width="100px" height="75px" alt="Test" title="Test" class="img-responsive">
                                                    </a>
                                                    @else
                                                        No image uploaded. 
                                                        <strong>
                                                            <a href="/article/{{$lpost['id']}}/edit">[add image]</a>
                                                        </strong>
                                                    @endif
                                                </div>
                                                <div class="col-sm-7 col-xs-9">
                                                    <p class="small text-success"><i class="text-standard far fa-file-alt"></i> Article posted {{\Carbon\Carbon::parse($lpost['created_at'])->format('D, M j Y g:i a')}}</p>
                                                    <header class="h4">
                                                        <a href="/p/{{$lpost['guid']}}">{{$lpost['post_title']}}</a>
                                                    </header>
                                                    <p>
                                                        {{$lpost['post_subtitle']}}
                                                    </p>
                                                    <p><span class="text-muted">Article in </span> {{$lpost['town']}}, {{$lpost['location']}}</p>
                                                </div>
                                                <div class="actions-section col-sm-3 col-xs-12 text-right">
                                                    <a href="/article/{{$lpost['id']}}/edit" class="btn btn-outline-cta rounded-pill btn-sm-max-140 air-xs-b bold"><i class="fas fa-pen pr-2"></i>Edit</a> 
                                                    <div class="actions-share">
                                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{route('home')}}/p/{{$lpost['guid']}}?utm_source=facebook&utm_medium=web&utm_campaign=share" target="_blank" class="facebook-link"><i class="fab fa-facebook-f "></i></a> |
                                                        <a href="https://twitter.com/intent/tweet?text={{$lpost['post_title']}}&amp;url={{route('home')}}/p/{{$lpost['guid']}}?utm_source=twitter&utm_medium=web&utm_campaign=share" target="_blank" class="twitter-link"><i class="fab fa-twitter"></i></a>
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