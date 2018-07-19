@extends('dashboard.layouts')

@push('css')
    <link rel="stylesheet" href="{{ url('/') }}/toastr/toastr.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/datatables/datatables.min.css">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ __('Home') }}</a></li>
        <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="active">{{ __('Room Management') }}</li>
    </ol>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ __('Edit') }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal" id="updateRoomForm" method="POST">
                        <div class="box-body">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <input type="hidden" name="id" value="{{ $room->id }}">
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">{{ __('Room Name') }}</label>
                                <div class="col-sm-8">
                                    <input type="text"
                                           name="name"
                                           class="form-control"
                                           id="inputName"
                                           placeholder="i.e. Deluxe Room"
                                           value="{{ $room->name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPax" class="col-sm-2 control-label">{{ __('Pax') }}</label>
                                <div class="col-sm-8">
                                    <input type="number"
                                           min="1"
                                           name="pax"
                                           class="form-control"
                                           placeholder="i.e. 4"
                                           value="{{ $room->pax }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPax" class="col-sm-2 control-label">{{ __('Location') }}</label>
                                <div class="col-sm-8">
                                    <input type="string"
                                           name="location"
                                           class="form-control"
                                           placeholder="i.e. 4"
                                           value="{{ $room->location }}">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <span class="pull-right">
                                <a class="btn btn-default" href="{{ url()->previous() }}">{{ __('Back') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            </span>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
                <!-- /.box -->
            </div> <!-- /.col -->
        </div> <!-- /.row -->
    </section>
@endsection

@push('js')
    <script src="{{ url('/') }}/toastr/toastr.min.js"></script>
    <script src="{{ url('/') }}/toastr/option.js"></script>
    <script>
        $(document).ready(function () {
            $('form').on("submit", function(event){
                event.preventDefault();

                var data = $(this).serialize();

                console.log(data);

                $.ajax({
                    type: "POST",
                    url: "{{ route('rooms.update', ['id' => $room->id]) }}",
                    data: data,
                    dataType: 'json'
                })
                    .done(function(data){
                        toastr.success(data.message);
                    })
                    .fail(function(data){
                        var errors = data.responseJSON;
                        $.each(errors.errors, function (key, value) {
                            toastr.error(value);
                        });
                    });
            });
        })
    </script>
@endpush