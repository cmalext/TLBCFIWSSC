<html>
<head>
	<title>{{ ($page == 'home')?'':ucwords($page).' - ' }} {{ ucwords('tangusbawan bagong lipunan community foundation inc. water service and sanitation cooperative') }}</title>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	<link href="{{url('/dist/css/home.css')}}" rel="stylesheet">
	<link href="{{url('/dist/css/font-awesome.min.css')}}" rel="stylesheet">
	<script src="{{url('/dist/js/jquery.js')}}"></script>
	<script src="{{url('/dist/js/spretche.js')}}"></script>
</head>
<body>
@include('home.navbar')
<div class="row">
@yield('content')
@include('home.footer')
</div>
</body>
</html>