@extends('admin.layouts.admin')
@section('title')
       Change Password
@endsection
@section('content')

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="col-md-12 col-sm-12 col-xs-12">
                @if(session()->has('error'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p >{{ session()->get('error') }}</p>
                    </div>
                @endif
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p >{{ session()->get('success') }}</p>
                    </div>
                @endif
            </div>
            <div class="title_left">
                <h3>Change Password</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <form class="form-horizontal form-label-left" action="{{ route('change.password') }}" method="POST" novalidate>
                            @csrf
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Current Password <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    {{-- <input id="name" class="form-control col-md-6 col-xs-6" required="required" type="text" name="title" value="{{ old('title') }}"> --}}
                                    <input type="password" class="form-control col-md-6 col-xs-6 @error('current_password') is-invalid @enderror" name="current_password" autocomplete="current_password" required="required">
                                    @error('current_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">New Password <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    {{-- <input id="name" class="form-control col-md-6 col-xs-6" required="required" type="text" name="title" value="{{ old('title') }}"> --}}
                                    <input type="password" class="form-control col-md-6 col-xs-6 @error('password') is-invalid @enderror" name="password" autocomplete="password" required="required">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Password Confirmation <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    {{-- <input id="name" class="form-control col-md-6 col-xs-6" required="required" type="text" name="title" value="{{ old('title') }}"> --}}
                                    <input type="password" class="form-control col-md-6 col-xs-6 @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="password_confirmation" required="required">
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <a href="{{ route('dashboard') }}"><button type="button" class="btn btn-primary">Cancel</button></a>
                                    <button id="send" type="submit" class="btn btn-success">Change Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
