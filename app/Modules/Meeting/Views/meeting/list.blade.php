@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable-css')
@endsection

@section('content')
    @include('partials.messages')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="col-lg-7">
                        <div class="pull-left" style="line-height: 35px;">
                            <strong><i class="fa fa-list"></i> Meeting Info</strong>
                        </div>
                    </div>
                    
                    <div class="col-lg-5">
                        <div class="pull-right">
                            @if(Auth::user()->user_type == '1x101')
                            <a class="" href="{{ url('/meeting/add-new') }}">
                                {!! Form::button('<i class="fa fa-plus"></i><b>New Meeting</b>', array('type' => 'button', 'class' => 'btn btn-default')) !!}
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row" id="search_area">

                    </div>
                    <br>
                    <div class="table-responsive">
                        <table id="list" class="table table-striped table-bordered dt-responsive " cellspacing="0"
                               width="100%">
                            <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Start Date</th>
                                <th>Status</th>
                                <th>Updated Date</th>
                                <th>Assigned Person</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div><!-- /.table-responsive -->
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col-lg-12 -->
    </div>

@endsection <!--content section-->
@section('footer-script')
    @include('partials.datatable-js')
    <script src="{{ asset("assets/scripts/jquery.validate.min.js") }}"></script>
    <script src="{{ asset("assets/scripts/moment.min.js") }}"></script>
    <script src="{{ asset("assets/plugins/datepicker-oss/js/bootstrap-datetimepicker.js") }}"></script>
    <script>
        reloadData( '{{url("/meeting/get-meeting-list/")}}');

        function reloadData(action_url, assigned_to, created_by, name, date_within, created_date, searchData = 0) {
            if (searchData == 0) {
                
                if ($('#assigned_to').val() || $('#created_by').val() || $('#name').val() || $('#date_within').val() ||
                    $('#created_date').val()) {
                    return;
                }
            }
            
            var table = $('#list').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                "lengthChange": false,
                ajax: {
                    url: action_url,
                    method: 'GET',
                    data: function (d) {
                        d._token = $('input[name="_token"]').val();
                        d.assigned_to = assigned_to;
                        d.created_by = created_by;
                        d.name = name;
                        d.date_within = date_within;
                        d.created_date = created_date;
                        d.searchData = searchData;
                    }
                },
                columns: [
                    {data: 'caption', name: 'caption'},
                    {data: 'start_dt', name: 'start_dt'},
                    {data: 'status', name: 'status'},
                    {data: 'updated_at', name: 'updated_at'},
                    
                    {
                        data: 'assigned_name', name: 'assigned_name'
                    },
                    
                    {data: 'creator_name', name: 'creator_name'},
                    {data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false}
                ],
                "aaSorting": []
            });

        }

        $(document).ready(function () {
            $.ajax({
                url: "{{url('search-panel')}}",
                data: {
                    action_url: '{{url("/meeting/get-meeting-list")}}',
                },
                success: function (data) {
                    $('#search_area').html(data.html);
                }
            });
        })
    </script>
@endsection <!--- footer-script--->

