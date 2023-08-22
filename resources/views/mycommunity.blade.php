@extends('layouts.app')
@section('title')
Manage Your Profile
@endsection
@section('meta')
<!-- Primary Meta Tags -->
<meta name="title" content="Manage Your Profile">
<meta name="description" content="Manage Your Profile">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/profile/edit">
<meta property="og:title" content="Manage Your Profile">
<meta property="og:description" content="Manage Your Profile">
<meta property="og:image" content="{{asset('images/logo.png')}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/profile/edit">
<meta property="twitter:title" content="Manage Your Profile">
<meta property="twitter:description" content="Manage Your Profile">
<meta property="twitter:image" content="{{asset('images/logo.png')}}">
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content-sec">
    <div class="container pad-0">
        <section class="page__content">
            <main id="main" role="main" class="page__main page__main--center my-community">
                <div class="st_InteractionGuard">
                    <div class="st_InteractionGuard__content">
                        <div class="st_ManageCommunitiesForm">
                            <form class="form">
                                <div class="form__inner">
                                    <h1 class="st_ManageCommunitiesForm__title">My Communities</h1>
                                    <div class="form__item">
                                        <ul class="st_ReorderableList" data-rbd-droppable-id="js-manage-followed-communities-list" data-rbd-droppable-context-id="0">
                                            @php $userCommunity = getUserCommunity(); $cid = '';@endphp
                                            @if(count($userCommunity) > 0)
                                            @foreach($userCommunity as $value)
                                            @if($value['default'] == 1)
                                            <li>
                                                <p class="st_ManageCommunitiesForm__item default" data-id="{{$value['community'][0]->id}}">
                                                    <label>
                                                        <i class="fa fa-home icon icon--space-right text text--primary"></i>{{$value['community'][0]->name}}, {{$value['community'][0]['region'][0]->name}}
                                                    </label>
                                                    <a class="btn btn--icon btn--icon-muted" href="/add/user-profile#js-preffered-patch">
                                                        <i class="fa fa-cog"></i>
                                                    </a>
                                                </p>
                                            </li>
                                            @else
                                            @php 
                                            $cid .= $value['community'][0]->id.','; 
                                            @endphp
                                            <li class="" data-rbd-draggable-context-id="0" data-rbd-draggable-id="{{$value['community'][0]->id}}" tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="{{$value['community'][0]->id}}" data-rbd-drag-handle-context-id="0" draggable="false">
                                                <p class="st_ManageCommunitiesForm__item">
                                                    <span>
                                                        <i class="fa fa-map-marker-alt icon icon--space-right text text--muted"></i>
                                                        {{$value['community'][0]->name}}, {{$value['community'][0]['region'][0]->name}}
                                                    </span>
                                                    <a class="btn btn--icon btn--icon-error remove_community" type="button">
                                                        <i class="fa fa-minus-circle"></i>
                                                    </a>
                                                </p>
                                            </li>
                                            @endif
                                            @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="form__item">
                                        <h2 class="st_ManageCommunitiesForm__title">Follow More Communities</h2>
                                        <p class="paragraph">Stay on top of what’s happening in all the communities you care about</p>
                                        <div class="" role="search">
                                            <label class="text-field text-field--is-outlined">
                                                <div class="text-field__prepend"><i class="text-field__icon fa fa-map-marker-alt"></i>
                                                </div>
                                                <input type="search" id="community" autocomplete="off" class="text-field__input" name="community" placeholder="Search by town name">
                                            </label>
                                        </div>
                                    </div>
                                    @php $cid = rtrim($cid,','); @endphp
                                    <input type="hidden" name="community_id" id="community_id2" value="{{$cid}}">
                                    <input type="hidden" name="remove_id" id="remove_id" value="">
                                    <input type="hidden" name="add_id" id="add_id" value="">
                                    <div id="community_list"></div>
                                    <div class="form__item">
                                        <div class="form__item">
                                            <button class="btn btn--cta" type="button" id="save_community">Save communities<i class="fas fa-spinner icon icon--space-left fa-spin" style="display: none;"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </section>
    </div>
