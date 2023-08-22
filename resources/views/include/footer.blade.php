<footer class="page__footer">
    <div class="footer container">

        <section class="footer__section-vertical--full">
            <h3 class="footer__header">Nearby Communities</h3>
            <ul class="list--unstyled list--columned">
                @if(!Auth::check() || !isset($info['location']))
                @php $allRegion = getAllRegion(); @endphp
                @if(count($allRegion) > 0)
                @foreach($allRegion as $key => $value)
                @if($key < 19)
                <li class="list-item__lg list-item--columned">
                    <a class="list-item__link list-item__link--xs" href="/r/{{sanitizeStringForUrl($value['name'])}}">
                        {{$value['name']}}
                    </a>
                </li>
                @endif
                @endforeach
                @endif
                @else
                @if(Auth::check() && isset($info['location']))
                @php $Community = getRegionCommunity($info['location']); @endphp
                @if(count($Community) > 0)
                @foreach($Community as $key => $value)
                @if($key < 10)
                <li class="list-item__lg list-item--columned">
                    <a class="list-item__link list-item__link--xs" href="/l/{{sanitizeStringForUrl($value['rname'])}}/{{sanitizeStringForUrl($value['name'])}}">
                        {{$value['name']}}, {{$value['region_code']}}
                    </a>
                </li>
                @endif
                @endforeach
                @endif
                @endif
                @endif
                <li><a class="list-item__link list-item__link--xs" title="View All Neighborhood Reporteres" href="/map">View All Communities</a></li>
            </ul>
        </section>
        @if(Auth::check() && isset($info['location']) && isset($info['town']))
        <section class="footer__section-vertical--full">
            <h3 class="footer__header">Topics</h3>
            <ul class="list--unstyled list--columned">
                @php echo getFooterMenu($info['location'],$info['town']); @endphp
            </ul>
        </section>
        @endif
        <section class="footer__section">
            <h3 class="footer__header">Corporate Info</h3>
            <ul class="list--unstyled">
                <li class="list-item"><a class="list-item__link list-item__link--xs" title="About Neighborhood Reporter" href="{{url('about')}}">About</a></li>
                <li class="list-item"><a class="list-item__link list-item__link--xs" target="_blank" title="Careers at Neighborhood Reporter" href="javascript:void(0);" rel="nofollow noopener">Careers</a></li>
            </ul>
        </section>
        <section class="footer__section">
            <h3 class="footer__header">Partnerships</h3>
            <ul class="list--unstyled">
                <li class="list-item">
                    <a class="list-item__link list-item__link--xs" target="_blank" title="Advertise on Neighborhood Reporter" href="/across-america/advertise-with-us" rel="nofollow noopener">Advertise</a>
                </li>
            </ul>
        </section>
        <section class="footer__section">
            <h3 class="footer__header">Support</h3>
            <ul class="list--unstyled">
                <li class="list-item"><a class="list-item__link list-item__link--xs" target="_blank" title="Frequently Asked Questions and How-Tos" href="{{url('faqCategory')}}" rel="nofollow noopener">FAQs</a></li>
                <li class="list-item"><a class="list-item__link list-item__link--xs" title="Contact Neighborhood Reporter" href="/contact-us">Contact</a></li>
                <li class="list-item"><a class="list-item__link list-item__link--xs" title="Community Guidelines" href="{{url('community-guidelines')}}">Community Guidelines</a></li>
                <li class="list-item"><a class="list-item__link list-item__link--xs" title="Posting Instructions" href="{{url('posting-instructions')}}">Posting Instructions</a></li>
            </ul>
        </section>
        <div class="footer__section--full">
            <ul class="footer__social-list">
                <li><a class="list-item__link footer__item--spacing list-item__link--xs" title="Contact Neighborhood Reporter at support@neighborhoodreporter.com" href="mailto:support@neighborhoodreporter.com">
                        <span class="fa-stack fa-lg">
                            <span class="fal far fa-circle fa-stack-2x"></span>
                            <span class="fa fas fa-envelope fa-stack-1x"></span>
                        </span></a>
                </li>
                <li>
                    <a class="list-item__link footer__item--spacing list-item__link--xs" target="_blank" title=" Neighborhood Reporter On Facebook" href="javascript:void(0);" rel="nofollow noopener">
                        <span class="fa-stack fa-lg">
                            <span class="fal far fa-circle fa-stack-2x"></span>
                            <span class="fab fab fa-facebook-f fa-stack-1x"></span>
                        </span>
                    </a>
                </li>
                <li>
                    <a class="list-item__link footer__item--spacing list-item__link--xs" target="_blank" title="Follow Neighborhood Reporter On Twitter" href="javascript:void(0);" rel="nofollow noopener">
                        <span class="fa-stack fa-lg">
                            <span class="fal far fa-circle fa-stack-2x"></span>
                            <span class="fab fa-twitter fa-stack-1x"></span>
                        </span>
                    </a>
                </li>
                <li>
                    <a class="list-item__link footer__item--spacing list-item__link--xs" target="_blank" title="Follow Neighborhood Reporter On LinkedIn" href="javascript:void(0);" rel="nofollow noopener">
                        <span class="fa-stack fa-lg">
                            <span class="fal far fa-circle fa-stack-2x"></span>
                            <span class="fab fa-linkedin-in fa-stack-1x"></span>
                        </span>
                    </a>
                </li>
                <li>
                    <a class="list-item__link footer__item--spacing list-item__link--xs" target="_blank" title="Follow Neighborhood Reporter On Instagram" href="javascript:void(0);" rel="nofollow noopener">
                        <span class="fa-stack fa-lg">
                            <span class="fal far fa-circle fa-stack-2x"></span>
                            <span class="fab fa-instagram fa-stack-1x"></span>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="footer__section--full"><a class="list-item__link list-item__link--no-margin footer__item--spacing list-item__link--xs" title="Neighborhood Reporter Terms of Use" href="{{url('terms')}}">Terms of Use</a><a class="list-item__link list-item__link--no-margin footer__item--spacing list-item__link--xs" title="Neighborhood Reporter Privacy Policy" href="{{url('privacy')}}">Privacy Policy</a></div>
        <div class="footer__copyright">
            &COPY; <!-- -->2021<!-- --> <a class="list-item__link" title="Neighborhood Reporter" href="/">Neighborhood Reporter</a> <!-- -->Media. All Rights Reserved.
        </div>        
    </div>
