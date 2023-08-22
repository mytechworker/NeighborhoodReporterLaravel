@php
$segment = Request::segment(1);
$image = DB::table('banner_images')->where('page_slug','faqCategory')->first();
$image1 = DB::table('banner_images')->where('page_slug','home')->first();
$url = URL::to("/");
@endphp
@if(!empty($image->image))
<style>
    .support-hero
    {
        background-image: url('{{ asset('images/'.$image->image) }}');
    }
</style>
@elseif($image->image==null || empty($image->image))
<style>
    .support-hero
    {
        background-image:url(./images/support-patch-main.jpg);
    }
</style>
@else
<style>
    .support-hero
    {
        background-image:url(./images/support-patch-main.jpg);
    }
</style>
@endif
@if(!empty($image1->image))
<style>
    .hero
    {
        background-image: url('{{ asset('images/'.$image1->image) }}');
    }
</style>
@elseif($image1->image==null || empty($image1->image))
<style>
    .hero
    {
        background-image:url(<?php echo $url ?>/images/patch_hero_992.jpg);
    }
</style>
@else
<style>
    .hero
    {
        background-image:url(./images/patch_hero_992.jpg);
    }
</style>
@endif

@if ($segment == 'faqCategory' || $segment == 'faq_detail' || $segment == 'submit_request')
<header class="support-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="head-logo-link" href="/">
                <img alt="Patch News" class="head-logo" src="{{asset('images/logo.png')}}" title="Neighborhood Reporter" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-items active">
                        <a class="submit-a-request" href="{{url('submit_request')}}">Submit a request</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
