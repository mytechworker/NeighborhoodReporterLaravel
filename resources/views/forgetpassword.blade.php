@extends('layouts.app')
@section('title')
Reset Password
@endsection
@section('meta')
<!-- Primary Meta Tags -->
<meta name="title" content="Reset Password Neighborhood Reporter">
<meta name="description" content="Reset Password Neighborhood Reporter">
<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{str_replace('_', '-', app()->getLocale())}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{route('home')}}/forget-password">
<meta property="og:title" content="Reset Password Neighborhood Reporter">
<meta property="og:description" content="Reset Password Neighborhood Reporter">
<meta property="og:image" content="{{asset('images/logo.png')}}">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="600">
<meta property="og:site_name" content="Neighborhood Reporter">
<meta property="fb:app_id" content="859635438272019">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta name="twitter:widgets:theme" content="light">
<meta name="twitter:widgets:border-color" content="#e9e9e9">
<meta property="twitter:url" content="{{route('home')}}/forget-password">
<meta property="twitter:title" content="Reset Password Neighborhood Reporter">
<meta property="twitter:description" content="Reset Password Neighborhood Reporter">
<meta property="twitter:image" content="{{asset('images/logo.png')}}">
@endsection
<style type="text/css">
    .auth-block-container.reset-pass-sec header.auth-block__tab-bar h1 {
  font-size: 1.3rem;
  min-height: 58px;
  text-align: center;
  line-height: 58px;
  margin: 0;
}
.auth-block-container.reset-pass-sec header.auth-block__tab-bar {
  border-bottom: 1px solid #d4cfcf;
  border-top-left-radius: 6px;
  border-top-right-radius: 6px;
  
  background:#f7f7f7
}
.auth-block-container.reset-pass-sec .auth-block{
    border: 1px solid #d4cfcf;
        border-radius: 6px;
}
.auth-block-container.reset-pass-sec form.form h2 {
  font-size: 1.3rem;
  font-weight: 700;
  line-height: 30px;
      margin-bottom: 15px;
}
.auth-block-container.reset-pass-sec .auth-block__content {
  padding: 25px 15px;
}
button.btn.btn-link.back-btn{
 background-color: transparent;
 border: none;
 padding: 0;
}
button.btn.btn-link.back-btn i{
 margin-right: 2px;
}
button.btn.btn-link.back-btn i, button.btn.btn-link.back-btn strong {
 color: #d20000;
 font-size: 14px;
 font-weight: 600;
}
 </style>

@section('content')
<section class="page__content">
    <main id="main" role="main" class="page__main">
       <div class="auth-block-container reset-pass-sec">
          <div class="auth-block">
             <header class="auth-block__tab-bar">
                 <h1>Reset Password</h1>
             </header>
             <div class="auth-block__content">
                <form class="form" action="{{ route('forget.password.post') }}" method="post">
                    @csrf
                   <div class="form__inner form__inner--is-condensed">
                      <h2 class="form__title">Enter your email address to<br>get a password reset link</h2>
                      <div class="form__item">
                         <label class="text-field text-field--is-outlined">
                            <input aria-label="Enter your email address" autocomplete="email" class="text-field__input" name="email" placeholder="Email address" required="" type="email" value="" autofocus>
                         </label>
                         @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                      </div>
                      <div class="form__item">
                         <button class="btn btn--cta" type="submit">Send link</button>
                      </div>
                      <div class="form__item">
                         <a class="btn btn-link back-btn" type="button" href="{{route('user.register')}}">
                            <i class="fa fa-chevron-left icon icon--space-right"></i>
                            <strong>Back to login</strong>
                         </a>
                      </div>
                   </div>
                </form>
             </div>
          </div>
       </div>
    </main>
 </section>
<script>
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