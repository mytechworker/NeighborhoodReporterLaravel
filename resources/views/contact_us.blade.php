@extends('layouts.app')
@section('title')
Contact Neighborhood Reporter
@endsection
@section('meta')
<!-- Primary Meta Tags -->
<meta name="title" content="Contact Neighborhood Reporter">
<meta name="description" content="Contact Neighborhood Reporter">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/contact-us">
<meta property="og:title" content="Contact Neighborhood Reporter">
<meta property="og:description" content="Contact Neighborhood Reporter">
<meta property="og:image" content="{{asset('images/logo.png')}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/contact-us">
<meta property="twitter:title" content="Contact Neighborhood Reporter">
<meta property="twitter:description" content="Contact Neighborhood Reporter">
<meta property="twitter:image" content="{{asset('images/logo.png')}}">
@endsection
<style>
    #block-system-main h1 {
        font-size: 18px;
        padding: 0;
        color: #111;
        margin-bottom: 20px;
        margin-top: 25px;
    }
    #block-system-main h3 {
        font-size: 20px;
        font-weight: 700;
        color: #4D4D4D;
    }
    #block-system-main p {
        font-size: 14px;
        margin-bottom: 10px;
        color: #4D4D4D;
    }
</style>
@section('content')
@if(isset($page))
<section class="page__content">
    <div id="block-system-main">
        {!! $page->content!!}
    </div>
</section>
@else
<p class="text-center">No Data Found</p>
@endif
<script>
    $('#block-system-main h1,h3,p,div').removeAttr('style');
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