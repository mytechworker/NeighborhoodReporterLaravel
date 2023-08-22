@extends('layouts.app')
@section('title')
Faq Listing
@endsection
@section('content')
{{-- <header class="support-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
       <div class="container">
          <a class="navbar-brand" href="#"><img alt="Patch News" class="support-logo" src="./images/support-patch-logo.png" title="Patch News"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarText">
             <ul class="navbar-nav ml-auto">
                <li class="nav-items active">
                   <a class="submit-a-request" href="#">Submit a request</a>
                </li>
             </ul>
          </div>
       </div>
    </nav>
 </header> --}}
 <div class="sp-section-main">
    <section class="bg-white top-border">
       <div class="container">
          <div class="row">
             <div class="col-lg-12">
                <nav class="sp-section-sub-nav">
                   <ol class="sp-section-breadcrumbs p-0">
                      <li title="Patch Support">
                         <a href="{{url('faqCategory')}}">Neighborhood Reporter</a>
                      </li>
                      <li title="For Community Organizations">
                         <a href="javascript:void(0);">{{$faq_category_title->title}}</a>
                      </li>
                   </ol>
                   <form class="support-form">
                     <input class="support-control" type="search" placeholder="Search" aria-label="Search" id="faq_category">
                     <div id="faq_category_list"></div> 
                   </form>
                  
                </nav>
             </div>
          </div>
       </div>
    </section>
    <section class="bg-white">
       <div class="container">
          <div class="row">
             <div class="col-lg-12">
                @foreach($faq_categories as $faq_category)
                    <header class="sp-section-page-header">
                    <h1>
                        {{$faq_category->title}}
                    </h1>
                    <p class="sp-section-page-header-description">{{$faq_category->description}}</p>
                    </header>
                @endforeach
                <ul class="sp-section-article-list">
                    @foreach($faqs as $faq)
                    <?php 
                    $title = strtolower(str_replace(" ","-",$faq->faq_category_id."-".$faq->title));
                  ?>
                        <li class="sp-section-article-list-item ">
                            <a href="{{route('faq_detail',$title)}}" class="sp-section-article-list-link">{{$faq->title}}</a>
                        </li>
                    @endforeach
                </ul>
             </div>
          </div>
       </div>
    </section>
 </div>
 <script type="text/javascript">
   $(document).ready(function () {
    
       $('#faq_category').on('keyup',function() {
           var query = $(this).val(); 
           var url = '{{ route("search_faq_listing", ":slug") }}';
            url = url.replace(':slug', query);
            var url1 = $(location).attr('href');
            var segments = url1.split( '/' );
            var action = segments[4];
            var sd=parseInt(action);
   
           $.ajax({
              
               url:url,
         
               type:"GET",
              
               data:{'faq_category':sd},
              
               success:function (data) {
                 
                   $('#faq_category_list').html(data);
               }
           })
           // end of ajax call
       });

       
       $(document).on('click', '.faq-category', function(){
         var value = $(this).text();
         var fid = $(this).data('id');
         var url = '{{ route("faq_detail", ":slug") }}';
         url = url.replace(':slug', fid);
           $("a").attr("href",url)
           $('#faq_category').val(value);
           $('#faq_category_list').html("");
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
   });
</script>
@endsection