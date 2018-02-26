@extends('user')
@section('content')
<script>
function toggleMonth(){
	var e = document.getElementById("type");
	var type = e.options[e.selectedIndex].value;
	if(type == 1){
		document.getElementById('mstart').required = true;
		document.getElementById('mend').required = true;
		$('#option-1').show();
		$('#option-2').hide();
	}else{
		document.getElementById('mstart').required = false;
		document.getElementById('mend').required = false;
		$('#option-1').hide();
		$('#option-2').show();
	}
}
</script>
<div class="outer">	
<p class="caption-1 caption-2">{{strtoupper($sub)}} Statistics</p>
<div class="form-center">
<form method="GET" target="_blank" action="@if($sub=='client') {{url('/client.php')}} @elseif($sub=='income') {{url('/income.php')}} @else {{url('/consumption.php')}} @endif">

@if($sub == 'client')
<label>Client Status</label>
<select name="status">
	<option value="3">All</option>
	<option value="0">Active</option>
	<option value="1">Deleted</option>
	<option value="2">Cutted Off</option>
</select>
<label>Client Type</label>
<select name="type">
	<option value="3">All</option>
	<option value="0">Residential</option>
	<option value="1">Commercial</option>
</select>

@else

<label>Report Type</label>
<select name="type" id="type"  onchange="toggleMonth()">
	<option value="1" selected>Monthly</option>
	<option value="2">Yearly</option>
</select>
<div id="option-1">
	<div class="col-50">
		<label>Select Start Month <span class="fa fa-asterisk"></span></label>
		<input type="month" id="mstart" value="{{date("Y-m")}}" name="start" required>
	</div>
	<div class="col-50">
		<label>Select end Month <span class="fa fa-asterisk"></span></label>
		<input type="month" id="mend"  value="{{date("Y-m")}}" name="end" required>
	</div>
</div>
<div id="option-2" style="display:none">
	<div class="col-50">
		<label>Select Year <span class="fa fa-asterisk"></span></label>
		<select name="syear">
			{{--*/ $eyear = $year /*--}}
			@if($year['start'] <= $year['end'])
			<option>{{$year['start']}}</option>
			{{--*/ $year['start']++ /*--}}
			@endif
		</select>
	</div>
	<div class="col-50">
		<label>Select Year <span class="fa fa-asterisk"></span></label>
		<select name="eyear">
			@if($eyear['start'] <= $eyear['end'])
			<option>{{$eyear['start']}}</option>
			{{--*/ $eyear['start']++ /*--}}
			@endif
		</select>
	</div>
</div>
<label>Payment Status</label>
<select name="status">
	<option value="1">Paid</option>
	<option value="2">Unpaid</option>
	<option value="1">All</option>
</select>
@endif
<p><button class="btn">Generate Report</button></p>
</form>
</div>
</div>
@stop