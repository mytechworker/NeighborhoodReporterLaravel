@extends('layouts.app')
@section('title')
Faq Detail
@endsection
<style>
.sp-article-info {
    margin-bottom: 30px;
}
</style>
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
                         <a href="javascript:void(0);">{{$faq_category->title}}</a>
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
             <div class="col-lg-3">
                <section class="sp-article-sidebar">
                   <div class="sp-section-articles">
                      <h3 class="sp-collapsible-sidebar-title sp-sidenav-title">Articles in this section</h3>
                      @foreach($faqs_list as $result)
                      @php
                        if($result->title == $faqs_title){
                           $class="sp-current-article";
                        }
                        else{
                           $class = '';
                        }
                        $title = strtolower(str_replace(" ","-",$result->faq_category_id."-".$result->title));
                     @endphp
                        <ul>
                            <li>
                                <a href="{{route('faq_detail',$title)}}" class="sp-sidenav-item {{$class}}" data-id="{{$result->id}}">{{$result->title}}</a>
                            </li>
                        </ul>
                    @endforeach
                   </div>
                </section>
             </div>
             <div class="col-lg-9">
                @foreach($faqs_lists as $faqs_list)
                    <article class="sp-article tab tab-active" data-id="{{$faqs_list->id}}">
                     <header class="sp-article-header">
                           <h1 title="News Partner Program" class="sp-article-title">
                              {{$faqs_list->title}}
                           </h1>
                           <div class="sp-article-author">
                              <div class="sp-article-meta">
                                 <ul class="sp-meta-group">
                                 <li class="sp-meta-data"><time datetime="2021-07-02T15:37:54Z" title="2021-07-02 21:07" data-datetime="relative">{{ $faqs->created_at->diffForHumans() }}</time></li>
                                 </ul>
                              </div>
                           </div>
                     </header>
                    <div class="sp-article-info">
                        {!! $faqs_list->description !!}
                    </div>
                    </article>
                @endforeach
             </div>
          </div>
       </div>
    </section>
 </div>
 <script type="text/javascript">
    $(document).ready(function(){ 
        $('.sp-sidenav-item').click(function(){  
          $(".tab").removeClass('tab-active');
          $(".tab[data-id='"+$(this).attr('data-id')+"']").addClass("tab-active");
          $(".sp-sidenav-item").removeClass('sp-current-article');
          $(this).parent().find(".sp-sidenav-item").addClass('sp-current-article');
         });
          $('.sp-section-articles').click(function(){  
          $(this).toggleClass('sp-collapsible-sidebar');
         });
    });

    $(document).ready(function () {
    
    $('#faq_category').on('keyup',function() {
        var query = $(this).val(); 
        $.ajax({
           
            url:"{{ route('search_faq_category') }}",
      
            type:"GET",
           
            data:{'faq_category':query},
           
            success:function (data) {
              
                $('#faq_category_list').html(data);
            }
        })
        // end of ajax call
    });

    
    $(document).on('click', '.faq-category', function(){
      var value = $(this).text();
      var fid = $(this).data('id');
      var url = '{{ route("faq_listing", ":slug") }}';
      url = url.replace(':slug', fid);
        $("a").attr("href",url)
        $('#faq_category').val(value);
        $('#faq_category_list').html("");
    });
});
          
$('.sp-article div,p,a,ul,li,h1,h2,h3,h4,h5,h6').removeAttr('style');
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