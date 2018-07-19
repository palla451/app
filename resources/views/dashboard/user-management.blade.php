@extends('dashboard.layouts')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('css')
    <link rel="stylesheet" href="{{ url('/') }}/plugins/pace/pace.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/toastr/toastr.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/datatables/datatables.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/sweetalert2/sweetalert2.min.css">
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
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        @permission('read-user')
                        <li class="active">
                            <a href="#allusers" data-toggle="tab">{{ __('All users') }}</a>
                        </li>
                        @endpermission
                        @permission('create-user')
                        <li{!! auth()->user()->canCreateUser() && !auth()->user()->canReadUser() ? ' class="active"':'' !!}>
                            <a href="#addnewusers" data-toggle="tab">{{ __('Register new users') }}</a>
                        </li>
                        @endpermission
                    </ul>
                    <div class="tab-content">
                        @permission('read-user')
                        <div class="active tab-pane" id="allusers">
                            <table id="userlist" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th style="width: 200px;">{{ __('Registration Date') }}</th>
                                    <th style="width: 150px;">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th style="width: 200px;">{{ __('Registration Date') }}</th>
                                    <th style="width: 150px;">{{ __('Action') }}</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>@endpermission
                        @permission('create-user')
                        <div class="{!! auth()->user()->canCreateUser() && !auth()->user()->canReadUser() ? 'active ':'' !!}tab-pane" id="addnewusers">
                            <form id="addNewUserForm" class="form-horizontal" action="{{ route('users.store') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">{{ __('Name') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="name" class="form-control" id="inputName" placeholder="i.e. Mario Rossi">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">{{ __('Email') }}</label>
                                    <div class="col-sm-8">
                                        <input type="email" name="email" class="form-control" placeholder="i.e. your-email@domain.com">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword" class="col-sm-2 control-label">{{ __('Password') }}</label>
                                    <div class="col-sm-8">
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPasswordConfirmation" class="col-sm-2 control-label">{{ __('Retype password') }}</label>
                                    <div class="col-sm-8">
                                        <input type="password" name="password_confirmation" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputRole" class="col-sm-2 control-label">{{ __('Role') }}</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="role">
                                            <option value="">{{ __('Please select a role') }}</option>
                                            @foreach(\App\Role::where('id', '!=', 1)->get() as $role)
                                            <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </form>
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
    <script>
        $(document).ajaxStart(function() { Pace.restart(); });

        $(document).ready(function () {
            $('form').on('submit', function(event){
                event.preventDefault();

                var data = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('users.store') }}",
                    data: data,
                    dataType: 'json'
                })
                    .done(function(data){
                        toastr.success(data.message);
                        $('#addNewUserForm').each(function(){
                            this.reset();
                        });
                        $('#userlist').DataTable().ajax.reload();
                    })
                    .fail(function(data){
                        var errors = data.responseJSON;
                        $.each(errors.errors, function (key, value) {
                            toastr.error(value);
                        });
                    });
            });

            $('#userlist').DataTable({
                initComplete: function(){
                    var api = this.api();
                    $('#userlist_filter input')
                        .off('.DT')
                        .on('keyup.DT', function (e) {
                            if (e.keyCode === 13) {
                                api.search(this.value).draw();
                            }
                        });
                },
                processing: true,
                serverSide: true,
                ajax: "{!! route('datatables.users') !!}",
                lengthMenu: [[5,20,50,100,-1], [5,20,50,100,"All"]],
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#userlist')
                .DataTable()
                .on('click', '.btn-delete', function (event) {
                    event.preventDefault();

                    var userName = $(this).data('name');
                    var url = $(this).data('remote');
                    var token = $('meta[name="csrf-token"]').attr('content');

                    swal({
                        title: '{{ __ ('Are you sure to delete') }}<br>' + userName + '?',
                        text: "{!! __("You won't be able to revert this!") !!}",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#ccc',
                        confirmButtonText: '{!! __('Yes, delete it!') !!}',
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
                                title: '{{ __('Deleted!') }}',
                                text: data.message,
                                type: 'success',
                                allowOutsideClick: false
                            }).then(function(){
                                $('#userlist').DataTable().ajax.reload();
                            });
                        })
                        .fail(function(data){
                            var errors = data.responseJSON;
                            swal({
                                title: '{{ __('Request denied!') }}',
                                text: errors.message,
                                type: 'error',
                                confirmButtonText: '{!! __('Close') !!}',
                                allowOutsideClick: false
                            });
                        });
                    });
                });
        })
    </script>
@endpush