@else
<header class="header top-header">
    <nav class="nav">
        <div class="nav-item header-hamburger-btn">
            <button class="hamburger" type="button"> 
                <span class="h-hamburger-item">
                    <span class="h-hamburger-line"></span> 
                </span>
            </button>
        </div>
        <div class="nav-item head-patch-logo">
            @php
            if(Session::has('user_home_rote')){
            $link = Session::get('user_home_rote');
            }else{
            $link = route('home');
            }
            @endphp
            <a class="head-logo-link" href="{{$link}}">
                <img class="head-logo" src="{{asset('images/logo.png')}}" title="Neighborhood Reporter" />
            </a>
            <div class="nav__search-field">
                <div class="autocomplete" role="search">
                    <label class="text-field">
                        <div class="text-field__prepend"><i class="text-field__icon fas fa-map-marker-alt"></i></div>
                        <input type="text" readonly="" aria-label="Find a community on Patch by entering a town name or ZIP code" autocomplete="off" class="text-field__input" name="community" placeholder="Your town" value="" /> 
                    </label>
                </div>
            </div>
        </div>
        @if(!Auth::check())
        <div class="nav-item nav__autho-menu">
            <a class="btn nav__link nav__link--separate no_mobile" title="Advertise With Us" href="/across-america/advertise-with-us" rel="nofollow">Advertise</a>
            <a class="btn nav__link" title="Log in" href="{{route('user.register')}}" rel="nofollow">
                <i class="fa fa-user icon icon--space-right-sm"></i><span>Log in</span>
            </a>
        </div>
        @endif
        @if(Auth::check())
        <div class="nav-item nav__autho-menu">
            <div class="UserMenu_UserMenu">
                <div class="dropdown">
                    <button aria-haspopup="true" aria-expanded="false" id="js-user-nav-menu" type="button" class="dropdown-toggle btn">
                        <span class="UserMenu_UserMenu__displayName">{{ Auth::user()->name }}</span>
                        @if(Auth::user()->profile_image == '')
                        <i class="fa fa-user-circle avatar-icon avatar-icon--small"></i>
                        @elseif (Auth::user()->profile_image && (substr(Auth::user()->profile_image, 0, 7) == "http://" || substr(Auth::user()->profile_image, 0, 8) == "https://"))
                        <img class="avatar-img" src="{{ Auth::user()->profile_image }}" alt="{{ Auth::user()->name }}"/>
                        @else
                        <img class="avatar-img" src="{{asset('images/'.Auth::user()->profile_image)}}" />
                        @endif
                        <i class="fa fa-caret-down UserMenu_UserMenu__caret"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-item"><a class="UserMenu_UserMenu__link" href="{{route('add-article')}}">Write article</a></li>
                        <li class="dropdown-item"><a class="UserMenu_UserMenu__link" href="/{{getLocationLink()}}/compose">Post</a></li>
                        <li class="dropdown-item"><a class="UserMenu_UserMenu__link" href="/content">Manage posts</a></li>
                        <li class="dropdown-item"><a class="UserMenu_UserMenu__link" href="{{route('view_profile')}}">View profile</a></li>
                        <li class="dropdown-item"><a class="UserMenu_UserMenu__link" href="{{route('add-user')}}">Edit profile</a></li>
                        <li class="dropdown-item"><a class="UserMenu_UserMenu__link" href="/profile/edit">My communities</a></li>
                        <li class="dropdown-item"><a class="UserMenu_UserMenu__link" href="{{route('settings-email')}}">Email settings</a></li>
                        <li class="dropdown-item"><a class="UserMenu_UserMenu__link" href="/{{getLocationLink()}}/invite">Invite a friend</a></li>
                        <li class="dropdown-item"><a class="UserMenu_UserMenu__link" href="/contact-us">Contact</a></li>
                        <li class="dropdown-item"><button class="UserMenu_UserMenu__link" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">Log out</button>
                            <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endif
        @php $place = ''; @endphp
        @if(isset($info['location']) && !isset($info['town']))
        @php $place = $info['location']; @endphp
        <div class="nav-item head-patche-title-container">
            <a class="head-patch-title" title="Neighborhood Reporter" href="/r/{{sanitizeStringForUrl($info['location'])}}">{{(isset($info['location'])?$info['location']:"")}}</a>
            @if(!Auth::check())
            <button class="btn btn-small" type="button" data-toggle="modal" data-target="#subscriberModal">
                <i class="fa icon icon-space-right-sm1 fa-plus"></i>Follow
            </button>
            @else
            <button class="btn btn-small" type="button">
                <i class="fa icon icon-space-right-sm1 fa-check"></i>Following
            </button>
            @endif
        </div>
        @elseif(isset($info['town']) && isset($info['location']))
        @php $place = $info['town']; @endphp
        <div class="nav-item head-patche-title-container">
            <a class="head-patch-title" title="Neighborhood Reporter" href="/l/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}">{{(isset($info['town'])?$info['town']:"")}}, {{(isset($info['location'])?$info['location']:"")}}</a>
            @if(!Auth::check())
            <button class="btn btn-small" type="button" data-toggle="modal" data-target="#subscriberModal">
                <i class="fa icon icon-space-right-sm1 fa-plus"></i>Follow
            </button>
            @else
            @if(checkFollowCommunity($info['town']))
            @if(checkDefaultFollowCommunity($info['town']))
            <button class="btn btn-small" type="button" data-toggle="modal" data-target="#defaultCommunity">
                <i class="fa icon icon-space-right-sm1 fa-check"></i>Following
            </button>
            @else
            <button class="btn btn-small" type="button" data-toggle="modal" data-target="#unfollow">
                <i class="fa icon icon-space-right-sm1 fa-check"></i>Following
            </button>
            @endif
            @else
            <button class="btn btn-small" type="button" id="addCommunity" data-community="{{$info['town']}}">
                <i class="fa icon icon-space-right-sm1 fa-plus"></i>Follow
            </button>
            @endif
            @endif

        </div>
        @endif


    </nav>
    @if(Auth::check())
    @if(isset($info['town']) && isset($info['location']))
    <nav class="tab-nav">
        <a class="tab-nav-item" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/post">Neighbor Posts</a>
        <a class="tab-nav-item" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/marketplace">Local Marketplace</a>
        <a class="tab-nav-item" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/calendar">Calendar</a>
    </nav>
    @endif
    @endif
    <nav class="secondary-nav mob-menu secondary-nav--is-displayed">
        <h3 class="header__tagline">Your news and your neighbors, together.</h3>
        <ul class="secondary-nav__list">
            <li class="secondary-nav__list-item secondary-nav__list-item--mobile-only">
                <div class="secondary-nav__list-row secondary-nav__list-row--space-around">
                    <div class="autocomplete" role="search">
                        <label class="text-field text-field--is-outlined">
                            <div class="text-field__prepend"><i class="text-field__icon fas fa-map-marker-alt"></i></div>
                            <input type="search" autocomplete="off" class="text-field__input" id="community1" placeholder="Your town" /> 
                        </label>
                    </div>
                </div>
            </li>
            <div id="community_list1"></div>
            @if(isset($info['town']) && isset($info['location']))
            <li class="secondary-nav__list-item">
                <button class="secondary-nav__menu-toggle" aria-haspopup="true" aria-expanded="false" id="js-secondary-nav-followed-communities">My Communities
                    <i aria-hidden="true" class="fa fa-caret-down icon icon--space-left-sm"></i>
                </button>
                <ul x-placement="bottom-start" aria-labelledby="js-secondary-nav-followed-communities" class="secondary-nav__menu" style="position: absolute; top: 0px; left: 0px; opacity: 0; pointer-events: none;">
                    @php $userCommunity = getUserCommunity(); @endphp
                    @if(count($userCommunity) > 0)
                    @foreach($userCommunity as $value)
                    @if($value['default'] == 1)
                    <li class="secondary-nav__menu-item">
                        <a class="secondary-nav__link" href="/l/{{sanitizeStringForUrl($value['community'][0]['region'][0]->name)}}/{{sanitizeStringForUrl($value['community'][0]->name)}}">
                            <i class="fa fa-home icon icon--space-right text text--primary"></i>{{$value['community'][0]->name}}, {{$value['community'][0]['region'][0]->name}}
                        </a>
                    </li>
                    @else
                    <li class="secondary-nav__menu-item">
                        <a class="secondary-nav__link" href="/l/{{sanitizeStringForUrl($value['community'][0]['region'][0]->name)}}/{{sanitizeStringForUrl($value['community'][0]->name)}}">
                            <i class="fas fa-map-marker-alt icon icon--space-right text text--muted"></i>{{$value['community'][0]->name}}, {{$value['community'][0]['region'][0]->name}}
                        </a>
                    </li>
                    @endif
                    @endforeach
                    @endif
                    <li class="secondary-nav__menu-item">
                        <a class="secondary-nav__link" href="/profile/edit">
                            <i class="fas fa-search icon icon--space-right text text--primary"></i>Follow more communities
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            @if(isset($info['location']))
            @php $Community = getRegionCommunity($info['location']); @endphp
            <li class="secondary-nav__list-item">
                <button class="secondary-nav__menu-toggle" aria-haspopup="true" aria-expanded="false" id="js-secondary-nav-nearby-toggle">Nearby<i aria-hidden="true" class="fa fa-caret-down icon icon--space-left-sm"></i></button>
                <ul data-column-items="5" x-placement="bottom-start" aria-labelledby="js-secondary-nav-nearby-toggle" class="secondary-nav__menu" style="position: absolute; top: 0px; left: 0px; opacity: 0; pointer-events: none;">
                    @if(count($Community) > 0)
                    @foreach($Community as $key => $value)
                    @if($key < 10)
                    <li class="secondary-nav__menu-item">
                        <a class="secondary-nav__link" href="/l/{{sanitizeStringForUrl($value['rname'])}}/{{sanitizeStringForUrl($value['name'])}}">{{$value['name']}}, {{$value['region_code']}}</a>
                    </li>
                    @endif
                    @endforeach
                    @endif
                </ul>
            </li>
            @endif
            @if(isset($info['location']) && isset($info['town']))
            <li class="secondary-nav__list-item">
                <button class="secondary-nav__menu-toggle" aria-haspopup="true" aria-expanded="false" id="js-secondary-nav-news-toggle">Local News<i aria-hidden="true" class="fa fa-caret-down icon icon--space-left-sm"></i></button>
                <ul data-column-items="7" x-placement="bottom-start" aria-labelledby="js-secondary-nav-news-toggle" class="secondary-nav__menu" style="position: absolute; top: 0px; left: 0px; opacity: 0; pointer-events: none;">
                    @php echo getHeaderMenu($info['location'],$info['town']); @endphp
                </ul>
            </li>
            <li class="secondary-nav__list-item"><a class="secondary-nav__link" title="{{$info['town']}} Neighbor Posts" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/post">Neighbor Posts</a></li>
            <li class="secondary-nav__list-item"><a class="secondary-nav__link" title="{{$info['town']}} Local Marketplace" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/marketplace">Local Marketplace</a></li>
            <li class="secondary-nav__list-item"><a class="secondary-nav__link" title="{{$info['town']}} Calendar" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/calendar">Calendar</a></li>
            <li class="secondary-nav__list-item"><a class="secondary-nav__link" title="Advertise With Us" href="/across-america/advertise-with-us" rel="nofollow">Advertise</a></li>
            @else
            <li class="secondary-nav__list-item secondary-nav__list-item--mobile-only">
                <a class="secondary-nav__link" title="Advertise With Us" href="/across-america/advertise-with-us" rel="nofollow">Advertise</a>
            </li>
            @endif
            <li class="secondary-nav__list-item secondary-nav__list-item--mobile-only">
                <a class="secondary-nav__link" href="/map">See all communities</a>
            </li>
        </ul>
    </nav>

