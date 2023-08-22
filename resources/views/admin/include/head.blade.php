<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> @yield('title') </title>
<!-- Bootstrap core CSS -->

<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

<link href="{{asset('fonts/css/font-awesome.min.css')}}" rel="stylesheet">
<link href="{{asset('css/animate.min.css')}}" rel="stylesheet">
<link rel="shortcut icon" href="{{asset('images/Nr-logo.ico')}}">
<link rel="icon" sizes="128x128" href="{{asset('images/Nr-logo.ico')}}">
<!-- Custom styling plus plugins -->
<link href="{{asset('css/custom.css')}}?v={{time()}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/developer.css')}}?v={{time()}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/maps/jquery-jvectormap-2.0.3.css')}}" />
<link href="{{asset('css/icheck/flat/green.css')}}" rel="stylesheet" />
<link href="{{asset('css/floatexamples.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('css/jquery.dataTables.min.css')}}?v={{time()}}" rel="stylesheet" type="text/css" />
<link href="{{asset('css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('css/bootstrap-datepicker.css')}}" rel="stylesheet">  

<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/nprogress.js')}}"></script>
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script src="{{asset('js/tinymce.min.js')}}" referrerpolicy="origin"></script>
<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('js/letter.avatar.js')}}"></script>
<script>
    tinymce.init({
      selector: '#mytextarea'
    });
  </script>