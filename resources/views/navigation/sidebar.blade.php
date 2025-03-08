<?php

use Illuminate\Support\Facades\Auth;
use App\Modules\Team\Models\TeamMembers;

$user_type = Auth::user()->user_type;
$type = explode('x', $user_type);
$Segment = Request::segment(3);
$auth_user_id = Auth::id();

?>
@if(env('IS_MOBILE') == false)
<aside class="main-sidebar">
    <section class="sidebar">
        


        <ul class="sidebar-menu" data-widget="tree">
            <li class="{{ (Request::is('dashboard*') ? 'active' : '') }}">
                <a href="{{ url ('/dashboard') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- <li class="{{ ((Request::is('issue/*')) ? 'active' : '') }}">
                    <a href="{{ url ('/issue/lists')}}"><i class="fa fa-users"></i>
                        <span>
                        Events
                        </span>
                    </a>
            </li> -->

            <li class="{{ (Request::is('meeting/*') ? 'active' : '') }}">
                                    <a href="{{ url ('/meeting/lists')}}"><i class="fa fa-book fa-fw"></i>
                                        Meeting
                                    </a>
            </li>
                
            @if(Auth::user()->user_type == '1x101')
                
            <li class="{{ ((Request::is('users/*')) ? 'active' : '') }}">
                                        <a href="{{ url ('/users/lists')}}"><i class="fa fa-users"></i>
                                            <span>
                                                Users
                                            </span>
                                        </a>
                                    </li>
                
            @endif
            
        </ul>
        


        <div id="1">
            <div class="circular-sb" id="msgtost" style="display: none;">
                <p id="">
                <p id="feature_text"></p>
                <button class="btn btn-success feedbackbtn" value="ok" id="yesbtn" style="margin-left: 30px;">OK
                </button>
                </p>

                <input type="hidden" value="1" id="msg1">
                <div class="circle1"></div>
                <div class="circle2"></div>
            </div>
        </div>

        
    </section>
    <!-- /.sidebar -->
</aside>

@endif

