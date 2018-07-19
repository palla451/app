@extends('dashboard.layouts')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('css')
    <link rel="stylesheet" href="{{ url('/') }}/plugins/pace/pace.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/toastr/toastr.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/datatables/datatables.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/plugins/daterangepicker/daterangepicker.css">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ __('Home') }}</a></li>
        <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="active">{{ __('Booking Management') }}</li>
    </ol>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        @permission('read-booking')
                        <li class="active">
                            <a href="#bookings" data-toggle="tab">{{ __('All booking') }}</a>
                        </li>
                        @endpermission
                        @permission('create-booking')
                        <li{!! auth()->user()->canCreateBooking() && !auth()->user()->canReadBooking() ? ' class="active"':'' !!}>
                            <a href="#addNewBooking" data-toggle="tab">{{ __('Make new booking') }}</a>
                        </li>
                        @endpermission
                    </ul>
                    <div class="tab-content">
                        @permission('read-booking')
                        <div class="active tab-pane" id="bookings">
                            <table id="bookingList" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>{{ __('Room Name') }}</th>
                                    <th>{{ __('Booked By') }}</th>
                                    <th>{{ __('Start') }}</th>
                                    <th>{{ __('End') }}</th>
                                    <th>{{ __('Duration') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th style="width: 60px;">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>{{ __('Room Name') }}</th>
                                    <th>{{ __('Booked By') }}</th>
                                    <th>{{ __('Start') }}</th>
                                    <th>{{ __('End') }}</th>
                                    <th>{{ __('Duration') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>@endpermission
                        @permission('create-booking')
                        <div class="{!! auth()->user()->canCreateBooking() && !auth()->user()->canReadBooking() ? 'active ':'' !!}tab-pane" id="addNewBooking">
                            <form id="search" action="{{ route('bookings.search') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Date and time range -->
                                        <div class="form-group">
                                            <label>{{ __('Select date and time') }}:</label>

                                            <div class="input-group">
                                                <input type="text" class="form-control pull-right" name="bookingTime" id="bookingTime">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar-check-o"></i>
                                                </div>
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <!-- /.form group -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ __('Pax') }}</label>
                                            <select class="form-control" style="width: 100%;" name="pax">
                                                <option value="">Please select one</option>
                                                @foreach($rooms as $room)
                                                <option>{{ $room->pax }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Location') }}</label>
                                            <select class="form-control" style="width: 100%;" name="location">
                                                <option value="">Please select one</option>
                                                @foreach($sedi as $sede)
                                                    <option>{{ $sede->sede }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="submit" class="btn btn-primary" style="width: 100%">{{ __('Submit') }}</button>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </form>
                            <div id="result">
                                <h3>{{ __('Available room') }}:</h3>
                                <table id="searchResult" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                     <thead>
                                     <tr>
                                         <th>{{ __('Room Name') }}</th>
                                         <th>{{ __('Pax') }}</th>
                                         <th>{{ __('Location') }}</th>
                                         <th>{{ __('Type') }}</th>
                                         <th>{{ __('Price') }}</th>
                                         <th>{{ __('Action') }}</th>
                                     </tr>
                                     </thead>
                                     <tfoot>
                                     <tr>
                                         <th>{{ __('Room Name') }}</th>
                                         <th>{{ __('Pax') }}</th>
                                         <th>{{ __('Location') }}</th>
                                         <th>{{ __('Type') }}</th>
                                         <th>{{ __('Price') }}</th>
                                         <th>{{ __('Action') }}</th>
                                     </tr>
                                     </tfoot>
                                </table>
                            </div>
                        </div>@endpermission
                    </div>
                </div>
            </div> <!-- /.col -->
        </div> <!-- /.row -->
    </section>
@endsection

@push('js')
    <script src="{{ url('/') }}/plugins/pace/pace.min.js"></script>
    <script src="{{ url('/') }}/toastr/toastr.min.js"></script>
    <script src="{{ url('/') }}/toastr/option.js"></script>
    <script src="{{ url('/') }}/datatables/datatables.min.js"></script>
    <script src="{{ url('/') }}/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ url('/') }}/plugins/daterangepicker/moment.min.js"></script>
    <script src="{{ url('/') }}/plugins/daterangepicker/daterangepicker.js"></script>
    <script>
        $(document).ajaxStart(function() { Pace.restart(); });
        $('#result').hide(); // hide booking search result table

        $(document).ready(function () {

            $('#bookingList').DataTable({
                initComplete: function(){
                    var api = this.api();
                    $('#bookingList_filter input')
                        .off('.DT')
                        .on('keyup.DT', function (e) {
                            if (e.keyCode === 13) {
                                api.search(this.value).draw();
                            }
                        });
                },
                processing: true,
                serverSide: true,
                ajax: "{!! route('datatables.bookings') !!}",
                lengthMenu: [[5,20,50,100,-1], [5,20,50,100,"All"]],
                columns: [
                    { data: 'room_name', name: 'room_name' },
                    { data: 'booked_by', name: 'booked_by' },
                    { data: 'start_date', name: 'start_date' },
                    { data: 'end_date', name: 'end_date' },
                    { data: 'duration', name: 'duration'},
                    { data: 'status', name: 'status'},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // Cancel booking
            $('#bookingList')
                .DataTable()
                .on('click', '.btn-delete', function (event) {
                    event.preventDefault();

                    var url = $(this).data('remote');
                    var token = $('meta[name="csrf-token"]').attr('content');

                    swal({
                        title: '{{ __ ('Are you sure to cancel this booking?') }}',
                        text: "{!! __("You won't be able to revert this!") !!}",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#ccc',
                        confirmButtonText: '{!! __('Yes, cancel it!') !!}',
                        cancelButtonText: '{!! __('Cancel') !!}',
                        allowOutsideClick: false
                    }).then(function () {
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {'_method' : 'DELETE', '_token' : token},
                            dataType: 'json'
                        })
                        .done(function(data){
                            swal({
                                title: '{{ __('Cancelled!') }}',
                                text: data.message,
                                type: 'success',
                                confirmButtonText: '{!! __('Close') !!}',
                                allowOutsideClick: false
                            }).then(function(){
                                $('#bookingList').DataTable().ajax.reload();
                            });
                        })
                        .fail(function(data){
                            var errors = data.responseJSON;
                            if (data.status === 403) {
                                swal({
                                    title: '{{ __('Request denied!') }}',
                                    text: errors.message,
                                    type: 'error',
                                    confirmButtonText: '{!! __('Close') !!}',
                                    allowOutsideClick: false
                                });
                            } else {
                                $.each(errors.errors, function (key, value) {
                                    toastr.error(value);
                                });
                            }
                        });
                    });
                });

            // Date range picker with time picker
            $('#bookingTime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 15,
                timePicker24Hour: true,
                minDate: moment().format('DD/MM/YYYY HH'),
                opens: 'right',
                locale: {
                    format: 'DD/MM/YYYY HH:mm:ss'
                }
            });

            $('#search').on('submit', function (event) {
                event.preventDefault();
                var data = $(this).serialize();
                var bookingTime = document.getElementById('bookingTime').value;

                $.ajax({
                    type: "POST",
                    url: "{{ route('bookings.search') }}",
                    data: data,
                    dataType: 'json'
                })
                .done(function(result){
                    $('#searchResult').DataTable().destroy();
                    $('#result').show();
                    $('#searchResult').DataTable({
                        data: result,
                        columns: [
                            { data: 'name' },
                            { data: 'pax', width: '100px', orderable: false, searchable: false},
                            { data: 'location', width: '100px', orderable: false, searchable: false},
                            { data: 'type', width: '100px', orderable: false, searchable: false},
                            { data: 'price', width: '100px', orderable: false, searchable: false},
                            { data: 'action', width: '100px', orderable: false, searchable: false}
                        ]
                    }).on('click', '.btn-book', function(event){
                        event.preventDefault();

                        var roomName = $(this).data('name');
                        var roomId = $(this).data('id');
                        var url = $(this).data('remote');
                        var token = $('meta[name="csrf-token"]').attr('content');
                        var clickedRow = $('#searchResult')
                                            .DataTable()
                                            .row($(this).parents('tr'));

                        swal({
                            title: roomName,
                            text: "{!! __("Are you sure to book this room?") !!}",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#ccc',
                            confirmButtonText: "{!! __("Yes, book it!") !!}",
                            cancelButtonText: '{!! __('Cancel') !!}',
                            allowOutsideClick: false
                        })
                        .then(function(){
                            var input = {
                                '_token' : token,
                                'roomId' : roomId,
                                'roomName' : roomName,
                                'bookingTime': bookingTime
                            };
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: input,
                                dataType: 'json'
                            })
                            .done(function(data){
                                swal({
                                    title: '{{ __('Booked!') }}',
                                    text: data.message,
                                    type: 'success',
                                    allowOutsideClick: false
                                }).then(function(){
                                    clickedRow.remove().draw();
                                    $('#bookingList').DataTable().ajax.reload();
                                });
                            })
                            .fail(function(data){
                                var errors = data.responseJSON;
                                $.each(errors.errors, function (key, value) {
                                    toastr.error(value);
                                });
                            });
                        });
                    });
                })
                .fail(function(data){
                    $('#result').hide();

                    var errors = data.responseJSON;
                    $.each(errors.errors, function (key, value) {
                        toastr.error(value);
                    });
                });
            });

        });
    </script>
@endpush