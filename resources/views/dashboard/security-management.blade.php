@extends('dashboard.layouts')

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('css')
    <link rel="stylesheet" href="{{ url('/') }}/plugins/pace/pace.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/toastr/toastr.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/datatables/datatables.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/sweetalert2/sweetalert2.min.css">
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
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#allroles" data-toggle="tab">{{ __('All roles') }}</a></li>
                        <li><a href="#addnewroles" data-toggle="tab">{{ __('Add new roles') }}</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="allroles">
                            <table id="rolelist" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>{{ __('Role Name') }}</th>
                                    <th>{{ __('Display Name') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th style="width: 150px;">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>{{ __('Role Name') }}</th>
                                    <th>{{ __('Display Name') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th style="width: 150px;">{{ __('Action') }}</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="tab-pane" id="addnewroles">
                            <form id="addNewRoleForm" class="form-horizontal" action="{{ route('security.store') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">{{ __('Role Name') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="name" class="form-control" id="inputName" placeholder="i.e. room-manager">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputDisplayName" class="col-sm-2 control-label">{{ __('Display Name') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="display_name" class="form-control" id="inputDisplayName" placeholder="i.e. Room Manager (optional)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputDescription" class="col-sm-2 control-label">{{ __('Description') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="description" class="form-control" id="inputDescription" placeholder="i.e. Manage room from backend  (optional)">
                                    </div>
                                </div>

                                <hr>

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
                                                                    value="{{ $item->id }}">
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
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-sm-8">
                                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
    <script src="{{ url('/') }}/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ajaxStart(function() { Pace.restart(); });

        $(document).ready(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square',
                radioClass: 'iradio_square',
                increaseArea: '20%' // optional
            });

            $('form').on('submit', function(event){
                event.preventDefault();

                var data = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('security.store') }}",
                    data: data,
                    dataType: 'json'
                })
                    .done(function(data){
                        toastr.success(data.message);
                        $('#addNewRoleForm').each(function(){
                            this.reset();
                        });
                        $('input[type="checkbox"]').removeAttr('checked').iCheck('update');
                        $('#rolelist').DataTable().ajax.reload();
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

            $('#rolelist').DataTable({
                initComplete: function(){
                    var api = this.api();
                    $('#rolelist_filter input')
                        .off('.DT')
                        .on('keyup.DT', function (e) {
                            if (e.keyCode === 13) {
                                api.search(this.value).draw();
                            }
                        });
                },
                processing: true,
                serverSide: true,
                ajax: "{!! route('datatables.roles') !!}",
                lengthMenu: [[5,20,50,100,-1], [5,20,50,100,"All"]],
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'display_name', name: 'display_name' },
                    { data: 'description', name: 'description' },
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#rolelist')
                .DataTable()
                .on('click', '.btn-delete', function (event) {
                    event.preventDefault();

                    var roleDisplayName = $(this).data('name');
                    var url = $(this).data('remote');
                    var token = $('meta[name="csrf-token"]').attr('content');

                    swal({
                        title: '{{ __ ('Are you sure to delete') }}<br>' + roleDisplayName + '?',
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
                                    confirmButtonText: '{!! __('Close') !!}',
                                    allowOutsideClick: false
                                }).then(function(){
                                    $('#rolelist').DataTable().ajax.reload();
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
        })
    </script>
@endpush