</footer>
<!-- bootstrap progress js -->
<script src="{{asset('js/progressbar/bootstrap-progressbar.min.js')}}"></script>
<script src="{{asset('js/nicescroll/jquery.nicescroll.min.js')}}"></script>
<!-- icheck -->
<script src="{{asset('js/icheck/icheck.min.js')}}"></script>
<!-- daterangepicker -->
<script type="text/javascript" src="{{asset('js/moment/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/datepicker/daterangepicker.js')}}"></script>
<!-- chart js -->
<script src="{{asset('js/chartjs/chart.min.js')}}"></script>

<script src="{{asset('js/custom.js')}}"></script>

<!-- flot js -->
<!--[if lte IE 8]><script type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
<script type="text/javascript" src="{{asset('js/flot/jquery.flot.js')}}"></script>
<script type="text/javascript" src="{{asset('js/flot/jquery.flot.pie.js')}}"></script>
<script type="text/javascript" src="{{asset('js/flot/jquery.flot.orderBars.js')}}"></script>
<script type="text/javascript" src="{{asset('js/flot/jquery.flot.time.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/flot/date.js')}}"></script>
<script type="text/javascript" src="{{asset('js/flot/jquery.flot.spline.js')}}"></script>
<script type="text/javascript" src="{{asset('js/flot/jquery.flot.stack.js')}}"></script>
<script type="text/javascript" src="{{asset('js/flot/curvedLines.js')}}"></script>
<script type="text/javascript" src="{{asset('js/flot/jquery.flot.resize.js')}}"></script>
<!-- worldmap -->
<script type="text/javascript" src="{{asset('js/maps/jquery-jvectormap-2.0.3.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/maps/gdp-data.js')}}"></script>
<script type="text/javascript" src="{{asset('js/maps/jquery-jvectormap-world-mill-en.js')}}"></script>
<script type="text/javascript" src="{{asset('js/maps/jquery-jvectormap-us-aea-en.js')}}"></script>
<!-- pace -->
<script src="{{asset('js/pace/pace.min.js')}}"></script>
<!-- skycons -->
<script src="{{asset('js/skycons/skycons.min.js')}}"></script>
<script src="{{asset('js/validator/validator.js')}}"></script>
<script src="{{asset('js/select-box.js')}}"></script>
<script>
NProgress.done();</script>
<script type="text/javascript">
    tinymce.init({
        selector: '#mytextarea',
        // update validation status on change
        onchange_callback: function (editor) {
            tinymce.triggerSave();
            $("#" + editor.id).valid();
        }
    });
    $(".st_FlagMenu .dropdown-toggle").click(function () {
        $(this).find(".flag-menu ul.dropdown-menu.dropdown-menu-right").toggle();
    });
    $("#js-user-nav-menu").click(function () {
        $(".UserMenu_UserMenu  ul.dropdown-menu.dropdown-menu-right").toggle();
    });
    $(".header-hamburger-btn").click(function () {
        $(".navbar-collapse").toggleClass('show');
        $('.header').removeClass("header--sticky-full");
        $('.header').removeClass("header--sticky-condensed");
        $('body').toggleClass("over-class");
    });
    $(".secondary-nav__list-item").click(function () {
        $(this).find('.secondary-nav__menu').toggleClass('show');
    });
    
    $(document).on("click", ".autocomplete input", function () {
        $('.fp-helper__wrapper.fp-helper--closed').show();
    });
    $(document).mouseup(function (e) {
        var container = $(".fp-helper__wrapper.fp-helper--closed");
        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0)
        {
            container.hide();
        }
    });
    
    $(document).on('click', '.btn--subscribe', function () {
        var $this = $(this);
        $(this).find('i').show();
        var formData = new FormData($("#subscriber_form")[0]);
        $.ajax({
            type: 'POST',
            url: "{{ route('follower-store') }}",
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if(data.url != ''){
                    window.location.href=data.url;
                }else{
                    $this.find('i').hide();
                    toastr.options = {
                        "positionClass": "toast-bottom-center"
                    }
                    toastr.success(data.message);
                    $("input[name=email]").val('');
                    $("#subscriberModal").modal('hide');
                }
            }
        });
    });
    $(document).on('click', '#addCommunity', function () {
        var $this = $(this);
        $.ajax({
            type: 'POST',
            url: "{{ route('community-store') }}",
            data: {'community': $(this).data('community')},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {

                $("#sendUpdate").modal('show');
            }
        });
    });
    $(document).on('click', '#sendEmailUpdate', function () {
        var $this = $(this);
        $.ajax({
            type: 'POST',
            url: "{{ route('add-email') }}",
            data: {'community': $(this).data('community')},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $("#sendUpdate").modal('hide');
                toastr.options = {
                    "positionClass": "toast-bottom-center"
                }
                toastr.success("Successfully Subscribe.!");
                setTimeout(function () {
                    location.reload();
                }, 4000);
            }
        });
    });
    $(document).on('click', '#removeFollower', function () {
        var $this = $(this);
        $.ajax({
            type: 'POST',
            url: "{{ route('remove-follower') }}",
            data: {'community': $(this).data('community')},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                toastr.options = {
                    "positionClass": "toast-bottom-center"
                }
                toastr.success("Successfully unfollow cummunity.!", "Success");
                setTimeout(function () {
                    location.reload();
                }, 4000);
            }
        });
    });
    $(".secondary-nav__list-item").click(function () {
            $(this).find('.secondary-nav__menu').toggleClass('show');
        });
        $('#community1').on('keyup', function () {
            var query = $(this).val();
            if (query != '') {
                $.ajax({
                    url: "{{ route('search_event_community') }}",
                    type: "GET",
                    data: {'communitie': query,'link':1},
                    success: function (data) {
                        $('#community_list1').html(data);
                    }
                });
            } else {
                $('#community_list1').html('');
            }
        });
        $(document).on('click', '.list-group-item1', function () {
            var value = $(this).text();
            var cid = $(this).data('id');
            $('#community').val(value);
            $('#community_id').val(cid);
            $('#community_list').html("");
        });
    jQuery("#single").select2({
        placeholder: "Please Select",
        allowClear: true
    });
    jQuery("#multiple").select2({
    placeholder: "Please Select",
            allowClear: true
    });
            @if (Session::has('message'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-full-width"
    };
    toastr.success("{{ session('message') }}");
    @endif
            @if (Session::has('error'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-full-width"
    };
    toastr.error("{{ session('error') }}");
    @endif
            @if (Session::has('info'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    ;
    toastr.info("{{ session('info') }}");
    @endif
            @if (Session::has('warning'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true
    };
    toastr.warning("{{ session('warning') }}");
            @endif
</script>
