@extends('layouts.manageApp')
@section('title')
Write an article | Neighborhood Reporter
@endsection
@section('meta')
<!-- Primary Meta Tags -->
<meta name="title" content="Write an article | Neighborhood Reporter">
<meta name="description" content="Write an article | Neighborhood Reporter">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/add/article">
<meta property="og:title" content="Write an article | Neighborhood Reporter">
<meta property="og:description" content="Write an article | Neighborhood Reporter">
<meta property="og:image" content="{{asset('images/logo.png')}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/add/article">
<meta property="twitter:title" content="Write an article | Neighborhood Reporter">
<meta property="twitter:description" content="Write an article | Neighborhood Reporter">
<meta property="twitter:image" content="{{asset('images/logo.png')}}">
@endsection
@section('content')
<link rel="stylesheet" href="{{asset('css/dropzone.min.css')}}" />
<script src="{{asset('js/dropzone.min.js')}}"></script>
<style>
    .not_show_other_pages{display: none;}
    .back-white{background-color: #fff;}
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
    .dropzone .dz-preview .dz-image img {
        height: 120px;
        width: 120px;
    }
</style>
<div class="main-container container">
    <div class="row">
        <section class="col-sm-12 write_article">
            <h1 class="page-header">Write an article</h1>
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
                    <form class="user_profile_form" id="article-node-form" method="POST" action="{{(isset($info['edit'])?route('article-update'):route('article-store'))}}" accept-charset="UTF-8" novalidate>
                        @csrf
                        <input type="hidden" name="id" value="{{(isset($info['edit'])?$info['id']:"")}}" />
                        <div>
                            <div class="form-wrapper">
                                <div class="form-input-wrapper w-100">
                                    <a class="form-changer" href="/add/user-profile#js-preffered-patch">Change</a>
                                    <div class="form-type-textfield form-item-form-input form-disabled form-item form-group">
                                        <label for="edit-form-input">Neighborhood community</label>
                                        <input id="" placeholder="Town or ZIP code" autocomplete="off" class="rounded-left form-control form-text" value="{{(isset($info['edit'])?$info['town'].','.$info['location']:getLocationLink(1))}}" readonly="1" type="text" name="select_location_input" size="60" maxlength="128">
                                    </div>
                                </div>
                                <div id="autocomplete-results" class="select-canon-patch-list"></div>
                            </div>

                            <div class="item form-type-textfield form-item-title form-item form-group">
                                <label for="edit-title">Headline</label>
                                <input placeholder="Write headline" value="{{(isset($info['edit'])?$info['post_title']:old('post_title'))}}" name="post_title" class="form-control edit_text" type="text" id="edit-title" required="required" size="60" maxlength="65">
                                <div id="edit-title-counter" class="counter"><strong>65</strong> characters remaining</div>
                            </div>
                            <div class="item form-type-textarea form-item-dek form-item form-group">
                                <label for="edit-dek">Subheadline</label>
                                <div class="form-textarea-wrapper">
                                    <textarea placeholder="Write description" required class="form-control maxlength form-textarea maxlength-processed" maxlength="140" id="edit-dek" name="post_subtitle" cols="60" rows="3">{{(isset($info['edit'])?$info['post_subtitle']:old('post_subtitle'))}}</textarea>
                                    <div id="edit-dek-counter" class="counter"><strong>140</strong> characters remaining</div>
                                </div>
                            </div>
                            @php
                            $category = getCategory();
                            @endphp
                            <div class="field-type-number-integer field-name-field-category field-widget-number form-wrapper form-group" id="edit-field-category">
                                <div id="field-category-add-more-wrapper">
                                    <div class="item form-type-select form-item-field-category-und-0-value form-item form-group">
                                        <label for="edit-field-category-und-0-value">Category</label>
                                        <select class="form-control form-select" required id="edit-field-category-und-0-value" name="post_category">
                                            @foreach($category as $value)
                                            @if(isset($info['edit']))
                                            <option value="{{$value['category_name']}}" {{($info['post_category'] == $value['category_name']?"selected":"")}}>{{$value['category_name']}}</option>
                                            @else
                                            <option value="{{$value['category_name']}}" {{(old('post_category') == $value['category_name']?"selected":"")}}>{{$value['category_name']}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <label class="top-label-main-image">Main image(s)</label>
                            <div class="needsclick dropzone" id="document-dropzone">
                            </div>
                            <a href="javascript:void(0)" class="open-close primary-color" id="openclose_video" style="visibility:hidden;">
                                <span>More image &amp; video options</span>
                            </a>
                            <div class="wrapper-article-form" id="openclose_video_handling_open">
                                <div class="field-type-list-boolean field-name-field-image-handling field-widget-options-onoff form-wrapper form-group" id="edit-field-image-handling">
                                    <label>Display image(s) above article?</label>
                                    <div class="form-type-checkbox form-item-field-image-handling-und form-item checkbox">
                                        <input type="checkbox" id="edit-field-image-handling-und" name="field_image_handling[und]" value="1" checked="checked" class="form-checkbox">
                                        <label for="edit-field-image-handling-und">YES</label>
                                    </div>
                                </div>

                            </div>
                            <div class="field-type-text-with-summary field-name-body form-wrapper form-group" id="edit-body">
                                <div id="body-add-more-wrapper">
                                    <div class="text-format-wrapper">
                                        <div class="item form-type-textarea form-item-body-und-0-value form-item form-group">
                                            <label for="edit-body-und-0-value">Body text</label>
                                            <textarea id="mytextarea" required="required" name="post_content" class="form-control col-md-10 col-xs-10">{{(isset($info['edit'])?$info['post_content']:old('post_content'))}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="post_status" id="post_status">
                            <div class="form-actions form-wrapper form-group" id="edit-actions">
                                @if(isset($info['edit']) && $info['post_status'] == 'active')
                                <a class="btn-lg-max-300 btn-info rounded-pill btn" href="{{ route('article.delete',$info->id) }}" onclick="return confirm('Are you sure you want to permanently delete this article?')">Remove from site</a>
                                <button class="btn-lg-max-300 btn-go rounded-pill btn btn-default form-submit" category="article" trigger="Update now" id="edit-submit" name="op" value="Update now" type="button">Update now</button>
                                @else
                                <button category="article" trigger="Save as draft" class="btn-lg-max-300 btn-info rounded-pill btn form-submit" id="edit-draft" name="op" value="Save as draft" type="button">Save as draft</button>
                                <button class="btn-lg-max-300 btn-go rounded-pill btn btn-default form-submit" category="article" trigger="Post now" id="edit-submit" name="op" value="Post now" type="button">Post now</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </section>
                <!-- /.block -->
            </div>
        </section>
    </div>
</div>
<script type="text/javascript">
    var uploadedDocumentMap = {};
    var currentFile = null;
    function getFileSize(url) {
        var fileSize = '';
        var http = new XMLHttpRequest();
        http.open('HEAD', url, false); // false = Synchronous

        http.send(null); // it will stop here until this http request is complete

// when we are here, we already have a response, b/c we used Synchronous XHR

        if (http.status === 200) {
            fileSize = http.getResponseHeader('content-length');
        }

        return fileSize;
    }
    var myDropzone = Dropzone.options.documentDropzone = {
    url: "{{ route('dropzone.upload_image') }}",
            maxFilesize: 100, // MB
            addRemoveLinks: true,
            acceptedFiles: "image/*,video/*",
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (file, response) {
            $('form').append('<input type="hidden" name="images[]" value="' + response.name + '">')
                    uploadedDocumentMap[file.name] = response.name;
            },
            removedfile: function (file) {
            var name = '';
                    if (typeof file.file_name !== 'undefined') {
            name = file.file_name;
            } else {
            name = uploadedDocumentMap[file.name];
            }
            $.ajax({
            url: "{{ route('dropzone.delete_image') }}",
                    data: {name: name},
                    success: function (data) {
                    file.previewElement.remove();
                            $('form').find('input[name="images[]"][value="' + name + '"]').remove();
                    }
            })
            },
            init: function () {
            this.on("complete", function (file) {
            if (currentFile)
                    this.removeFile(currentFile);
                    currentFile = file;
            });
                    @if (isset($info['edit']) && isset($info['post_image']) && $info['post_image'] != '')
                    var file = {name: "{{$info->post_image}}", size: getFileSize("{{postgetImageUrl($info['post_image'],$info['created_at'])}}"), status: 'success'};
                    this.emit("addedfile", file);
                    file.previewElement.classList.add('dz-complete');
                    this.emit("thumbnail", file, "{{postgetImageUrl($info['post_image'],$info['created_at'])}}");
                    this.files.push(file);
                    $('form').append('<input type="hidden" name="images[]" value="' + "{{$info->post_image}}" + '">');
                    uploadedDocumentMap["{{$info->post_image}}"] = "{{$info->post_image}}";
                    currentFile = file;
                    @endif
            }
    };
    jQuery(document).ready(function (e) {
        $(document).on('click', '.form-submit', function () {
            var editorContent = tinymce.get('mytextarea').getContent();
            if (editorContent == '' || editorContent == null) {
                if (!$('#editor-error-message').length) {
                    $('#mytextarea').parents('.item').addClass('bad');
                    $('<div class="alert">This field is required.</div>').insertAfter($(tinymce.get('mytextarea').getContainer()));
                }
            } else {
                $("#post_status").val('active');
                if ($('#editor-error-message')) {
                    $('#editor-error-message').remove();
                }
                $('form').submit();
            }
        });
        $(document).on('click', '#edit-draft', function () {
            var editorContent = tinymce.get('mytextarea').getContent();
            if (editorContent == '' || editorContent == null) {
                if (!$('#editor-error-message').length) {
                    $('#mytextarea').parents('.item').addClass('bad');
                    $('<div class="alert">This field is required.</div>').insertAfter($(tinymce.get('mytextarea').getContainer()));
                }
            } else {
                $("#post_status").val('draft');
                if ($('#editor-error-message')) {
                    $('#editor-error-message').remove();
                }
                $('form').submit();
            }
        });
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