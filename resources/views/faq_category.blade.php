@extends('layouts.app')
@section('title')
Faq Category
@endsection
@section('content')
{{-- <header class="support-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
       <div class="container">
        <a class="navbar-brand" href="#"><img alt="Patch News" class="support-logo" src="./images/support-patch-logo.png" title="Patch News"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="To                            ggle navigation">
                        <span class="navbar-toggler-icon"></                        span>
                                      </button>
                <div class="collapse navbar-collapse"                            id="navbarText">
                    <ul cla                                ss="navbar-nav ml-auto">
                                                         <li class="nav-items active">
                            <a class="submit-a-request" href="/hc                                /en-us/requests/new">S                            ubmit a request</a>                        
                                    </li>
                </ul>
                </div>
            </div>
        </nav>
        </header> --}}
        <div class="sp-main">
            <section class="support-hero">
                <div class="support-search">
                    <div class="row">
                        <div class="col-lg-12">
                            <form class="support-form">
                                <input class="support-control" type="search" placeholder="Search" aria-label="Search" id="faq_category">
                            </form>
                            <div id="faq_category_list"></div>                    
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="container my-5">
                    <ul class="support-blocks-list">
                        @foreach($faq_categories as $faq_category)
                        <?php
                        $title = strtolower(str_replace(" ", "-", $faq_category->id . "-" . $faq_category->title));
                        ?>
                        <li class="support-blocks-item">
                            <a href="{{route('faq_listing',$title)}}" class="support-item-link">
                                <h4 class="support-item-title">
                                    {{$faq_category->title}}
                                </h4>
                                <p class="support-item-description">{{$faq_category->description}}</p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </section>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {

                $('#faq_category').on('keyup', function () {
                    var query = $(this).val();
                    $.ajax({

                        url: "{{ route('search_faq_category') }}",

                        type: "GET",

                        data: {'faq_category': query},

                        success: function (data) {

                            $('#faq_category_list').html(data);
                        }
                    })
                    // end of ajax call
                });


                $(document).on('click', '.faq-category', function () {
                    var value = $(this).text();
                    var fid = $(this).data('id');
                    var url = '{{ route("faq_listing", ":slug") }}';
                    url = url.replace(':slug', fid);
                    $("a").attr("href", url)
                    $('#faq_category').val(value);
                    $('#faq_category_list').html("");
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
            });
        </script>
        @endsection