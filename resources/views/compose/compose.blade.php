@extends('layouts.app')
@section('title')
Write a Neighbor Post | Neighborhood Reporter
@endsection
@section('content')
<link rel="stylesheet" href="{{asset('css/dropzone.min.css')}}" />
<script src="{{asset('js/dropzone.min.js')}}"></script>
<style>
    .not_show_other_pages{display: none;}
    .bad .alert {
        padding: 0;
        color: #d22500;
    }
    .bad input,
    .bad textarea,
    .bad .tox{
        background-color: #ff000021;
        border: 1px solid #d22500 !important;
        box-shadow: 0px 0px 6px 3px #d2250040;
    }
    div#custome-validation.bad input {
        box-shadow: unset;
    }
    div#custome-validation.bad {
        background-color: #ff5f5f;
        padding: 8px;
        border-radius: 8px;
    }
    .tox.tox-tinymce {
        height: 450px !important;
    }
</style>
<div class="main-container container">
    <div class="row">
        <section class="col-sm-12 write_article">
            <div class="region region-content">
                <section>
                    <div class="col-md-12 col-sm-12 col-xs-12">
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
                    </div>
                    <div class="ask-sec">
                        <ul class="nav nav-pills st_Header" id="pills-tab" role="tablist">
                            <li class="nav-item-tab">
                                <a class="nav-link active" id="pills-home-tab" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose" role="tab" aria-controls="pills-home" aria-selected="true"> 
                                    <i class="fas fa-pencil-alt icon icon--space-right-sm"></i> 
                                    <span class="">Neighbor Post</span>
                                </a>
                            </li>
                            <li class="nav-item-tab">
                                <a class="nav-link" id="pills-profile-tab" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/event" role="tab" aria-controls="pills-profile" aria-selected="false"> 
                                    <i class="fa fa-calendar-alt icon icon--space-right-sm"></i> 
                                    <span class="styles_Tab__Label--Hidden__3L3Mh">Event</span> 
                                </a>
                            </li>
                            <li class="nav-item-tab">
                                <a class="nav-link" id="pills-contact-tab" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/classified" role="tab" aria-controls="pills-contact" aria-selected="false"> 
                                    <i class="fa fa-clipboard-list icon icon--space-right-sm"></i> 
                                    <span class="styles_Tab__Label--Hidden__3L3Mh">Classified</span> 
                                </a>
                            </li>
                            <li class="nav-item-tab">
                                <a class="nav-link" id="pills-contact-tab" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/bizpost" role="tab" aria-controls="pills-contact" aria-selected="false"> 
                                    <i class="fa fa-award icon icon--space-right-sm"></i> 
                                    <span class="styles_Tab__Label--Hidden__3L3Mh">Feature My Business</span> 
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <form class="NeighborPostForm-NeighborPostForm" method="POST" action="{{ route('neighbor-store') }}" enctype="multipart/form-data" accept-charset="UTF-8">
                                    @csrf
                                    <input type="hidden" name="location" id="location" value="{{$info['location']}}">
                                    <input type="hidden" name="town" id="town" value="{{$info['town']}}">
                                    <div class="st_Wrapper">
                                        <div class="st_Header">
                                            <h5 class="st_Header__title">The rules of posting:</h5>
                                            <button type="button" class="st_Header__closeButton" id="header_rules-btn"> <i class="fa fa-times icon icon--space-left styles_Header__closeIcon"></i></button>
                                        </div>
                                        <ul class="fa-ul st_List">
                                            <li class="st_List__item">
                                                <span class="fa-li">
                                                    <i class="fa fal fa-check"></i>
                                                </span>
                                                <strong class="st_List__emphasizedText">Be respectful.</strong> This is a space for friendly local discussions. No racist, discriminatory, vulgar or threatening language will be tolerated.
                                            </li>
                                            <li class="st_List__item"><span class="fa-li"><i class="fa fal fa-check"></i></span><strong class="st_List__emphasizedText">Be transparent.</strong> Use your real name, and back up your claims.</li>
                                            <li class="st_List__item"><span class="fa-li"><i class="fa fal fa-check"></i></span><strong class="st_List__emphasizedText">Keep it local.</strong> Be sure to have a local angle.</li>
                                            <li class="st_List__item"><span class="fa-li"><i class="fa fal fa-check"></i></span><strong class="st_List__emphasizedText">Keep it non-promotional.</strong> You can post promotions as an <a href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/event">Event</a> or <a href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/classified">Classified</a>.</li>
                                            <li class="st_List__item"><span class="fa-li"><i class="fa fal fa-check"></i></span>Review the <a href="{{url('community-guidelines')}}">Neighborhood Reporter Community Guidelines</a></li>
                                        </ul>
                                    </div>
                                    <div class="NeighborPostForm_NeighborPostForm__Inputs">
                                        <div class="NeighborPostForm_NeighborPostForm__EditorWrapper"><i class="fa fa-user-circle avatar-icon"></i>
                                            <label class="text-field text-field--no-border">
                                                <textarea class="text-field__input st_TextEditor" name="post_content" placeholder="Ask a question or share local news" rows="6"></textarea>
                                            </label>
                                        </div>
                                        <div class="st_CategoryOptions__CategoryButtonWrapper">
                                            <button type="button" class="btn st_CategoryOptions__CategoryButton">Question</button>
                                            <button type="button" class="btn st_CategoryOptions__CategoryButton">News Tip</button>
                                            <button type="button" class="btn st_CategoryOptions__CategoryButton">Recommendation</button>
                                            <button type="button" class="btn st_CategoryOptions__CategoryButton">Opinion</button>
                                        </div>
                                        <div class="styles_ImageManager__1-nON append_preview-image" style="display: none;">

                                        </div>
                                    </div>
                                    <div class="st_Footer">
                                        <label class="st_AddImageButton">
                                            <input accept="image/*" class="st_AddImageButton__input" id="addImage_input" name="images" type="file">
                                            <i class="fas fa-camera icon icon--space-right"></i>Add image
                                        </label>
                                        <button class="st_SubmitButton" type="submit">Post</button>
                                    </div>
                                </form> 
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /.block -->
            </div>
        </section>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function ($) {
    if (window.File && window.FileList && window.FileReader) {
        $("#addImage_input").on("change", function (e) {
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
                    $(".remove").click(function () {
                        $(this).parents("figure").remove();
                    });
                });
                fileReader.readAsDataURL(f);
            }
        });
    } else {
        alert("Your browser doesn't support to File API")
    }
    $(document).on('click', '#header_rules-btn', function () {
        $(this).parents('.st_Wrapper').hide();
    });
    $(".st_FlagMenu .dropdown-toggle").click(function () {
        $(this).find(".flag-menu ul.dropdown-menu.dropdown-menu-right").toggle();
    });
    $(document).on("click", ".header-hamburger-btn", function () {
        $(".h-hamburger-line").toggleClass('hamburger__line--open');
        $(".mob-menu").toggleClass("show-mob-menu");
        $('.header').toggleClass('header--fixed');
        $('.header').removeClass("header--sticky-full");
        $('.header').removeClass("header--sticky-condensed");
        $('body').toggleClass("over-class");
    });

    $(".secondary-nav__list-item").click(function () {
        $(this).find('.secondary-nav__menu').toggleClass('show');
    });
// Text Editor //

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
    $('#openclose_video').click(function () {
        $('#openclose_video_handling_open').toggle();
    });
    $("#edit-title").keyup(function () {
        var title_length = $(this).val().length;
        $("#edit-title-counter").find('strong').text(65 - title_length);
    });
    $("#edit-dek").keyup(function () {
        var title_length = $(this).val().length;
        $("#edit-dek-counter").find('strong').text(140 - title_length);
    });
});

</script>
@endsection