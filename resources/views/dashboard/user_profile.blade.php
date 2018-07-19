@extends('dashboard.layouts')

@push('css')
    <link rel="stylesheet" href="{{ url('/') }}/toastr/toastr.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/datatables/datatables.min.css">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ __('Home') }}</a></li>
        <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="active">{{ __('My Bookings') }}</li>
    </ol>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ __('My Profile') }}</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">Booking ID</th>
                                <th scope="col">Room</th>
                                <th scope="col">Location</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Created</th>
                                <th scope="col">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <th scope="row">{{ $booking->id }}</th>
                                <td>{{ $booking->room->name }}</td>
                                <td>{{ $booking->room->location }}</td>
                                <td>{{ $booking->start_date }}</td>
                                <td>{{ $booking->end_date }}</td>
                                <td>{{ $booking->created_at }}</td>
                                    @if($booking->status==1)
                                        <td style="background-color: orange; text-align: center">Option</td>
                                    @else
                                        @if($booking->status==0)
                                        <td style="background-color: #3C8DBC; text-align: center">Confirmed</td>
                                            @endif
                                        @endif
                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->

                </div>
                <!-- /.box -->
            </div> <!-- /.col -->
        </div> <!-- /.row -->
    </section>
@endsection