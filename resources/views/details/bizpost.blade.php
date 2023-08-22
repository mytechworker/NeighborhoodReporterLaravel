@extends('layouts.app')
@section('title')
{{$info['business_name']}} - {{$info['town']}}, {{$info['location']}} Neighborhood Reporter
@endsection
@section('meta')
@php
if ($info['image'] != '') {
$image = postgetImageUrl($info['image'], $info['created_at']);
} else {
$image = asset('images/logo.png');
}
@endphp
<!-- Primary Meta Tags -->
<meta name="title" content="{{$info['business_name']}} - {{$info['town']}},{{$info['location']}} Neighborhood Reporter">
<meta name="description" content="{{$info['headline']}} ">
<meta property="article:section" content="Business Listing">
<meta property="article:modified_time" content="{{$info['updated_at']}}">
<meta property="article:published_time" content="{{$info['created_at']}}">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/b/{{$info['id']}}/{{sanitizeStringForUrl($info['business_name'])}}">
<meta property="og:title" content="{{$info['business_name']}} - {{$info['town']}},{{$info['location']}} Neighborhood Reporter">
<meta property="og:description" content="Check out the latest business promotion from one of your neighbors. (The views expressed in this post are the author’s own.)">
<meta property="og:image" content="{{$image}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="{{$info['town']}},{{$info['location']}} Neighborhood Reporter">
<meta property="og:updated_time" content="{{$info['updated_at']}}">
<meta property="fb:app_id" content="859635438272019">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/b/{{$info['id']}}/{{sanitizeStringForUrl($info['business_name'])}}">
<meta property="twitter:title" content="{{$info['business_name']}} - {{$info['town']}},{{$info['location']}} Neighborhood Reporter">
<meta property="twitter:description" content="Check out the latest business promotion from one of your neighbors. (The views expressed in this post are the author’s own.)">
<meta property="twitter:image" content="{{$image}}">
@endsection
@section('content')
<style type="text/css">
    section.st_Section.think-sec .st_CardDetail__Header {
        padding: 0;
        margin: 0;
    }

    figure.st_Banner-main {
        margin: 0;
    }
    .st_Banner_Image {
        height: 200px;
        object-fit: cover;
    }
    .st_CardDetail__Header.think-img-sec {
        flex-direction: row;
        flex-wrap: nowrap;
        grid-gap: unset;
        gap: unset;
        border-bottom: 1px solid #e9e9e9;
        margin: 32px 16px 24px;
        padding-bottom: 20px;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }

    .page__main.st_DetailPage.think-sec {
        background-color: #fff;
        padding-bottom: 30px;
    }

    .think-sec .st_BusinessDetailCard_Header-wrap {
        display: flex;
        flex-wrap: nowrap;
        width: 75%;
    }

    .think-sec figure.st_Card__Thumbnail {
        display: flex;
        justify-content: center;
        margin-right: 8px;
        pointer-events: none;

    }

    .think-sec img.st_Card__ThumbnailImage {
        border-radius: 16px;
        display: block;
        height: 75px;
        width: 100px;
        -webkit-object-fit: cover;
        object-fit: cover;
    }

    .think-img-sec .st_CardDetail__Title-wrapper h1.st_CardDetail__Title {
        padding-left: 8px;
        padding-right: 8px;
        margin-bottom: 6px;
        color: #111;
        font-size: 1.25rem;
        font-weight: 700;
        line-height: 1.2;
    }

    .think-sec h2.st_BusinessDetailCard__tagline {
        margin-left: 16px;
        margin-right: 16px;
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 12px;
    }

    section.st_BusinessDetailCard__description .st_HTMLContent {
        font-size: 1rem;
        font-weight: 400;
    }

    .st_CardDetail__Content.think-contact {
        padding-left: 32px;
        padding-right: 32px;
        margin-top: 32px;
        display: flex;
        flex-wrap: nowrap;
        flex-direction: column;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 30px;
    }

    .st_CardDetail__Content.think-contact .st_ContactInformationSection {
        overflow: hidden;
        margin: 12px 0 8px;
        padding: 0;
        flex-grow: 1;
        width: 100%;
    }

    .st_CardDetail__Content.think-contact a.btn.st_ContactInformationSection__link {
        padding: 20px 4px;
        border: none;
        border-bottom: 1px solid #e9e9e9;
        color: #111;
        text-align: left;
        text-overflow: ellipsis;
        overflow: hidden;
        font-size: .9375rem;
        font-weight: 400;
        display: flex;
        align-items: center;
        vertical-align: middle;
        justify-content: flex-start;
    }

    .think-contact .st_AddressSection {
        display: inline-block;
    }

    .think-contact .st_AddressSection span {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .st_CardDetail__Content.think-contact a.btn.st_ContactInformationSection__link.st_Address__link {
        flex-direction: row;
        display: flex;
        align-items: center;
    }

    .st_CardDetail__Content.think-contact a.btn.st_ContactInformationSection__link i {
        color: #848484;
    }

    iframe.st_BusinessDetailCard__map-think {
        height: 120px;
        width: 100%;
        border: none;
        order: -1;
    }

    .right-sec.think-right {
        width: 300px;
    }

    .right-sec.think-right .st_ContactForm-think {
        background-color: #fff;
        padding: 32px 16px;
        -webkit-box-shadow: 0 1px 4px rgb(0 0 0 / 20%);
        box-shadow: 0 1px 4px rgb(0 0 0 / 20%);
        border-radius: 16px;
    }

    .right-sec.think-right .form__inner {
        border: 0;
        margin: 0 auto;
        padding: 0;
        width: auto;
    }

    .right-sec.think-right .st_ContactForm-Header {
        font-size: 1rem;
        font-weight: 700;
        line-height: 1.4;
        margin-bottom: 8px;
    }

    .right-sec.think-right label.st_ContactForm-Label {
        color: #404040;
        font-size: .875rem;
        margin-bottom: 2px;
        display: block;
    }

    .right-sec.think-right label.text-field {
        display: flex;
        flex-flow: nowrap;
        font-family: proxima_nova, Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;
        font-size: 1rem;
        overflow-x: hidden;
        padding: 0;
        background: #fff;
        border-bottom: 1px solid #ccc;
        width: 100%;
        border: none;
        background-color: transparent;
    }

    .right-sec.think-right label.text-field .text-field__input {
        background-color: #eef1f5;
        border: 2px solid #e9e9e9;
        width: 100%;
        border-radius: 12px;
        padding: 12px 8px;
        margin-bottom: 16px;
    }

    .right-sec.think-right button.btn.btn-submit {
        border: none;
        border-radius: 12px;
        font-size: .9375rem;
        font-weight: 400;
        margin-bottom: 6px;
        width: 100%;
        padding-top: 14px;
        padding-bottom: 14px;
        background-color: #009e13;
        color: #ffffff;
    }

    .right-sec.think-right .styles_FeatureBusiness {
        background-color: #fff;
        border-radius: 16px;
        -webkit-box-shadow: 0 1px 4px rgb(0 0 0 / 20%);
        box-shadow: 0 1px 4px rgb(0 0 0 / 20%);
        margin-top: 16px;
        padding: 16px;
    }

    .right-sec.think-right .styles_FeatureBusiness h4 {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .right-sec.think-right .styles_FeatureBusiness p {
        font-size: .875rem;
        margin-bottom: 16px;
    }

    .right-sec.think-right a.btn.btn--business {
        font-size: .875rem;
        font-weight: 400;
        padding: 8px 12px!important;
        border-radius: 8px;
        -webkit-box-shadow: none!important;
        box-shadow: none!important;
        width: auto;
        background: #009e13;
        color: #fff;
        display: block;
        border: 1px solid #009e13;
    }

    .think-sec button.Button_ActionBar.share {
        background: #009e13;
        color: #fff;
        padding: 8px 12px!important;
        border-radius: 8px;
    }

    .think-sec span.Button_ActionBar__Icon,
    .think-sec span.Button_ActionBar__Label {
        color: #fff;
    }

    .think-img-sec .st_CardDetail__Title-wrapper h1.st_CardDetail__Title a {
        line-height: 1.4;
        font-size: .875rem;
        font-weight: 400;
        margin-top: 6px;
        display: none;
    }

    .regular_2.slider .slick-slide {
        padding: 0px 5px;
        height: inherit;
    }
    .regular_2.slider .slick-track{
        display: flex;
    }

    .regular_2.slider.slick-initialized.slick-slider {
        padding: 0px 15px;
    }
    .st_Section__title.bb-slider h2 {
        font-size: 1rem;
        font-weight: 700;
        flex-grow: 1;
        border-top: 1px solid #e9e9e9;
        padding-top: 20px;
        padding-bottom: 10px;
        margin-bottom: 0px;
    }
    .st_Section__title.bb-slider {

        padding: 8px 16px;
    }
    .regular_2.slider .slick-slide .st_CarouselCard__Wrapper {
        min-height: unset;
        height: 100%;
        border-radius: 24px;
    }
    .regular_2.slider .slick-slide a.st_BusinessCard__Button {
        display: flex;
        flex-direction: column;
        height: 308px;
    }
    /*    .think-sec figure.st_Card__Thumbnail img.st_Card__ThumbnailImage {
            height: 140px;
            width: 100%;
        }*/
    .think-sec figure.st_Card__Thumbnail .st_Card__TextContentWrapper{
        flex-flow: column;
        display: flex;
        flex-grow: 1;
        align-content: flex-start;
    }
    .st_Card__TextContentWrapper.reg-2-text h2{
        color: #111;
        font-size: 1rem;
        font-weight: 700;
        line-height: 1.3;
        text-align: left;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        order: 0;
        flex-grow: 0;
        flex-basis: auto;
        padding-right: 0;
        flex-shrink: 0;
    }
    .st_Card__TextContentWrapper.reg-2-text .des-text {
        flex-basis: 100%;
        flex-grow: 1;
        order: 0;
    }
    .st_Card__TextContentWrapper.reg-2-text .des-text p{
        color: #111;
        line-height: 1.4;
        font-size: .9375rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        overflow-wrap: anywhere;
        text-align: left;
        margin-top: 8px;
        margin: 0;
    }
    .st_Card__TextContentWrapper.reg-2-text .st_BusinessCard__Footer span {
        color: #686868;
        margin-right: 5px;
    }
    .st_Card__TextContentWrapper.reg-2-text .st_BusinessCard__Footer {
        align-items: center;
        display: flex;
        flex-basis: 100%;
        justify-content: flex-end;
        margin-top: 4px;
        order: 4;
    }
    .regular_2.slider .st_BusinessCTA.st_MarketplaceCTA a.st_MarketplaceCTA__link {
        flex-grow: 1;
        justify-content: center;
        display: flex;
        flex-direction: column;
    }
    .regular_2.slider .st_CarouselCard__Wrapper a{
        height: 308px;
    }
    .regular_2.slider .st_CarouselCard__Wrapper a:hover{
        text-decoration: none;
    }
    .regular_2.slider  .st_BusinessCTA.st_MarketplaceCTA a.st_MarketplaceCTA__link {
        flex-grow: 1;
        justify-content: center;
        display: flex;
        flex-direction: column;
    }
    .regular_2.slider  .slick-slide a.st_MarketplaceCTA__link img {
        display: block;
        width: 57px;
        margin: 0 auto;
    }
    .regular_2.slider .st_BusinessCTA.st_MarketplaceCTA a.st_MarketplaceCTA__link h5 {
        color: #111;
        width: 100%;
        text-align: center;
        font-weight: 400;
        font-size: .875rem;
        margin-top: 10px;
    }
    .regular_2.slider .st_BusinessCTA.st_MarketplaceCTA a.st_MarketplaceCTA__link h4 {
        margin-top: 4px;
        font-size: 1rem;
        text-align: center;
        color: #d20000;
        /* padding-left: 10px; */
    }
    .regular_2.slider .st_BusinessCTA.st_MarketplaceCTA a.st_MarketplaceCTA__link h4 i{
        margin-left: 5px;
    }
    .regular_2.slider.slick-slider button.slick-arrow.slick-next {
        right: 3px;
    }
    .regular_2.slider.slick-slider button.slick-arrow.slick-prev:before {
        font-size: 44px;
        color: #fff;
        text-shadow: 0 0.5rem 1rem rgb(0 0 0 / 35%);  
        opacity: 1;
    }

    .regular_2.slider.slick-slider button.slick-arrow.slick-next:before {
        font-size: 44px;
        color: #fff;
        text-shadow: 0 0.5rem 1rem rgb(0 0 0 / 35%); 
        opacity: 1; 
    }
    .btn-share{
        position: relative;
    }
    .btn-share ul {
        border-top-style: solid;
        display: flex;
        flex-flow: row wrap;
        padding: 16px;
        min-width: 400px;
        height: auto;
        position: absolute;
        inset: 0px auto auto 0px;
        margin: 0px;
        transform: translate(0px, 36px);
    }

    .btn-share ul li.dropdown-item {
        margin: 0;
        width: 50%;
        color: #686868;
        text-decoration: none;
    }
    .btn-share ul li.dropdown-item .st_ShareLink {
        align-items: center;
        background: none;
        border: none;
        border-radius: 30px;
        display: flex;
        padding: 8px 12px!important;
        text-align: left;
        width: 100%;
        font-size: .875rem;
        color: #111!important;
    }
    .btn-share ul li.dropdown-item .st_ShareLink i {
        border-radius: 50%;
        color: #fff;
        margin-right: 8px;
        height: 26px;
        width: 26px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-share ul li.dropdown-item .st_ShareLink.st_ShareLink-facebook i {
        background: #4267b2; 
    }
    .btn-share ul li.dropdown-item .st_ShareLink.st_ShareLink-default i{
        background: #404040;
    }
    .btn-share ul li.dropdown-item .st_ShareLink.st_ShareLink-twitter i{
        background: #1da1f2;
    }

    .btn-share ul li.dropdown-item .st_ShareLink.st_ShareLink-linkedin i{
        background: #0077b5;
    }
    .btn-share ul li.dropdown-item .st_ShareLink.st_ShareLink-reddit i{
        background: #ff4500;
    }
    .btn-share.show .dropdown-menu.show {
        display: flex !important;
    }

    .styles_categories__zYfrH {
        font-size: .875rem;
        color: #848484;
        display: inline-block;
        margin: 0 32px 24px;
    }
    .st_ContactInformationSection__link:hover {
        background-color: #848484;
        color: #fff !important;
    }
    .st_ContactInformationSection__link:hover i{
        color: #fff !important;
    }
    .slick-initialized img.st_Card__ThumbnailImage{
        height: 100%;
        width: 100%;
    }
    .slick-initialized figure.st_Card__Thumbnail{
        margin: 0;
    }
    @media screen and (min-width: 576px) {
        .st_Card__TextContentWrapper.reg-2-text .des-text p{
            font-size: 1rem;
        }
        .right-sec.think-right .form {
            border-radius: 6px;
        }
        .think-sec figure.st_Card__Thumbnail .st_Card__TextContentWrapper{
            flex-flow: column
        }
        .st_Card__TextContentWrapper.reg-2-text .des-text {
            order: 0;
        }
    }

    @media screen and (min-width: 768px) {
        .st_CardDetail__Content.think-contact a.btn.st_ContactInformationSection__link {
            padding-top: 10px;
            padding-bottom: 10px;
            margin-bottom: 12px;
            border: none;
        }
        .st_Card__TextContentWrapper.reg-2-text .st_BusinessCard__Footer {
            order: 0;
            flex-basis: auto;
        }
        .st_Card__TextContentWrapper.reg-2-text h2{
            order: 0;
            flex-grow: 0;
            flex-basis: auto;
            padding-right: 0;
            flex-shrink: 0;
        }
        iframe.st_BusinessDetailCard__map-think {
            height: 320px;
            order: 1;
        }
        .st_CardDetail__Content.think-contact {
            flex-direction: row;
        }
        .think-sec figure.st_Card__Thumbnail {
            margin-right: 0;
            margin-bottom: 8px;
        }
        .think-sec img.st_Card__ThumbnailImage {
            height: 100px;
            width: 138px;
        }
        .think-img-sec .st_CardDetail__Title-wrapper h1.st_CardDetail__Title {
            padding-left: 16px;
            padding-right: 16px;
        }
    }

    @media (max-width:991px) {
        .right-sec.think-right {
            width: 100%;
            margin-top: 12px;
        }
        .think-img-sec .st_CardDetail__Title-wrapper h1.st_CardDetail__Title a {
            display: block;
        }
    }

    @media (max-width: 767px) {
        .regular_2.slider.slick-slider button.slick-arrow.slick-prev {
            left: 10px;
            z-index: 5;
        }
        .btn-share {
            width: 100%;
        }
        .btn-share ul li.dropdown-item{
            width: 100%;
        }
        .btn-share.show .dropdown-menu.show {
            padding: 10px 5px;
            min-width: 100%;
        }
        .regular_2.slider.slick-slider button.slick-arrow.slick-next {
            right: 33px;
        }
        .think-img-sec .st_CardDetail__Title-wrapper h1.st_CardDetail__Title a {
            display: block;
        }
        .think-sec button.Button_ActionBar.share {
            margin-bottom: 20px;
            margin: 0px;
            width: 100%;
            text-align: center;
            justify-content: center;
        }
        .st_CardDetail__Header.think-img-sec {
            flex-wrap: wrap;
            padding: 0;
        }
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content-sec">
    <div class="container pad-0">
        <div class="row mar-mob">
            <div class="col-md-12 col-lg-8 pad-0">
                <main id="main" role="main" class="page__main st_DetailPage think-sec">
                    <section class="st_Section event-sec">
                        <article>
                            <figure class="st_Banner-main"> 
                                @if($info['header_image'] != '')
                                <img alt="{{$info['business_name']}}" class="st_Banner_Image" src="{{postgetImageUrl($info['header_image'],$info['created_at'])}}">
                                @else
                                <img class="st_Banner_Image" src="{{asset('images/business-header-placeholder.png')}}">
                                @endif
                            </figure>
                            <div class="st_CardDetail__Header think-img-sec">
                                <section class="st_BusinessDetailCard_Header-wrap">
                                    <figure class="st_Card__Thumbnail"> 
                                        @if($info['image'] != '')
                                        <img alt="{{$info['business_name']}}" class="st_Card__ThumbnailImage" src="{{postgetImageUrl($info['image'],$info['created_at'])}}">
                                        @else
                                        <img class="st_Card__ThumbnailImage" src="{{asset('images/local-business-placeholder.png')}}">
                                        @endif
                                    </figure>
                                    <div class="st_CardDetail__Title-wrapper">
                                        <h1 class="st_CardDetail__Title">{{$info['business_name']}}
                                        </h1>
                                    </div>
                                </section>
                                <div class="btn-share">
                                    <button class="Button_ActionBar share" type="button" type="button" data-toggle="dropdown"> <span class="Button_ActionBar__Icon"><i class="fas fa-share"></i></span><span class="Button_ActionBar__Label">Share Profile</span> </button>
                                    <ul x-placement="bottom-start" class="dropdown-menu" style="display:none">
                                        <li class="dropdown-item">
                                            <a class="st_ShareLink st_ShareLink-facebook" target="_blank"  href="https://www.facebook.com/sharer/sharer.php?u={{route('home')}}/b/{{$info['id']}}/{{sanitizeStringForUrl($info['business_name'])}}?utm_source=facebook&utm_medium=web&utm_campaign=share">
                                                <i class="fab fa-facebook-f "></i>Share on Facebook</a>
                                        </li>
                                        <li class="dropdown-item">
                                            <a class="st_ShareLink st_ShareLink-default" target="_blank" href="mailto:?subject={{$info['business_name']}}&amp;body={{$info['headline']}}%0A%0A{{route('home')}}/b/{{$info['id']}}/{{sanitizeStringForUrl($info['business_name'])}}?utm_source=shared-email&utm_medium=email&utm_campaign=share" rel="nofollow">
                                                <i class="fas fa-envelope"></i>Share via email
                                            </a>
                                        </li>
                                        <li class="dropdown-item">
                                            <a class="st_ShareLink st_ShareLink-twitter" target="_blank"  href="https://twitter.com/intent/tweet?text={{$info['business_name']}}&amp;url={{route('home')}}/b/{{$info['id']}}/{{sanitizeStringForUrl($info['business_name'])}}?utm_source=twitter&utm_medium=web&utm_campaign=share" rel="nofollow">
                                                <i class="fab fa-twitter"></i>Share on Twitter
                                            </a>
                                        </li>
                                        <li class="dropdown-item">
                                            <input class="sr-only" value="{{route('home')}}/b/{{$info['id']}}/{{sanitizeStringForUrl($info['business_name'])}}?utm_source=share-link&utm_medium=web&utm_campaign=share" readonly="" type="url" >
                                            <button class="st_ShareLink st_ShareLink-default copyLink" type="button">
                                                <i class="fas fa-link"></i>Copy link
                                            </button>
                                        </li>
                                        <li class="dropdown-item">
                                            <a class="st_ShareLink st_ShareLink-linkedin" target="_blank"  href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{route('home')}}/b/{{$info['id']}}/{{sanitizeStringForUrl($info['business_name'])}}?utm_source=linkedin&utm_medium=web&utm_campaign=share">
                                                <i class="fab fa-linkedin-in"></i>Share on Linkedin
                                            </a>
                                        </li>
                                        <li class="dropdown-item">
                                            <a class="st_ShareLink st_ShareLink-reddit" target="_blank"  href="http://www.reddit.com/submit?title={{$info['business_name']}}&amp;url={{route('home')}}/b/{{$info['id']}}/{{sanitizeStringForUrl($info['business_name'])}}?utm_source=reddit&utm_medium=web&utm_campaign=share">
                                                <i class="fab fa-reddit-alien"></i>Share on Reddit</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="">
                                <span class="styles_categories__zYfrH">Category: {{$info['business_category']}}</span>
                                <h2 class="st_BusinessDetailCard__tagline">{!!nl2br($info['headline'])!!}</h2>
                                <section class="st_BusinessDetailCard__description">
                                    <div class="st_HTMLContent">{!!nl2br($info['message_to_reader'])!!}</div>
                                </section>
                                <div class="st_CardDetail__Content think-contact">
                                    <div class="st_ContactInformationSection"> 
                                        @if($info['website'] != '')
                                        <a class="btn btn--outline-muted btn--cta--medium st_ContactInformationSection__link" title="" target="_blank" href="{{$info['website']}}" rel="nofollow">
                                            <i class="fa fa-fw fa-lg fas fa-globe icon--space-right"></i>{{$info['website']}}
                                        </a>
                                        @endif
                                        @if($info['phone'] != '')
                                        <a class="btn btn--outline-muted btn--cta--medium st_ContactInformationSection__link" target="_blank" href="tel:{{$info['phone']}}" rel="nofollow">
                                            <i class="fa fa-fw fa-lg fas fa-mobile icon--space-right"></i>{{$info['phone']}}
                                        </a> 
                                        @endif
                                        @if($info['website'] != '')
                                        <a class="btn st_ContactInformationSection__link st_Address__link" title="" target="_blank" href="https://maps.google.com/maps?z=10&t=m&q={{urlencode($info['address'])}}" rel="nofollow">
                                            <i class="fa fa-fw fa-lg fa-map-marker-alt icon--space-right"></i>
                                            <div class="st_AddressSection">
                                                <span class="st_AddressLine">{{$info['address']}}</span>
                                            </div>
                                        </a> 
                                        @endif
                                    </div>
                                    <iframe class="st_BusinessDetailCard__map-think" loading="lazy" title="{{$info['business_name']}}" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCRPD5LV_iTdto-dDH-Fjv4M5gm99WX68E&amp;q={{urlencode($info['address'])}}"></iframe>
                                </div>
                            </div>
                        </article>
                    </section>
                    @if(count($info['bizPost']) > 1)
                    <div class="st_Section__title bb-slider">
                        <h2>More Local Businesses</h2> 
                    </div>
                    <div class="regular_2 slider">
                        @foreach($info['bizPost'] as $bpost)
                        @if($info['id'] == $bpost['id'])
                        @php continue; @endphp
                        @endif
                        <div>
                            <div class="st_CarouselCard__Wrapper">
                                <a class="st_BusinessCard__Button" href="/b/{{$bpost['id']}}/{{sanitizeStringForUrl($bpost['business_name'])}}">
                                    <figure class="st_Card__Thumbnail">
                                        @if($bpost['image'] != '')
                                        <img class="st_Card__ThumbnailImage" src="{{postgetImageUrl($bpost['image'],$bpost['created_at'])}}">
                                        @else
                                        <img class="st_Card__ThumbnailImage" src="{{asset('images/local-business-placeholder.png')}}">
                                        @endif
                                    </figure>
                                    <div class="st_Card__TextContentWrapper reg-2-text">
                                        <h2>{{$bpost['business_name']}}</h2>
                                        <div class="des-text">
                                            <p>{{$bpost['headline']}}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                        <div>
                            <div class="st_CarouselCard__Wrapper">
                                <div class="st_BusinessCTA st_MarketplaceCTA">
                                    <a class="st_MarketplaceCTA__link" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/marketplace">
                                        <img class="st_MarketplaceCTA__image" src="https://patch.com/img/cdn/assets/layout/local-shop.png" width="57">
                                        <h5>See the full local</h5>
                                        <h4>
                                            Marketplace
                                            <i class="fa fal fa-arrow-left fa-flip-horizontal text--primary"></i>
                                        </h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </main>
            </div>
            <div class="right-sec think-right">
                <div class="st_ContactForm-think">
                    <form class="form" id="contact_us_form">
                        <input type="hidden" name="post_id" value="{{$info['id']}}" />
                        <div class="form__inner">
                            <h3 class="st_ContactForm-Header">Contact us</h3>
                            <label class="st_ContactForm-Label" for="name">Name</label>
                            <label class="text-field">
                                <input type="text" aria-label="Full name" autocomplete="off" class="text-field__input formFields formnFields" name="name" placeholder="Your name" required="" value=""> </label>
                            <label class="st_ContactForm-Label" for="email">Email</label>
                            <label class="text-field">
                                <input type="email" aria-label="Email address" autocomplete="off" class="text-field__input formFields formeFields" name="email" placeholder="Enter your email" required="" value=""> </label>
                            <label class="st_ContactForm-Label" for="message">Message</label>
                            <label class="text-field">
                                <textarea class="text-field__input formFields formmFields" name="message" placeholder="Write your message" rows="4"></textarea>
                            </label>
                            <button class="btn btn-submit" id="formSubmit" disabled="" type="button">Submit<i class="fas fa-spinner icon icon--space-left fa-spin loader" style="display: none;"></i></button>
                        </div>
                    </form>
                </div>
                <div class="styles_FeatureBusiness">
                    <h4>Feature your business on Neighborhood Reporter</h4>
                    <p>Showcase your business and connect with customers and supporters.</p>
                    <a class="btn btn--business" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/bizpost" rel="nofollow">Feature My Business</a></div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function () {
        var $ = jQuery;
        $(document).on("click", ".st_FlagMenu .dropdown-toggle", function () {
            $(this).parent().find(".flag-menu ul.dropdown-menu.dropdown-menu-right").toggle();
            return false;
        });
        $(document).on("click", ".copyLink", function () {
            $(this).parent().find('input.sr-only').select();
            document.execCommand("copy");
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            };
            toastr.success("Copied.!");
        });
        $(document).on('keyup', '.formFields', function () {
            if ($('.formnFields').val() != '' || $('.formeFields').val() != '' || $('.formmFields').val() != '') {
                $("#formSubmit").prop('disabled', false);
            } else {
                $("#formSubmit").prop('disabled', true);
            }
        });
        $(document).on("click", "#formSubmit", function () {
            $(".loader").show();
            var formData = new FormData($("#contact_us_form")[0]);
            $.ajax({
                type: 'POST',
                url: "{{ route('bizpost-sendMail') }}",
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    document.getElementById('contact_us_form').reset();
                    toastr.options = {
                        "positionClass": "toast-bottom-right"
                    };
                    toastr.success("The business owner contacts you as soon as possible.!", "Email sent successfully.!");
                    $(".loader").hide();
                    $("#formSubmit").prop('disabled', true);
                }
            });
        });
        $(document).on("click", function (e) {
            if ($(e.target).is(".st_EventDetails__Item .dropdown .dropdown-menu.open-menu") === false) {
                $('.st_EventDetails__Item .dropdown .dropdown-menu.open-menu').removeClass('open-menu');
            }
        });
        $(document).on("click", "body", function () {
            $('.st_FlagMenu .dropdown-toggle').parent().find(".flag-menu ul.dropdown-menu.dropdown-menu-right").hide();
//            return false;
        });

        $(".regular_2").slick({
            dots: false,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            responsive: [{
                    breakpoint: 768,
                    settings: {

                        centerMode: false,
                        centerPadding: '40px',
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }, {
                    breakpoint: 991,
                    settings: {

                        centerMode: true,
                        centerPadding: '100px',
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }]
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

        $(".st_ArticleThreadBlock__toggle").click(function () {
            $(".st_ArticleThreadBlock__toggle .st_ArticleThreadBlock__toggleIcon").toggleClass("chevron-rotate");
        });

    });
</script>
@endsection