</header>
@endif
@if(isset($info['location']))
@php $Community = getRegionCommunity($info['location']); @endphp
<div class="fp-helper__wrapper fp-helper--closed" id="location-drop">
    <div class="fp-helper fp-helper--split">
        <section class="fp-helper--split__section">
            <h3 class="fp-helper__header">Nearby Communities</h3>
            <div class="fp-helper__section">
                <ul class="list--unstyled">
                    @if(count($Community) > 0)
                    @foreach($Community as $key => $value)
                    @if($key < 10)
                    <li class="list-item__lg list-item--columned">
                        <a class="list-item__link list-item__link--xs" href="/l/{{sanitizeStringForUrl($value['rname'])}}/{{sanitizeStringForUrl($value['name'])}}">
                            <i class="fa fa-map-marker-alt fa-fw fp-icon"></i>{{$value['name']}}, {{$value['region_code']}}
                        </a>
                    </li>
                    @endif
                    @endforeach
                    @endif
                </ul>
            </div>
        </section>
        <section class="fp-helper--split__section">
            <h3 class="fp-helper__header">State Edition</h3>
            <ul class="list--unstyled">
                <li class="list-item__lg list-item--columned">
                    <a class="list-item__link list-item__link--xs" href="/r/{{sanitizeStringForUrl($info['location'])}}">
                        <i class="fa fa-map-marker-alt fa-fw fp-icon"></i>{{$info['location']}}
                    </a>
                </li>
            </ul>
            <h3 class="fp-helper__header">National Edition</h3>
            <ul class="list--unstyled">
                <li class="list-item__lg list-item--columned"><a class="list-item__link list-item__link--xs" href="/map"><i class="fa fa-star fa-fw fp-icon"></i>See All Communities</a></li>
            </ul>
        </section>
    </div>
