@extends('dashboard.layouts')

@push('css')
    <link rel="stylesheet" href="{{ url('/') }}/toastr/toastr.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/datatables/datatables.min.css">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ __('Home') }}</a></li>
        <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="active">{{ __('User Management') }}</li>
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
                    <form class="form-horizontal" id="updateUserForm" method="POST">
                        <div class="box-body">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">{{ __('Name') }}</label>
                                <div class="col-sm-8">
                                    <input type="text"
                                           name="name"
                                           class="form-control"
                                           id="inputName"
                                           placeholder="i.e. Pisyek K"
                                           value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label">{{ __('Email') }}</label>
                                <div class="col-sm-8">
                                    <input type="email"
                                           name="email"
                                           class="form-control"
                                           placeholder="i.e. your-email@domain.com"
                                           value="{{ $user->email }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword" class="col-sm-2 control-label">{{ __('Password') }}</label>
                                <div class="col-sm-8">
                                    <input type="password" name="password" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPasswordConfirmation" class="col-sm-2 control-label">{{ __('Password confirmation') }}</label>
                                <div class="col-sm-8">
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputRole" class="col-sm-2 control-label">{{ __('Role') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="role">
                                        <option value="">{{ __('Please select a role') }}</option>
                                        @foreach(\App\Role::all() as $role)
                                            <option value="{{ $role->id }}"{{ $user->hasRole($role->name) ? ' selected':'' }}>{{ $role->display_name }}</option>
                                        @endforeach
                                    </select>
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

                $.ajax({
                    type: "POST",
                    url: "{{ route('users.update', ['id' => $user->id]) }}",
                    data: data,
                    dataType: 'json'
                })
                    .done(function(data){
                        toastr.success(data.message);
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