@extends('layouts.app')
@section('title')
Posting Instruction
@endsection
@section('meta')
<!-- Primary Meta Tags -->
<meta name="title" content="Neighborhood Reporter Posting Instructions">
<meta name="description" content="Neighborhood Reporter Posting Instructions">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/posting-instructions">
<meta property="og:title" content="Neighborhood Reporter Posting Instructions">
<meta property="og:description" content="Neighborhood Reporter Posting Instructions">
<meta property="og:image" content="{{asset('images/logo.png')}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/posting-instructions">
<meta property="twitter:title" content="Neighborhood Reporter Posting Instructions">
<meta property="twitter:description" content="Neighborhood Reporter Posting Instructions">
<meta property="twitter:image" content="{{asset('images/logo.png')}}">
@endsection
<style>
    .community-guidelines {
        padding: 0 8px;
    }
    section.page__content.Community-Guidelines {
        margin-top: 50px;
    }
    .community-guidelines h5 {
        font-size: 15px;
        color: #4d4d4d;
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
        <section class="posting-instructions community-guidelines">
            {!! $page->content!!}
        </section>
    </div>
</section>
@else
<p class="text-center">No Data Found</p>
@endif
<script>
    $('.posting-instructions h1,h2,h5,h3,h4,ul,li,div').removeAttr('style');
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