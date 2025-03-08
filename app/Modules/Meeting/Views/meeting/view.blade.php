<?php use App\Libraries\Encryption; ?>

<style>
    .collapsible:hover {
        cursor: pointer;
        text-decoration: underline;
    }
</style>
@extends('layouts.admin')
@section('header-resources')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset("assets/plugins/datatable/dataTables.bootstrap.min.css") }}"/>
    <link rel="stylesheet" href="{{ asset("assets/plugins/datatable/responsive.bootstrap.min.css") }}"/>
    <link rel="stylesheet" href="{{ asset("assets/plugins/datepicker-oss/css/bootstrap-datetimepicker.min.css") }}"/>
    <link rel="stylesheet" href="{{ asset("assets/plugins/intlTelInput/css/intlTelInput.css") }}"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
    <style>
        .plus_icon_email_number, .minus_icon_contact_number, .plus_icon_contact_number, minus_icon_contact_number {
            cursor: pointer;
        }

        .legend-color {
            color: #3c8dbc;
            padding-bottom: 0px !important;
            font-size: 12px;
            font-weight: bold;
            padding-left: 20px;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .v-gap {
            clear: both;
            height: 10px;
        }

        .dl-horizontal dt, .dl-horizontal dd {
            text-align: left;
            margin-bottom: 1px;
            width: auto;
            padding-right: 1em;
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
                    <div class="clearfix"></div>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="v-gap"></div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <dl class="dl-horizontal">
                                        @if($meeting_data->caption)
                                            <dt>Subject</dt>
                                            <dd>: {{$meeting_data->caption}}</dd>
                                        @endif
                                        @if($meeting_data->agenda)
                                            <dt>Agenda</dt>
                                            <dd>: {{$meeting_data->agenda}}</dd>
                                        @endif
                                        @if($meeting_data->parent_type)
                                            <dt>Start Date And Time</dt>
                                            <dd>: {{ date('d-M-Y H:i:s',strtotime($meeting_data->start_dt)) }}</dd>
                                        @endif

                                        @if($meeting_data->parent_type)
                                                <dt>Related to ({{$meeting_data->parent_type}})</dt>
                                           @if($meeting_data->parent_type=='Others')
                                                <dd>: {{$meeting_data->others_description}}</dd>
                                           @else
                                                <dd>:
                                                    <a href="{{url('/crm/'.\App\Libraries\CommonFunction::getRelatedToName('crm_meeting','parent_type',$meeting_data->parent_type).'/view/' . \App\Libraries\Encryption::encodeId($meeting_data->parent_id))}}">
                                                        {{\App\Libraries\CommonFunction::getDynamicParentName('crm_meeting','parent_type',$meeting_data->parent_id, $meeting_data->parent_type)}}</a>
                                                </dd>
                                            @endif
                                        @endif
                                        @if($meeting_data->location)
                                                <dt>Location</dt>
                                                <dd>: {{$meeting_data->location}}</dd>
                                        @endif

                                         @if($meeting_data->status)
                                                <dt>Status</dt>
                                                <dd>: {{$meeting_data->status}}</dd>
                                         @endif
                                            @if($meeting_data->created_at)
                                                <dt>Created at:</dt>
                                                <dd>: <span id="created_at">{{\App\Libraries\CommonFunction::dateDiff($meeting_data->created_at) }}</span></dd>
                                            @endif
                                            @if($meeting_data->created_by)
                                                <dt>Created by:</dt>
                                                <dd>: {{\App\Libraries\CommonFunction::userNameShow($meeting_data->created_by)}}</dd>
                                            @endif
                                            @if($meeting_data->updated_at)
                                                <dt>Updated at:</dt>
                                                <dd>: <span id="updated_at">{{\App\Libraries\CommonFunction::dateDiff($meeting_data->updated_at) }}</span></dd>
                                            @endif
                                    </dl>
                                </div>
                                <div class="col-md-6">
                                    <dl class="dl-horizontal">
                                        @if(\App\Libraries\CommonFunction::userNameShow($meeting_data->assigned_to))
                                        <dt>Assigned to</dt>
                                        <dd>:
                                            {{\App\Libraries\CommonFunction::userNameShow($meeting_data->assigned_to)}}
                                        </dd>
                                        @endif

                                        @if(count($meeting_attendees_data)>=1)
                                            <dt>Attendees</dt>
            
                                                @foreach($meeting_attendees_data as $key => $result)
                                                <dd>: {{\App\Libraries\CommonFunction::userNameShow($result->contact_id,1)}}</dd>
                                                @endforeach
                                        @endif
                                        @if($meeting_data->duration)
                                        <dt>Duration</dt>
                                        <dd>: {{$meeting_data->duration}}</dd>
                                        @endif
                                        @if($meeting_data->status)
                                            @if($meeting_data->status=='Held')
                                                @if(isset($meeting_data->outcome))
                                                    <dt>Outcome</dt>
                                                    <dd>: {{$meeting_data->outcome}}</dd>
                                                @endif
                                            @endif
                                        @endif
                                        @if($meeting_data->status)
                                            @if($meeting_data->status=='Planned')
                                                <dt>Is Reminder</dt>
                                                <dd>: {{ ($meeting_data->is_reminder == 1)? "Yes":"No"}} </dd>
                                                @if(isset($meeting_data->reminder_time))
                                                    <dt>Reminder</dt>
                                                    <dd>: Before {{$meeting_data->reminder_time}} mitutes</dd>
                                                @endif
                                            @endif
                                        @endif
                                        @if($meeting_data->description)
                                        <dt>Description</dt>
                                        <dd>: {{$meeting_data->description}}</dd>
                                        @endif
                                            
                                            @if($meeting_data->updated_by)
                                                <dt>Updated by:</dt>
                                                <dd>: {{\App\Libraries\CommonFunction::userNameShow($meeting_data->updated_by)}}</dd>
                                            @endif
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="col-md-12">
                                <div class="col-md-6 pull-left" style="padding-left: 25px;">
                                    <a href="{{ URL::previous() }}"
                                       class="btn btn-default btn-sm pull-left"><i
                                                class="fa fa-times"></i>
                                        <b>Back</b></a>
                                </div>
                                <div class="col-md-6  pull-right">
                                    @if (Auth::user()->user_type == "1x101" || Auth::user()->id == $meeting_data->assigned_to || Auth::user()->id == $meeting_data->created_by)
                                        <a href="/meeting/edit/{{ Encryption::encodeId($meeting_data->id)}}"
                                           class="btn  btn-info"><i class="fa fa-check-circle"></i> Edit</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                       
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
@section('footer-script')
    <script src="{{ asset("assets/scripts/jquery.validate.min.js") }}"></script>
    <script src="{{ asset("assets/scripts/moment.min.js") }}"></script>
    <script src="{{ asset("assets/plugins/datepicker-oss/js/bootstrap-datetimepicker.js") }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <script src="{{ asset("assets/plugins/datatable/dataTables.responsive.min.js") }}"></script>

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
                format: 'DD-MMM-YYYY h:m'
            });
        });


        $(document).ready(function () {
            $('#plus_icon_attendees').click(function () {
                $('#attendees').append('<div class="form-group has-feedback {{ $errors->has('contact_id') ? 'has-error' : ''}}">\n' +
                    '                       <label class="col-md-12 "></label>\n' +
                    '                       <div class="col-md-11">\n' +
                    '                           {!! Form::text('contact_id[]', $value = null, $attributes = array('class'=>'form-control contact_id','id'=>"contact_id")) !!}\n' +
                    '                           {!! $errors->first('contact_id','<span class="help-block">:message</span>') !!}\n' +
                    '                           {!! Form::hidden('contact_id_to[]','',array('class'=>'contact_id_to','id'=>'contact_id_to')) !!}' +
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

                if ($('#parent_type').val() != '' && $('#parent_type').val() != 'Others') {

                    connect_url = "{{URL::to('/')}}" + '/crm/lead/' + ($('#parent_type').val()).toLowerCase() + '_list';
                    $('#parent_id').autocomplete('enable');
                } else {
                    $('#parent_id').autocomplete('disable');
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
                autocompletedata(".contact_id", ".contact_id_empty-message", ".contact_id_to", "{{url('crm/lead/contact_list')}}");
            })


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
                } else if ($("#status").val() == 'Planned') {
                    $("#status_planned").removeAttr('hidden');
                    $("#status_planned").removeClass('hidden');
                    $("#status_held").attr('hidden');
                    $("#status_held").addClass('hidden');
                } else {
                    $("#status_held").attr('hidden');
                    $("#status_held").addClass('hidden');
                    $("#status_planned").attr('hidden');
                    $("#status_planned").addClass('hidden');
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

        $('input').attr('disabled', true);
        $('select').attr('disabled', true);
        $('textarea').attr('disabled', true);

        
        $("#bbs_more_btn").click(function () {
            showtext('#bbs_more', '#bbs_less');
        });
        $("#bbs_less_btn").click(function () {
            showtext('#bbs_less', '#bbs_more');
        });
        $("#description_more_btn").click(function () {
            showtext('#description_more', '#description_less');
        });
        $("#description_less_btn").click(function () {
            showtext('#description_less', '#description_more');
        });

        function showtext(display_block, display_none) {
            $(display_block).css("display", 'block');
            $(display_none).css("display", 'none');
        }
        
    </script>

@endsection
