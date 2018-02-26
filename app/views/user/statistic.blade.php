@extends('user')
@section('content')
<div class="outer">	
<p class="caption-1 caption-2">Clients Current Billing Statistics</p>
<div class="form-center">
<form method="GET" target="_blank" action="{{url('/monthly.php')}}">
<select name="type">
	<option value=0>Unpaid</option>
	<option value=1>Paid</option>
	<option value=2>All</option>
</select>
<p><button class="btn">Generate Report</button></p>
</form>
</div>
</div>
@stop