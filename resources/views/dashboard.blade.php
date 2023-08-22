{{-- <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
<form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form> --}}

{{-- <h1>{{Auth::user()->name}}</h1> --}}

<li class="nav-item dropdown">
    <img src="{{ Auth::user()->profile_image }}" alt="{{ Auth::user()->name }}" style="border:1px solid #cccccc; border-radius: 5px; width: 39px; height: auto; float:left; margin-right:7px;">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        {{ Auth::user()->name }}
    </a>

    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('logout') }}"
           onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</li>

<p>this is user dashboard</p>