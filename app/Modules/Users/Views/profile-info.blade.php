@extends('layouts.admin')
<?php

use App\Libraries\Encryption;



?>
<link rel="stylesheet" href="{{ asset("assets/plugins/intlTelInput/css/intlTelInput.css") }}"/>
@section('header-resources')
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            font-size: 14px;
        }

        .analog-clock {
            width: 250px;
            height: 250px;
        }

        #clock-face {
            stroke: black;
            stroke-width: 2px;
            fill: white;
        }

        #clock-face-db {
            stroke: black;
            stroke-width: 2px;
            fill: white;
        }

        #h-hand, #m-hand, #s-hand, #s-tail, #db-h-hand, #db-m-hand, #db-s-hand, #db-s-tail {
            stroke: black;
            stroke-linecap: round;
        }

        #h-hand, #db-h-hand {
            stroke-width: 3px;
        }

        #m-hand, #db-m-hand {
            stroke-width: 2px;
        }

        #s-hand, #db-s-hand {
            stroke-width: 1px;
        }

        .time-text {
            text-align: center;
        }

        .picture-container {
            position: relative;
            width: 500px;
            height: 300px;
            margin: 20px auto;
            border: 10px solid #fff;
            box-shadow: 0 5px 5px #000;
        }

        .picture {
            display: block;
            width: 100%;
            height: 300px;
        }

        .face {
            position: absolute;
            border: 2px solid green;
        }
    </style>

    <link rel="stylesheet" href="{{ asset("assets/plugins/datepicker-oss/css/bootstrap-datetimepicker.min.css") }}"/>
    @include('partials.datatable-css')
@endsection

