@extends('layouts.app')
@section('title')
@if(isset($info['town']))
Find out what's happening in {{$info['town']}}
@else
Register
@endif
@endsection
@section('meta')
@if(isset($info['town']))
@php
$image = asset('images/logo.png');
@endphp
<!-- Primary Meta Tags -->
<meta name="title" content="Find out what's happening in {{$info['town']}}">
<meta name="description" content="Get the news that matters most delivered straight to you">
<meta property="article:section" content="Business Listing">

<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{url()->full()}}">
<meta property="og:title" content="Find out what's happening in {{$info['town']}}">
<meta property="og:description" content="Get the news that matters most delivered straight to you">
<meta property="og:image" content="{{$image}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="{{$info['town']}},{{$info['location']}} Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{url()->full()}}">
<meta property="twitter:title" content="Find out what's happening in {{$info['town']}}">
<meta property="twitter:description" content="Get the news that matters most delivered straight to you">
<meta property="twitter:image" content="{{$image}}">
@else
<!-- Primary Meta Tags -->
<meta name="title" content="Find out what's happening outside your front door">
<meta name="description" content="Get the news that matters most delivered straight to you">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/register">
<meta property="og:title" content="Find out what's happening outside your front door">
<meta property="og:description" content="Get the news that matters most delivered straight to you">
<meta property="og:image" content="{{asset('images/logo.png')}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/register">
<meta property="twitter:title" content="Find out what's happening outside your front door">
<meta property="twitter:description" content="Get the news that matters most delivered straight to you">
<meta property="twitter:image" content="{{asset('images/logo.png')}}">
@endif
@endsection
@section('content')
@php
$segment2 = request()->segment(2);
$result= ucwords(str_replace("-"," ",$segment2));
$data =  DB::table('communities')->join('regions','regions.id','=','communities.region_id')
->select('communities.name','communities.id','regions.region_code')
//->where('communities.name', 'LIKE', '%'.$result.'%')
->where('communities.name', 'LIKE', $result)
->first();
@endphp
<link rel="stylesheet" href="{{asset('css/community.css')}}">
<style>
    .not_show_other_pages{display: none;}
