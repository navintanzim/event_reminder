@extends('layouts.admin')
@section('content')


    <div class="col-lg-12">
        @include('message.message')
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="pull-left" style="line-height: 35px;">
                    <strong><i class="fa fa-list"></i> Your Transaction History</strong>
                </div>

                <div class="clearfix"></div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" >
                <div class="table-responsive">
                    <table id="list" class="table table-striped table-bordered dt-responsive " cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Order Id</th>
                            <th>Application Tracking</th>
                            <th>Amount</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col-lg-12 -->

@endsection <!--content section-->
@section('footer-script')
    @include('Users::partials.datatable')
    <script>
        $(function () {
            $('#list').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{url("payment/get-transaction-details-data")}}',
                    method:'post',
                    data: function (d) {
                        d._token = $('input[name="_token"]').val();
                    }
                },
                columns: [
                    {data: 'transaction_id', name: 'transaction_id'},
                    {data: 'tracking_no', name: 'tracking_no'},
                    {data: 'amount', name: 'amount'},
                    {data: 'payment_date', name: 'payment_date'},
                    {data: 'payment_status', name: 'payment_status'}
                ],
                "aaSorting": []
            });
        });
    </script>
@endsection <!--- footer-script--->

