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
        <li class="active">{{ __('Room Management') }}</li>
    </ol>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#allrooms" data-toggle="tab">{{ __('All rooms') }}</a></li>
                        <li><a href="#addnewrooms" data-toggle="tab">{{ __('Add new rooms') }}</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="allrooms">
                            <table id="roomlist" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>{{ __('Room Name') }}</th>
                                    <th style="max-width: 100px;">{{ __('Pax') }}</th>
                                    <th style="max-width: 100px;">{{ __('Location') }}</th>
                                    <th style="max-width: 180px;">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>{{ __('Room Name') }}</th>
                                    <th>{{ __('Pax') }}</th>
                                    <th>{{ __('Location') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="tab-pane" id="addnewrooms">
                            <form id="addNewRoomForm" class="form-horizontal" action="{{ route('rooms.store') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">{{ __('Room Name') }}</label>

                                    <div class="col-sm-8">
                                        <input type="text" name="name" class="form-control" id="inputName" placeholder="i.e. Deluxe Room">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPax" class="col-sm-2 control-label">{{ __('Pax') }}</label>

                                    <div class="col-sm-8">
                                        <input type="number" min="1" name="pax" class="form-control" placeholder="i.e. 4">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputLocation" class="col-sm-2 control-label">{{ __('Location') }}</label>

                                    <div class="col-sm-8">
                                        <select class="form-control" id="location" name="location">
                                            <option value="Eur">
                                                Eur
                                            </option>
                                            <option value="Boezio">
                                                Boezio
                                            </option>
                                            <option value="Regolo">
                                                Regolo
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="type" class="col-sm-2 control-label">{{ __('Type Room') }}</label>

                                    <div class="col-sm-8">
                                        <select class="form-control" id="type" name="type">
                                            <option value="COWORKING">
                                                COWORKING
                                            </option>
                                            <option value="DAYOFFICE">
                                                DAYOFFICE
                                            </option>
                                            <option value="HOTDESKING">
                                                HOTDESKING
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="price1" class="col-sm-2 control-label">{{ __('Price 1h') }}</label>

                                    <div class="col-sm-8">
                                        <input type="number"  name="price1" class="form-control" placeholder="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="price2" class="col-sm-2 control-label">{{ __('Price 2h') }}</label>

                                    <div class="col-sm-8">
                                        <input type="number"  name="price2" class="form-control" placeholder="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPax" class="col-sm-2 control-label">{{ __('Price 3h') }}</label>

                                    <div class="col-sm-8">
                                        <input type="number"  name="price3" class="form-control" placeholder="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="price4" class="col-sm-2 control-label">{{ __('Price 4h') }}</label>

                                    <div class="col-sm-8">
                                        <input type="number"  name="price4" class="form-control" placeholder="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="price8" class="col-sm-2 control-label">{{ __('Price 8h') }}</label>

                                    <div class="col-sm-8">
                                        <input type="number"  name="price8" class="form-control" placeholder="">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
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
    <script>
        $(document).ajaxStart(function() { Pace.restart(); });

        $(document).ready(function () {
            $('form').on('submit', function(event){
                event.preventDefault();

                var data = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('rooms.store') }}",
                    data: data,
                    dataType: 'json'
                })
                    .done(function(data){
                        toastr.success(data.message);
                        $('#addNewRoomForm').each(function(){
                            this.reset();
                        });
                        $('#roomlist').DataTable().ajax.reload();
                    })
                    .fail(function(data){
                        var errors = data.responseJSON;
                        $.each(errors.errors, function (key, value) {
                            toastr.error(value);
                        });
                    });
            });

            $('#roomlist').DataTable({
                initComplete: function(){
                    var api = this.api();
                    $('#roomlist_filter input')
                        .off('.DT')
                        .on('keyup.DT', function (e) {
                            if (e.keyCode === 13) {
                                api.search(this.value).draw();
                            }
                        });
                },
                processing: true,
                serverSide: true,
                ajax: "{!! route('datatables.rooms') !!}",
                lengthMenu: [[5,20,50,100,-1], [5,20,50,100,"All"]],
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'pax', name: 'pax' },
                    { data: 'location', name: 'location' },
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#roomlist')
                .DataTable()
                .on('click', '.btn-delete', function (event) {
                    event.preventDefault();

                    var roomName = $(this).data('name');
                    var url = $(this).data('remote');
                    var token = $('meta[name="csrf-token"]').attr('content');

                    swal({
                        title: '{{ __ ('Are you sure to delete') }}<br>' + roomName + '?',
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
                                    $('#roomlist').DataTable().ajax.reload();
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