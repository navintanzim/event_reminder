<div class="col-md-2">
    <input type="hidden" name="action_url" id="action_url" value="{{$action_url}}">
    <div class="form-group has-feedback {{ $errors->has('assigned_to') ? 'has-error' : ''}}">
        <label class="col-md-12">Assigned User</label>
        <div class="col-md-12">
            <select id="assigned_to" class="form-control select_2_class" style="width: 100%;"
                    name="assigned_to">
                <option value="">Select one</option>
                @foreach($user as $userList)
                    <option value="{{$userList->id}}">
                        {{$userList->name}}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('assigned_to','<span class="help-block">:message</span>') !!}
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : ''}}">
        <label class="col-md-12">Text</label>
        <div class="col-md-12">
            {!! Form::text('name', null, array('class'=>'form-control ','style'=>'width: 100%;',
             'placeholder'=>'','id'=>"name")) !!}
            {!! $errors->first('name','<span class="help-block">:message</span>') !!}
        </div>
    </div>
</div>
<div class="col-md-2">
    <div class="form-group has-feedback {{ $errors->has('date_within') ? 'has-error' : ''}}">
        <label class="col-md-12">Created Within</label>
        <div class="col-md-12">
            <select id="date_within" class="form-control " style="width: 100%;"
                    name="date_within">
                <option value="">Select one</option>
                @foreach($monthArray as $key=>$value)
                    <option value="{{$key}}">
                        {{$value}}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('date_within','<span class="help-block">:message</span>') !!}
        </div>
    </div>
</div>
<div class="col-md-2" style="display: none;">
    <div class="form-group has-feedback {{ $errors->has('created_date') ? 'has-error' : ''}}">
        <label class="col-md-12">And</label>
        <div class="col-md-12">
            {!! Form::text('created_date', null, array('class'=>'form-control datepicker ','style'=>'width: 100%;',
             'placeholder'=>'','id'=>"created_date")) !!}
            {!! $errors->first('created_date','<span class="help-block">:message</span>') !!}
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label class="col-md-12 ">&nbsp;</label>
        <div class="col-md-12">
            <button class="btn btn-info" id="search"><i class="fa fa-search"
                                                        aria-hidden="true"></i>
                <b>Search</b></button>

                <button class="btn btn-primary" id="refresh">
                <b>Refresh</b></button>
        </div>
    </div>
</div>

    <link rel="stylesheet" href="{{ asset("assets/plugins/select2.min.css") }}">
    <script src="{{ asset("assets/plugins/select2.full.js") }}"></script>
<script>
    $(document).ready(function () {
        var today = new Date();
        var yyyy = today.getFullYear();
        $('.datepicker').datetimepicker({
            viewMode: 'years',
            sideBySide: true,
            format: 'DD-MMM-YYYY',
        });

        $("#refresh").on("click", function (event) {
 
            var oTable = $('#list').dataTable();
            oTable.fnClearTable();
            oTable.html('');
            oTable.fnDestroy();
            reloadData( '{{url("/meeting/get-meeting-list/")}}', 0, 0, 0, 0, 0, 2);

        });

        $("#search").on("click", function (event) {
            event.preventDefault();
            var assigned_to = $('#assigned_to').val();
            var created_by = $('#created_by').val();
            var name = $('#name').val();
            var date_within = $('#date_within').val();
            var created_date = $('#created_date').val();
            var action_url = $('#action_url').val();
            var oTable = $('#list').dataTable();
            oTable.fnClearTable();


                if(assigned_to || name || date_within || created_date)
                {
                    oTable.html('');
                    oTable.fnDestroy();
                    reloadData( action_url, assigned_to, created_by, name, date_within, created_date, 1);

                }
                else{
                    alert('No Data');
                    return false;
                }


            
        });
    });
    $(document).ready(function () {
        $('.select_2_class').select2({width: '100%'});
    })
</script>
