
@extends('layouts.admin')
<?php

use Illuminate\Support\Facades\Auth;

$user_type = Auth::user()->user_type;
?>
@section('header-resources')
    @include('partials.datatable-css')
@endsection

@section('content')

    @include('partials.messages')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="pull-left" style="line-height: 35px;">
                        <strong><i class="fa fa-list"></i> User List</strong>
                    </div>
                    <div class="pull-right">


                        @if($user_type == '1x101')
                            <a class="" href="{{ url('/users/create-new-user') }}">
                                {!! Form::button('<i class="fa fa-plus"></i><b> New User</b>', array('type' => 'button', 'class' => 'btn btn-default')) !!}
                            </a>
                        @endif
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="list" class="table table-striped table-bordered dt-responsive " cellspacing="0"
                               width="100%">
                            <thead>
                            <tr>
                                <th>User Full Name</th>
                                <th>Email Address</th>
                                <th>User Type</th>
                                <th>Status</th>
                                <th>Member Since</th>
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
    <script>
        $(function () {
            $('#list').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{url("users/get-user-list")}}',
                    method: 'post',
                    data: function (d) {
                        d._token = $('input[name="_token"]').val();
                    }
                },
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'type_name', name: 'type_name'},
                    {data: 'user_status', name: 'user_status'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "aaSorting": []
            });
        });
    </script>
@endsection <!--- footer-script--->

