<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('include.header')
    </head>
    <body>
        <div id="app" class="back-white">
            @if(Route::currentRouteName() != 'add-article')
            @include('include.menu')
            @else
            @include('include.article_menu')
            @endif
            <main class="">
                @yield('content')
            </main>
        </div>
        <div id="custom_notifications" class="custom-notifications dsp_none">
            <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
            </ul>
            <div class="clearfix"></div>
            <div id="notif-group" class="tabbed_notifications"></div>
        </div>
        @if(Route::currentRouteName() != 'add-article')
        @include('include.footer')
        @else
        @include('include.article_footer')
        @endif
    </body>
</html>