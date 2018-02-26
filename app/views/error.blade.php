<html>
<head>
	<title>ERROR</title>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	<link href="{{url('/dist/css/home.css')}}" rel="stylesheet">
	<link href="{{url('/dist/css/font-awesome.min.css')}}" rel="stylesheet">
	<script src="{{url('/dist/js/jquery.js')}}"></script>
	<script src="{{url('/dist/js/spretche.js')}}"></script>
	<script>
	function test(){
		setInterval(function(){
			window.location.href="{{url()}}";
		}, 5000);
	}
	</script>
</head>
<body style="background:#fff" onload="test()">
	<p style="text-align:center;padding:20px 0;font-size:20px;">{{$message}}</p>
	<p style="text-align:center;padding:20px 0;font-size:20px;">You will be redirected to home page shortly</p>
</body>
</html>