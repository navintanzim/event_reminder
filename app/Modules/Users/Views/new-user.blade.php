<?php

use Illuminate\Support\Facades\Auth;

if(Auth::user()->user_type != '1x101'){
    die('no access right! Please contact the system administrator');
}


?>

@extends('layouts.admin')

@section('header-resources')

    <link rel="stylesheet" href="{{ asset("assets/plugins/datepicker-oss/css/bootstrap-datetimepicker.min.css") }}" />
@endsection

@section("content")

    @include('partials.messages')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h5><strong><i class="fa fa-user-plus" aria-hidden="true"></i> Create New User</strong></h5>
                </div>

                {!! Form::open(array('url' => '/users/store-new-user','method' => 'patch', 'class' => 'form-horizontal', 'id' => 'create_user_form',
                'enctype' =>'multipart/form-data', 'files' => 'true')) !!}

                <div class="panel-body">
                    <div class="col-md-6">

                        <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : ''}}">
                            <label class="col-md-4 required-star">User Name</label>
                            <div class="col-md-7">
                                {!! Form::text('name', $value = null, $attributes = array('class'=>'form-control required',
                                'data-rule-maxlength'=>'40', 'placeholder'=>'Enter Name','id'=>"name")) !!}
                                {!! $errors->first('name','<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                      

                        @if($logged_user_type == '1x101') {{-- For System Admin --}}

                        <div class="form-group has-feedback {{ $errors->has('user_type') ? 'has-error' : ''}}">
                            <label class="col-md-4 required-star">User Type</label>
                            <div class="col-md-7">
                                {!! Form::select('user_type', $user_types, '', $attributes = array('class'=>'form-control required','data-rule-maxlength'=>'40',
                                'placeholder' => 'Select One', 'id'=>"user_type")) !!}
                                {!! $errors->first('user_type','<span class="help-block">:message</span>') !!}
                            </div>
                        </div>


                        @endif

                        <div class="form-group has-feedback {{$errors->has('user_DOB') ? 'has-error' : ''}}">
                            {!! Form::label('user_DOB','Date of Birth',['class'=>'col-md-4 required-star']) !!}
                            <div class="col-md-7">
                                <div class="input-group date datepicker" data-date="12-03-2015"
                                     data-date-format="dd-mm-yyyy">
                                    {!! Form::text('user_DOB',null, ['class'=>'form-control required', 'placeholder' => 'Pick from calender']) !!}
                                    <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                                </div>
                                {!! $errors->first('user_DOB','<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        


                    </div><!--/col-md-6-->

                    <div class="col-md-6">

                       
                        <div class="form-group has-feedback {{ $errors->has('phone') ? 'has-error' : ''}}">
                            <label class="col-md-4 required-star">Mobile Number</label>
                            <div class="col-md-7">
                                {!! Form::text('phone', $value = null, $attributes = array('class'=>'form-control required phone', 'maxlength'=>"15",
                                'minlength'=>"8", 'placeholder'=>'Enter your Mobile Number','id'=>"phone")) !!}
                                {!! $errors->first('phone','<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : ''}}">
                            <label class="col-md-4 required-star">Email Address</label>
                            <div class="col-md-7">
                                {!! Form::text('email', $value = null, $attributes = array('class'=>'form-control email required', 'data-rule-maxlength'=>'40',
                                'placeholder'=>'Enter your Email Address','id'=>"email")) !!}
                                {!! $errors->first('email','<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        

                    </div>
                </div> <!--/panel-body-->


                <div class="panel-footer">
                    <div class="pull-left">
                        <a href="{{url('users/lists')}}" class="btn btn-default btn-sm"><i class="fa fa-times"></i> <b>Close</b></a>
                    </div>
                    <div class="pull-right">
                        
                        <button type="submit" class="btn btn-block btn-sm btn-primary"><b>Submit</b></button>
                       
                    </div>
                    <div class="clearfix"></div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection

@section('footer-script')
    <link rel="stylesheet" href="{{ asset("assets/plugins/select2/select2.min.css") }}">
    <script src="{{ asset("assets/plugins/select2/select2.min.js") }}"></script>
    <script src="{{ asset("assets/scripts/jquery.validate.min.js") }}"></script>
    <script src="{{ asset("assets/scripts/moment.min.js") }}"></script>
    <script src="{{ asset("assets/plugins/datepicker-oss/js/bootstrap-datetimepicker.js") }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var phoneNumber=$('#phone').val();
        $.validator.addMethod('customphone', function (phoneNumber) {
            var phone_pattern = /^(?:\+88|01)?(?:\d{11}|\d{13})$/;
            return phone_pattern.test(phoneNumber);
        }, "Please enter a valid phone number");

        $(function () {
            var _token = $('input[name="_token"]').val();
            $("#create_user_form").validate({
                rules: {
                    phone: 'customphone'
                },
                errorPlacement: function () {
                    return false;
                }
            });
        });

        $(document).ready(function () {
            var today = new Date();
            var yyyy = today.getFullYear();
            $('.datepicker').datetimepicker({
                viewMode: 'years',
                format: 'DD-MMM-YYYY',
                maxDate: (new Date()),
                minDate: '01/01/' + (yyyy - 60)
            });

        });

        $(".Select2").select2({
            width: '100%'
        });
    </script>
@endsection
