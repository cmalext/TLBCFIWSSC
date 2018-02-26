<html>
<head>
	<title>{{ucwords($page)}} - TBLCFIWSSC</title>
	<link href="{{url('/dist/css/datatable.css')}}" rel="stylesheet">
	<link href="{{ url('/dist/css/user.css')}}" rel="stylesheet">
	<link href="{{ url('/dist/css/font-awesome.min.css')}}" rel="stylesheet">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<script src="{{url('/dist/js/jquery.js')}}"></script>
	<script src="{{url('/dist/js/user.js')}}"></script>
	<script src="{{url('/dist/js/datatable.js')}}"></script>
	<script src="{{url('dist/js/chart.js')}}"></script>
	<script>
		function filter(){
			$('.dataTables_filter input').val('no');
		}
	</script>
</head>
<body @if(Input::get('filter') != '') onload="filter()" @endif>
<div class="modal">
	<div class="modal-inner">
		<a href="javascript:void(0)" class="modal-close btn btn-circle btn-danger" onclick="modal_out()"><i class="fa fa-close"></i></a>
		<div class="ajax">
		</div>
	</div>
</div>
<div style="overflow-x:hidden">
@include('user.navbar')
<div class="row" id="row">
@yield('content')
</div>
</div>
</body>
</html>