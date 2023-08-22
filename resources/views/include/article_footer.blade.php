<footer class="container-fluid cm-footer">
    <div class="text-center container howto-nav"></div>
    <div class="text-center small container copyright-nav w-sm-25">
        <ul class="list-inline">
            <li class="first">
                <a class="gray-light-link" href="{{url('faqCategory')}}" target="_blank" class="gray-light-link">FAQs</a>
            </li>
            <li>
                <a class="gray-light-link" title="Community Guidelines" href="{{url('community-guidelines')}}">Community Guidelines</a>
            </li>
            <li>
                <a class="gray-light-link" title="Posting Instructions" href="{{url('posting-instructions')}}">Posting Instructions</a>
            </li>
            <li><a href="{{url('terms')}}" target="_blank" class="gray-light-link">Terms of Use</a>
            </li>
            <li class="last">
                <a href="{{url('privacy')}}" target="_blank" class="gray-light-link">Privacy Policy</a>
            </li>
        </ul>
    </div>
    <div class="text-center text-muted small container">© 2021 Neighborhood Reporter Media</div>
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
    
    $("#js-user-nav-menu").click(function () {
        $(".UserMenu_UserMenu  ul.dropdown-menu.dropdown-menu-right").toggle();
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
        "progressBar": true
    };
    toastr.error("{{ session('error') }}");
    @endif
            @if (Session::has('info'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true
    };
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
