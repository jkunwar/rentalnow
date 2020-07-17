@extends('admin.layouts.app')

@section('title', 'Rental Now | User Profile')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                User Profile
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            @if($user->profile_image)
                                <img class="profile-user-img img-responsive img-circle" 
                                    src="{{ URL::to('/') }}/{{$user->profile_image}}" alt="User profile picture"
                                >
                            @else
                                <img class="profile-user-img img-responsive img-circle" 
                                    src="{{ asset('admin/dist/img/avatar5.png') }}" alt="User profile picture"
                                >
                            @endif

                            <h3 class="profile-username text-center">{{ $user->name }}</h3>

                            <p class="text-muted text-center">{{ $user->email }}</p>
                            <p class="text-muted text-center">{{ $user->phone_number }}</p>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Rooms</b> <a class="pull-right">{{ $room_count }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Houses</b> <a class="pull-right">{{ $house_count }}</a>
                                </li>
                            </ul>

                            <a href="#" class="btn btn-danger btn-block"><b>Delete</b></a>
                        </div> 
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active" id="rooms"><a href="#activity" data-toggle="tab">Rooms</a></li>
                            <li id="houses"><a href="#timeline" data-toggle="tab">Houses</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                <div class="post table-responsive">
                                    <table class="table table-bordered" id="userItemTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Address</th>
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
        function loadDatatable(url){
            
            $('#userItemTable').DataTable({
                "searching": true,
                "destroy": true,
                "processing" : true,
                "serverSide" : true,
                "order": [['3', 'asc']],                
                "autoWidth": false,
                "ajax": {
                    "url": url,
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        "_token" : "{{ csrf_token() }}",
                    }
                },
                "columns": [
                    {"data" : "id"},
                    {"data" : "title"},
                    {"data" : "location", name:'addresses.location'},
                    {"data" : "created_at", searchable: false}
                ]
            });
        }
    	$(document).ready(function() {
            var url = "{{ route('admin.datatable.users.rooms', $user->id) }}";
            loadDatatable(url);
            $('#houses').click(function() {
                url = "{{ route('admin.datatable.users.houses', $user->id) }}";
                loadDatatable(url);
            });
            $('#rooms').click(function() {
                url = "{{ route('admin.datatable.users.rooms', $user->id) }}";
                loadDatatable(url);
            });
        });
    </script>
@endsection