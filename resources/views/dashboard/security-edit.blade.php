@extends('dashboard.layouts')

@push('css')
    <link rel="stylesheet" href="{{ url('/') }}/toastr/toastr.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/datatables/datatables.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/plugins/iCheck/all.css">
    <style>
        .form-horizontal .checkbox {
            padding-top: 3px;
        }
    </style>
@endpush

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ __('Home') }}</a></li>
        <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="active">{{ __('Security') }}</li>
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
                            <input type="hidden" name="id" value="{{ $role->id }}">
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">{{ __('Role Name') }}</label>
                                <div class="col-sm-8">
                                    <input type="text"
                                           name="name"
                                           class="form-control"
                                           id="inputName"
                                           placeholder="i.e. room-manaer"
                                           value="{{ $role->name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputDisplayName" class="col-sm-2 control-label">{{ __('Display Name') }}</label>
                                <div class="col-sm-8">
                                    <input type="text"
                                           name="display_name"
                                           class="form-control"
                                           id="inputDisplayName"
                                           placeholder="i.e. Room Manager (optional)"
                                           value="{{ $role->display_name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputDescription" class="col-sm-2 control-label">{{ __('Description') }}</label>
                                <div class="col-sm-8">
                                    <input type="text"
                                           name="description"
                                           class="form-control"
                                           id="inputDescription"
                                           placeholder="i.e. Manage room from backend (optional)"
                                           value="{{ $role->description }}">
                                </div>
                            </div>

                            <div class="text-center">
                                <h3>{{ __('Assign permission for this role') }}</h3>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-8">
                                    <table class="table table-striped table-condensed">
                                        <tr>
                                            <th style="width: 50px">#</th>
                                            <th>{{ __('Module') }}</th>
                                            <th class="text-center" style="width: 90px">
                                                {{ __('Create') }}</th>
                                            <th class="text-center" style="width: 90px">
                                                {{ __('Read') }}</th>
                                            <th class="text-center" style="width: 90px">
                                                {{ __('Update') }}</th>
                                            <th class="text-center" style="width: 90px">
                                                {{ __('Delete') }}</th>
                                        </tr>
                                        @foreach($permissions as $module => $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ __($module)  }}</td>
                                            @foreach($permissions[$module] as $item)
                                                <td class="text-center">
                                                    <div class="checkbox icheck">
                                                        <label>
                                                            <input
                                                                    type="checkbox"
                                                                    name="permission[]"
                                                                    value="{{ $item->id }}"
                                                                    {{ in_array($item->id, $role->getPermissionIds()) ? ' checked' : '' }}>
                                                        </label>
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Module') }}</th>
                                            <th class="text-center" style="width: 90px">
                                                {{ __('Create') }}</th>
                                            <th class="text-center" style="width: 90px">
                                                {{ __('Read') }}</th>
                                            <th class="text-center" style="width: 90px">
                                                {{ __('Update') }}</th>
                                            <th class="text-center" style="width: 90px">
                                                {{ __('Delete') }}</th>
                                        </tr>
                                    </table>
                                </div>
                            </div> <!-- /.form-group -->

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
    <script src="{{ url('/') }}/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ready(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square',
                radioClass: 'iradio_square',
                increaseArea: '20%' // optional
            });

            $('form').on("submit", function(event){
                event.preventDefault();

                var data = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: "{{ route('security.update', ['id' => $role->id]) }}",
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