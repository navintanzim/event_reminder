@extends('layouts.admin')
<?php

use Illuminate\Support\Facades\Auth;

if(Auth::user()->user_type != '1x101')
die('you have no access right');

?>
@section('header-resources')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset("assets/plugins/datepicker-oss/css/bootstrap-datetimepicker.min.css") }}"/>
    <link rel="stylesheet" href="{{ asset("assets/plugins/intlTelInput/css/intlTelInput.css") }}"/>
    <style>
        .plus_icon_email_number, .minus_icon_contact_number, .plus_icon_contact_number, minus_icon_contact_number {
            cursor: pointer;
        }

        .legend-color {
            color: #3c8dbc;
            padding-bottom: 0px !important;
            font-size: 16px;
            font-weight: bold;
            padding-left: 20px;
        }

        .v-gap {
            clear: both;
            height: 10px;
        }

        .optionPadding {
            padding-left: 5px;
            padding-right: 0px;
        }
    </style>
@endsection
@section("content")
    @include('partials.messages')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading" style="line-height: 35px;">
                    <strong><i class="fa fa-user" aria-hidden="true"></i>Meeting Info</strong>
                    <div class="clearfix"></div>
                </div>

                {!! Form::open(array('url' => '/meeting/store-new-meeting','method' => 'patch', 'class' => 'form-horizontal', 'id' => 'create_meeting_form',
                'enctype' =>'multipart/form-data', 'files' => 'true')) !!}

                <div class="panel-body">
                    <div class="v-gap"></div>
                    <span class="legend-color">Meeting Overview</span>

                    <div class="panel">
                        <div class="panel-body" style="padding: 10px 20px 20px 20px;">

                            <div class="col-md-12" style="padding-left: 30px;padding-right: 30px;">
                                <div class="col-md-6" style="padding-left: 30px;padding-right: 30px;">

                                    <div class="form-group has-feedback {{ $errors->has('caption') ? 'has-error' : ''}}">
                                        <label class="col-md-12 required-star">Subject</label>
                                        <div class="col-md-12">
                                            {!! Form::text('caption', $value = null,  array('class'=>'form-control required',
                                             'id'=>"caption")) !!}
                                            {!! $errors->first('caption','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group has-feedback {{ $errors->has('caption') ? 'has-error' : ''}}">
                                        <label class="col-md-12 ">Agenda</label>
                                        <div class="col-md-12">
                                            {!! Form::text('agenda', $value = null,  array('class'=>'form-control',
                                             'id'=>"agenda")) !!}
                                            {!! $errors->first('agenda','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group has-feedback {{ $errors->has('start_dt') ? 'has-error' : ''}}">
                                        <label class="col-md-12 required-star">Start Date And Time</label>
                                        <div class="col-md-12">
                                            {!! Form::text('start_dt', $value = null,  array('class'=>'datepicker form-control required',
                                            'id'=>"start_dt")) !!}
                                            {!! $errors->first('start_dt','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                   
                                    

                                </div><!--/col-md-6-->

                                <div class="col-md-6" style="padding-left: 30px;padding-right: 30px;">
                                    <div class="form-group has-feedback {{ $errors->has('assigned_to') ? 'has-error' : ''}}">
                                        <label class="col-md-12 required-star">Assigned to</label>
                                        <div class="col-md-12">
                                            <select id="assigned_to" class="form-control required Select2"
                                                    name="assigned_to">
                                                @foreach($userLists as $userLists)
                                                    <option value="{{$userLists->id}}"
                                                            @if(Auth::user()->id==$userLists->id) selected @endif>
                                                        {{$userLists->name}} ({{$userLists->email}})</option>
                                                @endforeach
                                            </select>
                                            {!! $errors->first('assigned_to','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group has-feedback {{ $errors->has('contact_id') ?  'has-error' : ''}}">
                                        <label class="col-md-12 ">Attendees</label>
                                        <div class="col-md-11">
                                            {!! Form::text('contact_id[]', $value = null,  array('class'=>'form-control contact_id','placeholder'=>"Type a user name, such as: 'test'",
                                 'id'=>"contact_id")) !!}
                                            {!! $errors->first('contact_id','<span class="help-block">:message</span>') !!}
                                            {!! Form::hidden('contact_id_to[]','',array('class'=>'contact_id_to','id'=>'contact_id_to')) !!}
                                            {!! Form::hidden('contact_id_type[]','',array('class'=>'contact_id_type','id'=>'contact_id_type')) !!}
                                            <p id="contact_id_empty-message" class="contact_id_empty-message"></p>
                                        </div>
                                        <i class="fa fa-plus-circle plus_icon_attendees" id="plus_icon_attendees"
                                           style="font-size:26px;color:green" aria-hidden="true"></i>
                                    </div>
                                    <div id="attendees"></div>

                                    <div class="form-group  has-feedback {{ $errors->has('duration') ? 'has-error' : ''}}">
                                        <label class="col-md-12 required-star">Duration</label>
                                        <div class="col-md-12">
                                            <div>
                                                {!! Form::text('duration', $value = null, array('class'=>'form-control required',
                                         'id'=>"duration","placeholder" => '10:30' )) !!}
                                                {!! $errors->first('duration','<span class="help-block">:message</span>') !!}
                                            </div>
                                        </div>
                                        {{--<div class="col-md-4">--}}
                                        {{--{!! Form::select('duration_type', ['' => 'Hours' ],null ,  array('class'=>'form-control',--}}
                                        {{--'id'=>"duration_type")) !!}--}}
                                        {{--</div>--}}

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-12" style="padding-left: 30px;padding-right: 30px;">
                                <div class="col-md-12" style="padding-left: 30px;padding-right: 30px;">
                                    <div class="form-group has-feedback {{ $errors->has('location') ? 'has-error' : ''}}">
                                        <label class="col-md-12">Location</label>
                                        <div class="col-md-12">
                                            {!! Form::text('location', $value = null,  array('class'=>'form-control',
                                                  'id'=>"location")) !!}
                                            {!! $errors->first('location','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12" style="padding-left: 30px;padding-right: 30px;">
                                <div class="col-md-6" style="padding-left: 30px;padding-right: 30px;">
                                    <div class="form-group has-feedback {{ $errors->has('status') ? 'has-error' : ''}}">
                                        <label class="col-md-12 ">Status</label>
                                        <div class="col-md-12">
                                            {!! Form::select('status', $status,null ,  array('class'=>'form-control',
                                                    'id'=>"status")) !!}
                                            {!! $errors->first('Status','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" id="status_held" hidden>
                                    <div class="form-group has-feedback {{ $errors->has('outcome') ? 'has-error' : ''}}">
                                        <label class="col-md-12 required-star">Outcome</label>
                                        <div class="col-md-12">
                                            {!! Form::text('outcome', $value = null,  array('class'=>'form-control',
                                             'id'=>"outcome")) !!}
                                            {!! $errors->first('outcome','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>

                                <div id="status_planned" hidden>
                                    <div class="col-md-2">
                                        <label class="col-md-12">Reminder</label>
                                        <input type="checkbox" name="is_reminder" id="is_reminder">
                                    </div>
                                    <div class="col-md-4" id="reminder_true" hidden>
                                        <div class="form-group has-feedback {{ $errors->has('reminder_time') ? 'has-error' : ''}}">
                                            <label class="col-md-12">Reminder</label>
                                            <div class="col-md-11">
                                                {!! Form::select('reminder_time', ['' => 'Select One','20'=>'Before 20 minutes','30'=>'Before 30 minutes','40'=>'Before 40 minutes','50'=>'Before 50 minutes','60'=>'Before 1 Hour'],null ,  array('class'=>'form-control','id'=>"reminder_time")) !!}
                                                {!! $errors->first('reminder_time','<span class="help-block">:message</span>') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12" style="padding-left: 30px;padding-right: 30px;">
                                <div class="col-md-12" style="padding-left: 30px;padding-right: 30px;">
                                    <div class="form-group has-feedback {{ $errors->has('description') ? 'has-error' : ''}}">
                                        <label class="col-md-12 ">Description</label>
                                        <div class="col-md-12">
                                            <textarea name="description" id="description"
                                                      class="form-control"></textarea>
                                            {!! $errors->first('description','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='clearfix'></div>

                            <div class="panel">
                                <div class="panel-body" style="padding: 10px 20px 20px 20px;">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class=" pull-left">
                                                    <a href="{{ URL::previous() }}"
                                                       class="btn btn-default btn-sm pull-left"><i
                                                                class="fa fa-times"></i>
                                                        <b>Back</b></a>
                                                </div>
                                                <div class="col-md-2 pull-right">
                                                    <button type="submit" class="btn btn-block btn-sm btn-primary">
                                                        <b>Save</b>
                                                    </button>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function () {
            var _token = $('input[name="_token"]').val();
            $("#create_meeting_form").validate({
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
                sideBySide: true,
                format: 'DD-MMM-YYYY H:m',
            });

        });
        $(document).on('click', '.calender-icon', function () {
            $(this).siblings('.datepicker').focus();
        });

        $(document).ready(function () {
            $('#plus_icon_attendees').click(function () {
                $('#attendees').append('<div class="form-group has-feedback {{ $errors->has('contact_id') ? 'has-error' : ''}}">\n' +
                    '                       <label class="col-md-12 "></label>\n' +
                    '                       <div class="col-md-11">\n' +
                    '                           {!! Form::text('contact_id[]', $value = null,  array('class'=>'form-control contact_id','id'=>"contact_id")) !!}\n' +
                    '                           {!! $errors->first('contact_id','<span class="help-block">:message</span>') !!}\n' +
                    '                           {!! Form::hidden('contact_id_to[]','',array('class'=>'contact_id_to','id'=>'contact_id_to')) !!}' +
                    '                           {!! Form::hidden('contact_id_type[]','',array('class'=>'contact_id_type','id'=>'contact_id_type')) !!}' +
                    '                           <p id="contact_id_empty-message" class="contact_id_empty-message"></p>' +
                    '                       </div>\n' +
                    '                       <i class="fa fa-minus-circle minus_icon_attendees" style="font-size:26px;color:red" aria-hidden="true"></i>\n' +
                    '                       </div>');
            });
            $(document).on('click', '.minus_icon_attendees', function () {
                $(this).parent().remove();
            });

            var connect_url = '';

            

            $(document).on('keyup', '.contact_id', function () {
                autocompletedataForAttendees(".contact_id", ".contact_id_empty-message", ".contact_id_to",".contact_id_type", "{{url('meeting/get-employee-with-user')}}");
            });

            function autocompletedataForAttendees(master_id, error_id, response_id, response_persion_type,  connect_url) {
                $(master_id).autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: connect_url,
                            dataType: "json",
                            data: {
                                q: request.term
                            },
                            success: function (data) {
                                console.log(response(data));
                            }
                        });
                    },
                    minLength: 3,
                    response: function (event, ui) {
                        if (ui.content.length === 0) {
                            $(this).val('');
                            $(this).siblings(error_id).text("No results found");
                        } else {
                            $(this).siblings(error_id).empty();
                        }
                    },
                    select: function (event, data) {
                        $(this).siblings(response_id).val(data.item.id);
                        $(this).siblings(response_persion_type).val(data.item.contact_type);
                    }
                });
            }


            function autocompletedata(master_id, error_id, response_id, connect_url) {
                $(master_id).autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: connect_url,
                            dataType: "json",
                            data: {
                                q: request.term
                            },
                            success: function (data) {
                                console.log(response(data));
                            }
                        });
                    },
                    response: function (event, ui) {
                        if (ui.content.length === 0) {
                            $(this).val('');
                            $(this).siblings(error_id).text("No results found");
                        } else {
                            $(this).siblings(error_id).empty();
                        }
                    },
                    select: function (event, data) {
                        $(this).siblings(response_id).val(data.item.id);
                    }
                });
            }

            $("#status").change(function () {
                if ($("#status").val() == 'Held') {
                    $("#status_held").removeAttr('hidden');
                    $("#status_held").removeClass('hidden');
                    $("#status_planned").attr('hidden');
                    $("#status_planned").addClass('hidden');
                    $("#email_notification_field").attr('hidden');
                    $("#email_notification_field").addClass('hidden');
                } else if ($("#status").val() == 'Planned') {
                    $("#status_planned").removeAttr('hidden');
                    $("#status_planned").removeClass('hidden');
                    $("#status_held").attr('hidden');
                    $("#status_held").addClass('hidden');
                    $("#email_notification_field").removeAttr('hidden');
                    $("#email_notification_field").removeClass('hidden');
                } else {
                    $("#status_held").attr('hidden');
                    $("#status_held").addClass('hidden');
                    $("#status_planned").attr('hidden');
                    $("#status_planned").addClass('hidden');
                    $("#email_notification_field").removeAttr('hidden');
                    $("#email_notification_field").removeClass('hidden');
                }
            });

            $("#is_reminder").click(function () {
                var checked = $(this).is(':checked');
                if (checked) {
                    $("#reminder_true").removeAttr('hidden');
                    $("#reminder_true").removeClass('hidden');
                } else {
                    $("#reminder_true").attr('hidden');
                    $("#reminder_true").addClass('hidden');
                }
            });


            var regex = new RegExp("^[0-9]{2}[:][0-9]{2}$");

            $('#duration').on("blur", function (event) {
                var string = $.trim($(this).val());
                if (!regex.test(string)) {
                    event.preventDefault();
                    alert('Please Input as like as 10:30 or 05:02 ');
                    $('#duration').val('');
                }
            });

            $('#duration').removeClass('engOnly');

        })
        $(".Select2").select2({
            width: '100%'
        });

    </script>
@endsection
