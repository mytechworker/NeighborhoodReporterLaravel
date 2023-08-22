@extends('layouts.app')
@section('title')
{{(isset($info['edit'])?"Edit a Classified":"Write a Classified")}} | Neighborhood Reporter
@endsection
@section('content')
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
        height: 300px !important;
    }
    .EventPage_event__2oGKg {
        max-width: 600px;
        margin: 0 auto;
    }
    .EventPage_event__header__2LUUh{
        margin-bottom: 0;
    }
    .DeleteEventButton_deleteButton__3VPw1 {
        color: #e02020;
        border-radius: 30px;
        border: 1px solid #e02020;
        padding: 6px 8px;
        cursor: pointer;
        margin: 0 6px;
    }
    .DeleteEventButton_deleteButton__3VPw1:hover{
        color: #e02020;
        border: 1px solid #e02020;
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
                    <div class="EventPage_event__2oGKg">
                        @if(isset($info['edit']))
                        <h5 class="EventPage_event__header__2LUUh">Edit your classified</h5>
                        @endif
                        <div class="ask-sec">
                            @if(!isset($info['edit']))
                            <ul class="nav nav-pills st_Header" id="pills-tab" role="tablist">
                                <li class="nav-item-tab">
                                    <a class="nav-link" id="pills-home-tab" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose" role="tab" aria-controls="pills-home" aria-selected="true"> 
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
                                    <a class="nav-link active" id="pills-contact-tab" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/classified" role="tab" aria-controls="pills-contact" aria-selected="false"> 
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
                            @endif
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                    <div class="EventFormContainer_formContainer Classified-form">
                                        <form id="event-node-form" method="POST" action="{{(isset($info['edit'])?route('classified-update'):route('classified-store'))}}" enctype="multipart/form-data" accept-charset="UTF-8">
                                            @csrf
                                            <input type="hidden" name="id" value="{{(isset($info['edit'])?$info['id']:"")}}" />
                                            <div class="form__inner">
                                                <div class="classified_location" role="search">
                                                    <label class="text-field">
                                                        <div class="text-field__prepend"> <i class="text-field__icon fas fa-map-marker-alt"></i> </div>
                                                        <input aria-label="Find a community on Patch by entering a town name or ZIP code" id="community" readonly autocomplete="off" class="text-field__input" name="community" value="{{getLocationLink(1)}}" required="" type="text"> 
                                                    </label>
                                                    <label class="icon-input">
                                                        <i class="fas fa-check"></i>
                                                    </label>
                                                </div>
                                                <?php
                                                $categoryArray = array('Announcements', 'For Sale', 'Free Stuff', 'Gigs & Services', 'Housing', 'Job Listing', 'Lost & Found', 'Other');
                                                ?>
                                                <div class="text-field cus-in cus-select-main">
                                                    <div class="custom-select-11">
                                                        <select class="form-control form-select" required="true" id="edit-field-category-und-0-value" name="category">
                                                            @foreach($categoryArray as $key => $value)
                                                            @if(isset($info['edit']))
                                                            <option value="{{$value}}" {{($info['category'] == $value?"selected":"")}}>{{$value}}</option>
                                                            @else
                                                            <option value="{{$value}}" {{(old('post_category') == $value?"selected":"")}}>{{$value}}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <label class="text-field cus-in">
                                                    <input aria-label="Classified Title" autocomplete="off" class="text-field__input" maxlength="100" name="classifiedTitle" placeholder="Title" required="" type="text" value="{{(isset($info['edit'])?$info['title']:old('classifiedTitle'))}}"> 
                                                </label>
                                                <textarea id="mytextarea" name="description" class="form-control col-md-10 col-xs-10">{{(isset($info['edit'])?$info['description']:old('description'))}}</textarea>                                            
                                                <div class="styles_ImageManager__1-nON append_preview-image" style="display: {{(isset($info['edit']) && $info['image'] != ''?"flex":"none")}};">
                                                    @if(isset($info['edit']) && $info['image'] != '')
                                                    <figure class="styles_ImageManager__item__1SWp-">
                                                        <img class="styles_ImageManager__image__Sl_sH" src="{{postgetImageUrl($info['image'],$info['created_at'])}}">
                                                        <button class="styles_ImageManager__btn__1yH98 remove" type="button">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </figure>
                                                    @endif
                                                </div>
                                                <footer class="st_Footer">
                                                    @if(isset($info['edit']))
                                                    <aside class="st_Footer__contentLeft" style="display: flex;flex-wrap: wrap;">
                                                        <a class="DeleteEventButton_deleteButton__3VPw1" href="{{ route('classified.delete',$info->id) }}" onclick="return confirm('Are you sure you want to delete this classified?')">Delete</a>
                                                    </aside>
                                                    @endif
                                                    <aside class="st_Footer__contentRight">
                                                        <label class="AddImageButton_addImageButton">
                                                            <input accept="image/*" class="AddImageButton_addImageButton__input" id="addImage_input" name="images" type="file">
                                                            <i class="fas fa-camera icon icon--space-right"></i>Add image
                                                        </label>
                                                        <button class="ProceedButton_proceedButton" type="submit">{{(isset($info['edit'])?"Update":"Post")}}</button>
                                                    </aside>
                                                </footer>
                                            </div>
                                        </form>
                                    </div>
                                </div>

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
                        $('.append_preview-image').html('').append(html).show();
                        $this.parent('label').hide();
                        $(".remove").click(function () {
                            $(this).parents("figure").remove();
                            $('.append_preview-image').hide();
                            $(".AddImageButton_addImageButton").show();
                        });
                    });
                    fileReader.readAsDataURL(f);
                }
            });
        } else {
            alert("Your browser doesn't support to File API")
        }


        $(".st_FlagMenu .dropdown-toggle").click(function () {
            $(this).find(".flag-menu ul.dropdown-menu.dropdown-menu-right").toggle();
        });

        
        $(".secondary-nav__list-item").click(function () {
            $(this).find('.secondary-nav__menu').toggleClass('show');
        });
        $(document).on("click", ".header-hamburger-btn", function () {
            $(".h-hamburger-line").toggleClass('hamburger__line--open');
            $(".mob-menu").toggleClass("show-mob-menu");
            $('.header').toggleClass('header--fixed');
            $('.header').removeClass("header--sticky-full");
            $('.header').removeClass("header--sticky-condensed");
            $('body').toggleClass("over-class");
        });
    });
</script>
@endsection