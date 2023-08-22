@extends('layouts.manageApp')
@section('title')
My Neighborhood Reporter
@endsection
@section('meta')
<!-- Primary Meta Tags -->
<meta name="title" content="My Neighborhood Reporter">
<meta name="description" content="My Neighborhood Reporter Draft Articles">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/content/articles/draft">
<meta property="og:title" content="My Neighborhood Reporter">
<meta property="og:description" content="My Neighborhood Reporter Draft Articles">
<meta property="og:image" content="{{asset('images/logo.png')}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/content/articles/draft">
<meta property="twitter:title" content="My Neighborhood Reporter">
<meta property="twitter:description" content="My Neighborhood Reporter Draft Articles">
<meta property="twitter:image" content="{{asset('images/logo.png')}}">
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    body {
        background: white !important; 
    }
    .back-white{
        background-color: white;
    }
    section.manage-posts #home ul.listings li {
        width: 100%;
        text-align: left;
        border: none;
        display: flex;
    }
    section.manage-posts #home ul.listings li .checkbox {
        vertical-align: top;
    }
    .border-bottom-solid {
        border-bottom: 1px solid #eee;
        margin-bottom: 15px;
        padding-bottom: 15px;
    }
    article.artical-text {
        width: 100%;
        margin-top: -5px;
        border-bottom: 1px solid #eee;
        margin-bottom: 15px;
        padding-bottom: 15px;
    }
    .artical-text .row{
        margin: 0;
    }
    #home .add-img-artical strong a {
        color: #007bff;
        cursor: pointer;
        text-decoration: none;
        font-size: 15px;
    }
    .manage-posts span.text-standard.far.fa-file-alt {
        font-size: 17px;
        color: #333;
    }
    .artical-text p.small.text-info {
        margin-bottom: 5px;
    }
    #home header.geo-text a{
        font-weight: 400;
        margin-bottom: 5.25px;
        margin-top: 0;
        line-height: 24px;
        font-size: 19px;
        color: #009e13;
        cursor: pointer;
        text-decoration: none;
    }
    article.artical-text p {
        margin-bottom: 3px;
        font-size: 15px;
    }
    #home .artical-text .actions-section .btn-outline-cta {
        padding: 5px 10px;
        font-size: 15px;
        line-height: 1.5;
        border-radius: 3px;
        max-width: 140px;
        width: 100%;
        border-radius: 50px;
        color: #dc3545;
        background-color: transparent;
        background-image: none;
        border-color: #d20000;
        font-weight: 700;
        margin-left: auto;
        margin-right: 0;
    }
    #home .artical-text .actions-section .btn-outline-cta i {
        padding-right: 5px;
    }
    #home .artical-text .actions-section .pill-btn {
        color: #fff;
        background-color: #d20000;
        border-color: #d20000;
        padding: 5px 10px;
        font-size: 15px;
        margin-top: 10px;
        line-height: 1.5;
        border-radius: 3px;
        max-width: 140px;
        width: 100%;
        border-radius: 50px;
        margin-left: auto;
        margin-right: 0;
    }
    form#js-listing-page-form button.submit {
        padding: 5px 10px;
        font-size: 14px;
        line-height: 1.5;
        border-radius: 3px;
        max-width: 180px;
        width: 100%;
        font-weight: 700;
        margin-left: 5px;
        border-radius: 50px;
    }
    @media (max-width: 767px){
        .artical-text .col-xs-12 {
            margin-bottom: 20px;
        }

        .flex-basis-md-pct-20.side-btn{
            align-items: center;
        }
    }
    @media (max-width: 576px) {
        #home .artical-text .actions-section a.btn {
            margin-left: 0;
        }
    }
