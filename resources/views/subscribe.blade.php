@extends('layouts.app')
@section('title')
Subscribe to the {{ucwords($segment2)}}
@endsection
<style type="text/css">
    section#block-system-main {
        text-align: center;
        justify-content: center;
    }
    #block-system-main .sub-text.post-form-wrapper h1 {
        font-size: 20px;
        line-height: 1.2;

    }
    div#subscribe-form-subscribe-page input {
        font-size: 16px;
        height: 44px;
        margin-bottom: 15px;
    }
    section.subs-input {
        width: 66%;
        margin: 0 auto;
    }
    button#js-subscribe-submit-button {
        height: 42px;
        font-size: 17px;
        line-height: 1.42857;
        box-shadow: 0 0.5rem 1rem rgb(0 0 0 / 15%);
        border-radius: 50px;
        padding: 0;
        font-weight: normal;
        text-align: center;
        vertical-align: middle;
        touch-action: manipulation;
        cursor: pointer;
        width: 100%;
        background-color: #d20000;
        color: #fff;
        font-weight: 700;
        margin-bottom: 5px;
    }

    @media (max-width: 767px){
        #block-system-main .sub-text.post-form-wrapper h1 br {
            display: none;
        }
        #block-system-main .sub-text.post-form-wrapper h1 {
            padding: 0px 15px;
        }
    }
</style>
@section('content')
<section id="block-system-main" class="Find page__content">
    <div class="sub-text post-form-wrapper">
        <h1>Find out what's happening in {{ucwords($segment2)}} with free, real-time <br> updates from Neighborhood Reporter.</h1>
        <div id="subscribe-form-subscribe-page" class="email-subscribe-wrapper">
            <form action="{{route('store-subscribe')}}" method="post" id="js-subscribe-form" accept-charset="UTF-8">
                @csrf
                <input type="hidden" name="location" value="{{ucwords($segment2)}}">
                <section class="subs-input">
                    <div class="email-input-group">
                        <input autocomplete="email" class="bg-light border border-gray outline-0 px-4 py-3 rounded text-base text-center w-100" id="js-subscribe-form-email-field" name="email" placeholder="Enter your email address" type="email" required=""> </div>
                    <section class=" py-2">
                        <button id="js-subscribe-submit-button" type="submit" name="let'go" class="border-0 btn btn-cta-alt">

                            Let's go!
                            <span id="js-subscribe-submit-button-label-loading" class="d-none fa fa-spinner spin ml-1"></span>
                            </h4> </button>
                    </section>
                    <div class="air-xs link-to-patch"><a href="{{route('home')}}" category="subscribe" class="cta-green-link not-in-patchtown">Not in {{ucwords($segment2)}}?</a></div>
                </section>
            </form>
        </div>
    </div>
</section>
@endsection