@extends('dashboard.layouts')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ __('Home') }}</a></li>
        <li class="active">{{ __('Dashboard') }}</li>
        <li class="active">{{ __('Optional Edit') }}</li>
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
            
            @foreach($bookingOptionals as $bookingOptional)


                <form method="POST" action="{{ route('bookingoptionals.update',$bookingOptional->id )}}">
                    {!! csrf_field() !!}
                    <input name="_method" type="hidden" value="PATCH">
                    <!-- Your fields here -->

                <div class="col-lg-3" style="display: none">
                    <fieldset>ID BookingOptional</fieldset>
                    <input type="text" name="bookingOptionaId" value="{{$bookingOptional->id}}">
                </div>
                <div style="background-color:#F39C12; height: 160px; padding-bottom: 15px">
                    <h2 style="font-style: italic; color: #ffffff; text-align: center">Coffee / Lunch</h2>

                    @foreach($optionals as $optional)


                        @if($optional->column_name=='coffee_break'||$optional->column_name=='permanent_coffee'||$optional->column_name=='permanent_coffeeplus'||$optional->column_name=='integrazione_permanentcoffee'||$optional->column_name=='quick_lunch')
                            @if($optional->column_name=='coffee_break')
                            <div class="col-lg-3">
                                <fieldset>{{ $optional->nome }}</fieldset>
                                <input type="number" name="{{$optional->column_name}}" value="{{($bookingOptional[$optional->column_name])/6.5}}">
                            </div>
                                @else
                                <div class="col-lg-3">
                                    <fieldset>{{ $optional->nome }}</fieldset>
                                    <input type="number" name="{{$optional->column_name}}" value="{{$bookingOptional[$optional->column_name]}}">
                                </div>
                            @endif
                        @else
                        @endif
                    @endforeach
                </div>



                    <div style="background-color: #00C0EF; height: 160px; padding-bottom: 15px">
                        <h2 style="font-style: italic; color: #ffffff; text-align: center">Noleggio</h2>
                        @foreach($optionals as $optional)

                            @if($optional->column_name=='webconference'||
                                    $optional->column_name=='videoconferenza' ||
                                    $optional->column_name=='videoproiettore' ||
                                    $optional->column_name=='lavagna_foglimobili' ||
                                    $optional->column_name=='stampante' ||
                                    $optional->column_name=='lavagna_interattiva'
                                    )
                                <div class="col-lg-3">
                                    <fieldset>{{ $optional->nome }}</fieldset>
                                    <input type="number" name="{{$optional->column_name}}" value="{{$bookingOptional[$optional->column_name]}}">
                                </div>
                            @else
                            @endif
                        @endforeach
                    </div>

                    <div style="background-color: #DD4B39; height: 160px; padding-bottom: 15px;">
                        <h2 style="font-style: italic; color: #ffffff; text-align: center">Connessioni</h2>
                        @foreach($optionals as $optional)
                            @if($optional->column_name=='connessione_viacavo'
                                || $optional->column_name=='upgrade_banda10mb'
                                || $optional->column_name=='upgrade_banda8mb'
                                || $optional->column_name=='upgrade_banda20mb'
                                || $optional->column_name=='wirless_4mb20accessi'
                                || $optional->column_name=='wirless_8mb35accessi'
                                || $optional->column_name=='wirless_10mb50accessi'
                            )
                                <div class="col-lg-3">
                                    <fieldset>{{ $optional->nome }}</fieldset>
                                    <input type="number" name="{{$optional->column_name}}" value="{{$bookingOptional[$optional->column_name]}}">
                                </div>
                            @else
                            @endif
                        @endforeach
                    </div>
            @endforeach

                <p class="col-sm-offset-0 col-sm-1" style="margin-top: 20px">
                    <button type="submit" class="btn btn-primary btn-lg">Send</button>
                </p>

            </form>
        </div>

            <!-- /.col -->
    </section>
    @endsection