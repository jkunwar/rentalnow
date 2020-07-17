@extends('admin.layouts.app')

@section('title', 'Rental Now | Rooms')

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
                             <h3 class="box-title">Rooms</h3>                    
                        </div>
                        <div class="box-body table-responsive">
                            <div data-alerts="alerts" data-fade="3000">
                                {{-- display jquery alert --}}
                            </div>
                            <table class="table table-bordered" id="roomsTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Room Title</th>
                                        <th style="width: 160px">Owner Name</th>
                                        <th>Address</th>
                                        <th>Description</th>
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
            $('#roomsTable').DataTable({
                "searching": true,
                "destroy": true,
                "processing" : true,
                "serverSide" : true,
                "order": [['5', 'asc']],                
                "autoWidth": false,
                // "pageLength": 5,
                "ajax": {
                    "url": "{{ route('admin.datatable.rooms') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        "_token" : "{{ csrf_token() }}",
                    }
                },
                "columns": [
                    {"data" : "id"},
                    {"data" : "title"},
                    {"data" : "name", name: 'users.name'},
                    {"data" : "location", name:'addresses.location'},
                    {"data" : "description", searchable: false, sortable: false},
                    {"data" : "created_at", searchable: false}
                ]
            });
        });
    </script>
@endsection