@extends('layouts.app')
@section('title')
Privacy Policy
@endsection
@section('meta')
<!-- Primary Meta Tags -->
<meta name="title" content="Neighborhood Reporter Privacy Policy">
<meta name="description" content="Neighborhood Reporter Privacy Policy">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/privacy">
<meta property="og:title" content="Neighborhood Reporter Privacy Policy">
<meta property="og:description" content="Neighborhood Reporter Privacy Policy">
<meta property="og:image" content="{{asset('images/logo.png')}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/privacy">
<meta property="twitter:title" content="Neighborhood Reporter Privacy Policy">
<meta property="twitter:description" content="Neighborhood Reporter Privacy Policy">
<meta property="twitter:image" content="{{asset('images/logo.png')}}">
@endsection
@section('content')
<style>
    .st_Policies h1 {
        margin: 12px 0;
        font-size: 1.125rem;
        color: #111;
        font-weight: bold;
    }
    .st_Policies h3 {
        font-size: 16px;
        font-weight: bold;
    }
    .st_Policies p {
        margin: 12px 0;
        font-size: 14px;
        line-height: normal;
    }
</style>
@if(isset($page))
<section class="page__content Community-Guidelines">
    <div class="container">
        <main class="st_Policies">
            {!! $page->content!!}
        </main>
    </div>
</section>
@else
<p class="text-center">No Data Found</p>
@endif
<script>
    $('.st_Policies h1,h3,p').removeAttr('style');
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