@extends('layouts.app')
@section('title')
Invite
@endsection
@section('meta')
<!-- Primary Meta Tags -->
<meta name="title" content="Invite a friend">
<meta name="description" content="Spread the local love">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/invite">
<meta property="og:title" content="Invite a friend">
<meta property="og:description" content="Spread the local love">
<meta property="og:image" content="{{asset('images/logo.png')}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/invite">
<meta property="twitter:title" content="Invite a friend">
<meta property="twitter:description" content="Spread the local love">
<meta property="twitter:image" content="{{asset('images/logo.png')}}">
@endsection
<style>
    .text-dark {
        color: #111;
    }
    .border-gray {
        border-color: #ccc !important;
    }
    .invite_wrapper .text-6xl {
        font-size: 36px;
    }
    .invite_wrapper .text-3xl {
        font-size: 24px;
    }
    .invite_wrapper h4{
        font-size: 18px;
        font-weight: 400;
    }
    .invite_wrapper .btn-cta {
        background: #d20000;
        color: #fff;
    }
    .invite_wrapper .shadow:hover {
        box-shadow: 0 1rem 3rem rgb(0 0 0 / 18%) !important;
    }
    .invite_wrapper .btn-cta-facebook {
        color: #fff;
        background-color: #3B5998;
        border-color: #3B5998;
    }
    .invite_wrapper .btn-cta-facebook:hover {
        color: #fff;
        background-color: #2d4373;
        border-color: #2a3f6c;
    }
    .invite_wrapper .btn-cta-twitter {
        color: #fff;
        background-color: #1DA1F2;
        border-color: #1DA1F2;
    }
    .invite_wrapper .btn-cta-twitter:hover {
        color: #fff;
        background-color: #0c85d0;
        border-color: #0b7fc6;
    }
    @media screen and (min-width: 768px) {
        .invite_wrapper .text-4xl {
            font-size: 28px;
        }
        .invite_wrapper .text-2xl {
            font-size: 22px;
        }
        .w-sm-40 {
            width: 40% !important;
        }
    }
</style>
@section('content')
<div class="main-container container">
    <div class="row">
        <section class="col-sm-12 invite_wrapper">
            <div class="region region-content">
                <section>
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
                    <form method="POST" action="{{route('store.invite')}}">
                        @csrf
                        <section class="mx-auto">
                            @php
                            $segment1 = request()->segment(1);
                            $segment2 = request()->segment(2);
                            @endphp
                            <input type="hidden" name="segment1" value="{{$segment1}}">
                            <input type="hidden" name="segment2" value="{{$segment2}}">
                            <section class="align-items-start d-flex flex-column mx-auto w-md-100 w-sm-40">
                                <section class="text-center my-3 w-100">
                                    <h1 class="m-0 font-weight-bold text-center text-dark text-6xl text-4xl"> Spread the local love </h1>
                                    <h4 class="pt-2"> Have a friend who loves staying on top of what's happening in {{ucwords($info['town'])}}? </h4>
                                    <h4 class="m-0 pt-3 font-weight-bold text-center text-dark text-3xl text-2xl">Invite via email</h4>
                                </section>
                                <section class="d-flex overflow-hide w-100 mb-3">
                                    <input placeholder="Your friend's name (optional)" type="text" class="border border-gray outline-0 post-input-field px-3 py-2 rounded w-100" name="friend_name">
                                </section>
                                <section class="d-flex overflow-hide w-100 mb-3">
                                    <input placeholder="Your friend's email address" type="email" required="required" class="border border-gray outline-0 post-input-field px-3 py-2 rounded w-100" name="friend_email">
                                </section>
                                <section class="d-flex overflow-hide w-100 mb-3">
                                    <input autocomplete="displayName" placeholder="Your name" type="text" required="required" class="border border-gray outline-0 post-input-field px-3 py-2 rounded w-100" name="your_name" value="{{isset(Auth::user()->name) ? Auth::user()->name : ''}}">
                                </section>
                                <section class="d-none py-2">
                                    <div>
                                        <div class="grecaptcha-badge" data-style="inline" style="width: 256px; height: 60px; box-shadow: gray 0px 0px 5px;">
                                            <div class="grecaptcha-logo">
                                                <iframe title="reCAPTCHA" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6Lf9WI0UAAAAAIWSgY0R8GBW7nJmHh1f7OM9KY1w&amp;co=aHR0cHM6Ly9wYXRjaC5jb206NDQz&amp;hl=en&amp;v=JF4U2g-hvLrBJ_UxdbKj92gN&amp;size=invisible&amp;badge=inline&amp;cb=wzv9oa7c6jc2" width="256" height="60" role="presentation" name="a-la2n1ybsysdc" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox"></iframe>
                                            </div>
                                            <div class="grecaptcha-error"></div>
                                            <textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea>
                                        </div>
                                        <iframe style="display: none;"></iframe>
                                    </div>
                                </section>
                                <section class="w-100 mb-3 py-1">
                                    <button type="submit" class="border-0 btn btn-cta d-block mx-auto p-2 rounded-pill outline-0 shadow w-100">
                                        <h4 class="font-weight-bold m-0"> Send email
                                            <!---->
                                        </h4>
                                    </button>
                                </section>
                                <section class="text-center my-3 w-100">
                                    <h4 class="m-0 font-weight-bold text-center text-dark text-3xl text-2xl"> Share your invite link </h4>
                                </section>
                                @php
                                $url =URL::to('/');
                                @endphp
                                <section class="border border-gray rounded d-flex overflow-hide w-100 mb-3">
                                    <input readonly="readonly" type="text" id="p1" class="border-0 outline-0 post-input-field px-3 py-2 rounded w-100" value="{{$url}}/{{$segment1}}/{{$segment2}}/register?&utm_source=invite-a-friend&utm_medium=web&utm_campaign=invite">
                                    <button type="button" class="border-0 btn btn-cta d-block mx-auto p-2 outline-0 shadow w-100" onclick="copyToClipboard()">
                                        <h4 class="font-weight-bold m-0"> Copy </h4>
                                    </button>
                                </section>
                                <div id="fb-root" class=" fb_reset">
                                    <div style="position: absolute; top: -10000px; width: 0px; height: 0px;">
                                        <div></div>
                                    </div>
                                </div>
                                <section class="w-100 mb-3 py-1">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fneighborhoodreporter.com%2F{{$segment1}}%2F{{$segment2}}%2Fregister%3F%26utm_source%3Dinvite-a-friend-fb%26utm_medium%3Dinvite%26utm_campaign%3Dinvite%26amp%3Bsrc%3Dsdkpreparse" target="_blank" rel="nofollow" data-href="" class="border-0 btn btn-cta-facebook d-block mx-auto p-2 rounded-pill outline-0 shadow w-100">
                                        <h4 class="font-weight-bold m-0">
                                            <i class="fab fa-facebook-f"></i> Share on Facebook
                                        </h4>
                                    </a>
                                </section>
                                <section class="w-100 mb-3 py-1">
                                    <a href="https://twitter.com/intent/tweet?url=https%3A%2F%2Fneighborhoodreporter.com%2F{{$segment1}}%2F{{$segment2}}%2Fregister%3F%26utm_source%3Dinvite-a-friend-twitter%26utm_medium%3Dinvite%26utm_campaign%3Dinvite" target="_blank" rel="nofollow" class="border-0 btn btn-cta-twitter d-block mx-auto p-2 rounded-pill outline-0 shadow w-100">
                                        <h4 class="font-weight-bold m-0">
                                            <i class="fab fa-twitter"></i> Share on Twitter
                                        </h4>
                                    </a>
                                </section>
                            </section>
                        </section>
                    </form>
                </section>
                <!-- /.block -->
            </div>
        </section>
    </div>
