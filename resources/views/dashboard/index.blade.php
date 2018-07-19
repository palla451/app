@extends('dashboard.layouts')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ __('Home') }}</a></li>
        <li class="active">{{ __('Dashboard') }}</li>
    </ol>
@endsection

@section('content')
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-briefcase"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{ __('Total Room') }}</span>
                        <span class="info-box-number">{{ number_format(\App\Room::all()->count()) }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-calendar-check-o"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{ __('Total Booking') }}</span>
                        <span class="info-box-number">{{ number_format(\App\Booking::all()->count()) }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="ion ion-ios-people"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{ __('Active User') }}</span>
                        <span class="info-box-number">{{ number_format(\App\User::active()->count()) }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{ __('Total User') }}</span>
                        <span class="info-box-number">{{ number_format(\App\User::all()->count()) }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-8">
                @if (auth()->user()->hasRole('superadmin|admin'))
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">7 Latest Booking</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Room Name') }}</th>
                                    <th>{{ __('Booked By') }}</th>
                                    <th>{{ __('Booked On') }}</th>
                                    <th>{{ __('Duration') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach (\App\Booking::orderBy('created_at', 'desc')->take(7)->get() as $booking)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $booking->room->name }}</td>
                                    <td>{{ $booking->user->name }}</td>
                                    <td>{{ $booking->start_date->format(\App\Booking::DATE_FORMAT) }}</td>
                                    <td>{{ $booking->getDuration() }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">My Dashboard</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        This is normal user dashboard.
                    </div>
                </div>
                @endif
            </div>

            <div class="col-md-4">
                <!-- USERS LIST -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Latest Members</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <ul class="users-list clearfix">
                            @foreach (\App\User::orderBy('created_at', 'desc')->take(8)->get() as $user)
                            <li>
                                <img src="{{ \Thomaswelton\LaravelGravatar\Facades\Gravatar::src($user->email, 128) }}" alt="User Image">
                                <a class="users-list-name" href="#">{{ $user->name }}</a>
                                <span class="users-list-date">{{ $user->created_at->diffForHumans() }}</span>
                            </li>
                            @endforeach
                        </ul>
                        <!-- /.users-list -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer text-center">
                        <a href="{{ route('users.index') }}" class="uppercase">View All Users</a>
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!--/.box -->
            </div>
            <!-- /.col -->
        </div>
    </section>
@endsection