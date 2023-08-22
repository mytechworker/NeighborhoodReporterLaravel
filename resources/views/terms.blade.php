@extends('layouts.app')
@section('title')
Neighborhood Reporter Terms of Use
@endsection
@section('meta')
<!-- Primary Meta Tags -->
<meta name="title" content="Neighborhood Reporter Terms of Use">
<meta name="description" content="Our best breaking news, stories, and events from the Neighborhood Reporter network of local news sites">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/terms">
<meta property="og:title" content="Neighborhood Reporter Terms of Use">
<meta property="og:description" content="Our best breaking news, stories, and events from the Neighborhood Reporter network of local news sites">
<meta property="og:image" content="{{asset('images/logo.png')}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/terms">
<meta property="twitter:title" content="Neighborhood Reporter Terms of Use">
<meta property="twitter:description" content="Our best breaking news, stories, and events from the Neighborhood Reporter network of local news sites">
<meta property="twitter:image" content="{{asset('images/logo.png')}}">
@endsection
@section('content')
<style>
    .terms-page h1 {
        color: #000;
        padding: 0;
        font-weight: bold;
    }

    .terms-page .region.region-content #header-block{
        padding: 0;
    }
    .terms-page p.bold {
        font-size: 14px;
        font-weight: bold;
    }
    .terms-page p{
        font-size: 14px;
    }
    .terms-page h3 {
        font-size: 20px;
        font-weight: bold;
    }
    .terms-page dl, .terms-page ol, .terms-page ul{
        padding: 0;
    }
</style>
@if(isset($page))
<section class="terms-page">
    <div class="container">
        <div class="region region-content">
            <section id="block-fe-components-fe-components-header-block" class="block block-fe-components clearfix">
                <section id="block-system-main" class="block block-system clearfix">
                    {!! $page->content!!}
                </section>
            </section> <!-- /.block -->
        </div>
    </div>
</section>
@else
<p class="text-center">No Data Found</p>
@endif
<script>
    $('#block-fe-components-fe-components-header-block p,h3,ul,div,h1').removeAttr('style');
    $(".header-hamburger-btn").click(function () {
        $(".h-hamburger-line").toggleClass('hamburger__line--open');
        $(".navbar-collapse").toggleClass('show');
        $('.header').removeClass("header--sticky-full");
        $('.header').removeClass("header--sticky-condensed");
        $('body').toggleClass("over-class");
        $(".mob-menu").toggleClass("show-mob-menu");
        $('.header').toggleClass('header--fixed');
    });
</script>
@endsection