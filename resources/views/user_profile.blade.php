@extends('layouts.app')
@section('title')
Manage Profile | My Neighborhood Reporter
@endsection
@section('meta')
<!-- Primary Meta Tags -->
<meta name="title" content="Manage Profile | My Neighborhood Reporter">
<meta name="description" content="Manage Profile | My Neighborhood Reporter">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/add/user-profile">
<meta property="og:title" content="Manage Profile | My Neighborhood Reporter">
<meta property="og:description" content="Manage Profile | My Neighborhood Reporter">
<meta property="og:image" content="{{asset('images/logo.png')}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/add/user-profile">
<meta property="twitter:title" content="Manage Profile | My Neighborhood Reporter">
<meta property="twitter:description" content="Manage Profile | My Neighborhood Reporter">
<meta property="twitter:image" content="{{asset('images/logo.png')}}">
@endsection
<style>
    .user-img img {
        border-radius: 50%;
        width: 80px;
        height: 80px;
    }

    .user-profile-card-link.user-profile {
        top: 0px;
    }
    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }

    .btn-11 {
        border:none;
        color: gray;
        font-size: 16px;
        background-color: white;
        padding: 8px 20px;
        font-size: 20px;
        font-weight: normal;
        color: #fff;
        background-color: #d20000;
        border-color: #d20000;
    }

    .upload-btn-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
    }
    .back-white{
        background-color: white;
    }
</style>
@section('content')

