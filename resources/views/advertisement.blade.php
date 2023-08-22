@extends('layouts.app')
@section('title')
Local Advertising for Your Business
@endsection
@section('meta')
<!-- Primary Meta Tags -->
<meta name="title" content="Local Advertising for Your Business | neighborhoodreporter.com">
<meta name="description" content="Grow your business with Neighborhood Reporter's digital advertising opportunities to target local customers in your community.">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/across-america/advertise-with-us">
<meta property="og:title" content="Local Advertising for Your Business | neighborhoodreporter.com">
<meta property="og:description" content="Grow your business with Neighborhood Reporter's digital advertising opportunities to target local customers in your community.">
<meta property="og:image" content="{{asset('images/logo.png')}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/across-america/advertise-with-us">
<meta property="twitter:title" content="Local Advertising for Your Business | neighborhoodreporter.com">
<meta property="twitter:description" content="Grow your business with Neighborhood Reporter's digital advertising opportunities to target local customers in your community.">
<meta property="twitter:image" content="{{asset('images/logo.png')}}">
@endsection
@section('content')
<style>
    .not_show_other_pages{display: none;}
</style>
<section class="ad-first my-5">
    <div class="container">
        <h1 class="ad-title text-center mb-3">Looking to advertise your business in across America?</h1>
        <h3 class="ad-sub-title text-center mb-3">Neighborhood Reporter is the #1 way to brand your business locally and bring local residents and consumers to your website.</h3>
        <p class="ad-text text-center">
            <span class="pb-3">Whether you're a small business or a national chain, advertising on Neighborhood Reporter enables you to target a relevant audience, build community trust in your business, and increase website traffic to boost brand awareness.</span>
            <span class="pb-3">Fill out the below form and our team will contact you to customize a plan specifically for your business that meets your advertising goals.</span>Or call us at&nbsp;<a class="green-color" href="tel:888-691-8988">888-691-8988</a>
        </p>
    </div>
</section>
<section class="ad-second">
    <div class="container ad-second-container">
        <div class="row ad-row">
            <div class="col-lg-6 col-md-6 ad-form-text-left">
                <h3 class="ad-second-title">Advertising on Neighborhood Reporter's trusted platform offers the familiarity of a local paper with scalable and hyper-local reach:</h3>
                <ul class="ad-list-unstyled p-4 m-0">
                    <li class="ad-list-item_flex"><i class="fa fa-map-marker-alt ad-fyp-icon"></i>Customized digital media and sponsorship opportunities on your choice of Neighborhood Reporter sites</li>
                    <li class="ad-list-item_flex"><i class="fa fa-star ad-fyp-icon"></i>Exclusive ad placement selections</li>
                    <li class="ad-list-item_flex"><i class="fa fa-envelope ad-fyp-icon"></i>Newsletter ads with daily exposure in your community</li>
                    <li class="ad-list-item_flex"><i class="fa fa-globe ad-fyp-icon"></i>Targeting opportunities based on behavioral, demographic, or geo-location factors</li>
                    <li class="ad-list-item_flex"><i class="fa fa-clipboard ad-fyp-icon"></i>Directory listings, branded content, social integration, and more!</li>
                </ul>
                <h3 class="ad-second-title">Contact us to learn more about how Neighborhood Reporter can impact your business.</h3>
            </div>
            <div class="col-lg-6 col-md-6 ad-form-text-right">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
                <form class="ad-form" method="POST" action="{{ route('advertise-store') }}" novalidate>
                    @csrf
                    <div class="item form-group mb-2">
                        <label class="ad-label">BUSINESS OR AGENCY NAME *</label>
                        <input id="name" name="business_name" value="{{ old('business_name') }}" type="name" class="form-control ad-input" placeholder="enter your business or agency name" required="required">
                    </div>
                    <div class="item form-group mb-2">
                        <label class="ad-label">ZIP CODE *</label>
                        <input type="number" name="zip_code" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="6" class="form-control ad-input" placeholder="enter your business's zip code" required="required" value="{{ old('zip_code') }}">
                    </div>
                    <div class="item form-group mb-2">
                        <label class="ad-label">FIRST NAME *</label>
                        <input id="name" class="form-control ad-input" required="required" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="enter your first name">
                    </div>
                    <div class="item form-group mb-2">
                        <label class="ad-label">LAST NAME *</label>
                        <input id="name" required="required" type="text" name="last_name" value="{{ old('last_name') }}" class="form-control ad-input" placeholder="enter your last name">
                    </div>
                    <div class="item form-group mb-2">
                        <label class="ad-label">EMAIL *</label>
                        <input id="name" required="required" type="email" name="email" value="{{ old('email') }}" class="form-control ad-input" placeholder="enter your email address">
                    </div>
                    <div class="item form-group mb-2">
                        <label class="ad-label">PHONE NUMBER *</label>
                        <input name="phone_no" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" maxlength="10" class="form-control ad-input" placeholder="enter your phone number" required="required" value="{{ old('phone_no') }}">
                    </div>
                    <div class="item form-group mb-2" id="custome-validation">
                        <label class="ad-label">WHAT IS YOUR MOST IMPORTANT ADVERTISING GOAL RIGHT NOW? *</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="Boost traffic to my website">
                            <label class="form-check-label ad-label my-1" for="exampleRadios1">
                                BOOST TRAFFIC TO MY WEBSITE
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="Drive sales">
                            <label class="form-check-label ad-label my-1" for="exampleRadios2">
                                DRIVE SALES
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="Find new customers">
                            <label class="form-check-label ad-label my-1" for="exampleRadios3">
                                FIND NEW CUSTOMERS
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios4" value="Increase Local Brand Awareness">
                            <label class="form-check-label ad-label my-1" for="exampleRadios4">
                                INCREASE LOCAL BRAND AWARENESS
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios5" value="All of the Above">
                            <label class="form-check-label ad-label my-1" for="exampleRadios5">
                                ALL OF THE ABOVE
                            </label>
                        </div>
                    </div>
                    <div class="item form-group mb-2" id="cus-text-area">
                        <label class="ad-label">TELL US MORE ABOUT YOUR BUSINESS: *</label>
                        <textarea id="textarea" required="required" name="about_your_business" class="form-control ad-input" rows="3">{{ old('about_your_business') }}</textarea>
                    </div>
                    <button id="send" type="submit" class="btn btn-success ad-btn-submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).on('click', '.ad-btn-submit', function () {
        if ($('input[name="exampleRadios"]:checked').length == 0) {
            $('#custome-validation').addClass('bad');
        } else {
            $('#custome-validation').removeClass('bad');
        }
        var textarea = $("#textarea").val();
        if (textarea == '') {
            $("#textarea").attr('placeholder', 'Please fill this field')
        } else {
            $("#textarea").attr('placeholder', '')
        }

    });
    jQuery('form').submit(function (e) {
        var submit = true;
        // evaluate the form using generic validaing
        if (!validator.checkAll(jQuery(this))) {
            submit = false;
        }

        if (submit) {
            this.submit();
        }
        return false;
    });
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