@section('content')

    @include('partials.messages')

    {{--    @if(Session::has('checkProfile'))--}}
    {{--        <div class="row">--}}
    {{--            <div class="col-sm-12">--}}
    {{--                <div class="alert alert-danger">--}}
    {{--                    <strong>Dear user</strong><br><br>--}}
    {{--                    <p>We noticed that your profile setting does not complete yet 100%.<br>Please upload your <b>profile--}}
    {{--                            picture</b>,<b>signature</b> And other required information <br>Without required filed you can't--}}
    {{--                        apply for any kind of Registration.<br><br>--}}
    {{--                        Thanks<br>BHTPA Authority--}}
    {{--                    </p>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    @endif--}}

    <div class="row">
        <div class="col-md-12">
            @if(Session::has('message'))
                <div class="alert alert-warning">
                    {{session('message')}}
                </div>
            @endif

            <div class="nav-tabs-custom">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab"
                                                  aria-expanded="false"><strong>Profile</strong></a></li>
                          
                        </ul>
                    </div>

                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="">
                                    <div class="col-md-6 col-sm-6">
                                        {!! Form::open(array('url' => '/users/profile_updates/'.$id,'method' =>'post','id'=>'update_form', 'class' => 'form-horizontal',
                                                'enctype'=>'multipart/form-data')) !!}
                                        <fieldset>
                                            {!! Form::hidden('Uid', $id) !!}
                                            <div class="row">
                                                <div class="progress hidden pull-right" id="upload_progress"
                                                     style="width: 50%;">
                                                    <div class="progress-bar progress-bar-striped active"
                                                         role="progressbar"
                                                         aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                                         style="width: 100%">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group has-feedback">
                                                <label class="col-lg-4 text-left">User Type</label>
                                                <div class="col-lg-8">
                                                    {{ $user_type_info->type_name }}
                                                </div>
                                            </div>
                                            @if($users->desk_id = '0')
                                                <div class="form-group has-feedback">
                                                    <label class="col-lg-4 text-left">User Desk Name</label>
                                                    <div class="col-lg-7">
                                                        {{$user_desk->desk_name}}
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="form-group has-feedback">
                                                <label class="col-lg-4 text-left">Email Address</label>
                                                <div class="col-lg-8">
                                                    {{ $users->email }}
                                                </div>
                                            </div>

                                            <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : ''}}">
                                                <label class="col-lg-4 text-left required-star">User’s first
                                                    name</label>
                                                <div class="col-lg-8">
                                                    {!! Form::text('name',$users->name, $attributes = array('class'=>'form-control required',
                                                    'placeholder'=>'Enter First Name','id'=>"name", 'data-rule-maxlength'=>'50')) !!}
                                                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                                    {!! $errors->first('name','<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>

                                            

                                            <div class="form-group">
                                                <label class="col-lg-4 text-left">Date of Birth</label>
                                                <div class="col-lg-8">
                                                    <div class="datepicker input-group date"
                                                         data-date-format="yyyy-mm-dd">
                                                        <?php
                                                        $dob = '';
                                                        if ($users->user_DOB) {
                                                            $dob = App\Libraries\CommonFunction::changeDateFormat($users->user_DOB);
                                                        }
                                                        ?>
                                                        {!! Form::text('user_DOB', $dob, ['class'=>'form-control']) !!}
                                                        <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                                        {!! $errors->first('user_DOB','<span class="help-block">:message</span>') !!}


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group has-feedback {{ $errors->has('phone') ? 'has-error' : ''}}">
                                                <label class="col-lg-4 text-left required-star">Mobile Number </label>
                                                <div class="col-lg-8">
                                                    {!! Form::text('phone',$users->phone, $attributes = array('class'=>'form-control required mobile_number_validation',
                                                    'placeholder'=>'Enter your Mobile Number','id'=>"phone", 'data-rule-maxlength'=>'16')) !!}
                                                    <span class="text-danger mobile_number_error"></span>
                                                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                                                    {!! $errors->first('phone','<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>

                                            <div class="form-group has-feedback">
                                                <label class="col-lg-4 text-left">User Status</label>
                                                <div class="col-lg-8">
                                                    {{ $users->user_status }}
                                                </div>
                                            </div>

                                            <div class="form-group has-feedback">
                                                <label class="col-lg-4 text-left"></label>
                                                <div class="col-lg-8">
                                                    @if(isset($desk) && $desk)
                                                        <fieldset class="scheduler-border">
                                                            <legend class="scheduler-border">Assigned Desk</legend>
                                                            <div class="control-group">
                                                                <?php $i = 1;?>
                                                                @foreach($desk as $desk_name)
                                                                    <dd>{{$i++}}. {!!$desk_name->desk_name!!}</dd>
                                                                @endforeach
                                                            </div>
                                                        </fieldset>
                                                    @endif
                                                </div>
                                            </div>
                                           

                                        <!---
                                            <div class="form-group">
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-8">
                                                    <?php
                                        $checked = '';
                                        if ($users->auth_token_allow == '1')
                                            $checked = "checked='checked'";
                                        ?>
                                        @if($user_type_info->auth_token_type=='optional')
                                            <input type="checkbox" name="auth_token_allow" value="1"
                                 {{$checked}} id="all_second_step">
                                                        <label for="all_second_step">Allow two step verification</label>
                                                    @endif
                                                </div>
                                            </div>
                                            -->


                                            <div class="form-group">
                                                <div class="col-md-9"></div>
                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-primary btn-block"
                                                            id='update_info_btn'><b>Save</b></button>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    {!! App\Libraries\CommonFunction::showAuditLog($users->updated_at, $users->updated_by) !!}
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-1 col-sm-1"></div>

                                    


                                    

                                    
                                    <div class="col-xs-12 col-md-5 col-sm-5 col-sm-offset-1">
                                    <div class="row">
                                       
                                    

                                    </div>
                                    </div>
                                    {!! Form::close() !!}
                                    
                                </div>
                                <div class="clearfix"></div>
                            </div><!-- /.tab-pane -->

                            
                            @if(\Illuminate\Support\Facades\Auth::user()->first_login == 1)
                                @if(Auth::user()->user_type != '1x101')
                                    <div class="tab-pane table-responsive" id="tab_3">
                                        <br>
                                        {!! Form::open(array('url' => '/users/process-delegation','method' =>
                                        'patch','id'=>'delegation', 'class' => '','enctype'
                                        =>'multipart/form-data')) !!}
                                        <div class="form-group col-lg-8">
                                            <div class="col-lg-3"><label class="required-star">User Type</label></div>
                                            <div class="col-lg-6">
                                                <?php $userDesignation = ($delegate_to_types ? $delegate_to_types : '') ?>
                                                {!! Form::select('designation', $userDesignation, '', $attributes =
                                                array('class'=>'form-control required', 'onchange'=>'getUserDeligate()',
                                                'placeholder' => 'Select Type', 'id'=>"designation_2")) !!}
                                            </div>
                                        </div>

                                        <div class="form-group  col-lg-8">
                                            <div class="col-lg-3"><label class="required-star">Delegated User</label>
                                            </div>
                                            <div class="col-lg-6">
                                                {!! Form::select('delegated_user', [] , '', $attributes =
                                                array('class'=>'form-control required',
                                                'placeholder' => 'Select User', 'id'=>"delegated_user")) !!}
                                            </div>
                                        </div>

                                        <div class="form-group  col-lg-8">
                                            <div class="col-lg-3"><label>Remarks</label></div>
                                            <div class="col-lg-6">
                                                {!! Form::text('remarks','', $attributes = array('class'=>'form-control',
                                                'placeholder'=>'Enter your Remarks','id'=>"remarks")) !!}
                                            </div>
                                        </div>


                                        <div class="form-group  col-lg-8">
                                            <div class="col-lg-6 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary" id='update_info_btn'><b>Deligate</b>
                                                </button>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div><!-- /.tab-pane -->
                                @endif

                                <div class="tab-pane" id="tab_4">
                                    <table id="last50activities"
                                           class="table table-striped table-responsive table-bordered dt-responsive"
                                           width="100%" cellspacing="0" style="font-size: 14px;">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Action Taken</th>
                                            <th>IP</th>
                                            <th>Date & Time</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div><!-- /.tab-pane -->

                                <div class="tab-pane" id="tab_5">
                                    <table id="accessList"
                                           class="table table-striped table-responsive table-bordered dt-responsive"
                                           width="100%" cellspacing="0" style="font-size: 14px;">
                                        <thead>
                                        <tr>
                                            <th>Remote Address</th>
                                            <th>Log in time</th>
                                            <th>Log out time</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div><!-- /.tab-pane -->

                                <div class="tab-pane" id="tab_6">
                                    <table id="accessLogFailed"
                                           class="table table-striped table-responsive table-bordered dt-responsive"
                                           width="100%" cellspacing="0" style="font-size: 14px;">
                                        <thead>
                                        <tr>
                                            <th>Remote Address</th>
                                            <th>Failed Login Time</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div><!-- /.tab-pane -->

                                <div class="tab-pane" id="tab_7">
                                    <div class="col-sm-12">
                                        <div class="col-sm-6">
                                            <div class="form-group has-feedback" id="serverTime">
                                                <div class="col-lg-12">
                                                    <fieldset class="scheduler-border">
                                                        <legend class="scheduler-border">Application Time</legend>
                                                        {{--                                                                                            <div class="control-group">--}}
                                                        <strong>Date : </strong> <span id="app_date"></span> <br/>
                                                        {{--                                                                                                <strong>Time : </strong> <span id="app_time">{{ date('g:i:s A') }}</span>--}}
                                                        {{--                                                                                            </div>--}}
                                                        <div style="margin-top: 50px; margin-left: 100px"
                                                             class="analog-clock">
                                                            <div class="time-text hidden">
                                                                <span id="hr">00</span>
                                                                <span>:</span>
                                                                <span id="min">00</span>
                                                                <span>:</span>
                                                                <span id="sec">00</span>
                                                                <span id="suffix">--</span>
                                                            </div>
                                                            <svg width="140" height="140">
                                                                <circle id="clock-face" cx="70" cy="70" r="65"/>
                                                                <line id="h-hand" x1="70" y1="70" x2="70" y2="38"/>
                                                                <line id="m-hand" x1="70" y1="70" x2="70" y2="20"/>
                                                                <line id="s-hand" x1="70" y1="70" x2="70" y2="12"/>
                                                                <line id="s-tail" x1="70" y1="70" x2="70" y2="56"/>
                                                                <text x="62" y="18">12</text>
                                                                <text x="94" y="28">1</text>
                                                                <text x="114" y="45">2</text>

                                                                <text x="126" y="76">3</text>
                                                                <text x="117" y="104">4</text>
                                                                <text x="96" y="122">5</text>

                                                                <text x="66" y="130">6</text>
                                                                <text x="38" y="124">7</text>
                                                                <text x="18" y="104">8</text>

                                                                <text x="7" y="76">9</text>
                                                                <text x="14" y="45">10</text>
                                                                <text x="34" y="26">11</text>
                                                            </svg>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group has-feedback">
                                                <div class="col-lg-12">
                                                    <fieldset class="scheduler-border">
                                                        <legend class="scheduler-border">Database Time</legend>
                                                        <div class="control-group">
                                                            <strong>Date : </strong> <span
                                                                    id="db_date"></span> <br/>
                                                            {{--                                                            <strong>Time : </strong> <span--}}
                                                            {{--                                                                    id="db_time"></span>--}}

                                                            <div style="margin-top: 50px; margin-left: 100px"
                                                                 class="analog-clock">
                                                                <div class="time-text hidden">
                                                                    <span id="db_hr">00</span>
                                                                    <span>:</span>
                                                                    <span id="db_min">00</span>
                                                                    <span>:</span>
                                                                    <span id="db_sec">00</span>
                                                                    <span id="suffix">--</span>
                                                                </div>
                                                                <svg width="140" height="140">
                                                                    <circle id="clock-face-db" cx="70" cy="70" r="65"/>
                                                                    <line id="db-h-hand" x1="70" y1="70" x2="70"
                                                                          y2="38"/>
                                                                    <line id="db-m-hand" x1="70" y1="70" x2="70"
                                                                          y2="20"/>
                                                                    <line id="db-s-hand" x1="70" y1="70" x2="70"
                                                                          y2="12"/>
                                                                    <line id="db-s-tail" x1="70" y1="70" x2="70"
                                                                          y2="56"/>
                                                                    <text x="62" y="18">12</text>
                                                                    <text x="94" y="28">1</text>
                                                                    <text x="114" y="45">2</text>

                                                                    <text x="126" y="76">3</text>
                                                                    <text x="117" y="104">4</text>
                                                                    <text x="96" y="122">5</text>

                                                                    <text x="66" y="130">6</text>
                                                                    <text x="38" y="124">7</text>
                                                                    <text x="18" y="104">8</text>

                                                                    <text x="7" y="76">9</text>
                                                                    <text x="14" y="45">10</text>
                                                                    <text x="34" y="26">11</text>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!-- /.tab-pane --><!-- /.tab-pane -->
                                    @endif

                                </div><!-- /.tab-content -->
                        </div>
                    </div>
                </div><!-- nav-tabs-custom -->
            </div>
        </div>

        <div class="clearfix"></div>

        @endsection

        @section('footer-script')
            @include('partials.datatable-js')
            <script src="{{ asset("assets/scripts/jquery.validate.min.js") }}"></script>
            <script src="{{ asset("assets/scripts/moment.min.js") }}"></script>
            <script src="{{ asset("assets/plugins/datepicker-oss/js/bootstrap-datetimepicker.js") }}"></script>
            <script src="{{ asset('assets/plugins/select2.min.js') }}"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.js"></script>
            <script src="{{ asset("assets/plugins/facedetection.js") }}" type="text/javascript"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
            <link rel="stylesheet" href="{{ asset('assets/plugins/select2.min.css') }}">
            <script src="{{ asset("assets/plugins/facedetection.js") }}"></script>

            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
            <script>
                $(document).ready(function () {
                    $(".Select2").select2({
                        width: '100%'
                    });
                    var url = document.location.toString();
                    if (url.match('#')) {
                        $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
                        $('.nav-tabs a').removeClass('active');
                    }
                });

                function getUserDeligate() {
                    var _token = $('input[name="_token"]').val();
                    var designation = $('#designation_2').val();
                    $.ajax({
                        url: '{{url("users/get-delegate-userinfo")}}',
                        type: 'post',
                        data: {
                            _token: _token,
                            designation: designation
                        },
                        dataType: 'json',
                        success: function (response) {
                            html = '<option value="">Select User</option>';
                            $.each(response, function (index, value) {
                                html += '<option value="' + value.id + '" >' + value.name + '</option>';
                            });
                            $('#delegated_user').html(html);
                        },
                        beforeSend: function (xhr) {
                            console.log('before send');
                        },
                        complete: function () {
                            //completed
                        }
                    });
                }

                $(function () {
                    $("#vreg_form").validate({
                        errorPlacement: function () {
                            return false;
                        }
                    });
                });


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $(document).ready(function () {
                   

                    $('.checkGoogleLogin').click(function () {
                        var googleSignUpId = $(this).attr("data-id");
                        if (googleSignUpId == 1) {
                            alert("You Have sign up by google.no need to change password");
                            return false;
                        }
                    });

                    

                });

                $(function () {
                    $('.datepicker').datetimepicker({
                        viewMode: 'years',
                        format: 'DD-MMM-YYYY',
                        minDate: '01/01/1916'
                    });
                });

                $(function () {

                    $('#accessList').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{url("users/get-access-log-data-for-self")}}',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        },
                        columns: [
                            {data: 'ip_address', name: 'ip_address'},
                            {data: 'login_dt', name: 'login_dt'},
                            {data: 'logout_dt', name: 'logout_dt'},

                        ],
                        "aaSorting": []
                    });


                    $('#accessLogFailed').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{url("users/get-access-log-failed")}}',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        },
                        columns: [
                            {data: 'remote_address', name: 'remote_address'},
                            {data: 'created_at', name: 'created_at'}

                        ],
                        "aaSorting": []
                    });

                    $('#last50activities').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{url("users/get-last-50-actions")}}',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        },
                        columns: [
                            {data: 'rownum', name: 'rownum'},
                            {data: 'action', name: 'action'},
                            {data: 'ip_address', name: 'ip_address'},
                            {data: 'created_at', name: 'created_at'}

                        ],
                        "aaSorting": []
                    });
                    

                    var flag = 0;
                    $('.server_date_time').on('click', function () {
                        flag++;
                        if (flag == 1) {
                            getAppTimeDate();
                            getTimeDate();
                        }
                    });

                    function getTimeDate() {
                        $.ajax({
                            type: 'POST',
                            url: '{{url("users/get-server-time")}}',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function (data) {
                                const options = {weekday: "long", year: "numeric", month: "long", day: "numeric"}
                                $('#db_date').html(data.db_date);
                                $('#db_time').html(data.db_time);
                                $('#app_date').html(d.toLocaleDateString("en-US", options));

                                getDbTimeDate(data.db_hour, data.db_min, data.db_sec);
                            }
                        });
                    }
                });


                // analog app clock
                let d = new Date();
                let hour = d.getHours();
                let min = d.getMinutes();
                let sec = d.getSeconds();


                function getAppTimeDate() {
                    //calculate angle
                    let h = 30 * (parseInt(hour) + parseFloat(min / 60));
                    let m = 6 * min;
                    let s = 6 * sec;

                    //move hands
                    setAttr('h-hand', h);
                    setAttr('m-hand', m);
                    setAttr('s-hand', s);
                    setAttr('s-tail', s + 180);

                    //display digital time
                    // h = hour;
                    // m = min;
                    // s = sec;
                    //
                    // if(h >= 12){
                    //     setText('suffix', 'PM');
                    // }else{
                    //     setText('suffix', 'AM');
                    // }
                    //
                    // if(h != 12){
                    //     h %= 12;
                    // }
                    //
                    // setText('sec', s);
                    // setText('min', m);
                    // setText('hr', h);


                    sec++;
                    if (sec == 60) {
                        sec = 0;
                        min++;

                        if (min == 60) {
                            min = 0;
                            hour++;
                        }
                    }

                    //call every second
                    setTimeout(getAppTimeDate, 1000);

                };

                //analog database clock
                function getDbTimeDate(db_hour, db_min, db_sec) {

                    //calculate angle
                    let db_h = 30 * (parseInt(db_hour) + parseFloat(db_min / 60));
                    let db_m = 6 * db_min;
                    let db_s = 6 * db_sec;
                    //move hands
                    setAttr('db-h-hand', db_h);
                    setAttr('db-m-hand', db_m);
                    setAttr('db-s-hand', db_s);
                    setAttr('db-s-tail', db_s + 180);

                    //display digital time
                    // db_h = db_hour;
                    // db_m = db_min;
                    // db_s = db_sec;
                    //
                    // if(db_h >= 12){
                    //     setText('db_suffix', 'PM');
                    // }else{
                    //     setText('db_suffix', 'AM');
                    // }
                    //
                    // if(db_h != 12){
                    //     db_h %= 12;
                    // }
                    //
                    // setText('db_sec', db_s);
                    // setText('db_min', db_m);
                    // setText('db_hr', db_h);

                    db_sec++;
                    if (db_sec == 60) {
                        db_sec = 0;
                        db_min++;

                        if (db_min == 60) {
                            db_min = 0;
                            db_hour++;
                        }
                    }

                    //call every second
                    //setTimeout(getDbTimeDate(db_h, db_m, db_s), 1000);
                    setTimeout(function () {
                        getDbTimeDate(db_hour, db_min, db_sec);
                    }, 1000);

                };

                $('#password_change_form').validate({
                    rules: {
                        user_confirm_password: {
                            equalTo: "#user_new_password"
                        }
                    },
                    errorPlacement: function () {
                        return false;
                    }
                });

                $(document).ready(
                    function () {
                        $("#profile-form").validate({
                            errorPlacement: function () {
                                return false;
                            }
                        });
                        $('.resetIt').on('click', function (e) {
                            e.preventDefault();
                            var imgSrc = $('.resetIt').data('src');
                            var html = '<img src="' + imgSrc + '" class="profile-user-img img-responsive img-circle"alt="Profile Picture" id="user_pic" width="200"/>';
                            $('.addImages').prepend(html);
                            // $('#user_pic').attr('src',$('.resetIt').data('src'));
                            $("#profile_image_div").html('<label id="profile_image_div" style="padding: 1px 3px" class="btn btn-primary  btn-file">\n' +
                                '                                                    <i class="fa fa-picture-o" aria-hidden="true"></i>\n' +
                                '                                                    Browse <input id="fileuploader" type="file" onchange="readURLUser(this);" name="profile_image" data-type="user"\n' +
                                '                                                                  data-ref="{{Encryption::encodeId(Auth::user()->id)}}" style="display: none;">\n' +
                                '                                                </label>');
                            $('div.croppie-container').remove();
                            // $("#profile_image_div").html('');
                            // alert($('.resetIt').data('src'));
                            $('#fileuploader').val('');
                            $('.hiddenReset').addClass('hidden');
                        });
                    });

                $("#delegation").validate({
                    errorPlacement: function () {
                        return false;
                    }

                });
                $("#update_form").validate({
                    errorPlacement: function () {
                        return false;
                    }
                });

                function readURLUser(input) {
                    if (input.files && input.files[0]) {
                        $("#user_err").html('');
                        var mime_type = input.files[0].type;
                        if (!(mime_type == 'image/jpeg' || mime_type == 'image/jpg' || mime_type == 'image/png')) {
                            $("#user_err").html("Image format is not valid. Only PNG or JPEG or JPG type images are allowed.");
                            return false;
                        }
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#user_pic').attr('src', e.target.result);
                            $("#profile_image_div").html("<img  style='height: 50px;width: 100px' src='/assets/images/loadWait.gif'>");
                            $('#update_info_btn').prop('disabled', true);
                        };
                        reader.readAsDataURL(input.files[0]);

                        uploadCrop = $('#user_pic');
                       

                        // $("#image_name").val(data);
                        // $('.ajax-file-upload-statusbar').remove();
                    }
                }

                function readURLSignature(input) {
                    if (input.files && input.files[0]) {
                        $("#signature_error").html('');
                        var mime_type = input.files[0].type;
                        if (!(mime_type == 'image/jpeg' || mime_type == 'image/jpg' || mime_type == 'image/png')) {
                            $("#signature_error").html("Image format is not valid. Only PNG or JPEG or JPG type images are allowed.");
                            return false;
                        }
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#user_signature').attr('src', e.target.result);
                            $('.hiddensignReset').removeClass('hidden');
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }

                function resetImage(e) {
                    $('#user_pic').attr('src', e);

                }

                function resetSignature(e) {
                    $('#user_signature').attr('src', e);
                    $('.hiddensignReset').addClass('hidden');

                }

                $('#update_info_btn').on('click', function (ev) {
                    uploadCrop.croppie('result', {
                        type: 'canvas',
                        size: 'original'
                    }).then(function (resp) {
                        $('#imagebase64').val(resp);
                        $('#update_info_btn').submit();
                    });
                });

                function setAttr(id, val) {
                    var v = 'rotate(' + val + ', 70, 70)';
                    document.getElementById(id).setAttribute('transform', v);
                };

                function setText(id, val) {
                    if (val < 10) {
                        val = '0' + val;
                    }
                    document.getElementById(id).innerHTML = val;
                };

                //window.onload=clock;
            </script>

            <script type="text/javascript">
                $(".picture").change(function () {

                    $('.face').remove();
                    $('#picture').faceDetection({
                        complete: function (faces) {
                            console.log(faces);
                            for (var i = 0; i < faces.length; i++) {
                                $('<div>', {
                                    'class': 'face',
                                    'css': {
                                        'position': 'absolute',
                                        'left': faces[i].x * faces[i].scaleX + 'px',
                                        'top': faces[i].y * faces[i].scaleY + 'px',
                                        'width': faces[i].width * faces[i].scaleX + 'px',
                                        'height': faces[i].height * faces[i].scaleY + 'px'
                                    }
                                })
                                    .insertAfter(this);
                            }
                        },
                        error: function (code, message) {
                            alert('Error: ' + message);
                        }
                    });

                    var $uploadCrop = $('#upload-demo');
                    $uploadCrop.croppie({
                        viewport: {
                            width: 250,
                            height: 250,
                            type: 'square'
                        },
                        boundary: {
                            width: 300,
                            height: 300
                        },
                        enableResize: true,
                    });
                    $uploadCrop.croppie('bind', 'asif.jpeg');
                    // vanillaRotate.addEventListener('click', function(vanilla) {
                    //     $uploadCrop.rotate(parseInt($(this).data('deg')));
                    // });
                    // $('.upload-result').on('click', function (ev) {
                    //     $uploadCrop.croppie('result', {
                    //         type: 'canvas',
                    //         size: 'original'
                    //     }).then(function (resp) {
                    //         $('#imagebase64').val(resp);
                    //         $('#form').submit();
                    //     });
                    // });

                });


            </script>

            <style>
                #accessList {
                    height: 100px !important;
                    overflow: scroll;
                }

                .dataTables_scrollHeadInner {
                    width: 100% !important;
                }

                .profileinfo-table {
                    width: 100% !important;
                }
            </style>

            {{--initial- input plugin--}}
            <script src="{{ asset("assets/plugins/intlTelInput/js/intlTelInput.js") }}" type="text/javascript"></script>
            <script src="{{ asset("assets/plugins/intlTelInput/js/utils.js") }}" type="text/javascript"></script>
            <script>
                $("#phone").intlTelInput({
                    onlyCountries: ["bd"],
                    initialCountry: "BD",
                    placeholderNumberType: "MOBILE",
                    separateDialCode: true,
                });

                $("#user_emergency_contact").intlTelInput({
                    onlyCountries: ["bd"],
                    initialCountry: "BD",
                    placeholderNumberType: "MOBILE",
                    separateDialCode: true,
                });

            </script>

            <script>
                var base_url_qr = '{{url('/')}}';
                var token = '{{ csrf_token() }}';
            </script>

@endsection
