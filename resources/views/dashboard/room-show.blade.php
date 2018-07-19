@extends('dashboard.layouts')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('css')
    <link rel="stylesheet" href="{{ url('/') }}/plugins/pace/pace.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/toastr/toastr.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/sweetalert2/sweetalert2.min.css">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ __('Home') }}</a></li>
        <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li><a href="{{ route('rooms.index') }}">{{ __('Room Management') }}</a></li>
        <li class="active">{{ $room->name }}</li>
    </ol>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-body no-padding">
                        <div id="calendar" class="fc"></div>
                    </div>
                </div>
            </div> <!-- /.col -->
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ __('Upcoming Booking') }}</h3>
                    </div>
                    <div class="box-body">
                    @foreach(\App\Booking::where('room_id', $room->id)->take(10)->orderBy('start_date')->get() as $booking)
                        <strong><i class="fa fa-calendar-o margin-r-5"></i> {{ $booking->user->name }}</strong>
                        <p class="text-muted">
                            Booked on: {{ $booking->start_date->format(\App\Booking::DATE_FORMAT) }}<br>
                            Duration: {{ $booking->getDuration() }}
                        </p>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @endforeach
                    </div>
                </div>
            </div>
        </div> <!-- /.row -->
    </section>
@endsection

@push('js')
    <script src="{{ url('/') }}/plugins/pace/pace.min.js"></script>
    <script src="{{ url('/') }}/plugins/fullcalendar/lib/moment.min.js"></script>
    <script src="{{ url('/') }}/plugins/fullcalendar/fullcalendar.min.js"></script>
    <script src="{{ url('/') }}/toastr/toastr.min.js"></script>
    <script src="{{ url('/') }}/toastr/option.js"></script>
    <script src="{{ url('/') }}/sweetalert2/sweetalert2.min.js"></script>
    <script>
        $(document).ajaxStart(function() { Pace.restart(); });
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listWeek'
                },
                defaultDate: '{{ date('Y-m-d') }}',
                navLinks: false,
                editable: false,
                eventLimit: true, // allow "more" link when too many events
                events: {
                    url: '{!! route('fullcalendar.room', ['id' => $room->id]) !!}',
                    error: function() {
                        alert("cannot load json");
                    }
                }
            });
        });
    </script>
@endpush