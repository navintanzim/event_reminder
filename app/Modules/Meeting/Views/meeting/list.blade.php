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

                            <button class="btn btn-default pull-right load-modal-btn" id="import_modal_button" style="margin-left: 5px;">
                                <i class="fa fa-plus"></i> <b>Import Excel Data</b>
                            </button>
                            @endif
                        </div>
                    </div>


                    <div id="aae_modal" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel" style="color: black"> Excel upload system</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;
                                    </button>
                                </div>
                                    <div class="modal-body" id="aae_modal_body">
                                        {!! Form::open(array('url' => 'meeting/import/upload-excel','method' => 'patch', 'class' => 'form-horizontal', 'id' => 'html_upload_form',
                                            'enctype' =>'multipart/form-data', 'files' => 'true')) !!}
                                        
                                        <div class="form-group col-md-12 {{$errors->has('file') ? 'has-error' : ''}}" style="color: black;margin-top: 5px;">
                                            {!! Form::label('file_label','Import xlsx/csv file: ',['class'=>' col-md-6']) !!}
                                            <div class="col-md-6">
                                                <span id="file_err" class="text-danger" style="font-size: 8px;"></span>
                                                {!! Form::file('file', ['class'=>'required',
                                                'id' => 'file','onchange'=>'htmlupload(this)'])!!}
                                                <span class="text-danger" style="font-size: 9px; font-weight: bold">[File Format: xlsx/csv ]</span><br/>
                                                <div style="position:relative;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12"  style="background-color:burlywood; margin-bottom: 10px;">
                                            <div style="margin: 30px">
                                         Warning! Upload only xlsx or csv file. You can see sample file.
                                                <a href="{{ url('meeting/import/sample_file') }}" target="_blank">
                                                    Click Here
                                                </a>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="pull-left">
                                                <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close
                                                </button>
                                            </div>
                                            <div class="pull-right">
                                                <button type="submit" disabled
                                                        class="btn btn-block btn-sm btn-primary" id="upload_btn"><b>Upload</b>
                                                </button>
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>
                                        {!! Form::close() !!}

                                    </div>

                            </div>

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


        function htmlupload(input) {
            if (input.files && input.files[0]) {
                $("#file_err").html('');
                var mime_type = input.files[0].type;
                var fileName = input.files[0].name;
                var ext = fileName.split('.').pop();
                var msg = "<h4>File format is not valid. Only xlsx or csv type files are allowed.</h4>";
                //
                if ((!(mime_type == 'application/vnd.ms-excel'|| mime_type =='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'))|| ext =="xls") {
                    $("#file_err").html(msg);
                    $('#upload_btn').prop("disabled", true);
                    $("#file").val('');
                    return false;
                }else{
                    $('#upload_btn').prop("disabled", false);
                }
                var reader = new FileReader();

                reader.readAsDataURL(input.files[0]);
            }
        }

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



            $(document).on('click','#import_modal_button',function(e){
            $('#aae_modal').modal('show');
        });

        $('#upload_btn').click(function(e){
            if( $("#fiscal_year").val()==""){
            e.preventDefault();
            alert('Please select a fiscal year');
            }
        });

        


        })
    </script>
@endsection <!--- footer-script--->

