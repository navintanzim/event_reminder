<?php echo
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: text/html');
?>

<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ env('PROJECT_NAME') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fav icon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset("assets/images/favicon.ico") }}"/>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}" media="all"/>
    <link rel="stylesheet" href="/css/font-awesome.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css?v=202102.12">
    <link rel="stylesheet" href="/css/responsive.css?v=202102.12">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.css') }}"/>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <style>
        .panel-heading{font-size: 19px;}
        .panel-heading > .checkbox{font-size: 14px;}
        body {
            @if (env('IS_MOBILE'))
                background: white;
            @endif
        }

        .content-wrapper{
            min-height: 250px !important;
        }
    </style>


    @yield('header-resources')

</head>

{{--<body class="hold-transition sidebar-mini skin-purple">--}}
<body class="hold-transition fixed sidebar-mini">

{{ csrf_field() }}

<div class="wrapper">


@include('navigation.home.header')

@yield('body')

@include('navigation.home.footer')
<!-- /.content-wrapper -->
  

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        </ul>
        <div class="tab-content">
            <div class="tab-pane" id="control-sidebar-home-tab"></div>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <div class="control-sidebar-bg"></div>

    <div id="helpDiv">
       
        <div class="msgtost2">
            
            <div class="tooltip-demo pull-right">
           

            </div>
        </div>
    </div>

</div>

    <!-- jQuery -->
    <script src="{{ asset("assets/plugins/jquery/jquery.min.js") }}" src="" type="text/javascript"></script>
    <script src="{{ asset('js/admin.js') }}"></script>

    <script src="{{ asset("assets/scripts/sweetalert2.all.js") }}"></script>
    <script src="{{ asset("assets/plugins/toastr/toastr.js") }}"></script>
    <script src="{{ asset("assets/scripts/custom.js") }}"></script>









</body>
</html>