</style>
<section class="page__content">
    <main id="main" role="main" class="page__main page__main--center login_wrapper">
        <div class="auth-block-container auth-block-container--full">

            <ul class="nav nav-tabs auth-block__tab-bar" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link auth-block__tab {{!isset($_GET['utm_campaign']) ? 'active' :''}}" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Log in</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link auth-block__tab {{isset($_GET['utm_campaign']) ? 'active' :''}}" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Sign up</a>
                </li>
            </ul>
            <div class="tab-content auth-block__content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <form class="form" method="post" action="{{route('user.login')}}">
                        @csrf
                        <?php
                        if (isset($_REQUEST['back'])) {
                            echo '<input type="hidden" value="' . $_REQUEST['back'] . '" name="back_to">';
                            echo '<input type="hidden" value="' . $_REQUEST['p'] . '" name="p">';
                        }
                        if (isset($_REQUEST['ru'])) {
                            echo '<input type="hidden" value="' . $_REQUEST['ru'] . '" name="ru">';
                        }
                        ?>

                        <div class="form__inner form__inner--is-condensed">
                            <h2 class="form__title">Log in to get started</h2>
                            <div class="login--wrapper">
                                <div>
                                    <div class="form__item">
                                        <label class="text-field text-field--is-outlined">
                                            <input aria-label="Enter your email address" autocomplete="email" class="text-field__input" name="email" placeholder="Email address" required type="email" value="{{ old('email') }}" autofocus>
                                        </label>
                                        @if ($errors->has('email'))
                                        <span class="text-danger email">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <div class="form__item">
                                        <label class="text-field text-field--is-outlined">
                                            <input aria-label="Enter your password" autocomplete="current-password" class="text-field__input" name="upassword" placeholder="Password" required type="password" id="password">
                                            <i class="far fa-eye" id="togglePassword" style="margin-left: -30px; cursor: pointer;"></i>
                                            {{-- <div class="text-field__append">
                                                <button class="text-field__btn" type="button">Show</button>
                                    </div> --}}
                                        </label>
                                        @if ($errors->has('upassword'))
                                            <span class="text-danger">{{ $errors->first('upassword') }}</span>
                                            @endif
                                    </div>
                                    <div>
                                        <div>
                                            <div class="grecaptcha-badge" data-style="inline" style="width: 256px; height: 60px; box-shadow: gray 0px 0px 5px;">
                                                <div class="grecaptcha-logo">
                                                    <iframe title="reCAPTCHA" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6Lf9WI0UAAAAAIWSgY0R8GBW7nJmHh1f7OM9KY1w&amp;co=aHR0cHM6Ly9wYXRjaC5jb206NDQz&amp;hl=en&amp;type=image&amp;v=RDRwZ7RcROX_wCxEJ01WeqEX&amp;theme=light&amp;size=invisible&amp;badge=inline&amp;cb=hj76smgj6ho8" width="256" height="60" role="presentation" name="a-89rwyz8kqwus" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox"></iframe>
                                                </div>
                                                <div class="grecaptcha-error"></div>
                                                <textarea id="g-recaptcha-response-3" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea>
                                            </div>
                                            <iframe style="display: none;"></iframe>
                                        </div>
                                    </div>
                                    <div class="form__item">
                                        <button class="btn btn--cta" type="submit">Log in</button>
                                    </div>
                                </div>
                                <section class="st_socialButtonContainer reg">
                                    <div class="st_socialButtonContainerHeader"><span>or</span>
                                    </div>
                                    <div class="st_socialButtonContainerInner">
                                        <a href="{{url('login/google')}}" class="st_socialButton google reg" type="button"><span class="st_socialButtonIcon reg"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><rect width="24" height="24" rx="12" fill="url(#pattern0)"></rect><defs><pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1"><use xlink:href="#image0" transform="translate(-0.418084 -0.45887) scale(0.0129888)"></use></pattern><image id="image0" width="144" height="144" xlink:href="data:image/png;base64,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"></image></defs></svg></span>Continue with Google</a>
                                        <a href="{{url('login/facebook')}}" class="st_socialButton facebook reg" type="button"><span class="st_socialButtonIcon reg"><svg viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M27.5625 14.5C27.5625 7.00781 21.4922 0.9375 14 0.9375C6.50781 0.9375 0.4375 7.00781 0.4375 14.5C0.4375 21.2812 5.35938 26.9141 11.8672 27.8984V18.4375H8.42188V14.5H11.8672V11.5469C11.8672 8.15625 13.8906 6.24219 16.9531 6.24219C18.4844 6.24219 20.0156 6.51562 20.0156 6.51562V9.85156H18.3203C16.625 9.85156 16.0781 10.8906 16.0781 11.9844V14.5H19.8516L19.25 18.4375H16.0781V27.8984C22.5859 26.9141 27.5625 21.2812 27.5625 14.5Z" fill="white"></path></svg></span>Continue with Facebook</a>
                                        {{-- <button class="st_socialButton apple reg" type="button"><span class="st_socialButtonIcon reg"><svg viewBox="10 10 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M35.3828 28.5117C35.3828 26.3438 36.3789 24.7617 38.3125 23.5312C37.1992 21.9492 35.5586 21.1289 33.3906 20.9531C31.2812 20.7773 28.9961 22.125 28.1758 22.125C27.2969 22.125 25.3047 21.0117 23.7227 21.0117C20.4414 21.0703 16.9844 23.5898 16.9844 28.8047C16.9844 30.3281 17.2188 31.9102 17.8047 33.5508C18.5664 35.7188 21.2617 40.9922 24.0742 40.875C25.5391 40.875 26.5938 39.8203 28.5273 39.8203C30.4023 39.8203 31.3398 40.875 32.9805 40.875C35.8516 40.875 38.3125 36.0703 39.0156 33.9023C35.207 32.0859 35.3828 28.6289 35.3828 28.5117ZM32.1016 18.9023C33.6836 17.0273 33.5078 15.2695 33.5078 14.625C32.1016 14.7422 30.4609 15.6211 29.5234 16.6758C28.4688 17.8477 27.8828 19.3125 28 20.8945C29.5234 21.0117 30.9297 20.25 32.1016 18.9023Z" fill="white"></path></svg></span>Continue with Apple</button> --}}
                                    </div>
                                </section>
                            </div>
                            <div class="form__item">
                                <a class="btn btn--link" type="button" href="{{route('forget.password.get')}}">Forgot your password?</a>
                                <p class="paragraph paragraph--small">New to Neighborhood Reporter?
                                    <a href="" id="goto_signup" data-toggle="tab"><button class="btn btn--link" type="button">Sign up now</button></a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <form class="form" method="POST" action="{{route('u.register')}}">
                        @csrf
                        <div class="form__inner form__inner--is-condensed">
                            <h2 class="form__title">Find out what's happening<br>outside your front door</h2>
                            <div class="form__item">
                                {{-- <div class="autocomplete" role="search"> --}}
                                <label class="text-field text-field--is-outlined">
                                    <div class="text-field__prepend"><i class="text-field__icon fa fa-map-marker-alt"></i>
                                    </div>
                                    <input aria-label="Find a community on Patch by entering a town name or ZIP code" autocomplete="off" class="text-field__input" name="community" id="community" placeholder="Your town" required type="text" value="{{isset($data) ? $data->name. ', ' .$data->region_code : ''}}">
                                </label>
                                {{-- </div> --}}
                            </div>
                            <input type="hidden" name="community_id" id="community_id" value="{{isset($data) ? $data->id : ''}}">
                            <div id="community_list"></div>
                            <div class="form__item">
                                <label class="text-field text-field--is-outlined">
                                    <input aria-label="Enter your email address" autocomplete="email" class="text-field__input" name="name" placeholder="First and last name" required type="text" value="{{old('name')}}"> 
                                </label>
                                @if ($errors->has('name'))
                                <span class="text-danger error">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form__item">
                                <label class="text-field text-field--is-outlined">
                                    <input aria-label="Enter your email address" autocomplete="email" class="text-field__input" name="email" placeholder="Email address" required type="email" value="{{old('email')}}" autofocus>
                                </label>
                                @if ($errors->has('email'))
                                <span class="text-danger error">{{ $errors->first('email') }}</span>
                                @endif
                            </div> 
                            <div class="form__item">
                                <label class="text-field text-field--is-outlined">
                                    <input aria-label="Enter your email address" autocomplete="email" class="text-field__input" name="password" placeholder="Password" required type="password">
                                </label>
                                @if ($errors->has('password'))
                                <span class="text-danger error">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form__item">
                                <button class="btn btn--cta find-community" type="submit">Find your community</button>
                            </div>
                            <div class="form__item">
                                <a class="btn btn--link btn--link-muted btn--link-no-underline" type="button"><i class="fa icon icon--space-right fa-check-square"></i>Send me local news updates</a>
                                <hr class="form__divider">
                                <p class="paragraph paragraph--small">Already have an account?
                                    <a href="" id="goto_login" data-toggle="tab"><button class="btn btn--link" type="button">Log in now</button></a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>
