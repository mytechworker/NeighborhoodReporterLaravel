@extends('layouts.app')
@section('title')
Change password
@endsection
<style>
    .user-img img {
        border-radius: 50%;
        width: 80px;
        height: 80px;
    }
    .back-white{
        background-color: white;
    }
    .user-profile-card-link.user-profile {
        top: 0px;
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
                <h1 class="page-header">Change Password</h1>
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
                        <form class="user_profile_form" method="post" action="{{ route('update.password') }}">
                            @csrf
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
                                    <section class="p-4 user-profile-card-links w-100 "><a href="{{route('view_profile')}}" class="d-block" target="_blank"><span class="fas fa fa-user-circle"></span><span class="ml-2">View my profile on Neighborhood Reporter</span></a><a href="{{url('add/user-profile')}}" class="mt-2 d-block"><span class="fas fa fa-pencil-alt"></span><span class="ml-2">Edit profile</span></a></section>
                                </section>
                                <div class="denotes-required small text-danger"><b>*</b> denotes required field
                                </div>
                                <div class="form-item-title form-item form-group">
                                    <label for="edit-title">Current Password <span class="form-required" title="This field is required.">*</span></label>
                                    <input class="form-control form-text required" type="password" id="edit-title" name="current_password" autocomplete="current_password" required="required">
                                    @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-item-title form-item form-group">
                                    <label for="edit-title">New Password <span class="form-required" title="This field is required.">*</span></label>
                                    <input class="form-control form-text required" type="password" id="edit-title" name="password" autocomplete="password" required="required">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-item-title form-item form-group">
                                    <label for="edit-title">Password Confirmation <span class="form-required" title="This field is required.">*</span></label>
                                    <input class="form-control form-text required" type="password" id="edit-title" name="password_confirmation" autocomplete="password_confirmation" required="required">
                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-actions form-wrapper form-group" id="edit-actions"><button class="btn-lg-max-300 btn-info btn form-submit" id="edit-submit" name="op" value="Update Profile" type="submit">Update Password</button>
                                </div>

                            </div>
                        </form>
                    </section>
                    <!-- /.block -->
                </div>
            </section>
        </div>
    </div>
</div>
<script>
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
</script>
@endsection