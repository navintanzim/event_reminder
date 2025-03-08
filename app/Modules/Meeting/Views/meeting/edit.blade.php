<?php

use Illuminate\Support\Facades\Auth;

if(Auth::user()->user_type != '1x101')
die('you have no access right');

?>


@extends('layouts.admin')
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
    </style>
@endsection
@section("content")
    @include('partials.messages')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="pull-left" style="line-height: 35px;">
                        <strong>Meeting Info</strong>
                    </div>
                    <div class="pull-right">
                        <!--1x101 is Sys Admin, 7x712 is SB Admin, 11x422 is Bank Admin-->
                        <a class="" href="{{ url('/meeting/add-new') }}">
                            {!! Form::button('<i class="fa fa-plus"></i><b>Add meeting</b>', array('type' => 'button', 'class' => 'btn btn-default')) !!}
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>

                {!! Form::open(array('url' => '/meeting/update-meeting','method' => 'patch', 'class' => 'form-horizontal', 'id' => 'create_meeting_form',
                'enctype' =>'multipart/form-data', 'files' => 'true')) !!}

                <div class="panel-body">
                    <div class="v-gap"></div>
                    <span class="legend-color">Meeting Overview</span>
                    <div class="panel">
                        <div class="panel-body" style="padding: 10px 20px 20px 20px;">
                            <div class="col-lg-12" style="padding-left: 30px;padding-right: 30px;">
                                <div class="col-md-6" style="padding-left: 30px;padding-right: 30px;">
                                    <div class="form-group has-feedback {{ $errors->has('caption') ? 'has-error' : ''}}">
                                        <label class="col-md-12 required-star">Subject</label>
                                        <div class="col-md-12">
                                            <input type="hidden" name="meeting_id"
                                                   value="{{ \App\Libraries\Encryption::encodeId($meeting_data->id) }}">
                                            {!! Form::text('caption', $value = $meeting_data->caption, array('class'=>'form-control required',
                                             'id'=>"caption")) !!}
                                            {!! $errors->first('caption','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback {{ $errors->has('agenda') ? 'has-error' : ''}}">
                                        <label class="col-md-12">Agenda</label>
                                        <div class="col-md-12">
                                            {!! Form::text('agenda', $value = $meeting_data->agenda, array('class'=>'form-control',
                                            'data-rule-maxlength'=>'40', 'id'=>"agenda")) !!}
                                            {!! $errors->first('agenda','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" style="padding-left: 30px;padding-right: 30px;">
                                    <div class="form-group has-feedback {{ $errors->has('assigned_to') ? 'has-error' : ''}}">
                                        <label class="col-md-12 required-star">Assigned to</label>
                                        <div class="col-md-12">
                                            <select id="assigned_to" class="form-control required Select2" name="assigned_to">
                                                <option value="">Select one</option>
                                                @foreach($userLists as $userLists)
                                                    <option value="{{$userLists->id}}"
                                                            @if($meeting_data->assigned_to==$userLists->id) selected @endif>
                                                        {{$userLists->name}} ({{$userLists->email}})</option>
                                                @endforeach
                                            </select>
                                            {!! $errors->first('assigned_to','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                    @php $z=1; @endphp
                                    @if(count($meeting_attendees_data)>=1)
                                        @foreach($meeting_attendees_data as $key => $result)
                                            <div class="form-group has-feedback {{ $errors->has('contact_id') ? 'has-error' : ''}}">
                                                @if($z==1)
                                                    <label class="col-md-12 required-star">Attendees</label>
                                                @else
                                                    <label class="col-md-12"></label>
                                                @endif
                                                <div class="col-md-11">
                                                    {!! Form::text('contact_id[]', \App\Libraries\CommonFunction::userNameShow($result->contact_id,1) , array('class'=>'form-control contact_id',
                                              'id'=>"contact_id")) !!}
                                                    {!! $errors->first('contact_id','<span class="help-block">:message</span>') !!}
                                                    {!! Form::hidden('contact_id_to[]',$result->contact_id,array('class'=>'contact_id_to','id'=>'contact_id_to')) !!}
                                                    {!! Form::hidden('contact_id_type[]',$result->contact_type,array('class'=>'contact_id_type','id'=>'contact_id_type')) !!}
                                                    <p id="contact_id_empty-message"
                                                       class="contact_id_empty-message"></p>
                                                </div>
                                                @if($z==1)
                                                    <i class="fa fa-plus-circle plus_icon_attendees"
                                                       id="plus_icon_attendees"
                                                       style="font-size:26px;color:green" aria-hidden="true"></i>
                                                @else
                                                    <i class="fa fa-minus-circle minus_icon_attendees"
                                                       style="font-size:26px;color:red"
                                                       aria-hidden="true"></i>
                                                @endif

                                            </div>
                                            @php $z++; @endphp
                                        @endforeach
                                    @else
                                        <div class="form-group has-feedback {{ $errors->has('contact_id') ?  'has-error' : ''}}">
                                            <label class="col-md-12 ">Attendees</label>
                                            <div class="col-md-11">
                                                {!! Form::text('contact_id[]', $value = null,  array('class'=>'form-control contact_id',
                                     'id'=>"contact_id")) !!}
                                                {!! $errors->first('contact_id','<span class="help-block">:message</span>') !!}
                                                {!! Form::hidden('contact_id_to[]','',array('class'=>'contact_id_to','id'=>'contact_id_to')) !!}
                                                {!! Form::hidden('contact_id_type[]','',array('class'=>'contact_id_type','id'=>'contact_id_type')) !!}
                                                <p id="contact_id_empty-message" class="contact_id_empty-message"></p>
                                            </div>
                                            <i class="fa fa-plus-circle plus_icon_attendees" id="plus_icon_attendees"
                                               style="font-size:26px;color:green" aria-hidden="true"></i>
                                        </div>
                                    @endif
                                    <div id="attendees"></div>
                                </div>
                                <div class='clearfix'></div>
                                <div class="col-md-6" style="padding-left: 30px;padding-right: 30px;">
                                    <div class="form-group has-feedback {{ $errors->has('start_dt') ? 'has-error' : ''}}">
                                        <label class="col-md-12 required-star">Start Date And Time</label>
                                        <div class="col-md-12">
                                            {!! Form::text('start_dt', date('d-M-Y H:i:s',strtotime($meeting_data->start_dt)), array('class'=>'datepicker form-control required',
                                            'id'=>"start_dt")) !!}
                                            {!! $errors->first('start_dt','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-md-6" style="padding-left: 30px;padding-right: 30px;">
                                    <div class="form-group has-feedback {{ $errors->has('duration') ? 'has-error' : ''}}">
                                        <label class="col-md-12 required-star">Duration</label>
                                        <div class="col-md-12">
                                            {!! Form::text('duration', $value = $meeting_data->duration, array('class'=>'form-control required',
                                            'data-rule-maxlength'=>'40', 'id'=>"duration")) !!}
                                            {!! $errors->first('duration','<span class="help-block">:message</span>') !!}
                                        </div>
                                      
                                    </div>
                                </div>

                            </div>


                            <div class="col-md-12" style="padding-left: 30px;padding-right: 30px;">
                                <div class="col-md-12" style="padding-left: 30px;padding-right: 30px;">
                                    <div class="form-group has-feedback {{ $errors->has('location') ? 'has-error' : ''}}">
                                        <label class="col-md-12">Location</label>
                                        <div class="col-md-12">
                                            {!! Form::text('location', $value = $meeting_data->location, array('class'=>'form-control',
                                             'id'=>"location")) !!}
                                            {!! $errors->first('location','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='col-md-12' style="padding-left: 30px;padding-right: 30px;">
                                <div class="col-md-6" style="padding-left: 30px;padding-right: 30px;">
                                    <div class="form-group has-feedback {{ $errors->has('status') ? 'has-error' : ''}}">
                                        <label class="col-md-12">Status</label>
                                        <div class="col-md-12">
                                            {!! Form::select('status', $status,$meeting_data->status , array('class'=>'form-control',
                                                'id'=>"status")) !!}
                                            {!! $errors->first('Status','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" id="status_held" hidden>
                                    <div class="form-group has-feedback {{ $errors->has('outcome') ? 'has-error' : ''}}">
                                        <label class="col-md-12">Outcome</label>
                                        <div class="col-md-12">
                                            {!! Form::text('outcome', $value = $meeting_data->outcome, array('class'=>'form-control',
                                            'id'=>"outcome")) !!}
                                            {!! $errors->first('outcome','<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div id="status_planned" hidden>
                                    <div class="col-md-2">
                                        <label class="col-md-12">Reminder</label>
                                        <input type="checkbox" name="is_reminder" id="is_reminder"
                                               @if($meeting_data->is_reminder==1) checked @endif>
                                    </div>
                                    <div class="col-md-3" id="reminder_true" hidden>
                                        <div class="form-group has-feedback {{ $errors->has('reminder_time') ? 'has-error' : ''}}">
                                            <label class="col-md-12">Reminder</label>
                                            <div class="col-md-12">
                                                {!! Form::select('reminder_time', ['' => 'Select One','20'=>'Before 20 minutes','30'=>'Before 30 minutes','40'=>'Before 40 minutes','50'=>'Before 50 minutes','60'=>'Before 1 Hour'],$meeting_data->reminder_time , array('class'=>'form-control','id'=>"reminder_time")) !!}
                                                {!! $errors->first('reminder_time','<span class="help-block">:message</span>') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                          
                            <div class="col-md-12" style="padding-left: 30px;padding-right: 30px;">
                                <div class="col-md-12" style="padding-left: 30px;padding-right: 30px;">
                                    <div class="form-group has-feedback {{ $errors->has('description') ? 'has-error' : ''}}">
                                        <label class="col-md-12">Description</label>
                                        <div class="col-md-12">
                                            <textarea name="description" id="description"
                                                      class="form-control">{{$meeting_data->description}}</textarea>
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
                                                        <b>Update</b>
                                                    </button>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div> <!--/panel-body-->
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    @if(Auth::user()->user_type == "1x101" )
        <div>
            <strong>Created: </strong> by <a href="{{ url ('users/view/'.\App\Libraries\Encryption::encodeId($meeting_data->created_by)) }}"target="_blank">
                {{\App\Libraries\CommonFunction::userMailShow($meeting_data->created_by)}}</a> at {{\App\Libraries\CommonFunction::dateDiff($meeting_data->created_at) }} &nbsp;
            <strong>Updated: </strong> by <a href="{{ url ('users/view/'.\App\Libraries\Encryption::encodeId($meeting_data->updated_by)) }}"target="_blank">
                {{\App\Libraries\CommonFunction::userMailShow($meeting_data->updated_by)}}</a> at {{\App\Libraries\CommonFunction::dateDiff($meeting_data->updated_at) }}
        </div>
    @elseif(Auth::user()->user_type != "1x101")
        <div>
            <strong>Created: </strong> by {{\App\Libraries\CommonFunction::userMailShow($meeting_data->created_by)}} at {{\App\Libraries\CommonFunction::dateDiff($meeting_data->created_at) }} &nbsp;
            <strong>Updated: </strong> by {{\App\Libraries\CommonFunction::userMailShow($meeting_data->updated_by)}} at {{\App\Libraries\CommonFunction::dateDiff($meeting_data->updated_at) }}
        </div>

    @endif
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
                format: 'DD-MMM-YYYY H:m'
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
                    '                           {!! Form::text('contact_id[]', $value = null, array('class'=>'form-control contact_id','id'=>"contact_id")) !!}\n' +
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

            $(document).on('change', '#parent_type', function () {
                $('#parent_id').val('');
                if ($('#parent_type').val() != '' && $('#parent_type').val() != 'Others') {
                    $('#parent_id_to').val();
                    var parent_type = $('#parent_type').val();
                    $.ajax({
                        url: "{{URL::to('/')}}" + '/crm/lead/get-define-enum-name',
                        data: {
                            table_name: 'crm_meeting',
                            field_name: 'parent_type',
                            parent_type: parent_type
                        },
                        success: function (data) {
                            connect_url = "{{URL::to('/')}}" + '/crm/lead/' + data.toLowerCase() + '_list';
                            if ($('#parent_type').val() != 'Others') {
                                autocompletedata("#parent_id", "#parent_id_empty-message", "#parent_id_to", connect_url);
                            }
                        }
                    });
                    $('#parent_id').autocomplete('enable');
                } else {
                    $('#parent_id').autocomplete('disable');
                }
            });

            $(document).on('change', '#parent_id', function () {
                console.log($('#parent_type').val(), $('#parent_id_to').val());
                if($('#parent_type').val() == "Accounts" && $('#parent_id_to').val()){
                    let parent_type = $('#parent_id_to').val();
                    $.ajax({
                        url: "{{URL::to('/')}}" + '/meeting/get-account-edit-url',
                        type: 'POST',
                        data: {
                            account_id: parent_type,
                        },
                        success: function (data) {
                            if (data.responseCode === 1) {
                            var editUrl = data.edit_url;
                            if (confirm('Do you want to edit this account?')) {
                                window.open(editUrl, '_blank');
                            }
                        }
                        }
                    });
                    $('#parent_id').autocomplete('enable');
                } 
              
            });

            $('#parent_id').autocomplete({
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
                        $(this).siblings('#parent_id_empty-message').text("No results found");
                    } else {
                        $(this).siblings('#parent_id_empty-message').empty();
                    }
                },
                select: function (event, data) {
                    $(this).siblings('#parent_id_to').val(data.item.id);
                }
            });


            $(document).on('keyup', '.contact_id', function () {
                autocompletedataForAttendees(".contact_id", ".contact_id_empty-message", ".contact_id_to",".contact_id_type", "{{url('crm/get-contact-with-user')}}");
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
                statusCheck();
            });
            statusCheck();

            function statusCheck() {
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
            }

            isCheckedCheck();

            function isCheckedCheck() {
                var checked = $('#is_reminder').is(':checked');
                if (checked) {
                    $("#reminder_true").removeAttr('hidden');
                    $("#reminder_true").removeClass('hidden');
                } else {
                    $("#reminder_true").attr('hidden');
                    $("#reminder_true").addClass('hidden');
                }
            }

            $("#is_reminder").click(function () {
                isCheckedCheck();
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
