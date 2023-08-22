@extends('layouts.app')
@section('title')
Submit Request
@endsection
<style>
    .submit-request .sub-nav {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        margin: 30px 0px;
        min-height: 50px;
        padding-bottom: 15px;
    }
    .submit-request .breadcrumbs {
        margin: 0 0 15px 0;
        padding: 0;
    }
    .submit-request .breadcrumbs li {
        color: #666;
        display: inline;
        font-weight: 300;
        font-size: 13px;
        max-width: 450px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .submit-request .breadcrumbs li + li::before {
        content: ">";
        margin: 0 4px;
    }
    .submit-request .search {
        position: relative;
    }
    .submit-request .search::before {
        position: relative;
        top: 50%;
        transform: translateY(-50%);
        background-color: #fff;
        color: #777;
        content: "\f002";
        font-family: "Font Awesome 5 Free";
        font-weight: 600;
        font-size: 18px;
        position: absolute;
        left: 15px;
    }
    .submit-request .search input[type="search"] {
        border: 1px solid #ddd;
        border-radius: 30px;
        box-sizing: border-box;
        color: #999;
        height: 40px;
        padding-left: 40px;
        padding-right: 20px;
        -webkit-appearance: none;
        width: 100%;
    }
    .submit-r-head h1 {
        font-size: 32px;
        margin-bottom: 20px;
    }
    .submit-request .form {
        max-width: 650px;
    }
    #new_request .form-field label {
        display: block;
        font-size: 13px;
        margin-bottom: 5px;
    }
    #new_request .form-field.required > label::after {
        content: "*";
        color: #f00;
        margin-left: 2px;
    }
    #new_request .form-field input[type="text"] {
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    #new_request .form-field input {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 10px;
        width: 100%;
    }
    #new_request .form-field ~ .form-field {
        margin-top: 25px;
    }
    .request-form textarea {
        min-height: 120px;
    }
    #new_request .form-field textarea {
        vertical-align: middle;
        border: 1px solid #ddd;
        border-radius: 2px;
        resize: vertical;
        width: 100%;
        outline: none;
        padding: 10px;
    }
    #new_request .form-field p {
        color: #666;
        font-size: 12px;
        margin: 5px 0;
    }
    #new_request .form-field .upload-dropzone {
        border: 1px solid #ddd;
        font-size: 12px;
        overflow: hidden;
        position: relative;
        text-align: center;
    }
    #new_request .upload-dropzone input[type=file] {
        opacity: 0;
        position: absolute;
        top: 0;
        right: 0;
        cursor: pointer;
        height: 100%;
        width: 100%;
    }
    #new_request .upload-dropzone span {
        color: #666;
        display: inline-block;
        line-height: 24px;
        padding: 10px;
    }
    #new_request .upload-dropzone span a{
        color: #007bff;
    }
    .submit-request .form footer {
        margin-top: 40px;
        padding-top: 30px;
    }
    .submit-request .form footer input[type="submit"] {
        background-color: rgba(0, 158, 19, 1);
        border: 0;
        border-radius: 4px;
        color: #FFFFFF;
        font-size: 14px;
        font-weight: 400;
        line-height: 2.72;
        min-width: 190px;
        padding: 0 1.9286em;
        width: 100%;
    }


    @media screen and (min-width: 768px) {
        .submit-request .sub-nav input[type="search"] {
            min-width: 300px;
        }
        .submit-request .form footer input[type="submit"] {
            width: auto;
        }
        .submit-request .sub-nav {
            align-items: baseline;
            flex-direction: row;
        }
        .submit-request .breadcrumbs {
            margin: 0;
        }
    }

