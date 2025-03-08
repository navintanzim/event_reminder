@extends('layouts.admin')

<link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.min.css" rel="stylesheet" />
<link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.print.css" rel="stylesheet" media="print" />
<link rel="stylesheet" href="/css/main.css?v=202102.12">
<style>
    .bg-blue-ebonyclay {
        border-color: #22313F !important;
        background-image: none !important;
        background-color: #22313F !important;
        color: #FFFFFF !important;
    }

    .hint {
        display: none;
    }

    

    
</style>
@section('content')
        <div class="box-body col-md-8" style="border: 3px solid #0000ff; ">
            <div class="col-md-12" id="calendar" style="height: 80%; width: 100%; overflow: auto;"></div>
        </div>

        <div class="row">
            
            <div class="col-md-12">



            </div>

            
            

        </div>
        @endsection

        @section('footer-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <!-- <script src="{{ asset("assets/plugins/jquery/jquery.min.js") }}" src="" type="text/javascript"></script> -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.min.js"></script>


    <script>

    
        var calendar = $("#calendar").fullCalendar({

        contentHeight: "auto",
        height: 180,
        
        header: {
            left: 'prev,next ',
            center: 'title',
            right: 'month, today'
        },
        navLinks: true,
        editable: true,
        eventLimit: true,
        weekends: true,
        events: function(start, end, timezone, callback) {
            var events = [];
            jQuery.ajax({
                url: '/dashboard/task-meeting-calendar',
                type: 'get',
                success: function(data) {
                    var i = 0;
                    for (i = 0; i < data.length; i++) {
                        events.push({
                            title: data[i].title + '  ' + (data[i].Task ? data[i].Task : data[i].Meeting),
                            start: data[i].start,
                            end: data[i].end,
                            color: data[i].Task ? "blue" : "green"
                        });
                    }
                    callback(events);
                }
            });
        },
        });

    </script>
@endsection

