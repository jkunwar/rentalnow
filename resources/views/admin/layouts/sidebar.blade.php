<aside class="main-sidebar">
	<section class="sidebar">
		<div class="user-panel">
			<div class="pull-left image">
				<img src="{{ asset('admin/dist/img/avatar5.png') }}" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p>
					<a href="profile">{{ auth()->user()->name }}</a>
				</p>
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>

		<ul class="sidebar-menu" data-widget="tree">
			<li class="header" style="height: 40px"></li>

			<li class="@if(Request::is('admin/dashboard')) active @endif">
				<a href="{{ route('admin.dashboard') }}">
					<i class="fa fa-tachometer"></i> <span>Dashboard</span>
				</a>
			</li>
			
			<li class="@if(Request::is('admin/users')) active @endif">
				<a href="{{ route('admin.user.index') }}">
					<i class="fa fa-users"></i> <span>Users</span>
				</a>
			</li>

			<li class="@if(Request::is('admin/rooms')) active @endif">
				<a href="{{ route('admin.room.index') }}">
					<i class="fa fa-bed"></i> <span>Rooms</span>
				</a>
			</li>

			<li class="@if(Request::is('admin/houses')) active @endif">
				<a href="{{ route('admin.house.index') }}">
					<i class="fa fa-home"></i><span> Houses</span> 
				</a>
			</li>

			<li class="header" style="height: 40px"></li>

			<li>  
          		<a  class="" href="{{ route('admin.auth.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            	<i class="fa fa-sign-out"></i> <span>Logout</span></a>
            	<form id="logout-form" action="{{ route('admin.auth.logout') }}" method="POST" style="display: none;">
                	{{ csrf_field() }}
            	</form>
        	</li>
		</ul>
	</section>
</aside>