<div class="container-wrap">
    <div class="main-container container user_profile_wrapper">
        <div class="row">
            <section class="col-sm-12">
                <grammarly-extension data-grammarly-shadow-root="true" style="position: absolute; top: 0px; left: 0px; pointer-events: none;" class="cGcvT">
                </grammarly-extension>
                <grammarly-extension data-grammarly-shadow-root="true" style="mix-blend-mode: darken; position: absolute; top: 0px; left: 0px; pointer-events: none;" class="cGcvT"></grammarly-extension>
                <h1 class="page-header">Manage Profile</h1>
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
                <div class="region region-content">
                    <section id="" class="">
                        <form class="user_profile_form" method="post" action="{{ route('update-user') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$data['id']}}">
                            <div>
                                <section class="align-items-center d-flex flex-column mb-3 position-relative shadow rounded text-center user-profile-card">
                                    <a class="align-items-center d-flex flex-column position-relative py-3 text-dark user-profile-card-link w-100 user-profile" target="_blank" href="{{route('view_profile')}}">
                                        <aside class="position-absolute text-success user-profile-card-external">
                                            <span class="fas fa fa-external-link-alt"></span>
                                        </aside>
                                        <section class="px-4 w-100 profile-img-container">
                                            @if(Auth::user()->profile_image == '')
                                            <span class="fa fa-user-circle fa-5x display-2 mx-auto rounded-circle text-success w-100"></span>
                                            @elseif (Auth::user()->profile_image && (substr(Auth::user()->profile_image, 0, 7) == "http://" || substr(Auth::user()->profile_image, 0, 8) == "https://"))
                                            <div class="user-img">
                                                <img class="avatar-icon" src="{{ Auth::user()->profile_image }}" alt="{{ Auth::user()->name }}"/>
                                            </div>
                                            @else
                                            <div class="user-img">
                                                <img class="avatar-icon" src="{{asset('images/'.Auth::user()->profile_image)}}" />
                                            </div>
                                            @endif
                                        </section>
                                    </a>


                                    <section class="px-4 w-100">
                                        <p class="mt-1 h4"><strong>{{$data['name']}}</strong></p>
                                        <p class="mb-0 text-capitalize">Neighbor</p>
                                    </section>
                                    <section class="p-4 user-profile-card-links w-100 "><a href="{{route('view_profile')}}" class="d-block" target="_blank"><span class="fas fa fa-user-circle"></span><span class="ml-2">View my profile on Neighborhood Reporter</span></a><a href="{{url('update-password')}}" class="mt-2 d-block"><span class="fas fa fa-key"></span><span class="ml-2">Change password</span></a></section>
                                </section>
                                <div class="denotes-required small text-danger"><b>*</b> denotes required field
                                </div>
                                <section id="js-preffered-patch" class="mb-4">
                                    <label>
                                        Home Community
                                        <span title="This field is required." class="form-required">*</span></label>
                                    <section class="w-100">
                                        <section class="position-relative">
                                            <section class="border border-grey d-flex overflow-hide rounded">
                                                <input required="required" id="community" name="community" value="{{$data['town']}}" placeholder="Your town or ZIP code" type="text" class="form-control border-0 required rounded"><label class="align-items-center d-flex justify-content-center m-0 px-4 rounded-0"><span class="fal fa fa-check text-primary"></span></label>
                                            </section>
                                            <div id="community_list"></div>
                                            <!---->
                                        </section>
                                        <!---->
                                    </section>
                                    <p class="mt-2 mb-0 small"><i> You are allowed to change your Home Community
                                            once every 7 days. If you change it, you'll receive email updates
                                            about your new community. <a href="/settings/email">Adjust your
                                                email setting here</a></i></p>
                                </section>
                                <div class="form-wrapper form-group" id=""><input class="input-lg" type="hidden" value="123"></div>
                                <div class="form-item-title form-item form-group">
                                    <label for="edit-title">Email Login <span class="form-required" title="This field is required.">*</span></label>
                                    <input class="form-control form-text required" type="text" id="edit-title" name="email" value="{{$data['email']}}" size="60" maxlength="255">
                                </div>
                                <input type="hidden" name="changed" value="">
                                <input type="hidden" name="form_build_id" value="form-gUHhxUVcReurgLsWR31TB9x6g1awtlnXrNdFGb-fHRw">
                                <input type="hidden" name="form_id" value="user_profile_node_form">
                                <input type="hidden" name="form_patch_token" value="FDm3XyiJvu4ldv_HGKAt6DjjsizEKwXUmrMFDX8VP64">
                                <p class="move-up"><i class="fa fa-check text-cta fa-lg bold" aria-hidden="true"></i> Verified email address</p>
                                <div class="soft-hide form-wrapper form-group" id="">
                                    <div id="field-role-add-more-wrapper">
                                        <div class="form-type-textfield form-item-field-role-und-0-value form-disabled form-item form-group">
                                            <label for="edit-field-role-und-0-value">Role </label>
                                            <input class="text-full form-control form-text" disabled="disabled" type="text" id="edit-field-role-und-0-value" name="field_role[und][0][value]" value="patch poster" size="60" maxlength="255">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-wrapper form-group" id="">
                                    <div id="">
                                        <div class="form-group">
                                            <label for="">First and Last Name <span class="form-required" title="This field is required.">*</span></label>
                                            <input class="text-full form-control form-text required" type="text" id="" name="username" value="{{$data['name']}}" size="60" maxlength="50">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-wrapper form-group" id="edit-field-phone">
                                    <div id="">
                                        <div class="form-group">
                                            <label for="">Phone </label>
                                            <input class="text-full form-control form-text" placeholder="###-###-####" type="text" id="edit-field-phone-und-0-value" name="phone" value="{{isset($data['phone']) ? $data['phone'] : old('phone')}}" size="60" maxlength="10">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-wrapper form-group" id="edit-field-website">
                                    <div id="">
                                        <div class="form-item form-group">
                                            <label for="">Website </label>
                                            <input class="text-full form-control form-text" type="text" id="" name="website" value="{{isset($data['website']) ? $data['website'] : old('website')}}" size="60" maxlength="255">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-wrapper form-group" id="edit-field-time-zone">
                                    <div class="form-group">
                                        <label for="">Time Zone </label>
                                        <select class="form-control form-select" id="edit-field-time-zone-und" name="timezone">
                                            <option value="America/Chicago" {{($data['timezone']=='America/Chicago') ? 'selected' :''}}>CDT - Monday, August 9, 2021 -
                                                11:34pm</option>
                                            <option value="America/New_York" {{($data['timezone']=='America/New_York' || $data['timezone']==null) ? 'selected' :''}}>EDT - Tuesday,
                                                August 10, 2021 - 12:34am</option>
                                            <option value="America/Denver" {{($data['timezone']=='America/Denver') ? 'selected' :''}}>MDT - Monday, August 9, 2021 -
                                                10:34pm</option>
                                            <option value="America/Phoenix" {{($data['timezone']=='America/Phoenix') ? 'selected' :''}}>MST - Monday, August 9, 2021 -
                                                9:34pm</option>
                                            <option value="America/Los_Angeles" {{($data['timezone']=='America/Los_Angeles') ? 'selected' :''}}>PDT - Monday, August 9, 2021 -
                                                9:34pm</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-wrapper form-group" id="edit-field-bio">
                                    <div id="">
                                        <div class="form-item form-group">
                                            <label for="">Bio </label>
                                            <div class="form-textarea-wrapper resizable textarea-processed resizable-textarea">
                                                <textarea class="text-full form-control form-textarea" id="" name="bio" cols="60" rows="5" spellcheck="false">{{isset($data['bio']) ? $data['bio'] : old('bio')}}</textarea>
                                                <div class="grippie"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="field-type-list-boolean field-name-field-delete-photo field-widget-options-onoff form-wrapper form-group" id="edit-field-delete-photo" style="display: none;">
                                    <div class="form-type-checkbox form-item-field-delete-photo-und form-item checkbox">
                                        <input type="checkbox" id="edit-field-delete-photo-und" name="field_delete_photo[und]" value="1" class="form-checkbox">
                                        <label for="edit-field-delete-photo-und">Delete Photo </label>
                                    </div>
                                </div>
                                <div id="profile-image" name="profile-image"></div>
                                <div class="field-type-image field-name-field-image-asset field-widget-image-image form-wrapper form-group" id="edit-field-image-asset">
                                    <div id="edit-field-image-asset-und-0-ajax-wrapper">
                                        <div class="form-type-managed-file form-item-field-image-asset-und-0 form-item form-group">
                                            <label for="edit-field-image-asset-und-0-upload">Photo </label>
                                            <div class="image-widget form-managed-file clearfix">
                                                <div class="image-widget-data">
                                                    <div class="input-group"><span class="input-group-btn"><span class="btn btn-primary btn-file">Browse<input class="form-file" type="file" id="" name="files[field_image_asset_und_0]" size="22"></span></span><input class="form-control" type="text" readonly=""><span class="input-group-btn"><button class="btn btn-default form-submit ajax-processed" id="edit-field-image-asset-und-0-upload-button" name="field_image_asset_und_0_upload_button" value="Upload" type="submit" style="display: none;">Upload</button>
                                                        </span>
                                                    </div>
                                                    <input type="hidden" name="field_image_asset[und][0][fid]" value="0">
                                                    <input type="hidden" name="field_image_asset[und][0][display]" value="1">
                                                    <div class="mp-image-resize-wrapper">
                                                        <input class="mp-image-resize mp-image-resize-processed" data-upload-button-name="field_image_asset_und_0_upload_button" data-url="/mp_image_resize/upload/field_image_asset/und/0/form-gUHhxUVcReurgLsWR31TB9x6g1awtlnXrNdFGb-fHRw" data-drop-message="Drop a file here or click <em>Browse</em> below." data-max-files="1" type="hidden" name="field_image_asset[und][0][mp_image_resize]" value="" id="mp-image-resize-0">
                                                        <canvas id="mp-image-resize-canvas"></canvas>
                                                        <canvas id="mp-image-resize-canvas-thumb"></canvas>
                                                        <div class="item-list drop">
                                                            <div class="drop-message">Drop a file here or click
                                                                <em>Browse</em> below.
                                                            </div>
                                                        </div>
                                                        <a href="#" class="">
                                                            <div class="upload-btn-wrapper">
                                                                <button class="btn-11">Browse</button>
                                                                <input type="file" name="myfile" />
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="help-block">Images must be <strong>png gif jpg
                                                    jpeg</strong></p>
                                        </div>
                                    </div>
                                </div>
                                <h2 class="element-invisible">Vertical Tabs</h2>
                                <div class="vertical-tabs-panes vertical-tabs-processed tab-content"><input class="vertical-tabs-active-tab" type="hidden" name="additional_settings__active_tab" value=""></div>
                                <div class="form-actions form-wrapper form-group" id="edit-actions"><button class="btn-lg-max-300 btn-info btn form-submit" id="edit-submit" name="op" value="Update Profile" type="submit">Update Profile</button>
                                </div>
                                <div class="never-share small text-info"><i>Neighborhood Reporter will NEVER share your email or
                                        phone number.</i></div>
                            </div>
                        </form>
                    </section>
                    <!-- /.block -->
                </div>
            </section>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(".st_FlagMenu .dropdown-toggle").click(function () {
        $(this).find(".flag-menu ul.dropdown-menu.dropdown-menu-right").toggle();
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
        pauseOnHover: false,
        pauseOnFocus: false
    });
    $(".header-hamburger-btn").click(function () {
        $(".h-hamburger-line").toggleClass('hamburger__line--open');
        $(".navbar-collapse").toggleClass('show');
        // $(".mob-menu").toggleClass("show-mob-menu");
    });

    $(".secondary-nav__list-item").click(function () {
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
    }
    $(".header-hamburger-btn").click(function () {
        // $('.header').toggleClass('header--fixed');
        $('.header').removeClass("header--sticky-full");
        $('.header').removeClass("header--sticky-condensed");
        $('body').toggleClass("over-class");
    });

    $(document).ready(function () {
        $(".autocomplete input").click(function () {
            $('.fp-helper__wrapper.fp-helper--closed').show();

        });
    });

    $(document).mouseup(function (e) {
        var container = $(".fp-helper__wrapper.fp-helper--closed");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.hide();
        }
    });

    $('#community').on('keyup', function () {
        var query = $(this).val();
        $('#community_list').css('display', 'block');
        $.ajax({
            url: "{{ route('search_user_community') }}",
            type: "GET",
            data: {
                'communitie': query
            },
            success: function (data) {
                $('#community_list').html(data);
                $('.list-group-item').click(function () {
                    var community = $(this).text();
                    $('#community').val(community);
                    $('#community_list').css('display', 'none');
                });
            }
        });
    });
</script>
@endsection