@extends('layouts.app')
@section('title')
{{(isset($info['edit'])?"Edit your business post":"Post a bizpost on Neighborhood Reporter")}}
@endsection
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
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
    .text-field__input{
        padding: 0;
    }
    .styles_ImageManager__image__Sl_sH {
        max-height: 115px;
    }
    .styles_ImageManager__item__div{
        position: relative;
        margin: 0 auto;
        height: 100%;
        width: -moz-fit-content;
        width: fit-content;
        padding: 20px 0;
    }
    .styles_ImageManager__1-nON {
        border-bottom: 1px solid #e9e9e9;
        display: block;
        padding: 16px;
        height: 180px;
        text-align: center;
        padding: 10px 0;
        border-bottom: 1px solid #ccc;
        color: #a8a8a8;
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
                        <h5 class="EventPage_event__header__2LUUh">Edit your business post</h5>
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
                                    <a class="nav-link" id="pills-contact-tab" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/classified" role="tab" aria-controls="pills-contact" aria-selected="false"> 
                                        <i class="fa fa-clipboard-list icon icon--space-right-sm"></i> 
                                        <span class="styles_Tab__Label--Hidden__3L3Mh">Classified</span> 
                                    </a>
                                </li>
                                <li class="nav-item-tab">
                                    <a class="nav-link active" id="pills-contact-tab" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/bizpost" role="tab" aria-controls="pills-contact" aria-selected="false"> 
                                        <i class="fa fa-award icon icon--space-right-sm"></i> 
                                        <span class="styles_Tab__Label--Hidden__3L3Mh">Feature My Business</span> 
                                    </a>
                                </li>
                            </ul>
                            @endif
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <div class="EventFormContainer_formContainer">
                                        <form id="event-node-form" method="POST" action="{{(isset($info['edit'])?route('bizpost-update'):route('bizpost-store'))}}" enctype="multipart/form-data" accept-charset="UTF-8">
                                            @csrf
                                            <input type="hidden" name="id" value="{{(isset($info['edit'])?$info['id']:"")}}" />
                                            <div class="form__inner">
                                                <label class="text-field cus-in">
                                                    <input autocomplete="off" class="text-field__input pac-target-input" required name="bussinessName" placeholder="Business name:" type="text" value="{{(isset($info['edit'])?$info['business_name']:old('bussinessName'))}}"> 
                                                </label>
                                                <?php
                                                $categoryArray = array('Advertising', 'Agriculture', 'Apparel', 'Automotive', 'Aviation', 'Biotech and Biomedical', 'Civil Engineering', 'Construction', 'Defense', 'Education', 'Entertainment', 'Environmental Services', 'Financial', 'Food', 'Healthcare', 'Home Repair', 'Hospitality', 'Information Services', 'Legal Services', 'Logistics and Transportation', 'Management Consulting', 'Manufacturing', 'Mechanical and Industrial Engineering', 'Media', 'Metals', 'Non-Profit Organizations', 'Other', 'Pharmaceutical', 'Power and Energy', 'Publishing', 'Real Estate', 'Retail', 'Technology', 'Telecommunications');
                                                ?>
                                                <div class="text-field cus-in cus-select-main">
                                                    <div class="custom-select-11">
                                                        <select class="form-control form-select" required="true" id="edit-field-category-und-0-value" name="business_category">
                                                            @foreach($categoryArray as $key => $value)
                                                            @if(isset($info['edit']))
                                                            <option value="{{$value}}" {{($info['business_category'] == $value?"selected":"")}}>{{$value}}</option>
                                                            @else
                                                            <option value="{{$value}}" {{(old('business_category') == $value?"selected":"")}}>{{$value}}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="" role="search">
                                                    <label class="text-field">
                                                        <div class="text-field__prepend"> <i class="text-field__icon fas fa-map-marker-alt"></i> </div>
                                                        <input autocomplete="off" class="text-field__input" name="community" id="community" placeholder="Town or Region code" required type="search" value="{{(isset($info['edit'])?$info['town'].','.$info['location']:getLocationLink(1))}}"> 
                                                    </label>
                                                </div>
                                                <input type="hidden" name="community_id" id="community_id">
                                                <div id="community_list"></div>
                                                <label class="text-field cus-in limit-text">
                                                    <input class="text-field__input pac-target-input" id="edit-title" required maxlength="60" name="headline" placeholder="Headline - Share promos, coupons or a tag line about your business" type="text" value="{{(isset($info['edit'])?$info['headline']:old('headline'))}}"> 
                                                    <ul dir="ltr" class="redactor-statusbar"><li><span>{{(isset($info['edit'])?strlen($info['headline']):"0")}}</span>/60 character max</li></ul>
                                                </label>

                                                <label class="text-field cus-in business-input limit-text input-title">
                                                    <textarea name="description" id="edit-dek" required placeholder="Business description - tell readers more about your business" maxlength="2000" rows="6"  class="text-field__input pac-target-textarea">{{(isset($info['edit'])?$info['message_to_reader']:old('description'))}}</textarea>
                                                    <ul dir="ltr" class="redactor-statusbar"><li><span>{{(isset($info['edit'])?strlen($info['message_to_reader']):"0")}}</span>/2000 character max</li></ul>
                                                </label>
                                                <section>
                                                    <div class="ContactsSection__header">Contact information</div>
                                                    <label class="text-field cus-in">
                                                        <input required class="text-field__input pac-target-input" id="phone" name="phoneNumber" placeholder="Phone (e.g., 2125550000):" type="tel" value="{{(isset($info['edit'])?$info['phone']:old('phoneNumber'))}}"> 
                                                    </label>
                                                    <label class="text-field cus-in">
                                                        <input aria-label="Business URL" required autocomplete="off" class="text-field__input pac-target-input" name="website" placeholder="Website (e.g., http://www.neighborhoodreporter.com):" type="url" value="{{(isset($info['edit'])?$info['website']:old('website'))}}"> 
                                                    </label>
                                                    <label class="text-field cus-in">
                                                        <input autocomplete="off" required class="text-field__input pac-target-input" id="pac-input" name="address" placeholder="Address" type="search" value="{{(isset($info['edit'])?$info['address']:old('address'))}}"> 
                                                    </label>
                                                    <div class="styles_ImageManager__1-nON main_preview-image" style="display: {{(isset($info['edit']) && $info['image'] != ''?"block":"none")}};">
                                                        @if(isset($info['edit']) && $info['image'] != '')
                                                        Main image preview
                                                        <div class="styles_ImageManager__item__div">
                                                            <figure class="styles_ImageManager__item__1SWp-">
                                                                <img class="styles_ImageManager__image__Sl_sH" src="{{postgetImageUrl($info['image'],$info['created_at'])}}">
                                                                <button class="styles_ImageManager__btn__1yH98 remove" type="button">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </figure>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="styles_ImageManager__1-nON header_preview-image" style="display: {{(isset($info['edit']) && $info['header_image'] != ''?"block":"none")}};">
                                                        @if(isset($info['edit']) && $info['header_image'] != '')
                                                        Header image preview
                                                        <div class="styles_ImageManager__item__div">
                                                            <figure class="styles_ImageManager__item__1SWp-">
                                                                <img class="styles_ImageManager__image__Sl_sH" src="{{postgetImageUrl($info['header_image'],$info['created_at'])}}">
                                                                <button class="styles_ImageManager__btn__1yH98 remove" type="button">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </figure>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <footer class="st_Footer">
                                                        @if(isset($info['edit']))
                                                        <aside class="st_Footer__contentLeft" style="display: flex;flex-wrap: wrap;">
                                                            <a class="DeleteEventButton_deleteButton__3VPw1" href="{{ route('bizpost.delete',$info->id) }}" onclick="return confirm('Are you sure you want to delete this business post?')">Delete</a>
                                                        </aside>
                                                        @endif
                                                        <aside class="st_Footer__contentRight">
                                                            <label class="AddImageButton_addImageButton header_image">
                                                                <input accept="image/*" class="AddImageButton_addImageButton__input" name="header_images" id="addHeaderImage_input" type="file">
                                                                <i class="fas fa-camera icon icon--space-right"></i>Add Header Image
                                                            </label>
                                                            <label class="AddImageButton_addImageButton main_image">
                                                                <input accept="image/*" class="AddImageButton_addImageButton__input" name="main_images" id="addImage_input" type="file">
                                                                <i class="fas fa-camera icon icon--space-right"></i>Add image
                                                            </label>
                                                            <button class="ProceedButton_proceedButton" type="submit">{{(isset($info['edit'])?"Update":"Post")}}</button>
                                                        </aside>
                                                    </footer>
                                                </section>
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
        var phones = [{"mask": "(###) ###-####"}];
        $('#phone').inputmask({
            mask: phones,
            greedy: false,
            definitions: {'#': {validator: "[0-9]", cardinality: 1}}});
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
                        var html = 'Main image preview<div class="styles_ImageManager__item__div"><figure class="styles_ImageManager__item__1SWp-">' +
                                '<img alt="' + file.name + '" class="styles_ImageManager__image__Sl_sH" src="' + e.target.result + '">' +
                                '<button class="styles_ImageManager__btn__1yH98 remove" type="button">' +
                                '<i class="fas fa-times"></i>' +
                                '</button>' +
                                '</figure></div>';
                        $('.main_preview-image').html('').append(html).show();
                        $this.parent('label').hide();
                        $(".remove").click(function () {
                            $(this).parents("figure").remove();
                            $('.main_preview-image').hide();
                            $(".main_image").show();
                        });
                    });
                    fileReader.readAsDataURL(f);
                }
            });
            $("#addHeaderImage_input").on("change", function (e) {
                var $this = $(this);
                var files = e.target.files,
                        filesLength = files.length;
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i];
                    var fileReader = new FileReader();
                    fileReader.onload = (function (e) {
                        var file = e.target;
                        var html = 'Header image preview<div class="styles_ImageManager__item__div"><figure class="styles_ImageManager__item__1SWp-">' +
                                '<img alt="' + file.name + '" class="styles_ImageManager__image__Sl_sH" src="' + e.target.result + '">' +
                                '<button class="styles_ImageManager__btn__1yH98 header_remove" type="button">' +
                                '<i class="fas fa-times"></i>' +
                                '</button>' +
                                '</figure></div>';
                        $('.header_preview-image').html('').append(html).show();
                        $this.parent('label').hide();
                        $(".header_remove").click(function () {
                            $(this).parents("figure").remove();
                            $('.header_preview-image').hide();
                            $(".header_image").show();
                        });
                    });
                    fileReader.readAsDataURL(f);
                }
            });
        } else {
            alert("Your browser doesn't support to File API")
        }
        $(document).on('click', '.list-group-item', function () {
            var value = $(this).text();
            var cid = $(this).data('id');
            $('#community').val(value);
            $('#community_id').val(cid);
            $('#community_list').html("");
        });

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
        $("#edit-title").keyup(function () {
            $(this).parent().find(".redactor-statusbar").find('span').text($(this).val().length);
        });
        $("#edit-dek").keyup(function () {
            $(this).parent().find(".redactor-statusbar").find('span').text($(this).val().length);
        });

    });

    function initMap() {
        const input = document.getElementById("pac-input");
        const options = {
            componentRestrictions: {country: "us"}
        };
        const autocomplete = new google.maps.places.Autocomplete(input, options);
        // Set initial restriction to the greater list of countries.
        autocomplete.setComponentRestrictions({
            country: ["us", "pr", "vi", "gu", "mp"]
        });
        const southwest = {lat: 5.6108, lng: 136.589326};
        const northeast = {lat: 61.179287, lng: 2.64325};
        const newBounds = new google.maps.LatLngBounds(southwest, northeast);
        autocomplete.setBounds(newBounds);
        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();
            if (!place.geometry || !place.geometry.location) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            let address = "";
            if (place.address_components) {
                address = [
                    (place.address_components[0] &&
                            place.address_components[0].short_name) ||
                            "",
                    (place.address_components[1] &&
                            place.address_components[1].short_name) ||
                            "",
                    (place.address_components[2] &&
                            place.address_components[2].short_name) ||
                            "",
                ].join(" ");
            }
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBv5K3bTbjxjv_4QsspbSpZI6CHvxPPVsc&callback=initMap&libraries=places"></script>
@endsection