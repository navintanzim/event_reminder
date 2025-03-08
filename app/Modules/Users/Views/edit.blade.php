<?php
use App\Libraries\Encryption;
$user_type_explode = explode('x', $users->user_type);
$random_number = rand ( 10000 , 99999 );
?>

@extends('layouts.admin')

@section('header-resources')
@endsection

@section("content")

    @include('partials.messages')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h5><strong><i class="fa fa-user" aria-hidden="true"></i> Edit User</strong></h5>
                </div>
                {!! Form::open(array('url' => '/users/update/'.Encryption::encodeId($users->id),'method' => 'patch', 'class' => 'form-horizontal',
                        'id'=> 'user_edit_form')) !!}

                {!! Form::hidden('validateFieldName', '', array('id' => 'validateFieldName')) !!}
                {!! Form::hidden('isRequired', '', array('id' => 'isRequired')) !!}
                {!! Form::hidden('TOKEN_NO', $random_number) !!}

                <div class="panel-body">
                    <div class="col-md-6">
                        <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : ''}}">
                            <label class="col-md-4 text-left required-star">User Name</label>
                            <div class="col-md-7">
                                {!! Form::text('name', $value = $users->name, $attributes = array('class'=>'form-control',
                                'id'=>"name", 'data-rule-maxlength'=>'50')) !!}
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                @if($errors->first('name'))
                                    <span class="control-label">
                            <em><i class="fa fa-times-circle-o"></i> {{ $errors->first('name','') }}</em>
                        </span>
                                @endif
                            </div>
                        </div>
                        
                       

                        <div class="form-group has-feedback {{ $errors->has('user_type') ? 'has-error' : ''}}">
                            <label class="col-md-4 text-left required-star">User Type</label>

                            <div class="col-md-7">
                                {!! Form::select('user_type', $user_types, $users->user_type, $attributes = array('class'=>'form-control required',
                                'id'=>"user_type",'readonly' => "readonly")) !!}
                                @if($errors->first('user_type'))
                                    <span class="control-label">
                            <em><i class="fa fa-times-circle-o"></i> {{ $errors->first('user_type','') }}</em>
                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group has-feedback {{ $errors->has('user_status') ? 'has-error' : ''}}">
                            <label class="col-md-4 text-left">Status</label>

                            <div class="col-md-7">
                                {{ $users->user_status }}
                            </div>
                        </div>


                    </div>

                    {{--Right Side--}}
                    <div class="col-md-6">
                        <div class="form-group has-feedback {{ $errors->has('phone') ? 'has-error' : ''}}">
                            <label class="col-md-4 text-left required-star">Phone</label>

                            <div class="col-md-7">
                                {!! Form::text('phone', $value = $users->phone, $attributes = array('class'=>'form-control required mobile_number_validation',
                                'placeholder'=>'Enter the Mobile Number','id'=>"user_phone", 'data-rule-maxlength'=>'15')) !!}
                                <span class="text-danger mobile_number_error"></span>
                                <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                                @if($errors->first('phone'))
                                    <span class="control-label">
                            <em><i class="fa fa-times-circle-o"></i> {{ $errors->first('phone','') }}</em>
                        </span>
                                @endif
                            </div>
                        </div>
                        

                        <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : ''}}">
                            <label class="col-md-4 text-left">Email</label>

                            <div class="col-md-7">
                                {{ $users->email }}
                            </div>
                        </div>
                        

                    </div>
                </div>

                <div class="panel-footer">
                    
                    <div class="pull-right">
                        <a href="/users/lists" class="btn btn-default btn-sm"><i class="fa fa-times"></i><b>
                                Close</b></a>
                       
                            <button type="submit" class="btn btn-sm btn-primary" id='submit_btn'><b>Save</b>
                            </button>
                      
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

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var phoneNumber=$('#user_phone').val();
        $.validator.addMethod('customphone', function (phoneNumber) {
            var phone_pattern = /^(?:\+88|01)?(?:\d{11}|\d{13})$/;
            return phone_pattern.test(phoneNumber);
        }, "Please enter a valid phone number");
        $(document).ready(function () {
            $("#user_edit_form").validate({
                rules: {
                    user_phone: 'customphone'
                },
                errorPlacement: function () {
                    return false;
                }
            });
        });

        $(document).ready(function () {
            if($('#access_role').val()=='Vendor'){
                $('.vendorclass').show();
                $('#vendor_id').addClass('required');
            }

            $("#district").change(function () {
                var self = $(this);
                var districtId = $('#district').val();
                if (districtId !== '') {
                    $(this).after('<span class="loading_data">Loading...</span>');
                    $("#loaderImg").html("<img style='margin-top: -15px;' src='<?php echo url('/public/assets/images/ajax-loader.gif'); ?>' alt='loading' />");
                    $.ajax({
                        type: "GET",
                        url: "<?php echo url('/users/get-thana-by-district-id'); ?>",
                        data: {
                            districtId: districtId
                        },
                        success: function (response) {
                            var option = '<option value="">Select One</option>';
                            if (response.responseCode == 1) {
                                $.each(response.data, function (id, value) {
                                    if (id == '{{$users->thana}}') {
                                        option += '<option value="' + id + '" selected>' + value + '</option>';
                                    } else {
                                        option += '<option value="' + id + '">' + value + '</option>';
                                    }
                                });
                            }
                            $("#thana").html(option);
                            self.next().hide();
                        }
                    });
                }
            });

            $('#access_role').change(function () {
               var access_role = $(this).val();
               if (access_role == 'Vendor') { 
                   $('.vendorclass').show();
                   $('#vendor_id').addClass('required');
               }
               else {
                $('.vendorclass').hide();
                   $('#vendor_id').removeClass('required');
               }
           });

            $("#district").trigger('change');
        });

        $("#code").blur(function () {
            var code = $(this).val().trim();
            if (code.length > 0 && code.length < 12) {
                $('.code-error').html('');
                $('#submit_btn').attr("disabled", false);
            } else {
                $('.code-error').html('Code number should be at least 1 character to maximum  11 characters!');
                $('#submit_btn').attr("disabled", true);
            }
        });

        $(".Select2").select2({
            width: '100%'
        });
    </script>
@endsection <!--- footer-script--->
