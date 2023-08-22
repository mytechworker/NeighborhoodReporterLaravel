@extends('layouts.app')
@section('title')
{{(isset($info['edit'])?"Edit an Event":"Write an Event")}} | Neighborhood Reporter
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
                        <h5 class="EventPage_event__header__2LUUh">Edit your event</h5>
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
                                    <a class="nav-link active" id="pills-profile-tab" href="/{{sanitizeStringForUrl($info['location'])}}/{{sanitizeStringForUrl($info['town'])}}/compose/event" role="tab" aria-controls="pills-profile" aria-selected="false"> 
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
                            @endif
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <div class="EventFormContainer_formContainer">
                                        <form id="event-node-form" method="POST" action="{{(isset($info['edit'])?route('event-update'):route('event-store'))}}" enctype="multipart/form-data" accept-charset="UTF-8">
                                            @csrf
                                            <input type="hidden" name="id" value="{{(isset($info['edit'])?$info['id']:"")}}" />
                                            <div class="form__inner">
                                                <div class="" role="search">
                                                    <label class="text-field">
                                                        <div class="text-field__prepend"> <i class="text-field__icon fas fa-map-marker-alt"></i> </div>
                                                        <input autocomplete="off" class="text-field__input" name="community" id="community" placeholder="Town or Region code" required type="search" value="{{(isset($info['edit'])?$info['town'].','.$info['location']:getLocationLink(1))}}"> 
                                                    </label>
                                                </div>
                                                <input type="hidden" name="community_id" id="community_id">
                                                <div id="community_list"></div>
                                                <div class="st_DateTimeField">
                                                    <div class="DayPickerInput">
                                                        <label class="text-field">
                                                            <div class="datepicker date input-group">
                                                                <input type="text" placeholder="Date" autocomplete="off" class="form-control py-4 px-4" name="event_date" value="{{(isset($info['edit'])?\Carbon\Carbon::parse($info['date'])->format('M d Y'):old('event_date'))}}" required="" id="reservationDate">
                                                                <div class="input-group-append"></div>
                                                                <div class="text-field__prepend"><i class="text-field__icon fa fa-calendar-alt"></i></div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div class="st_DateTimeField__separator"></div>
                                                    <div class="timePicker_timePicker">
                                                        <i class="far fa-clock"></i>
                                                        <input id='timepicker' type='text' class="timepicker_start" name='timepicker' value="{{(isset($info['edit'])?\Carbon\Carbon::parse($info['time'])->format('h:i'):'09:00')}}" /> 
                                                        <input type="hidden" name="am_pm" class="am_pm" value="{{(isset($info['edit'])?$info['am_pm']:'AM')}}"/>
                                                    </div>
                                                    <div class="st_DateTimeField__btn-group">
                                                        <button class="st_DateTimeField__toggle {{(isset($info['edit']) && $info['am_pm'] == 'AM' ? "active-ampm" : "")}}" type="button">AM</button>
                                                        <button class="st_DateTimeField__toggle {{(isset($info['edit']) && $info['am_pm'] == 'PM' ? "active-ampm" : "")}}" type="button">PM</button>
                                                    </div>
                                                </div>
                                                <label class="text-field cus-in">
                                                    <input aria-label="Address" autocomplete="off" class="text-field__input pac-target-input" id="pac-input" name="eventAddress" value="{{(isset($info['edit'])?$info['venue']:old('eventAddress'))}}" required placeholder="Venue or Address" type="text">
                                                </label>
                                                <label class="text-field cus-in">
                                                    <input aria-label="Event Title" autocomplete="off" class="text-field__input" maxlength="100" name="eventTitle" value="{{(isset($info['edit'])?$info['title']:old('eventTitle'))}}" placeholder="Title" required="" type="text">
                                                </label>
                                                <textarea id="mytextarea" required="required" name="description" class="form-control col-md-10 col-xs-10">{{(isset($info['edit'])?$info['description']:old('description'))}}</textarea>
                                                <div>
                                                    <label class="text-field-new {{(isset($info['edit']) && $info['link'] != ''?'show':'')}}">
                                                        <input  class="text-field-input" name="link" style="border: 1px solid #ccc;" value="{{(isset($info['edit'])?$info['link']:old('link'))}}" placeholder="Link out to more info">
                                                    </label>
                                                </div>
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
                                                    <aside class="st_Footer__contentLeft" style="{{(isset($info['edit'])?'display: flex;flex-wrap: wrap;':'')}}">
                                                        @if(isset($info['edit']))
                                                        <a class="DeleteEventButton_deleteButton__3VPw1" href="{{ route('event.delete',$info->id) }}" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                                                        @endif
                                                        <button class="btn btn--link add-link" type="button" style="{{(isset($info['edit']) && $info['link'] != ''?'display: none;':'')}}">+ Add Link</button>
                                                        <button class="btn btn--link add-link remove-link {{(isset($info['edit']) && $info['link'] != ''?'remove-show':'')}}" type="button">- Remove Link</button>
                                                    </aside>
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
    function getTimepickiTime(obj) {
        var TimeValue = obj.val();
        var trimmedTimeValue = TimeValue.replace(/ /g, '');
        var resultSplit = trimmedTimeValue.split(':');
        return resultSplit;
    }
    jQuery(document).ready(function ($) {
        $(document).on('click', '.ProceedButton_proceedButton', function () {
            $('#timepicker').val($('.time').find('.timepicki-input').val() + ':' + $('.mins').find('.timepicki-input').val());
            $('form').submit();
        });
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
                        var html = '<figure class="styles_ImageManager__item__1SWp-">' +
                                '<img class="styles_ImageManager__image__Sl_sH" src="' + e.target.result + '">' +
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
            var title_length = $(this).val().length;
            $("#edit-title-counter").find('strong').text(65 - title_length);
        });
        $("#edit-dek").keyup(function () {
            var title_length = $(this).val().length;
            $("#edit-dek-counter").find('strong').text(140 - title_length);
        });
        $('#timepicker').timepicki({
            start_time: getTimepickiTime($('.timepicker_start')),
            overflow_minutes: true
        });

        $('[data-toggle="tooltip"]').tooltip();
        // add Link //
        $(".add-link").click(function () {
            $('.text-field-new').toggleClass('show');
            $('button.btn.btn--link.add-link.remove-link').addClass('remove-show');
            $(this).hide();
        });

        $("button.btn.btn--link.add-link.remove-link").click(function () {
            $(".add-link").show();
            $(this).removeClass('remove-show');
        });
        $(function () {
            // INITIALIZE DATEPICKER PLUGIN
            $('.datepicker').datepicker({
                clearBtn: true,
                format: "M dd yyyy",
                keepOpen: true,
                inline: true,
                debug: true,
                autoclose: true,
                startDate: new Date()
            });
        });
        // add Link end  //

        $(function () {
            $('.st_DateTimeField__toggle').click(function () {
                $('.st_DateTimeField__toggle.active-ampm').removeClass('active-ampm');
                $(this).addClass('active-ampm');
                $('.am_pm').val($(this).html());
            });
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