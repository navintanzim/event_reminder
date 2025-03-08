@if(isset($contacts))
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="row" style="margin-right: -4px; margin-bottom: -2px;">
                <b class="col-md-5" style="padding: 5px 0 0 10px;">Contacts Info</b>
            </div>
        </div>
        <div class="panel-body">
            @if(count($contacts) == 1)
                <div class="row">
                    <div class="col-md-6">
                        <dl class="dl-horizontal">
                            <dt>Full Name</dt>
                            <dd>: {{$contacts[0]->full_name}}</dd>
                            <dt>Designaton</dt>
                            <dd>: {{$contacts[0]->designation}}</dd>
                            <dt>Country</dt>
                            <dd>: {{$contacts[0]->country}}</dd>
                            <dt> Assigned to</dt>
                            <dd>
                                : {{\App\Libraries\CommonFunction::userNameShow($contacts[0]->assigned_to)}}</dd>
                            @if($contacts[0]->created_at)
                                <dt>Created at:</dt>
                                <dd>: <span id="created_at">{{\App\Libraries\CommonFunction::dateDiff($contacts[0]->created_at) }}</span></dd>
                            @endif
                            @if($contacts[0]->created_by)
                                <dt>Created by:</dt>
                                <dd>: {{\App\Libraries\CommonFunction::userNameShow($contacts[0]->created_by)}}</dd>
                            @endif
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="dl-horizontal">
                            <dt>Department</dt>
                            <dd>: {{$contacts[0]->department}}</dd>
                            <dt>City</dt>
                            <dd>: {{$contacts[0]->city}}</dd>
                            <dt>Description</dt>
                            <dd>: {{$contacts[0]->description}}</dd>
                            @if($contacts[0]->updated_at)
                                <dt>Updated at:</dt>
                                <dd>: <span id="updated_at">{{\App\Libraries\CommonFunction::dateDiff($contacts[0]->updated_at) }}</span></dd>
                            @endif
                            @if($contacts[0]->updated_by)
                                <dt>Updated by:</dt>
                                <dd>: {{\App\Libraries\CommonFunction::userNameShow($contacts[0]->updated_by)}}</dd>
                            @endif
                        </dl>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12">
                        <div class="col-md-6 pull-right">
                            <a href="{{url('/crm/contact/edit/' . Encryption::encodeId($contacts[0]->id))}}"
                               class="btn btn-info pull-right"><i
                                        class="fa fa-check-circle"></i>
                                Edit</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif
