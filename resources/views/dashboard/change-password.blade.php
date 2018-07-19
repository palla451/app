@extends('dashboard.layouts')

@push('css')
    <link rel="stylesheet" href="{{ url('/') }}/toastr/toastr.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/datatables/datatables.min.css">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ __('Home') }}</a></li>
        <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="active">{{ __('Change Password') }}</li>
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
                    <form class="form-horizontal" id="changePasswordForm" method="POST">
                        <div class="box-body">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="form-group">
                                <label for="inputNewPassword" class="col-sm-2 control-label">{{ __('New Password') }}</label>
                                <div class="col-sm-8">
                                    <input type="password"
                                           name="new_password"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword" class="col-sm-2 control-label">{{ __('Retype Password') }}</label>
                                <div class="col-sm-8">
                                    <input type="password"
                                           name="new_password_confirmation"
                                           class="form-control">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <span class="pull-right">
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

                $.ajax({
                    type: "POST",
                    url: "{{ route('change-password.update', ['id' => $user->id]) }}",
                    data: data,
                    dataType: 'json'
                })
                    .done(function(data){
                        toastr.success(data.message);
                        $('#changePasswordForm').each(function(){
                            this.reset();
                        });
                    })
                    .fail(function(data){
                        var errors = data.responseJSON;
                        if (data.status === 403) {
                            toastr.error(errors.message);
                        } else {
                            $.each(errors.errors, function (key, value) {
                                toastr.error(value);
                            });
                        }
                    });
            });
        })
    </script>
@endpush