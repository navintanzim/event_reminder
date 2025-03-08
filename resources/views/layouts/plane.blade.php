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
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <![endif]-->


    @yield('header-resources')

</head>

{{--<body class="hold-transition sidebar-mini skin-purple">--}}
<body class="hold-transition fixed sidebar-mini">

{{ csrf_field() }}

<div class="wrapper">

<?php
if (!empty(Session::get('user_pic'))) {
    $userPic = url("/") . '/users/upload/' . Session::get('user_pic');
} else {
    $userPic = URL::to('/assets/images/default_profile.jpg');
}
?>

@include ('navigation.nav')

@yield('body')

<!-- /.content-wrapper -->
    @if(!env('IS_MOBILE'))
    <footer class="main-footer">
        <div class="pull-right hidden-xs" style="margin-right: 40px">
            <b>Version</b> 2.0
        </div>

        

    </footer>
    @endif

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
       
        {{--<div class="col-sm-9"></div>--}}
        {{--<div class="col-sm-3 msgtost2">--}}
        <div class="msgtost2">
            
            <div class="tooltip-demo pull-right">
           

            </div>
        </div>
    </div>

</div>

{{--<script type="text/javascript" src="{{ asset("home/feedback/support_widget.js") }}"></script>--}}
<!--  only for vue js !-->
@if(Request::is('dms/*'))
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset("assets/plugins/jquery/jquery.min.js") }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <script>
        $('.user-menu').click(function () {
            $(this).toggleClass('open');
        });
        $('.notifications-menu').click(function () {
            $(this).toggleClass('open');
        });

        $(function () {
            // $('ul li').on('click', function () {
            //     $(this).addClass('active').siblings().removeClass('active');
            // });
        });
    </script>
@else

    <!-- jQuery -->
    <script src="{{ asset("assets/plugins/jquery/jquery.min.js") }}" src="" type="text/javascript"></script>
    <script src="{{ asset('js/admin.js') }}"></script>

    <script src="{{ asset("assets/scripts/sweetalert2.all.js") }}"></script>
    <script src="{{ asset("assets/plugins/toastr/toastr.js") }}"></script>
    <script src="{{ asset("assets/scripts/custom.js") }}"></script>
    <!-- AdminLTE for demo purposes -->
    {{--        <script src="{{ url("assets/scripts/js/demo.js") }}"></script>--}}
@endif



@yield('footer-script')

