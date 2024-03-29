@extends('admin.layouts.app')

@section('title', 'Renta Now | Dashboard')
@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading"><strong>Admin's</strong> Dashboard</div>

                            <div class="panel-body">
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <p>Welcome Mr./Mst : <strong>{{ Auth::user()->name}}</strong></p>
                                <p>Your joined  : {{ Auth::user()->created_at->diffForHumans() }} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection