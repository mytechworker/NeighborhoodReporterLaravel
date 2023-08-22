@extends('layouts.app')
@section('title')
Community Guidelines
@endsection
@section('meta')
<!-- Primary Meta Tags -->
<meta name="title" content="Community Guidelines Neighborhood Reporter">
<meta name="description" content="Community Guidelines Neighborhood Reporter">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/community-guidelines">
<meta property="og:title" content="Community Guidelines Neighborhood Reporter">
<meta property="og:description" content="Community Guidelines Neighborhood Reporter">
<meta property="og:image" content="{{asset('images/logo.png')}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/community-guidelines">
<meta property="twitter:title" content="Community Guidelines Neighborhood Reporter">
<meta property="twitter:description" content="Community Guidelines Neighborhood Reporter">
<meta property="twitter:image" content="{{asset('images/logo.png')}}">
@endsection
<style>
    #block-system-main h1 {
        display: block;
        font-size: 39px;
        padding-bottom: 0;
        font-weight: 700;
        margin: 10px 0;
        line-height: 1;
        padding: 10px 8px;
        color: #4d4d4d;
    }
    .community-guidelines {
        padding: 0 8px;
    }
    .community-guidelines h5 {
        font-size: 15px;
        color: #4d4d4d;
    }
    .community-guidelines .sub-heading {
        font-size: 23px;
        font-weight: normal;
        color: #333;
    }
    .community-guidelines ul {
        list-style-position: inside;
        margin-bottom: 10.5px;
        color: #333;
        color: #4d4d4d;
    }
    .community-guidelines .list-item {
        list-style-position: inside;
        font-size: 15px;
        margin: 10px 0;
        color: #333;
    }
    .community-guidelines  a {
        text-decoration: underline;
    }

    section.page__content.Community-Guidelines {
        margin-top: 50px;
    }
    .community-guidelines hr{
        border: unset;
        margin-top: 20px;
        margin-bottom: 20px;
        display: inline-block;
    }

    .posting-instructions.community-guidelines h1 {
        display: block;
        font-size: 39px;
        padding-bottom: 0;
        font-weight: 700;
        margin: 10px 0;
        line-height: 1;
    }
    .posting-instructions.community-guidelines  .section-heading {
        color: #333;
        padding: 10px 0;
        font-size: 24px;
    }
    .community-guidelines a.page-link {
        text-decoration: underline;
        background-color: transparent;
        border: unset;
        display: unset;
        margin: unset;
        padding: unset;
        line-height: normal;
        color: #000;
    }
    .posting-instructions.community-guidelines .list-item {
        font-size: 16px;
        margin: 0px 30px;
        color: #333;
    }
    .posting-instructions.community-guidelines ul{
        margin-top: 10px;
        padding-left: 0;
    }
    .posting-instructions.community-guidelines .sub-heading  {
        color: #333;
        padding: 10px 0;
        font-size: 18px;
        font-weight: bold;
    }
    .posting-instructions.community-guidelines .sub-heading  a{
        color: #333;
        text-decoration: none;
    }
    .posting-instructions.community-guidelines h4{
        font-size: 18px;
        margin: 0;
    }

</style>
@section('content')
@if(isset($page))
<section class="page__content Community-Guidelines">
    <div class="container">
        <section id="block-system-main" class="block block-system clearfix">
            {!! $page->content!!}
        </section>
    </div>
</section>
@else
<p class="text-center">No Data Found</p>
@endif
<script>
    $('#block-system-main h5,h3,ul,h1,li,h4,div').removeAttr('style');
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