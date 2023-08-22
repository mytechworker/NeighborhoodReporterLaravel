@extends('layouts.app')
@section('title')
About Neighborhood Reporter
@endsection
@section('meta')
<!-- Primary Meta Tags -->
<meta name="title" content="About Neighborhood Reporter">
<meta name="description" content="Our best breaking news, stories, and events from the Neighborhood Reporter network of local news sites.">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/about">
<meta property="og:title" content="About Neighborhood Reporter">
<meta property="og:description" content="Our best breaking news, stories, and events from the Neighborhood Reporter network of local news sites.">
<meta property="og:image" content="{{asset('images/logo.png')}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/about">
<meta property="twitter:title" content="About Neighborhood Reporter">
<meta property="twitter:description" content="Our best breaking news, stories, and events from the Neighborhood Reporter network of local news sites.">
<meta property="twitter:image" content="{{asset('images/logo.png')}}">
@endsection
<style>
    .about-sub-header
    {
        border:1px solid #d20000
    }

    .about-sub-header-bg
    {
        background:#d20000;
        padding:0 10px 30px 0;
        border:1px solid transparent
    }

    .st_About {
        color: #404040;
        font-size: .875rem;
    }

    .about-us .st_About__Header {
        margin: 12px 0;
        font-size: 32px;
        color: #111;
        font-family: Merriweather,Georgia,Times New Roman,Times,serif;
        font-weight: 700;
    }
    .about-us .st_About__AboutInfo {
        display: flex;
        margin: 0 0 3em;
    }
    .about-us .st_About__AboutInfoText {
        width: 35%;
    }
    .about-us h3 {
        color: #111;
        font-size: 16px;
    }
    .about-us p {
        margin: 12px 0;
        line-height: normal;
    }
    .about-us li {
        margin: 12px 0 12px -22px;
    }
    .about-us .st_About__AboutInfoImage {
        width: 40%;
        height: 30px;
        margin: 0 0 5em 5em;
    }
    .about-us .st_About__HeaderImage {
        display: block;
        max-width: 100%;
        height: auto;
        border-radius: 6px;
    }
    .about-us hr {
        color: #ccc;
    }
    .about-us .st_About__BioImage {
        display: block;
        max-width: 100%;
        height: auto;
        border-radius: 6px;
    }
    .about-us .st_About__Bio {
        width: 86%;
        margin: 0 0 0 2em;
    }
    .about-us .who_we_are {
        display:flex;margin:0 0 3em 0;
    }
    .about-us .bio_img_wrapper {
        width:14%;
    }
    .about-us h4 {
        color: #686868;
        padding-bottom: 6px;
        font-size: 14px;
    }
    .about-us .press_release:first-child {
        margin:-14px -5px 0 -5px;
    }
    .about-us .press_release {
        margin:8px -5px 0 -5px;
    }
    .about-us .st_About__ReleaseHeader {
        margin: 12px 0;
        font-size: 1.125rem;
        color: #111;
    }
    @media screen and (max-width: 768px) {
        .about-us.st_About {
            margin: 0 20px;
        }
    }
    @media screen and (max-width: 576px) {
        .about-us .st_About__AboutInfo {
            flex-flow: column-reverse;
        }
        .about-us .st_About__AboutInfoText {
            width: 100%;
        }
        .about-us .st_About__AboutInfoImage {
            width: 100%;
            height: auto;
            margin: 0 0 12px;
        }
        .about-us .st_About__Bio {
            margin: 0 0 0 7em;
        }
        .about-us.st_About p.st_About__BioDetails {
            margin: 10em 0 0 -9rem;
        }
        .about-us .st_About__BioImage {
            max-width: 125px;
            width: auto;
        }
    }
    @media screen and (max-width: 360px) {
        .about-us .st_About__BioImage {
            max-width: 125px;
        }
    }
</style>
@section('content')
<section class="page__content">
    <main class="st_About about-us">
        {!! $page->content!!}
        <hr>
        @if(count($press_releases) > 0)
        <h1 class="st_About__Header">Press releases</h1>
        <div class="about-sub-header">
            <div class="about-sub-header-bg"></div>
            <div class="p-3">
                @foreach($press_releases as $press_release)
                <div class="press_release">
                    <div>
                        <h1 class="st_About__ReleaseHeader"><b><a href="{{$press_release->external_link}}" style="color:#111111" target="_blank" rel="noreferrer">{{$press_release->title}}</a></b></h1>
                    </div>
                    <div style="margin:-10px 0 0 0;color:#4D4D4D">
                        @php
                        $date = dateFormat($press_release->date);
                        @endphp
                        <p><i>{{ !empty($date) ? $date: '-' }}</i>
                        </p>
                    </div>
                </div>
                <hr>
                @endforeach
            </div>
        </div>
        @else
        <P class="text-center">No Press Release Found</P>
        @endif
    </main>
</section>
<script>
    $('.about-us h1,h3,p,li,h4,div').removeAttr('style');
    $(".header-hamburger-btn").click(function () {
        $(".h-hamburger-line").toggleClass('hamburger__line--open');
        $(".navbar-collapse").toggleClass('show');
        $('.header').removeClass("header--sticky-full");
        $('.header').removeClass("header--sticky-condensed");
        $(".mob-menu").toggleClass("show-mob-menu");
        $('.header').toggleClass('header--fixed');
    });
</script>
@endsection