</section>
<script>
    $(document).ready(function () {

        $('#community').on('keyup', function () {
            var query = $(this).val();
            $.ajax({

                url: "{{ route('search_community') }}",

                type: "GET",

                data: {'communitie': query},

                success: function (data) {

                    $('#community_list').html(data);
                }
            })
            // end of ajax call
        });

        $(document).on('click', '.list-group-item', function () {

            var value = $(this).text();
            var cid = $(this).data('id');
            $('#community').val(value);
            $('#community_id').val(cid);
            $('#community_list').html("");
        });
    });

</script>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });
</script>

<script>
    $("#goto_signup").click(function () {
        $('#myTab li:last-child a').tab('show')
    })

    $("#goto_login").click(function () {
        $('#myTab li:first-child a').tab('show')
    })

    const params = new URLSearchParams(window.location.search);
    var xpop = params.get('utm_campaign');
    if (xpop == 'invite')
    {
        $('#profile-tab').trigger('click');
        $('#home').removeClass('active show');
        $('#profile').addClass('active show');
    }

    $(".find-community").click(function () {
        sessionStorage.setItem("errorname", "error");
    })
    var geterror = sessionStorage.getItem("errorname");
    var error = $('span').hasClass('error');
    if(geterror=='error' && error==true)
    {
        $('#profile-tab').trigger('click');
        $('#home').removeClass('active show');
        $('.email').css('display','none');
        $('#profile').addClass('active show');
    }

    $("#home-tab").click(function () {
        sessionStorage.setItem("errorname", "login");
    })
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