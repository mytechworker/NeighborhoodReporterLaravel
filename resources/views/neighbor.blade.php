@extends('layouts.app')
@section('title')
{{$info['town']}}, {{$info['location']}} Neighborhood Reporter - Breaking Local News Events Schools & Sports
@endsection
@section('meta')
<!-- Primary Meta Tags -->
<meta name="title" content="{{$info['town']}} Neighbor Posts | {{$info['town']}}, {{$info['location']}} Neighborhood Reporter">
<meta name="description" content="{{$info['town']}}, {{$info['location']}}  local notices and open conversation posted by Patch readers">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/post">
<meta property="og:title" content="{{$info['town']}} Neighbor Posts | {{$info['town']}}, {{$info['location']}} Neighborhood Reporter">
<meta property="og:description" content="{{$info['town']}}, {{$info['location']}}  local notices and open conversation posted by Patch readers">
<meta property="og:image" content="{{asset('images/logo.png')}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/post">
<meta property="twitter:title" content="{{$info['town']}} Neighbor Posts | {{$info['town']}}, {{$info['location']}} Neighborhood Reporter">
<meta property="twitter:description" content="{{$info['town']}}, {{$info['location']}}  local notices and open conversation posted by Patch readers">
<meta property="twitter:image" content="{{asset('images/logo.png')}}">
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content-sec">
    <div class="container pad-0">
        <div class="row mar-mob">
            <div class="col-md-12 col-lg-8 pad-0">
                <main id="main" role="main" class="page__main">                    
                    <input type="hidden" id="login_user_id" value="{{Auth::id()}}">
                    <input type="hidden" id="login_url" value="{{ route("user.register") }}">
                    <input type="hidden" id="like_url" value="{{ route("post-like") }}">
                    <input type="hidden" id="report_url" value="{{ route("post-report") }}">
                    <input type="hidden" id="intrest_url" value="{{ route("event-intrest") }}">
                    <input type="hidden" id="location" value="{{$info['location']}}">
                    <input type="hidden" id="town" value="{{$info['town']}}">
                    <a class="compose-block" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose" rel="nofollow"> 
                        <i class="fas fa-user-circle avatar-icon"></i> 
                        <span class="compose-block__label">Ask a question or share local news</span> 
                        <i class="compose-block__image-icon fas fa-camera"></i> 
                        <span class="compose-block__post">Post</span> 
                    </a>
                    <section class="st_Section__1bIk_ NeighborPosts-sec" data-nosnippet="true">
                        <header class="st_Section__header">
                            <h2>{{$info['town']}} Neighbor Posts</h2>
                        </header>
                        <div id="neighbourLoadData">
                            @php $neigh_last_id = 0; @endphp
                            @if(count($info['neighbourPostList']) > 0)
                            @foreach($info['neighbourPostList'] as $npost)
                            <article class="st_Card">
                                <div class="st_Card__Content">
                                    <div class="st_Card__TextContentWrapper">
                                        <h6 class="st_Card__LabelWrapper">
                                            <a class="byline__secondary" title="{{$npost['town']}},{{$npost['location']}}" href="/l/{{sanitizeStringForUrl($npost['location'])}}/{{sanitizeStringForUrl($npost['town'])}}">
                                                {{$npost['town']}}, {{$npost['location']}}
                                            </a>
                                            <span class="st_Card__LabelDivider">|</span>
                                            <span>Neighbor Post</span>
                                            <span class="st_Card__LabelDivider">|</span>
                                            <a class="byline__secondary">
                                                <time datetime="{{$npost['created_at']}}">{{ \Carbon\Carbon::parse($npost['created_at'])->format('M d') }}</time>
                                            </a>
                                        </h6>
                                        <div class="byline byline--avatar">
                                            @if($npost['userInfo']->profile_image == '')
                                            <a><i class="fa fa-user-circle avatar-icon--base"></i></a>
                                            @else
                                            <img alt="{{$npost['userInfo']->name}} profile picture" class="avatar-img" src="{{getUserImageUrl($npost['userInfo']->profile_image)}}?width=36" />
                                            @endif
                                            <div class="byline__wrapper">
                                                <div>
                                                    <a class="byline__name byline__name--avatar">
                                                        <strong>{{$npost['userInfo']->name}}</strong>, Neighbor
                                                    </a>
                                                    <span class="st_Badges"></span>
                                                </div>
                                                <div class="byline__row"></div>
                                            </div>
                                        </div>
                                        <div class="st_Card__Body st_Card__Body--Truncated">
                                            <p>{!!nl2br($npost['post_content'])!!}</p>
                                        </div>
                                        <div>
                                            <button class="btn--link btn--link-base" type="button">Read more</button>
                                        </div>
                                    </div>
                                    @if($npost['post_image'] != '')
                                    <a class="st_Card__Thumbnail__1" href="/n/{{sanitizeStringForUrl($npost['location'])}}/{{sanitizeStringForUrl($npost['town'])}}/{{$npost['id']}}">
                                        <img src="{{postgetImageUrl($npost['post_image'],$npost['created_at'])}}" />
                                    </a>
                                    @endif
                                </div>
                                <div class="st_ActionBar">
                                    <div class="st_ActionBar__BarLeft">
                                        <button aria-label="thank" class="Button_ActionBar like_button-post" data-postid="{{$npost['id']}}" data-type="neighbour" type="button">
                                            <span class="Button_ActionBar__Icon">
                                                <?php
                                                if (isset($npost['userLikeInfo']) && !$npost['userLikeInfo']->isEmpty()) {
                                                    echo '<i class="fas fa-heart"></i>';
                                                } else {
                                                    echo '<i class="far fa-heart"></i>';
                                                }
                                                ?>
                                            </span> 
                                            <span class="Button_ActionBar__Label">
                                                Thank({{$npost['like_count']}})
                                            </span>
                                        </button>
                                        <a class="st_Card__ReplyLink" href="/n/{{sanitizeStringForUrl($npost['location'])}}/{{sanitizeStringForUrl($npost['town'])}}/{{$npost['id']}}#reply_block_article_nid={{$npost['id']}}">
                                            <i class="far fa-comment st_Card__ReplyLinkIcon"></i>
                                            Reply({{$npost['comment_count']}}) 
                                        </a>
                                        <button class="Button_ActionBar share share-button" data-title="{{$npost['post_title']}}" data-url="/n/{{sanitizeStringForUrl($npost['location'])}}/{{sanitizeStringForUrl($npost['town'])}}/{{$npost['id']}}" type="button"> 
                                            <span class="Button_ActionBar__Icon">
                                                <i class="fas fa-share"></i>
                                            </span>
                                            <span class="Button_ActionBar__Label">Share</span> 
                                        </button>
                                    </div>
                                    <div class="st_ActionBar__BarRight">
                                        <div class="st_FlagMenu">
                                            <div aria-label="flags" class="dropdown">
                                                <div class="js-content-flag-menu" aria-haspopup="true" aria-expanded="false" disabled="">
                                                    <button aria-label="flag" class="Button--flag dropdown-toggle" type="button"> 
                                                        <span class="st_Button__Icon"><i class="far fa-flag"></i></span> 
                                                    </button>
                                                    <div class="flag-menu">
                                                        <ul class="dropdown-menu dropdown-menu-right" data-postid="{{$npost['id']}}" data-type="neighbour">
                                                            <li class="st_FlagMenu__label">Reason for reporting:</li>
                                                            <li class="st_FlagItem__link dropdown-item"><span>Spam</span></li>
                                                            <li class="st_FlagItem__link dropdown-item"><span>Promotional</span></li>
                                                            <li class="st_FlagItem__link dropdown-item"><span>Disagree</span></li>
                                                            <li class="st_FlagItem__link dropdown-item"><span>Not Local</span></li>
                                                            <li class="st_FlagItem__link dropdown-item"><span>Unverified</span></li>
                                                            <li class="st_FlagItem__link dropdown-item"><span>Offensive</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @include('neighbor_comment')
                            </article>
                            @php $neigh_last_id = $npost['id']; @endphp
                            @endforeach
                            @else
                            <section class="st_FeaturedModule__ModuleLabel">
                                <h4 class="st_FeaturedModule__Title">No neighbor's post available.</h4>
                            </section>
                            @endif
                        </div>
                        @if(count($info['neighbourPostList']) > 0)
                        <a class="st_Section__linkButton" href="javascript:void(0);" name="load_more_button" data-url="{{ route("neighbour-load-data") }}" data-id="{{$neigh_last_id}}" id="load_more_neighbour_button" style="{{($info['hideNeighborButton'] == 1?"display: none;":"")}}">See more neighbor posts</a> 
                        @endif
                    </section>
                </main>
            </div>
            <div class="right-sec">
                <div class="vertical-slider m-20">
                    <div class="st_ModuleLabel">
                        <h4 class="st_ModuleLabel__Text__8quJk">Featured Events</h4>
                        <button class="btn btn--info-modal" type="button"> <i class="fa fa-info-circle st_ModuleLabel__Icon__mtBVa"></i> </button>
                    </div>
                    <section class="regular slider">
                        @if(count($info['eventList']) > 0)
                        @foreach($info['eventList'] as $epost)
                        <div>
                            <article class="st_CardCompact">
                                <div class="st_ContentLeft">
                                    <span><time datetime="{{$epost['created_at']}}">{{ \Carbon\Carbon::parse($epost['created_at'])->format('M d, Y') }}</time></span>
                                    <div class="st_TitleWrapper">
                                        <h5 class="styles_CardCompact__Title__3Et5F">
                                            <a class="styles_CardCompact__TitleLink__2PtcE" title="{{$epost['title']}}" href="/e/{{$epost['id']}}/{{sanitizeStringForUrl($epost['title'])}}">{{$epost['title']}}</a>
                                        </h5>
                                    </div>
                                </div>
                                @if($epost['image'] != '')
                                <a class="st_CardCompact__ImageLink" href="/e/{{$epost['id']}}/{{$epost['title']}}">
                                    <img src="{{postgetImageUrl($epost['image'],$epost['created_at'])}}">
                                </a>
                                @endif
                            </article>
                        </div>
                        @endforeach
                        @endif
                    </section>
                    <div class="st_ModuleFooter"><a href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/event" rel="nofollow">+ Add your event</a></div>
                </div>
                <div class="vertical-slider m-20">
                    <div class="st_ModuleLabel__Wrapper st_ModuleLabel__Wrapper--Classified">
                        <h4 class="st_ModuleLabel__Text">
                            Featured Classifieds
                        </h4>
                        <button class="btn btn--info-modal" type="button"><i class="fa fa-info-circle st_ModuleLabel__Icon"></i></button>
                    </div>
                    <section class="regular slider">
                        @if(count($info['classifiedList']) > 0)
                        @foreach($info['classifiedList'] as $cpost)
                        <div>
                            <article class="st_CardCompact">
                                <div class="st_ContentLeft">
                                    <span class="st_Description">{{$cpost['category']}}</span> 
                                    <div class="st_TitleWrapper">
                                        <h5 class="st_CardCompact__Title">
                                            <a class="st_CardCompact__TitleLink" title="{{$cpost['title']}}" href="/c/{{$cpost['id']}}/{{sanitizeStringForUrl($cpost['title'])}}">{{$cpost['title']}}</a>
                                        </h5>
                                    </div>
                                </div>
                                @if($cpost['image'] != '')
                                <a class="st_CardCompact__ImageLink" href="/c/{{$cpost['id']}}/{{$cpost['title']}}">
                                    <img src="{{postgetImageUrl($cpost['image'],$cpost['created_at'])}}">
                                </a>
                                @endif
                            </article>
                        </div>
                        @endforeach
                        @endif
                    </section>
                    <div class="st_ModuleFooter__Wrapper">
                        <a class="btn btn--text-primary st_ModuleFooter__Text st_ModuleFooter__Text--Classified add_post_link" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/classified" rel="nofollow">+ Add your classified</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var body = '';
    var action_bar = '';
    function loadMoreData(id = 0, url, html_id, $this) {
        $.ajax({
            type: 'POST',
            url: url,
            data: {id: id, location: $("#location").val(), town: $("#town").val()},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $this.remove();
                $('#' + html_id).append(data);
            }
        });
    }
    jQuery(document).ready(function () {
        var $ = jQuery;
        $(document).on("click", ".st_FlagMenu .dropdown-toggle", function () {
            $(this).parent().find(".flag-menu ul.dropdown-menu.dropdown-menu-right").toggle();
//            return false;
        });
        $(document).on("click", "body", function () {
//            $('.st_FlagMenu .dropdown-toggle').parent().find(".flag-menu ul.dropdown-menu.dropdown-menu-right").hide();
//            return false;
        });
        $(document).on("click", ".st_FlagItem__link", function () {
            $(this).parent().hide();
            var $this = $(this);
            if ($(this).parent().data('option') == 'edit') {
                if ($(this).find('span').text() == 'Edit') {
                    body = action_bar = '';
                    var text = $('.body_remove_' + $(this).parent().data('postid')).find('p').text();
                    body = $('.body_remove_' + $(this).parent().data('postid'));
                    action_bar = $('.action_remove_' + $(this).parent().data('postid'));
                    $('.body_remove_' + $(this).parent().data('postid')).remove();
                    $('.action_remove_' + $(this).parent().data('postid')).remove();
                    var html = '<form class="styles_ReplyForm__3YbUI">' +
                            '<div class="styles_ReplyForm__fieldContainer__3cNzb">' +
                            '<label class="text-field text-field--no-border">' +
                            '<textarea class="text-field__input styles_TextEditor__l92NA styles_TextEditor--is-editing__GrQTN styles_TextEditor--is-small__36ivx" id="edit_message-box" name="message" placeholder="Write your reply" rows="4">' + text + '</textarea>' +
                            '</label>' +
                            '</div>' +
                            '<footer class="styles_ReplyForm__footer__vKEul">' +
                            '<button class="styles_ReplyForm__cancel__1bzbN" data-id="' + $(this).parent().data('postid') + '" type="button">Cancel</button>' +
                            '<button class="styles_ReplyForm__submit__11sYc" data-id="' + $(this).parent().data('postid') + '" type="button" id="edit_replay-btn">Update</button>' +
                            '</footer>' +
                            '</form>';
                    $('.reply_' + $(this).parent().data('postid')).append(html);
                } else {
                    if (confirm('Are you sure you want to delete this reply?')) {
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('delete-article-comment') }}",
                            data: {id: $(this).parent().data('postid'), post_id: $(this).parent().data('nei')},
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (data) {
                                toastr.options = {
                                    "closeButton": true,
                                    "progressBar": true
                                };
                                toastr.info("Your reply delete successfully.!");
                                $('.st_ArticleThreadBlock__toggle').find('strong').text('Replies(' + data.count + ')');
                                $('#reply_div_' + $this.parent().data('postid')).remove();
                            }
                        });
                    }
                }
                $this.parent().hide();
            } else {
                var URL = $('#report_url').val();
                if ($('#login_user_id').val() == '') {
                    window.location.href = $('#login_url').val() + "?ru=" + window.location.href;
                } else {
                    $.ajax({
                        type: 'POST',
                        url: URL,
                        data: {post_id: $(this).parent().data('postid'), type: $(this).parent().data('type'), 'report': $(this).find('span').text()},
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            alert('Your report successfully submited.');
                        }
                    });
                }
            }
        });
        $(document).on("click", function (e) {
            if ($(e.target).is(".st_EventDetails__Item .dropdown .dropdown-menu.open-menu") === false) {
                $('.st_EventDetails__Item .dropdown .dropdown-menu.open-menu').removeClass('open-menu');
            }
        });
        if (window.File && window.FileList && window.FileReader) {
            $(document).on("change", "#addImage_input", function (e) {
                var $this = $(this);
                var files = e.target.files,
                        filesLength = files.length;
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i];
                    var fileReader = new FileReader();
                    fileReader.onload = (function (e) {
                        var file = e.target;
                        var html = '<figure class="styles_ImageManager__item__1SWp-">' +
                                '<img alt="' + file.name + '" class="styles_ImageManager__image__Sl_sH" src="' + e.target.result + '">' +
                                '<button class="styles_ImageManager__btn__1yH98 remove" type="button">' +
                                '<i class="fas fa-times"></i>' +
                                '</button>' +
                                '</figure>';
                        $('.append_preview-image').append(html).show();
                        $this.parent('label').hide();
                        $(".remove").click(function () {
                            $(this).parents("figure").remove();
                            $(".st_AddImageButton").show();
                            $("#addImage_input").val('');
                        });
                    });
                    fileReader.readAsDataURL(f);
                }
            });
        } else {
            alert("Your browser doesn't support to File API")
        }
        $(document).on("click", ".reply_btn1", function () {
            if ($('#login_user_id').val() == '') {
                window.location.href = $('#login_url').val() + "?ru=" + window.location.href;
            } else {
                $(this).parents(".st_Card").find(".comment_add_box").show();
                var html = '<form class="styles_ReplyForm__3YbUI styles_ReplyForm--floating__1Mv71 border_top" id="event_comment_form" enctype="multipart/form-data" method="POST" action="#" accept-charset="UTF-8">' +
                        '@csrf' +
                        '<input type="hidden" name="post_id" value="' + $(this).data('id') + '">' +
                        '<input type="hidden" name="user_id" value="{{Auth::id()}}">' +
                        '<input type="hidden" name="parent_id" value="' + $(this).data('id') + '">' +
                        '<div class="styles_ReplyForm__fieldContainer__3cNzb">' +
                        '<i class="fa fa-user-circle avatar-icon avatar-icon--base"></i>' +
                        '<label class="text-field text-field--no-border">' +
                        '<textarea class="text-field__input styles_TextEditor__l92NA styles_TextEditor--is-small__36ivx" name="message" id="replay_message-box" placeholder="Reply to this article" rows="4" spellcheck="false"></textarea>' +
                        '</label>' +
                        '</div>' +
                        '<div class="styles_ImageManager__1-nON append_preview-image" style="display: none;"></div>' +
                        '<footer class="styles_ReplyForm__footer__vKEul">' +
                        '<button class="styles_ReplyForm__cancel__1bzbN" type="button">Cancel</button>' +
                        '<label class="st_AddImageButton">' +
                        '<input accept="image/*" class="st_AddImageButton__input" id="addImage_input" name="images" type="file">' +
                        '<i class="fas fa-camera icon icon--space-right"></i>Add image' +
                        '</label>' +
                        '<button class="styles_ReplyForm__submit__11sYc" id="comment_replay-btn" type="button">Reply<i class="fas fa-spinner icon icon--space-left fa-spin loader" style="display: none;"></i></button>' +
                        '</footer>' +
                        '</form>';
                $(this).parents(".st_Card").find(".comment_add_box").find('.styles_ArticleThreadBlock__elevatedForm__38Z58').html(html);
                $(this).hide();
            }
        });
        $(document).on("click", "#comment_replay-btn", function () {
            if ($("#replay_message-box").val() == '') {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                };
                toastr.error("Your reply is too short.");
            } else {
                if ($('#login_user_id').val() == '') {
                    window.location.href = $('#login_url').val() + "?ru=" + window.location.href;
                } else {
                    $('.loader').show();
                    var formData = new FormData($("#event_comment_form")[0]);
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('add-neighbor-comment') }}",
                        data: formData,
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            $("#collapseReply_" + data.postid).prepend(data.body);
                            $("#event_comment_form").remove();
                            $(".compose-block").show();
                            $('.loader').hide();
                            toastr.options = {
                                "closeButton": true,
                                "progressBar": true
                            };
                            toastr.info("Your reply sent successfully.!");
                            $('.st_ArticleThreadBlock__toggle').find('strong').text('Replies(' + data.count + ')');
                            if ($('.st_ArticleThreadBlock__toggle').attr('aria-expanded') == 'false') {
                                $('.st_ArticleThreadBlock__toggle').trigger('click');
                            }
                        }
                    });
                }
            }
        });
        $(document).on('click', '.comment_reply', function () {
            var html = '<form class="styles_ReplyForm__3YbUI styles_ReplyForm--floating__1Mv71 border_top remove_form_'+$(this).data('postid')+'" id="event_comment_form" enctype="multipart/form-data" method="POST" action="#" accept-charset="UTF-8">' +
                    '@csrf' +
                    '<input type="hidden" name="post_id" value="' + $(this).data('nei') + '">' +
                    '<input type="hidden" name="user_id" value="{{Auth::id()}}">' +
                    '<input type="hidden" name="parent_id" value="' + $(this).data('postid') + '">' +
                    '<input type="hidden" name="reply_comment" value="1">' +
                    '<div class="styles_ReplyForm__fieldContainer__3cNzb">' +
                    '<i class="fa fa-user-circle avatar-icon avatar-icon--base"></i>' +
                    '<label class="text-field text-field--no-border">' +
                    '<textarea class="text-field__input styles_TextEditor__l92NA styles_TextEditor--is-small__36ivx" name="message" id="replay_message-box" placeholder="Reply to this article" rows="4" spellcheck="false"></textarea>' +
                    '</label>' +
                    '</div>' +
                    '<div class="styles_ImageManager__1-nON append_preview-image" style="display: none;"></div>' +
                    '<footer class="styles_ReplyForm__footer__vKEul">' +
                    '<button class="styles_ReplyForm__cancel__1bzbN" type="button" data-id="' + $(this).data('postid') + '">Cancel</button>' +
                    '<label class="st_AddImageButton">' +
                    '<input accept="image/*" class="st_AddImageButton__input" id="addImage_input" name="images" type="file">' +
                    '<i class="fas fa-camera icon icon--space-right"></i>Add image' +
                    '</label>' +
                    '<button class="styles_ReplyForm__submit__11sYc" data-id="' + $(this).data('postid') + '" id="comment_replay-btn2" type="button">Reply<i class="fas fa-spinner icon icon--space-left fa-spin loader" style="display: none;"></i></button>' +
                    '</footer>' +
                    '</form>';
            $('.remove_form_' + $(this).data('postid')).remove();
            $('.action_remove_' + $(this).data('postid')).after(html);
        });
        $(document).on("click", "#edit_replay-btn", function () {
            if ($("#edit_message-box").val() == '') {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                };
                toastr.error("Your reply is too short.");
            } else {
                var $this = $(this);
                var formData = {
                    'id': $(this).data('id'),
                    'comment': $("#edit_message-box").val()
                };
                $.ajax({
                    type: 'POST',
                    url: "{{ route('edit-article-comment') }}",
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        body = data.body;
                        $('.reply_' + $this.data('id')).append(data.body);
                        $('.reply_' + $this.data('id')).parent().parent().append(action_bar);
                        $this.parents('.styles_ReplyForm__3YbUI').remove();
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true
                        };
                        toastr.info("Your reply edit successfully.!");
                    }
                });
            }
        });
        $(document).on("click", "#comment_replay-btn2", function () {
            if ($("#comment_message-box").val() == '') {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                };
                toastr.error("Your reply is too short.");
            } else {
                if ($('#login_user_id').val() == '') {
                    window.location.href = $('#login_url').val() + "?ru=" + window.location.href;
                } else {
                    $('.loader').show();
                    var $this = $(this);
                    var formData = new FormData($("#event_comment_form")[0]);
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('add-neighbor-comment') }}",
                        data: formData,
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            $("#reply_div_" + $this.data('id')).append(data.body);
                            $("#replay_message-box").val('');
                            $(".compose-block").show();
                            $('.loader').hide();
                            toastr.options = {
                                "closeButton": true,
                                "progressBar": true
                            };
                            toastr.info("Your reply sent successfully.!");
                            $('.st_ArticleThreadBlock__toggle').find('strong').text('Replies(' + data.count + ')');
                            $this.parents('.styles_ReplyForm__3YbUI').remove();
                        }
                    });
                }
            }
        });
        $(document).on("click", ".styles_ReplyForm__cancel__1bzbN", function () {
            $('.reply_' + $(this).data('id')).append(body);
            $('.reply_' + $(this).data('id')).parent().parent().append(action_bar);
            $(this).parents('.styles_ReplyForm__3YbUI').remove();
            $(".compose-block").show();
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
            pauseOnHover: true,
            pauseOnFocus: true
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
        $(document).on('click', '.share-button', function () {
            $this = $(this);
            if (navigator.share) {
                navigator.share({
                    title: $this.data('title'),
                    url: "{{URL::to('/')}}" + $this.data('url') + '?utm_source=share-mobile&utm_medium=web&utm_campaign=share'
                }).then(() => {
                    console.log('Thanks for sharing!');
                })
                        .catch(console.error);
            }
        });
        $(document).on('click', '#load_more_button', function () {
            var id = $(this).data('id');
            var url = $(this).data('url');
            //console.log(id);
            $(this).html('<b>Loading...</b>');
            loadMoreData(id, url, 'loadData', $(this));
        });
        $(document).on('click', '#load_more_event_button', function () {
            var id = $(this).data('id');
            var url = $(this).data('url');
            //console.log(id);
            $(this).html('<b>Loading...</b>');
            loadMoreData(id, url, 'loadEventData', $(this));
        });
        $(document).on('click', '#load_more_classified_button', function () {
            var id = $(this).data('id');
            var url = $(this).data('url');
            //console.log(id);
            $(this).html('<b>Loading...</b>');
            loadMoreData(id, url, 'loadClassifiedData', $(this));
        });
        $(document).on('click', '#load_more_neighbour_button', function () {
            var id = $(this).data('id');
            var url = $(this).data('url');
            //console.log(id);
            $(this).html('<b>Loading...</b>');
            loadMoreData(id, url, 'neighbourLoadData', $(this));
        });
        $(document).on('click', '.like_button-post', function () {
            var URL = $('#like_url').val();
            var $this = $(this);
            if ($('#login_user_id').val() == '') {
                window.location.href = $('#login_url').val() + '?home=1';
            } else {
                $.ajax({
                    type: 'POST',
                    url: URL,
                    data: {post_id: $(this).data('postid'), type: $(this).data('type')},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        $this.html(data.html);
                    }
                });
            }
        });
        $(document).on('click', '.intrest_button-post', function () {
            var URL = $('#intrest_url').val();
            var $this = $(this);
            if ($('#login_user_id').val() == '') {
                window.location.href = $('#login_url').val() + '?home=1';
            } else {
                $.ajax({
                    type: 'POST',
                    url: URL,
                    data: {post_id: $(this).data('postid')},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        $this.html(data.html);
                    }
                });
            }
        });
        $(document).on('click', '.btn--link-base', function () {
            $(this).parents('.st_Card__TextContentWrapper').find('.st_Card__Body').toggleClass('st_Card__Body--Truncated');
            if ($(this).text() == 'Read more') {
                $(this).text('See less');
            } else {
                $(this).text('Read more');
            }
        });
    });
</script>
@endsection