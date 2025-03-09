<?php

use App\Libraries\CommonFunction;
use Illuminate\Support\Facades\Auth;

$user_name = Auth::user()->name;
?>

@if(env('IS_MOBILE') == false)
<!-- Main Header -->
<header class="main-header" style="">
    <!-- Logo -->
    <a href="#" class="logo">
        <span class="logo-mini" style="font-size: 10px;font-weight: bold;"><img class="img-responsive"
                                                                                src="{{ url('assets/images/business_automation.png') }}"></span>
        <span class="logo-lg"><img style="height: 50px; width: 120px; padding:2px;" class="img-responsive"
                                   src="{{ url('assets/images/business_automation.png') }}"> </span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top text-center" role="navigation">

    <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                


                <li class="dropdown notifications-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="loadNotifications">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-success" id="notificationCount"></span>
                        <span class="label label-warning countPendingNotification"></span>

                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have <span class="countPendingNotification"></span> new notifications
                        </li>
                        <li>
                            <!-- Inner Menu: contains the notifications -->
                            <ul class="menu" id="notification">
                                <li class="text-center" id="notificationLoading">
                                    <i class="fa fa-spinner fa-pulse fa-3x"></i>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="/notification-all">See All Messages</a></li>
                    </ul>
                </li>

                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                    {{--                        <img src="{{ $userPic }}" class="user-image" alt="User Image">--}}
                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ $user_name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="{{ $userPic }}" class="img-circle" alt="User Image">
                            <p>
                                {{ $user_name }}
                                - @if(isset(Auth::user()->designation)){!! Auth::user()->designation !!}@endif
                                {{--                                <small>Member since Nov. 2012</small>--}}
                                <small>Last login: {{ Session::get('last_login_time') }}</small>
                                
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ url('users/profileinfo') }}" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ url('logout') }}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>

                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                {{--                <li>--}}
                {{--                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>--}}
                {{--                </li>--}}
            </ul>
        </div>
        <div class="navbar-header header-caption" style="font-size: 25px; color: #2d2dc3;">{{env('TOPBAR_HEADER')}}</div>
    </nav>
</header>
@endif
