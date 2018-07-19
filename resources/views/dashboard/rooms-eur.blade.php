@extends('dashboard.layouts')

@push('css')
    <link href='{{ url('/') }}/newfullcalendar/fullcalendar.min.css' rel='stylesheet' />
    <link href='{{ url('/') }}/newfullcalendar/fullcalendar.print.min.css' rel='stylesheet' media='print' />
    <link href='{{ url('/') }}/newfullcalendar/scheduler.min.css' rel='stylesheet' />
    <style>
        #calendar {
            max-width: 1024px;
            margin-top: 40px;
            margin-left: auto;
            margin-right: auto;
            background-color: #ffffff;
        }
    </style>
    <title>Booking Calendar</title>

@endpush

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ __('Home') }}</a></li>
        <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="active">{{ __('Booking Calendar') }}</li>
    </ol>
@endsection


@section('content')
<section>
    <div class="row">
        <div class="col-md-12">
            <div id='calendar'></div>
        </div>
    </div>
</section>
    @endsection





@push('js')

    <script src="{{ url('/') }}/newfullcalendar/moment.min.js"></script>
    <script src="{{ url('/') }}/newfullcalendar/fullcalendar.min.js"></script>
    <script src="{{ url('/') }}/newfullcalendar/scheduler.min.js"></script>



    <script>
        $(function() { // document ready
            $('#calendar').fullCalendar({
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                now: new Date(),

                editable: false, // enable draggable events
                aspectRatio: 1.8,
                scrollTime: '08:00', // undo default 6am scrollTime
                header: {
                    left: 'today prev,next',
                    center: 'title',
                    right: 'timelineDay,timelineThreeDays,agendaWeek,month,listWeek'
                },
                defaultView: 'timelineDay',
                resourceLabelText: 'Rooms',
                resources: '{!! route('fullcalendar.roomeur') !!}',
                events: '{!! route('fullcalendar.bookingeur') !!}',
                timeFormat: 'H(:mm)'
                /*  events: [
                      {
                          id: "1",
                          resourceId: "1",
                          start: "2018-06-27 09:00:00",
                          end: "2018-06-27 12:00:00",
                          title: "Sia",
                      },
                      {
                          id: "2",
                          resourceId: "1",
                          start: "2018-06-27 15:00:00",
                          end: "2018-06-27 19:00:00",
                          title: "Cruciani",
                      }
                  ]*/
            });
        });

    </script>

@endpush






