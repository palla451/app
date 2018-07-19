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
            <div class="col-md-12">
                @if (auth()->user()->hasRole('superadmin|admin'))
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">New Optional</h3>
                        </div>
                        <!-- /.box-header -->
                        <form class="form-horizontal" action="{{ route('storenewoptional') }}" method="POST">

                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="nome" class="col-sm-2 control-label">Nome Optional</label>
                                <div class="col-sm-6">
                                    <input value="" type="text" class="form-control" name="nome" id="nome">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="prezzo_per_unita" class="col-sm-2 control-label">Prezzo per unita</label>
                                <div class="col-sm-6">
                                    <input value="" type="number" class="form-control" name="prezzo_per_unita" id="prezzo_per_unita">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default">Send</button>
                                </div>
                            </div>
                            <!-- space -->
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                </div>
                            </div>
                        </form>
                    </div>

                @else
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">My Dashboard</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <h4 style="text-align: center">You are not authorized to visit this page</h4>
                        </div>
                    </div>
                @endif
            </div>
            <!-- /.col -->
        </div>
    </section>
@endsection