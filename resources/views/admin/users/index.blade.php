@extends('admin.layouts.app')

@section('title', 'Rental Now | Users')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                             <h3 class="box-title">Users</h3>                    
                        </div>
                        <div class="box-body table-responsive">
                            <div data-alerts="alerts" data-fade="3000">
                                {{-- display jquery alert --}}
                            </div>
                            <table class="table table-bordered" id="usersTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Total Rooms</th>
                                        <th>Total Houses</th>
                                        <th style="width: 150px">Created Date (G.M.T)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')

    <!-- DataTables -->
    <script src="{{asset('admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

    <script>
    	$(document).ready(function() {
            $('#usersTable').DataTable({
                "searching": true,
                "destroy": true,
                "processing" : true,
                "serverSide" : true,
                "order": [['4', 'desc']],                
                "autoWidth": false,
                // "pageLength": 5,
                "ajax": {
                    "url": "{{ route('admin.datatable.users') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        "_token" : "{{ csrf_token() }}",
                    }
                },
                "columns": [
                    {"data" : "id"},
                    {"data" : "name", sortable: false},
                    {"data" : "total_rooms", searchable: false},
                    {"data" : "total_houses", searchable: false},
                    {"data" : "created_at", searchable: false}
                ]
            });
        });
    </script>
@endsection