<header class="header top-header container-fluid profile_header">
    <div class="d-flex flex-column">
        <nav class="nav">
            <div class="nav-item header-hamburger-btn">
                <button class="hamburger" type="button"> <span class="h-hamburger-item">
                        <span class="h-hamburger-line"></span> </span>
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
            </div>
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
        </nav>
        <div class="navbar-collapse collapse" style="height: auto;">
            <nav role="navigation">
                <ul class="menu nav navbar-nav">
                    <li class="first">
                        <a href="{{$link}}" category="nav_primary" trigger="hamburger_home" class="l-bold">
                            <span class="fas fa-lg fa fa-home" aria-hidden="true"></span>
                            <span class="ml-1">Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('add-article')}}" title="Write an Article on Neighborhood Reporter" category="nav_primary" trigger="hamburger_article">Write an Article</a>
                    </li>
                    <li>
                        <a href="/{{getLocationLink()}}/compose/event" title="Post an Event on Patch" category="nav_primary" trigger="hamburger_event">Post an Event</a></li>
                    <li>
                        <a href="/{{getLocationLink()}}/compose/classified" title="Post a Classified on Patch" category="nav_primary" trigger="hamburger_classified">Post a Classified</a></li>
                    <li>
                        <a href="/{{getLocationLink()}}/compose/bizpost" title="Promote My Business on Patch" category="nav_primary" trigger="hamburger_bizpost">Promote My Business</a></li>
                    <li class="last">
                        <a href="{{route('my-post')}}" title="View My Posts" category="nav_primary" trigger="hamburger_view_my_post">View My Posts</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>