</style>
<section class="manage-posts">
    <div class="container">
        <div class="manage-tab">

            <ul class="nav nav-tabs" role="tablist">
                <li><a  class="active" href="/content">Articles</a></li>
                <li><a  href="/content/events">Events</a></li>
                <li><a  href="/content/classified">Classifieds</a></li>
                <li><a  href="/content/bizpost">Business Listings</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade active show">
                    <ul class="nav nav-tabs" role="tablist">
                        <li><a href="/content">Posted</a></li>
                        <li><a class="active" href="/content/articles/draft">Draft</a></li>
                    </ul>
                    <div class="tab-content article_posted">
                        <div id="menu6" class="tab-pane fade active show">
                            <div id="listings-wrapper">
                                <form id="js-listing-page-form" method="post">
                                    <ul class="listings list-unstyled">
                                        @if(count($info['post']) > 0)
                                        @foreach($info['post'] as $lpost)
                                        <li class="article_{{$lpost['id']}}">
                                            <input type="checkbox" name="deleteIds[]" data-type="" id="article-item_{{$lpost['id']}}" value="{{$lpost['id']}}" class="checkbox check-box">
                                            <article class="artical-text">
                                                <div class="row">
                                                    <div class="col-sm-2 col-xs-12 add-img-artical"> 
                                                        @if($lpost['post_image'] != '')
                                                        <a href="/p/{{$lpost['guid']}}" target="_blank" class="thumbnail w100px">
                                                            <img src="{{postgetImageUrl($lpost['post_image'],$lpost['created_at'])}}" width="100px" height="75px" alt="Test" title="Test" class="img-responsive">
                                                        </a>
                                                        @else
                                                        No image uploaded. 
                                                        <strong>
                                                            <a href="/article/{{$lpost['id']}}/edit">[add image]</a>
                                                        </strong>
                                                        @endif
                                                    </div>
                                                    <div class="col-sm-7 col-xs-12">
                                                        <p class="small text-info">
                                                            <span aria-hidden="true" class="text-standard far fa-file-alt">

                                                            </span> 
                                                            Article Draft created {{\Carbon\Carbon::parse($lpost['created_at'])->format('D, M j Y g:i a')}}
                                                        </p>
                                                        <header class="geo-text">
                                                            <a href="/p/{{$lpost['guid']}}">{{$lpost['post_title']}}</a>
                                                        </header>
                                                        <p> {{$lpost['post_subtitle']}} </p>
                                                        <p><span class="text-muted">Article in </span> {{$lpost['town']}}, {{$lpost['location']}} Neighbor Posts </p>
                                                    </div>
                                                    <div class="actions-section col-sm-3 col-xs-12 text-right">
                                                        <a href="/article/{{$lpost['id']}}/edit" class="btn btn-outline-cta">
                                                            <i class="fas fa-pencil-alt"></i>Edit
                                                        </a> 
                                                        <a href="javascript:void(0);" data-id="{{$lpost['id']}}" data-type="post" class="btn btn-danger pill-btn delete_article-post">Delete</a>
                                                    </div>
                                                </div>      
                                            </article>
                                        </li>
                                        @endforeach
                                        @else
                                        Your content will show up here after saving.
                                        @endif
                                    </ul>
                                    @if(count($info['post']) > 0)
                                    <label>
                                        <input type="checkbox" class="check-all">
                                        Select All</label>
                                    <button type="button" id="deleteAll" class="submit btn btn-danger">Delete Selected Drafts</button>
                                    @endif
                                </form>

                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $(".st_FlagMenu .dropdown-toggle").click(function () {
            $(this).find(".flag-menu ul.dropdown-menu.dropdown-menu-right").toggle();
        });
        
        $(".header-hamburger-btn").click(function () {
            $(".h-hamburger-line").toggleClass('hamburger__line--open');
            $(".navbar-collapse").toggleClass('show');
        });
        $(".secondary-nav__list-item").click(function () {
            $(this).find('.secondary-nav__menu').toggleClass('show');
        });
        $(".header-hamburger-btn").click(function () {
            $('.header').removeClass("header--sticky-full");
            $('.header').removeClass("header--sticky-condensed");
            $('body').toggleClass("over-class");
        });
        $(document).on('change', '.check-all', function () {
            if ($(this).prop('checked')) {
                $('.check-box').prop('checked', true);
            } else {
                $('.check-box').prop('checked', false);
            }
        });
        $(document).on('click', '#deleteAll', function () {
            var allVals = [];
            $(".check-box:checked").each(function () {
                allVals.push($(this).val());
            });
            if (allVals.length <= 0) {
                alert("Please select row.");
            } else {
                if (confirm("Are you sure you want to delete this draft?")) {
                    var join_selected_values = allVals.join(",");
                    $.ajax({
                        url: "{{ route('articlesDeleteAll') }}",
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {ids: join_selected_values},
                        dataType: 'json',
                        success: function (data) {
                            toastr.options = {
                                "closeButton": true,
                                "progressBar": true,
                                "positionClass": "toast-bottom-center"
                            };
                            toastr.success("Articles Deleted successfully.");
                            $.each(allVals, function (index, value) {
                                $('.article_' + value).remove();
                            });
                            location.reload();
                        }
                    });
                }
            }
        });
        $(document).on('click', '.delete_article-post', function () {
            var $this = $(this);
            if (confirm("Are you sure you want to delete this draft?")) {
                $.ajax({
                    url: "{{ route('articlesDelete') }}",
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {id: $(this).data('id')},
                    dataType: 'json',
                    success: function (data) {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-bottom-center"
                        };
                        toastr.success("Article Deleted successfully.");
                        $this.parents('.article_' + $this.data('id')).remove();
                    }
                });
            }
        });
    });

</script>
@endsection