@if(isset($accounts_data))
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="row" style="margin-right: -4px; margin-bottom: -2px;">
                <b class="col-md-5" style="padding: 5px 0 0 10px;">Account Info</b>
            </div>
        </div>
        <div class="panel-body">
            @if(count($accounts_data) == 1)
                <div class="row">
                    <div class="col-md-6">
                        <dl class="dl-horizontal">
                            @if($accounts_data->name)
                                <dt>Name</dt>
                                <dd>: {{$accounts_data->name}}</dd>
                            @endif
                            @if($accounts_data->website)
                                <dt>Website</dt>
                                <dd>:
                                    <?php $parse = parse_url($accounts_data->website); ?>
                                    @if(isset($parse['host']))
                                    <a title="{{$accounts_data->website}}"
                                       target="_blank"
                                       href="{{$accounts_data->website}}">{{$parse['host']}}</a>
                                    @endif
                                </dd>
                            @endif

                            @if($accounts_data->location)
                                <dt>Billing Address</dt>
                                <dd>: {{$accounts_data->location}}
                                    , {{$accounts_data->thana ? $accounts_data->thana.' ,':''}}{{$accounts_data->city}}
                                    , {{$accounts_data->division}} {{$accounts_data->postcode ? $accounts_data->postcode.' - ':''}}
                                    , {{$accounts_data->country}}</dd>
                            @endif
                            @if(count($phone_email_data) >0)
                                @php $phoneRowCount = 0; @endphp
                                @foreach($phone_email_data as $data)
                                    @if($data->cont_cat == 'Email')
                                        @if($data->cont_type  && $data->cont_phone_email)
                                            <dt> {{$data->cont_type}} Email Address</dt>
                                            <dd>: {{$data->cont_phone_email}}</dd>
                                        @endif
                                        @php $phoneRowCount++ @endphp
                                    @endif
                                @endforeach
                            @endif
                            <dt> Description</dt>
                            <dd id="description_less">
                                : {!!  \App\Libraries\CommonFunction::stringLimit($accounts_data->description,100,'description_more_btn')!!}</dd>
                            <dd style="display: none"
                                id="description_more">
                                : {{$accounts_data->description}}
                                <a id='description_less_btn' href='javascript:void(0);'>See Less</a>
                            </dd>
                                @if($accounts_data->created_at)
                                    <dt>Created at:</dt>
                                    <dd>: <span id="created_at">{{\App\Libraries\CommonFunction::dateDiff($accounts_data->created_at) }}</span></dd>
                                @endif
                                @if($accounts_data->created_by)
                                    <dt>Created by:</dt>
                                    <dd>: {{\App\Libraries\CommonFunction::userNameShow($accounts_data->created_by)}}</dd>
                                @endif
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="dl-horizontal">

                            @if(count($phone_email_data) >0)
                                @php $emailRowCount = 0; @endphp
                                @foreach($phone_email_data as $data)
                                    @if($data->cont_cat == 'Phone')
                                        @if($data->cont_type && $data->cont_phone_email)
                                            <dt> {{$data->cont_type}} Phone</dt>
                                            <dd>: {{$data->cont_phone_email}}</dd>
                                        @endif
                                        @php $emailRowCount++ @endphp
                                    @endif
                                @endforeach
                            @endif
                            @if($accounts_data->account_type)
                                <dt>Accounts Type</dt>
                                <dd>: {{$accounts_data->account_type}} </dd>
                            @endif
                            @if($accounts_data->industry)
                                <dt>Industry Type</dt>
                                <dd>: {{$accounts_data->industry}} </dd>
                            @endif
                            @if($accounts_data->annual_revenue)
                                <dt>Annual Revenue</dt>
                                <dd>: {{$accounts_data->annual_revenue}} </dd>
                            @endif
                            @if($accounts_data->no_of_emps)
                                <dt>No. of Employees</dt>
                                <dd>: {{ $accounts_data->no_of_emps }} </dd>
                            @endif
                            @if(\App\Libraries\CommonFunction::getSectorInfoBBSCodeName($accounts_data->bbs_code))
                                <dt>Business Sector(BBS Code)</dt>
                                <dd id="bbs_less">
                                    : {!!  \App\Libraries\CommonFunction::stringLimit(\App\Libraries\CommonFunction::getSectorInfoBBSCodeName($accounts_data->bbs_code),100,'bbs_more_btn')  !!}
                                </dd>
                                <dd style="display: none"
                                    id="bbs_more">{{ \App\Libraries\CommonFunction::getSectorInfoBBSCodeName($accounts_data->bbs_code) }}
                                    <a id='bbs_less_btn' href='javascript:void(0);'>See Less</a></dd>
                            @endif
                            @if(\App\Libraries\CommonFunction::getContactAccountName($accounts_data->parent_id))
                                <dt>Principal Account</dt>
                                <dd>
                                    : {{ \App\Libraries\CommonFunction::getContactAccountName($accounts_data->parent_id) }} </dd>
                            @endif
                                @if($accounts_data->updated_at)
                                    <dt>Updated at:</dt>
                                    <dd>: <span id="updated_at">{{\App\Libraries\CommonFunction::dateDiff($accounts_data->updated_at) }}</span></dd>
                                @endif
                                @if($accounts_data->updated_by)
                                    <dt>Updated by:</dt>
                                    <dd>: {{\App\Libraries\CommonFunction::userNameShow($accounts_data->updated_by)}}</dd>
                                @endif
                        </dl>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12">
                        <div class="col-md-6 pull-right">
                            <a href="{{url('/crm/accounts/edit-account/' . Encryption::encodeId($accounts_data->id))}}"
                               class="btn btn-info pull-right"><i
                                        class="fa fa-check-circle"></i>
                                Edit</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif
@if(isset($Leads))
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="row" style="margin-right: -4px; margin-bottom: -2px;">
                <b class="col-md-5" style="padding: 5px 0 0 10px;">Leads Info</b>
            </div>
        </div>
        <div class="panel-body">
            @if(count($Leads) == 1)
                <div class="row">
                    <div class="col-md-6">
                        <dl class="dl-horizontal">
                            <dt>Caption</dt>
                            <dd>: {{$Leads[0]->caption}}</dd>
                            <dt>Contact</dt>
                            <dd>:
                                <a href="{{url('crm/contact/view/' . Encryption::encodeId($Leads[0]->lead_contact_id))}}"> {{($Leads[0]->full_name)}}</a>
                            </dd>
                            <dt>Lead Source</dt>
                            @php $leadsourch=array_flip($leadSourceList) @endphp
                            <dd>: {{$key = array_search($Leads[0]->lead_source, $leadsourch)}}</dd>
                            <dt>Opportunity Amount</dt>
                            <dd>: {{$Leads[0]->opp_amt}} BDT</dd>
                            <dt>Lead Status</dt>
                            <dd>: {{$Leads[0]->lead_status}}</dd>
                            @if($Leads[0]->lead_status=='Converted')
                                <dt> Expected Close Date</dt>
                                <dd>: {{($Leads[0]->close_dt)}}</dd>
                                <dt>Primary Competitor</dt>
                                <dd>
                                    : {{\App\Libraries\CommonFunction::getContactAccountName($Leads[0]->competitor1_account_id)}}</dd>
                                <dt>Competitor Strength</dt>
                                <dd>: {{($Leads[0]->competitor_strengh)}}</dd>
                                <dt>Second Competitor</dt>
                                <dd>
                                    : {{\App\Libraries\CommonFunction::getContactAccountName($Leads[0]->competitor2_account_id)}}</dd>
                                <dt>Opportunity Status</dt>
                                <dd>: {{($Leads[0]->opp_status)}}</dd>
                            @endif
                            @if($Leads[0]->created_at)
                                <dt>Created at:</dt>
                                <dd>: <span id="created_at">{{\App\Libraries\CommonFunction::dateDiff($Leads[0]->created_at) }}</span></dd>
                            @endif
                            @if($Leads[0]->created_by)
                                <dt>Created by:</dt>
                                <dd>: {{\App\Libraries\CommonFunction::userNameShow($Leads[0]->created_by)}}</dd>
                            @endif
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="dl-horizontal">
                            <dt>Referred By</dt>
                            <dd>: {{$Leads[0]->referred_by}}</dd>
                            <dt>Assigned Name</dt>
                            <dd>: {{$Leads[0]->assigned_name}}</dd>
                            <dt>Primary Product Line</dt>
                            <dd>: {{$Leads[0]->product_line}}</dd>
                            <dt>Created By</dt>
                            <dd>: {{$Leads[0]->creator_name}}</dd>
                            @if($Leads[0]->lead_status=='Converted')
                                <dt>Probability (%)</dt>
                                <dd> : {{ $Leads[0]->probability}} </dd>
                                <dt>Competitor Weakness</dt>
                                <dd> : {{ $Leads[0]->competitor_weekness}} </dd>
                            @endif
                            @if($Leads[0]->opp_status=='Close Lost')
                                <dt>Lost with (Winner Account)</dt>
                                <dd>
                                    : {{ \App\Libraries\CommonFunction::getContactAccountName($Leads[0]->lost_with_account_id)}} </dd>
                                <dt>Cause of Lost (Details)</dt>
                                <dd> : {{ $Leads[0]->lost_cause}} </dd>
                            @endif
                            @if($Leads[0]->opp_status=='Close Win')
                                <dt>Wining Statement</dt>
                                <dd> : {{ $Leads[0]->win_statement}} </dd>
                            @endif
                            <dt>Description</dt>
                            <dd> : {{ $Leads[0]->description}} </dd>
                            @if($Leads[0]->updated_at)
                                <dt>Updated at:</dt>
                                <dd>: <span id="updated_at">{{\App\Libraries\CommonFunction::dateDiff($Leads[0]->updated_at) }}</span></dd>
                            @endif
                            @if($Leads[0]->updated_by)
                                <dt>Updated by:</dt>
                                <dd>: {{\App\Libraries\CommonFunction::userNameShow($Leads[0]->updated_by)}}</dd>
                            @endif
                        </dl>
                    </div>
                </div>
                @if(Auth::user()->user_type == "1x101" || Auth::user()->id == $Leads[0]->assigned_to )
                    @if(($Leads[0]->opp_status != 'Close Lost' || $Leads[0]->opp_status != 'Close Win'))
                        <div class="modal-footer">
                            <div class="col-md-12">
                                <div class="col-md-6 pull-right">
                                    <a href="{{url('/crm/lead/edit/' . Encryption::encodeId($Leads[0]->id))}}"
                                       class="btn btn-info pull-right"><i
                                                class="fa fa-check-circle"></i> Edit</a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            @else
                <div class="row">
                    <div class="col-md-12">&nbsp;</div>
                </div>
            @endif
        </div>
    </div>
@endif
