<?php echo
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: text/html');?>
        <!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta content="" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--with provited template--}}
    {{--<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">--}}
    {{--main template--}}
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"
          name="viewport">
    <title>{{ env('PROJECT_NAME') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="/home/images/favicon.ico">
    <link href='//fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&amp;display=swap' rel='stylesheet'>


    @yield('header-resources')

</head>

<body>
{{ csrf_field() }}
@yield('body')



@yield('footer-script')


<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
<script>
    // window.ba_sw_id = 'bcf8ddf0-f088-465b-b1bc-c9410ba2e35b';
    // var s1 = document.createElement('script');
    // s1.setAttribute('src','https://uat-feedback.oss.net.bd/src/0.1.1/social_widget_link.js');
    // document.head.appendChild(s1);
</script>
</body>
</html>