</style>
@section('content')
<main class="submit-request">
    <div class="container">
        <nav class="sub-nav">
            <ol class="breadcrumbs">
                <li title="Patch Support">
                    <a href="{{url('faqCategory')}}">Neighborhood Reporter</a>
                </li>
                <li title="Submit a request"> Submit a request </li>
            </ol>
        </nav>
        <div class="submit-r-head">
            <h1> Submit a request </h1>
        </div>    
        <div class="form">
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
            <form id="new_request" action="{{url('submit_request')}}" method="post" enctype="multipart/form-data" class="ad-form" novalidate>
                @csrf
                <input name="utf8" type="hidden" value="✓">
                <input type="hidden" name="authenticity_token" value="hc:requests:client:srExDT9n_HrsUW1zkjP-CM5dsBQmBW51EZsmMC-bb8cWlD-5mgut2WHUHCg-XmnNYI7WL3Jq_lma24pZrNg_-w" data-hc-status="ready">
                <input type="hidden" name="request[ticket_form_id]" id="request_ticket_form_id" value="81248">
                <div class="form-field string required request_anonymous_requester_email item form-group mb-2">
                    <label for="request_anonymous_requester_email">Your email address</label>
                    <input type="email" name="email" id="request_anonymous_requester_email" aria-required="true" class="form-control ad-input" required="required" value="{{ old('email') }}">
                </div>
                <div class="form-field text  required  request_description item form-group mb-2">
                    <label id="request_description_label" for="request_description">What can we help you with? Please include as much detail as possible!</label>
                    <textarea name="description" id="description" aria-required="true" aria-describedby="request_description_hint" aria-labelledby="request_description_label" class="form-control ad-input" required="required">{{old('description')}}</textarea>
                    <input type="hidden" name="request[description_mimetype]" id="request_description_mimetype" value="text/plain" style="display: none;">
                    <p id="request_description_hint">*IMPORTANT*: If you need to contact your local editor, learn how here: <a href="#" rel="nofollow">https://bit.ly/2EcZwlt</a>
                    </p>
                </div>
                <div class="form-field string  optional  request_custom_fields_24082516">
                    <label id="request_custom_fields_24082516_label" for="request_custom_fields_24082516">Home Neighborhood Reporter</label>
                    <input type="text" name="town" id="request_custom_fields_24082516" aria-required="false" aria-describedby="request_custom_fields_24082516_hint" aria-labelledby="request_custom_fields_24082516_label" value="{{ old('town') }}">
                    <p id="request_custom_fields_24082516_hint">If you do not know your preferred Neighborhood Reporter, please select a proper Neighborhood Reporter town by visiting <a href="https://www.neighborhoodreporter.com/" rel="nofollow">https://www.neighborhoodreporter.com/</a>
                    </p>
                </div>
                <div class="form-field string  optional  request_custom_fields_360015867552">
                    <label id="request_custom_fields_360015867552_label" for="request_custom_fields_360015867552">Relevant URL(s)</label>
                    <input type="url" name="url" id="request_custom_fields_360015867552" aria-required="false" aria-describedby="request_custom_fields_360015867552_hint" aria-labelledby="request_custom_fields_360015867552_label" value="{{ old('url') }}">
                    <p id="request_custom_fields_360015867552_hint">Want to request an edit, removal, or need any other help with a post on Neighborhood Reporter? Please copy and paste the URL here.</p>
                </div>
                <script data-conditional-fields="[]"></script>
                <div class="form-field">
                    <label for="request-attachments"> Attachments </label>
                    <div id="upload-dropzone" class="upload-dropzone">
                        <input type="file" name="attachement" multiple="true" id="request-attachments" data-fileupload="true" data-dropzone="upload-dropzone" data-error="upload-error" data-create-url="/hc/en-us/request_uploads" data-name="request[attachments][]" data-pool="request-attachments-pool" data-delete-confirm-msg="" aria-describedby="upload-error">
                        <span>
                            <a>Add file</a> or drop files here </span>
                    </div>
                    <div id="upload-error" class="notification notification-error notification-inline" style="display: none;">
                        <span data-upload-error-message=""></span>
                    </div>
                    <ul id="request-attachments-pool" class="upload-pool" data-template="upload-template"></ul>
                    <script type="text/html" id="upload-template">
                        <li class="upload-item" data-upload-item>
                            <a class="upload-link" target="_blank" data-upload-link></a>
                            <p class="upload-path" data-upload-path></p>
                            <p class="upload-path" data-upload-size></p>
                            <p data-upload-issue class="notification notification-alert notification-inline" aria-hidden="true"></p>
                            <span class="upload-remove" data-upload-remove></span>
                            <div class="upload-progress" data-upload-progress></div>
                            <input type="hidden">
                        </li>
                        </script>
                    </div>
                    <footer>
                        <input type="submit" name="commit" value="Submit" class="btn-submit">
                    </footer>
                </form>
            </div>
        </div>
    </main>
    <script>
        jQuery('form').submit(function (e) {
            var submit = true;
            // evaluate the form using generic validaing
            if (!validator.checkAll(jQuery(this))) {
                submit = false;
            }

            if (submit) {
                this.submit();
            }
            return false;
        });
        $(".header-hamburger-btn").click(function () {
            $(".h-hamburger-line").toggleClass('hamburger__line--open');
            $(".navbar-collapse").toggleClass('show');
            $('.header').removeClass("header--sticky-full");
            $('.header').removeClass("header--sticky-condensed");
            $('body').toggleClass("over-class");
            $(".mob-menu").toggleClass("show-mob-menu");
            $('.header').toggleClass('header--fixed');
        });
    </script>
    @endsection