</div>
<script>
    function removeA(arr) {
        var what, a = arguments, L = a.length, ax;
        while (L > 1 && arr.length) {
            what = a[--L];
            while ((ax = arr.indexOf(what)) !== -1) {
                arr.splice(ax, 1);
            }
        }
        return arr;
    }
    function arrayContains(needle, arrhaystack) {
        return (arrhaystack.indexOf(needle) > -1);
    }
    jQuery(document).ready(function () {
        var $ = jQuery;
        $('#community').on('keyup', function () {
            var query = $(this).val();
            $.ajax({
                url: "{{ route('search_event_community') }}",
                type: "GET",
                data: {'communitie': query},
                success: function (data) {
                    $('#community_list').html(data);
                }
            });
        });
        $(document).on('click', '.list-group-item', function () {
            var value = $(this).text();
            var cid = $(this).data('id');
            var html = '<li class="" data-rbd-draggable-context-id="0" data-rbd-draggable-id="' + cid + '" tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="' + cid + '" data-rbd-drag-handle-context-id="0" draggable="false">' +
                    '<p class="st_ManageCommunitiesForm__item"><span><i class="fa fa-map-marker-alt icon icon--space-right text text--muted"></i>' + value + '</span>' +
                    '<a class="btn btn--icon btn--icon-error remove_community" type="button"><i class="fa fa-minus-circle"></i>' +
                    '</a>' +
                    '</p>' +
                    '</li>';
            var c1 = c2 = [];
            if ($('#community_id2').val() != '') {
                c1 = $('#community_id2').val().split(',');
            }
            if ($('#add_id').val() != '') {
                c2 = $('#add_id').val().split(',');
            }
            final = c1.concat(c2);
            final.push($('.default').data('id').toString());
            $('#community_list').html("");
            $('#community').val('');
            if (final.indexOf(cid.toString()) !== -1) {
                toastr.options = {
                    "positionClass": "toast-bottom-center"
                };
                toastr.warning("You already added that community", "Unbale to add community");

            } else {
                $('.st_ReorderableList').append(html);
                if ($('#add_id').val() != '') {
                    cidArray = $('#add_id').val().split(',');
                    cidArray.push(cid);
                    cid = cidArray.toString();
                }
                $('#add_id').val(cid);
            }
        });
        $(document).on('click', '.remove_community', function () {
            if ($('#community_id2').val() != '') {
                cidArray = $('#community_id2').val().split(',');
                cid = $(this).parents('li').attr('data-rbd-draggable-id');
                if ($.inArray(cid.toString(), cidArray) > -1) {
                    if ($('#remove_id').val() != '') {
                        cidArray1 = $('#remove_id').val().split(',');
                        cidArray1.push(cid);
                        cid = cidArray1.toString();
                    }
                    $('#remove_id').val(cid);
                } else {
                    cidArray2 = $('#add_id').val().split(',');
                    rcid2 = $(this).parents('li').attr('data-rbd-draggable-id');
                    cidArray1 = removeA(cidArray2, rcid2);
                    cid = cidArray1.toString();
                    $('#add_id').val(cid);
                }
            }
            $(this).parents('li').remove();
            var c1 = [];
            if ($('#community_id2').val() != '') {
                c1 = $('#community_id2').val().split(',');
            }
            if (c1.indexOf(cid.toString()) !== -1) {
                var index = c1.indexOf(cid.toString());
                c1.splice(index, 1);
                $('#community_id2').val(c1.toString());
            }
        });
        $(document).on('click', '#save_community', function () {
            var $this = $(this);
            $(this).find('i').show();
            $.ajax({
                type: 'POST',
                url: "{{ route('community-store') }}",
                data: {ids: $('#community_id2').val(), addIds: $('#add_id').val(), removeIds: $('#remove_id').val()},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $this.find('i').hide();
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": true,
                        "progressBar": true,
                        "positionClass": "toast-bottom-center",
                        "preventDuplicates": true,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };
                    toastr.info("Followed communities have been updated.!");
                    var c1 = c2 = [];
                    if ($('#community_id2').val() != '') {
                        c1 = $('#community_id2').val().split(',');
                    }
                    if ($('#add_id').val() != '') {
                        c2 = $('#add_id').val().split(',');
                    }
                    final = c1.concat(c2);
                    final.push($('.default').data('id').toString());
                    $('#community_id2').val(final.toString());
                }
            });
        });

        $(document).on("click", ".header-hamburger-btn", function () {
            $(".h-hamburger-line").toggleClass('hamburger__line--open');
            $(".mob-menu").toggleClass("show-mob-menu");
        });
        $(document).on("click", ".secondary-nav__list-item", function () {
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
        };
        $(document).on("click", ".header-hamburger-btn", function () {
            $('.header').toggleClass('header--fixed');
            $('.header').removeClass("header--sticky-full");
            $('.header').removeClass("header--sticky-condensed");
            $('body').toggleClass("over-class");
        });
        $(document).on("click", ".autocomplete input", function () {
            $('.fp-helper__wrapper.fp-helper--closed').show();
        });
        $(document).mouseup(function (e) {
            var container = $(".fp-helper__wrapper.fp-helper--closed");
            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0)
            {
                container.hide();
            }
        });
    });
</script>
@endsection