{{--Global search box script--}}
<script>

    $(document).ready(function () {

        var checkSearchSession = localStorage.getItem("dropdownSearchBox");
        if (checkSearchSession) {
            $("#dropdown_search_icon").removeClass('fa-search');
            $("#dropdown_search_icon").addClass('fa-times');
            $("#dropdownSearchBox").closest('li').addClass('open');
            $("#dropdownSearchBox").attr('aria-expanded', 'true');
        }

        $("#dropdownSearchBox").click(function () {

            var getSearchSession = localStorage.getItem("dropdownSearchBox");
            if (getSearchSession) {
                $("#dropdown_search_icon").removeClass('fa-times');
                $("#dropdown_search_icon").addClass('fa-search');
                $(this).closest('li').removeClass('open');
                $(this).attr('aria-expanded', 'false');
                localStorage.removeItem("dropdownSearchBox");
            } else {
                localStorage.setItem("dropdownSearchBox", "open");
                $("#dropdown_search_icon").removeClass('fa-search');
                $("#dropdown_search_icon").addClass('fa-times');
                $(this).closest('li').addClass('open');
                $(this).attr('aria-expanded', 'true');
            }
        });

        feedbackmessage();

        function feedbackmessage() {
            $.ajax({
                {{--                url: '{{ url("settings/fMsgShow") }}',--}}
                type: "get",
                data: {},
                success: function (data) {
                    if (data.id == 2) {
                        $("#msgtost2").css('display', 'block');
                        $("#feature_text2").html(data.feature_text);
                    }

                }
            })
        }

        $(".feedbackbtn2").click(function () {
            var featurId = $("#msg2").val();
            var value = $(this).val();
            $("#msgtost2").remove();
            $.ajax({
                url: '{{ url("settings/feedback") }}',
                type: "get",
                data: {value: value, featurId: featurId},
                success: function (data) {
                }
            })
        })


        // Notification Count Script
        notificationCount();
        function notificationCount() {
            $.ajax({
                url: '{{ url("/notifications/count") }}',
                type: "get",
                success: function (result) {
                    $('#notificationCount').html(result.length)
                    $('.countPendingNotification').html(result)
                }
            })
        }
        // End Notification Count Script

        // Unread Notification load Script
        var flag = 0;
        $("#loadNotifications").click(function () {
            if (flag == 0) {
                $.ajax({
                    url: '{{ url("/notifications/show") }}',
                    type: "get",
                    success: function (data) {
                        flag = 1;

                        $.getScript("/assets/scripts/moment.min.js").done(function () {
                            if (data.length == 0) {
                                $("#notificationLoading").html('You have no new notification');
                            } else {
                                $.each(data, function (key, value) {
                                    $("#notification").append('<li>' +
                                        '<a href="/single-notification/' + value.id + '" class="notificationitem">' +
                                        '<i class="fa fa-paper-plane fa-fw"></i>' + value.email_subject +
                                        ' <div class="pull-right"><small class="text-muted"><i class="fa fa-clock-o"> ' + moment(value.created_at).fromNow() + '</i></small></div>' +
                                        '</a>' +
                                        '</li>')
                                });

                                $('#notificationLoading').hide();
                            }
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        flag = 0;
                        console.log(errorThrown);
                    }
                })
            }
        })
        // End Unread Notification load Script
    });
</script>

<script type="text/javascript">
    // $("input[type=text]:not([class*='textOnly'],[class*='email'],[class*='exam'],[class*='number'],[class*='bnEng'],[class*='textOnlyEng'],[class*='datepicker'],[class*='mobile_number_validation'])").addClass('engOnly');

    // Bootstrap Tooltip initialize
    jQuery('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });

    // Bootstrap Tooltip initialize
    jQuery('[data-toggle="tooltip"]').tooltip();

    // popover demo
    jQuery("[data-toggle=popover]").popover()
</script>
@if(Auth::user())
    <script type="text/javascript">
        var setSession = '';
        var isMobile = {{ env('IS_MOBILE') ? 'true' : 'false' }};
        var url = "/users/get-user-session";
        if(isMobile){
            let currentUrl = window.location.href;
            let queryParams = currentUrl.split('?')[1] || '';
            url = url+"?"+queryParams;
        }


        function getSession() {
            $.get(url, function (data, status) {
                if (data.responseCode == 1) {
                    setSession = setTimeout(getSession, 6000);
                } else {
                    // alert('Your session has been closed. Please login again');
                    // window.location.replace('/login');
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Your session has been closed. Please login again',
                        footer: '<a href="/login">Login</a>'
                    }).then((result) => {
                        if (result.value) {
                            window.location.replace('/login')
                        }
                    })
                }
            });
        }

        setSession = setTimeout(getSession, 6000);
    </script>
@endif





{{-- Store URL info --}}
<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>

<script type="text/javascript">
    var ip_address = '<?php echo $_SERVER['REMOTE_ADDR'];?>';

    var user_id = '0';
    @if(\Illuminate\Support\Facades\Auth::user())
        user_id = '{{ Auth::user()->id }}';
            @endif

    var message = 'Ok';
    @if(isset($exception))
        message = "Invalid Id! 401";
            @endif

    var project_name = "{{ env('project_code') }}" + "." + "<?php echo env('SERVER_TYPE', 'unknown');?>";

</script>

<?php if (env('mongo_audit_log')) {
    require_once(public_path() . "/url_webservice/set-app-data.blade.php");
} ?>
<script>
    // window.ba_sw_id = 'bcf8ddf0-f088-465b-b1bc-c9410ba2e35b';
    // var s1 = document.createElement('script');
    // s1.setAttribute('src','https://uat-feedback.oss.net.bd/src/0.1.1/social_widget_link.js');
    // document.head.appendChild(s1);
</script>
</body>
</html>
