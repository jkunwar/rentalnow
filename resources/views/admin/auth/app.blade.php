<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	  <!-- Tell the browser to be responsive to screen width -->
  	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  	<!-- Bootstrap 3.3.7 -->
  	<link rel="stylesheet" href="{{ asset('admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  	<!-- Font Awesome -->
  	<link rel="stylesheet" href="{{ asset('admin/bower_components/font-awesome/css/font-awesome.min.css') }}">
  	<!-- Ionicons -->
  	<link rel="stylesheet" href="{{ asset('admin/bower_components/Ionicons/css/ionicons.min.css') }}">
  	<!-- Theme style -->
  	<link rel="stylesheet" href="{{ asset('admin/dist/css/AdminLTE.min.css') }}">
  	<!-- iCheck -->
  	<link rel="stylesheet" href="{{ asset('admin/plugins/iCheck/square/blue.css') }}">
	<title>
		@yield('title')
	</title>

</head>
<body class="hold-transition login-page">
	@yield('content')

	<!-- jQuery 3 -->
	<script src="{{ asset('admin/bower_components/jquery/dist/jquery.min.js') }}"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="{{ asset('admin/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
	<!-- iCheck -->
	<script src="{{ asset('admin/plugins/iCheck/icheck.min.js') }}"></script>
	<script>
	  $(function () {
	    $('input').iCheck({
	      checkboxClass: 'icheckbox_square-blue',
	      radioClass: 'iradio_square-blue',
	      increaseArea: '20%' /* optional */
	    });
	  });
	</script>
</body>
</html>