</div>
@else
<div class="fp-helper__wrapper fp-helper__wrapper1 fp-helper--closed" id="location-drop">
    <div class="fp-helper">
        <div class="fyp-helper__section">
            <ul class="list--unstyled">
                <li class="list-item__lg list-item--columned">
                    <a class="list-item__link list-item__link--xs" href="/map">
                        <i class="fa fa-star fa-fw fp-icon"></i>See All Communities
                    </a>
                </li>
            </ul>
        </div>
        <section class="fp-helper__section">
            <h3 class="fp-helper__header">Region</h3>
            <div class="fp-helper__section">
                <ul class="list--unstyled">
                    @php $allRegion = getAllRegion(); @endphp
                    @if(count($allRegion) > 0)
                    @foreach($allRegion as $value)
                    <li class="list-item__lg list-item--columned">
                        <a class="list-item__link list-item__link--xs" href="/r/{{sanitizeStringForUrl($value['name'])}}">
                            <i class="fa fa-map-marker-alt fa-fw fp-icon"></i>{{$value['name']}}
                        </a>
                    </li>
                    @endforeach
                    @endif
                </ul>
            </div>
        </section>
    </div>
</div>
@endif
@php
$home= \Request::route()->getName();
@endphp
@if($home=='home')
<article class="hero not_show_other_pages">
    <h2 class="hero__title">
        Find out what's happening<br />
        outside your front door
    </h2>
    <div class="auth-block-container">
        <div class="auth-block">
            <div class="auth-block__content">
                <form class="form" id="subscriber_form">
                    @csrf
                    <div class="form__inner">
                        <h2 class="form__title">
                            Get the news that matters most delivered straight to you
                        </h2>

                        <input type="hidden" name="type" value="community">
                        <div class="form__item">
                            <div class="autocomplete1" role="search">
                                <label class="text-field">
                                    <div class="text-field__prepend"><i class="text-field__icon fas fa-map-marker-alt"></i></div>
                                    <input type="search" autocomplete="off" class="text-field__input" id="community" name="location" placeholder="Your town" required="" value="" /> 
                                </label>
                            </div>
                        </div>
                        <div id="community_list"></div>
                        <div class="form__item">
                            <label class="text-field text-field--is-outlined">
                                <input type="email" aria-label="Enter your email address" autocomplete="email" class="text-field__input" name="email" placeholder="Email address" required="" value="" /> 
                            </label>
                        </div>

                        <div class="form__item">
                            <button class="btn btn--cta btn--subscribe" type="button">Find your community<i class="fas fa-spinner icon icon--space-left fa-spin" style="display: none;"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</article>
