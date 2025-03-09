@extends('layouts.admin')

@section('header-resources')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <style>
        .plus_icon_email_number, .minus_icon_contact_number, .plus_icon_important_date, .plus_icon_contact_number, minus_icon_contact_number {
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
            padding-left: 10px;
        }

        .box {
            float: left;
            width: 20px;
            height: 20px;
            margin: 5px;
            border: 1px solid rgba(0, 0, 0, .2);
        }

        .red {
            background: #ae163e;
        }

    </style>
@endsection

@section("content")
    @include('partials.messages')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">

                <div class="panel-heading">
                    <div class="col-lg-5">
                        <div class="pull-left" style="line-height: 35px;">
                            <strong> Reminder List</strong>
                        </div>

                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                  
                    <div class="table-responsive" style="margin-top: 20px;">
                        <table id="list" class="table table-striped table-bordered dt-responsive " cellspacing="0"
                               width="100%">
                            <thead>
                            <tr>
                                <th> App Id</th>
                                <th> Caption</th>
                                <th> Content</th>
                                <th> Email To</th>
                                <th>Subject</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($EmailData as $Data)
                                <tr>
                                   
                                    <td>{{$Data->app_id}}</td>
                                    <td>{{$Data->caption}}</td>
                                    <td>{{$Data->email_content}}</td>
                                    <td>{{$Data->email_to}}</td>
                                    <td>{{$Data->email_subject}} </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                            <div class="col-md-12">
                                <div class="col-md-6 pull-left">
                                    <a href="{{ url ('meeting/lists')}}"
                                       class="btn btn-default btn-sm pull-left">
                                        Close
                                    </a>
                                </div>

                            </div>


                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-script')

@endsection