</div>
<script type="text/javascript">
    $(".st_FlagMenu .dropdown-toggle").click(function () {
        $(this).find(".flag-menu ul.dropdown-menu.dropdown-menu-right").toggle();
    });
    $(".regular").slick({
        dots: false,
        arrows: false,
        infinite: true,
        slidesToShow: 3,
        autoplay: true,
        autoplaySpeed: 2000,
        slidesToScroll: 1,
        vertical: true,
        verticalSwiping: true,
        pauseOnHover: false,
        pauseOnFocus: false
    });
    $(".header-hamburger-btn").click(function () {
        $(".h-hamburger-line").toggleClass('hamburger__line--open');
        $(".navbar-collapse").toggleClass('show');
        // $(".mob-menu").toggleClass("show-mob-menu");
    });

    $(".secondary-nav__list-item").click(function () {
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
    }
    $(".header-hamburger-btn").click(function () {
        // $('.header').toggleClass('header--fixed');
        $('.header').removeClass("header--sticky-full");
        $('.header').removeClass("header--sticky-condensed");
        $('body').toggleClass("over-class");
    });



</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".autocomplete input").click(function () {
            $('.fp-helper__wrapper.fp-helper--closed').show();

        });
    });

    $(document).mouseup(function (e) {
        var container = $(".fp-helper__wrapper.fp-helper--closed");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.hide();
        }
    });

    // Text Editor //
    jQuery(document).ready(function ($) {
        /** ******************************
         * Simple WYSIWYG
         ****************************** **/
        $('#editControls a').click(function (e) {
            e.preventDefault();
            switch ($(this).data('role')) {
                case 'h1':
                case 'h2':
                case 'h3':
                case 'p':
                    document.execCommand('formatBlock', false, $(this).data('role'));
                    break;
                default:
                    document.execCommand($(this).data('role'), false, null);
                    break;
            }
            var textval = $("#editor").html();
            $("#editorCopy").val(textval);
        });
        $("#editor").keyup(function () {
            var value = $(this).html();
            $("#editorCopy").val(value);
        }).keyup();
        $('#checkIt').click(function (e) {
            e.preventDefault();
            alert($("#editorCopy").val());
        });
    });

    $('#openclose_video').click(function () {
        $('#openclose_video_handling_open').toggle();
    });

    function copyToClipboard() {
        /* Get the text field */
        var copyText = document.getElementById("p1");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        navigator.clipboard.writeText(copyText.value);
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        };
        toastr.success("Copied.!");
    }

</script>
@endsection