@endif
@if(isset($info['location']))
<div class="modal fade" id="subscriberModal" tabindex="-1" aria-labelledby="subscriberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog--subscribe">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title h4">Find out what’s happening in {{$place}} with free, real-time updates from Patch.</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="subscriber_form">
                    @csrf
                    <input type="hidden" name="location" value="{{$place}}">
                    <input type="hidden" name="type" value="{{(isset($info['town']) && isset($info['location'])?"community":"region")}}">
                    <div class="form__inner">
                        <div class="form__item">
                            <label class="text-field text-field--is-outlined">
                                <input aria-label="Enter your email address" autocomplete="email" class="text-field__input text text__center" name="email" placeholder="Email address" required="" type="email" value="">
                            </label>
                        </div>
                        <div class="form__item">
                            <button class="btn btn--cta btn--subscribe" type="button">Let's go!<i class="fas fa-spinner icon icon--space-left fa-spin" style="display: none;"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade defaultCommunity" id="defaultCommunity" tabindex="-1" aria-labelledby="defaultCommunityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog--subscribe">
        <div class="modal-content">
            <div class="auth-block-container">
                <div class="auth-block">
                    <div class="auth-block__content">
                        <form class="form">
                            @csrf
                            <div class="form__inner form__inner--is-condensed">
                                <h2 class="form__title">Are you sure you want to stop following the {{$place}} Neighborhood Reporter?</h2>
                                <p class="paragraph">In order to unfollow your home community, you have to choose a new one first.</p>
                                <div class="form__item">
                                    <a class="btn--large btn--pill btn--outline-primary" href="/add/user-profile#js-preffered-patch">Change home community</a></div>
                                <button class="btn btn--link btn--link-muted" type="button" data-dismiss="modal" aria-label="Close">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade defaultCommunity" id="sendUpdate" tabindex="-1" aria-labelledby="sendUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog--subscribe">
        <div class="modal-content">
            <div class="auth-block-container">
                <div class="auth-block">
                    <div class="auth-block__content1">
                        <form class="form">
                            @csrf
                            <div class="form__inner form__inner--is-condensed">
                                <h2 class="form__title">Success! You’re now following the {{$place}} Neighborhood Reporter</h2>
                                <div class="form__item">
                                    <p class="paragraph">Would you like to receive free, real-time email updates about what’s happening in {{$place}}?</p>
                                </div>
                                <div class="form__item">
                                    <div class="form__item">
                                        <button class="btn btn--cta" id="sendEmailUpdate" data-community="{{$place}}" type="button">Yes, send me updates!</button>
                                    </div>
                                </div>
                                <button class="btn btn--link btn--link-muted" type="button" data-dismiss="modal" aria-label="Close" onclick="window.location.reload(true);">No, thanks</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade defaultCommunity" id="unfollow" tabindex="-1" aria-labelledby="sendUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog--subscribe">
        <div class="modal-content">
            <div class="auth-block-container">
                <div class="auth-block">
                    <div class="auth-block__content1">
                        <form class="form">
                            @csrf
                            <div class="form__inner form__inner--is-condensed">
                                <h2 class="form__title">Are you sure you want to stop following the {{$place}} neighborhood Reporter?</h2>
                                <p class="paragraph">You’ll no longer receive email notifications about what’s happening in {{$place}}.</p>
                                <div class="form__item">
                                    <div class="form__item">
                                        <button class="btn btn--cta btn--outline-primary" type="button" id="removeFollower" data-community="{{$place}}">Unfollow</button>
                                    </div>
                                </div>
                                <button class="btn btn--link btn--link-muted" type="button">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif