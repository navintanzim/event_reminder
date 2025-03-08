@if(env('IS_MOBILE')==false)
<div class="container">
    <div class="section-title text-center">
        <h2>Notice</h2>
    </div>
    <div id="ebsNotice" class="ebs-notice-content">
        @if($notice)
            @foreach ($notice as $value)
                @if($loop->index==0)
                    <div class="ebs-notice-item">
                        <div class="ebs-notice-item-head">
                            <span class="ebs-notice-icon"></span>
                            <div class="collapsible-link" data-toggle="collapse" data-target="#ebs-notice-0{{$loop->index}}"
                                 aria-expanded="true" aria-controls="ebs-notice-0{{$loop->index}}">
                                <span class="ebs-notice-date">{{ \App\Libraries\CommonFunction::changeDateFormat(substr($value->update_date, 0, 10))}}</span>
                                <h4>{{$value->heading}}</h4>
                            </div>
                        </div>
                        <div id="ebs-notice-0{{$loop->index}}" class="ebs-notice-item-body collapse show" aria-labelledby="ebs-notice-0{{$loop->index}}"
                             data-parent="#ebsNotice">
                            <div class="ebs-notice-item-desc">
                                <p>{{$value->details}}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="ebs-notice-item">
                        <div class="ebs-notice-item-head">
                            <span class="ebs-notice-icon"></span>
                            <div class="collapsible-link" data-toggle="collapse" data-target="#ebs-notice-0{{$loop->index}}"
                                 aria-expanded="false"
                                 aria-controls="ebs-notice-0{{$loop->index}}">
                                <span class="ebs-notice-date">{{ \App\Libraries\CommonFunction::changeDateFormat(substr($value->update_date, 0, 10))}}</span>
                                <h4>{{$value->heading}}</h4>
                            </div>
                        </div>
                        <div id="ebs-notice-0{{$loop->index}}" class="ebs-notice-item-body collapse" aria-labelledby="ebs-notice-0{{$loop->index}}"
                             data-parent="#ebsNotice">
                            <div class="ebs-notice-item-desc">
                                <p>{{$value->details}}</p>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>

    {{--<div class="ebs-pagination text-center my-4 p-3">--}}
        {{--<ul class="pagination">--}}
            {{--<li class="page-item"><a class="page-link page-prev" href="#">Previous <span--}}
                            {{--class="link-space-left">|</span> </a></li>--}}
            {{--<li class="page-item"><a class="page-link" href="#">1</a></li>--}}
            {{--<li class="page-item"><a class="page-link" href="#">2</a></li>--}}
            {{--<li class="page-item"><a class="page-link" href="#">3</a></li>--}}
            {{--<li class="page-item"><a class="page-link" href="#">4</a></li>--}}
            {{--<li class="page-item"><a class="page-link" href="#">5</a></li>--}}
            {{--<li class="page-item">...</li>--}}
            {{--<li class="page-item"><a class="page-link" href="#">20</a></li>--}}
            {{--<li class="page-item"><a class="page-link page-next" href="#"> <span class="link-space-right">|</span> Next</a>--}}
            {{--</li>--}}
        {{--</ul>--}}
    {{--</div>--}}
</div>
@endif