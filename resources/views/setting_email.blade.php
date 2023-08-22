@extends('layouts.app')
@section('title')
Email Setting
@endsection
@section('meta')
<!-- Primary Meta Tags -->
<meta name="title" content="Edit your email subscriptions">
<meta name="description" content="Edit your email subscriptions">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/settings/email">
<meta property="og:title" content="Edit your email subscriptions">
<meta property="og:description" content="Edit your email subscriptions">
<meta property="og:image" content="{{asset('images/logo.png')}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/settings/email">
<meta property="twitter:title" content="Edit your email subscriptions">
<meta property="twitter:description" content="Edit your email subscriptions">
<meta property="twitter:image" content="{{asset('images/logo.png')}}">
@endsection
@section('content')
<section class="page__content email-setting-section">
    <main class="email-setting-main">
        <div class="email-setting-sub-content">
            <div class="email-setting-wc">
                <h2>Customize your email subscriptions below</h2>
                Uncheck the updates you no longer wish to receive, and click "Save changes" to update your settings.
            </div>

            <div class="email-setting-chk-section">
                <form action="{{route('save-email')}}" method="post">
                    <?php
                    if (isset($_REQUEST['sid'])) {
                        echo '<input type="hidden" value="' . $_REQUEST['sid'] . '" name="sid">';
                    }
                    ?>
                    @csrf
                    @foreach($data as $key=>$community)
                    <div>
                        <input type="hidden" name="form[{{$key}}][user_id]" value="{{$community['user_id']}}">
                        <input type="hidden" name="form[{{$key}}][community_id]" value="{{$community['community_id']}}">
                        <h3>{{$community['name']}}, {{$community['region_code']}}</h3>
                        <div class="email-setting-chk-content">
                            <div class="styles_accordion">
                                <div class="styles_header">
                                    <label class="CustomCheckbox_customCheckbox CustomCheckbox_customCheckbox-bounce">
                                        Daily Newsletter
                                        <input class="CustomCheckbox_customCheckbox_input" {{($community['daily_news']==1 ? 'checked' : '')}} name='form[{{$key}}][daily_news]' type="checkbox" value="1">
                                        <svg class="CustomCheckbox_customCheckbox_checkMark">
                                        <polyline points="5 10.75 8.5 14.25 16 6"></polyline>
                                        </svg>
                                    </label>
                                    <button class="styles_arrow" type="button">
                                    </button>
                                </div>
                                <div class="collapse">
                                    <div class="styles_body"><span class="styles_frequency">1 per day</span>
                                        A morning email with the biggest stories for the day
                                    </div>
                                </div>
                            </div>
                            <div class="styles_accordion">
                                <div class="styles_header">
                                    <label class="CustomCheckbox_customCheckbox CustomCheckbox_customCheckbox-bounce">
                                        Breaking News Alerts
                                        <input class="CustomCheckbox_customCheckbox_input" name="form[{{$key}}][breaking_news]" {{($community['breacking_news']==1 ? 'checked' : '')}} type="checkbox" value="1">
                                        <svg class="CustomCheckbox_customCheckbox_checkMark">
                                        <polyline points="5 10.75 8.5 14.25 16 6"></polyline>
                                        </svg>
                                    </label>
                                    <button class="styles_arrow" type="button">
                                    </button>
                                </div>
                                <div class="collapse">
                                    <div class="styles_body">
                                        <input id="breaking1" type="radio" name="breaking1" class="styles_input" checked="true">
                                        <label for="breaking1" class="styles_label">
                                            <span class="styles_title">Local</span>
                                            <span class="styles_frequency">3-5 per week</span>Real-time alerts for local stories
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="styles_accordion">
                                <div class="styles_header">
                                    <label class="CustomCheckbox_customCheckbox CustomCheckbox_customCheckbox-bounce">
                                        Community Calendar
                                        <input class="CustomCheckbox_customCheckbox_input" name="form[{{$key}}][community_cal]" {{($community['community_cal']==1 ? 'checked' : '')}} type="checkbox" value="1">
                                        <svg class="CustomCheckbox_customCheckbox_checkMark">
                                        <polyline points="5 10.75 8.5 14.25 16 6"></polyline>
                                        </svg>
                                    </label>
                                    <button class="styles_arrow" type="button">
                                    </button>
                                </div>
                                <div class="collapse">
                                    <div class="styles_body"><span class="styles_frequency">1 per week</span>
                                        A weekly digest of upcoming events near you
                                    </div>
                                </div>
                            </div>
                            <div class="styles_accordion">
                                <div class="styles_header">
                                    <label class="CustomCheckbox_customCheckbox CustomCheckbox_customCheckbox-bounce">
                                        Neighbor Posts
                                        <input class="CustomCheckbox_customCheckbox_input" name="form[{{$key}}][neighbor_posts]" {{($community['neighbor_posts']==1 ? 'checked' : '')}} type="checkbox" value="1">
                                        <svg class="CustomCheckbox_customCheckbox_checkMark">
                                        <polyline points="5 10.75 8.5 14.25 16 6"></polyline>
                                        </svg>
                                    </label>
                                    <button class="styles_arrow" type="button">
                                    </button>
                                </div>
                                <div class="collapse">
                                    <div class="styles_body"><span class="styles_frequency">1-3 per week</span>
                                        Local questions and updates from your neighbors
                                    </div>
                                </div>
                            </div>
                            <div class="styles_accordion">
                                <div class="styles_header">
                                    <label class="CustomCheckbox_customCheckbox CustomCheckbox_customCheckbox-bounce">
                                        Classifieds
                                        <input class="CustomCheckbox_customCheckbox_input" name="form[{{$key}}][classifieds]" type="checkbox" {{($community['classifieds']==1 ? 'checked' : '')}} value="1">
                                        <svg class="CustomCheckbox_customCheckbox_checkMark">
                                        <polyline points="5 10.75 8.5 14.25 16 6"></polyline>
                                        </svg>
                                    </label>
                                    <button class="styles_arrow" type="button">
                                    </button>
                                </div>
                                <div class="collapse">
                                    <div class="styles_body"><span class="styles_frequency">1 per week</span>
                                        A weekly roundup of Classified listings posted by neighbors
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div>
                        <h3>Other</h3>
                        <div class="email-setting-chk-content">
                            <div class="styles_accordion">
                                <div class="styles_header">
                                    <label class="CustomCheckbox_customCheckbox CustomCheckbox_customCheckbox-bounce">
                                        Neighborhood Reporter: Company News
                                        <input class="CustomCheckbox_customCheckbox_input" name="company_news" {{(isset($user_data[0]['company_news'])&&$user_data[0]['company_news']==1 ? 'checked' : '')}} type="checkbox" value="1">
                                        <svg class="CustomCheckbox_customCheckbox_checkMark">
                                        <polyline points="5 10.75 8.5 14.25 16 6"></polyline>
                                        </svg>
                                    </label>
                                    <button class="styles_arrow" type="button">
                                    </button>
                                </div>
                                <div class="collapse">
                                    <div class="styles_body">
                                        I want to receive occasional updates from Neighborhood Reporter with company news and announcements.
                                    </div>
                                </div>
                            </div>
                            <div class="styles_accordion">
                                <div class="styles_header">
                                    <label class="CustomCheckbox_customCheckbox CustomCheckbox_customCheckbox-bounce">
                                        Replies to Your Posts
                                        <input class="CustomCheckbox_customCheckbox_input" {{(isset($user_data[0]['replies_posts'])&&$user_data[0]['replies_posts']==1 ? 'checked' : '')}}   name="replies_posts" type="checkbox" value="1">
                                        <svg class="CustomCheckbox_customCheckbox_checkMark">
                                        <polyline points="5 10.75 8.5 14.25 16 6"></polyline>
                                        </svg>
                                    </label>
                                    <button class="styles_arrow" type="button">
                                    </button>
                                </div>
                                <div class="collapse">
                                    <div class="styles_body">
                                        Send me an email when someone replies to my post on Neighborhood Reporter.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="email-setting-bottom">No thanks, I don't want to receive any more Neighborhood Reporter emails.
                <button class="styles_asLink">I quit</button>
                <hr class="styles_appFooter">
                <button class="btn btn-success ad-btn-submit">Save changes</button>
            </div>
            </form>
        </div>
    </main>
</section>
<script type="text/javascript">
    $(".st_FlagMenu .dropdown-toggle").click(function () {
        $(this).find(".flag-menu ul.dropdown-menu.dropdown-menu-right").toggle();
    });
   

    $(".secondary-nav__list-item").click(function () {
        $(this).find('.secondary-nav__menu').toggleClass('show');
    });
    $(document).on('click', '.styles_asLink', function () {
        $('input[type=checkbox]').prop('checked', false);
        $('form').submit();
    });

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

    // checbox
    jQuery(document).ready(function () {
        var $as = jQuery('.email-setting-chk-content .styles_accordion').click(function () {
            jQuery(this).toggleClass('styles_accordionOpen').next('ul.cust_sub-side').slideToggle();
            return true;
        });
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