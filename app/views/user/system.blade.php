@extends('user')
@section('content')
<div class="outer">	
<p class="caption-1 caption-2">{{($sub=='schedule')?"System Schedules":"System Prices"}}</p>
<div class="form-center">
<p class="caption-4">Warning: This is a very crucial function of the system. Only the high rank personnel/s should be allowed to access and update these data. </p>

<form method="POST">
@if($sub == 'schedule')
@if(Input::get('success') != '')
<?php
	switch(\Input::get('success')){
		case 1:
		echo "<p class='error'>importing must be greater than to day of disconnection</p>";
		break;
		case 2:
		echo "<p class='error'>releasing the billing must be greater than importing</p>";
		break;
		case 3:
		echo "<p class='error'>disconnection must be less than disconnection</p>";
		break;
		case 4:
		echo "<p class='error'>Cutoff must be less than importing</p>";
		break;
		default:
		echo "<p class='success'>Successfully updated</p>";
	}
?>
@endif
<label>Day of importing billings (must be within the month) <span class="fa fa-asterisk"></span></label>
<input type="number" min="1" max="31" name="collect" value="{{$date['collect']}}" required>
<label>Day of printing and releasing of billing (must be within the month)<span class="fa fa-asterisk"></span></label>
<input type="number" min="1" max="31" name="release" value="{{$date['release']}}" required>
<label>Due day (must be next month)<span class="fa fa-asterisk"></span></label>
<input type="number" min="1" max="31" name="notice" value="{{$date['notice']}}">
<label>Day of Disconnection (must be next month)<span class="fa fa-asterisk"></span></label>
<input type="number" min="1" max="31" name="cutoff" value="{{$date['cutoff']}}">
@else
<p class="{{$error['type'] or ''}}">{{$error['message'] or ''}}</p>
<label>Membership Fee / php <span class="fa fa-asterisk"></span></label>
<input type="number" min="0" name="membership" value="{{$price['membership']}}"><br><br>

<input type="hidden" min="0" name="vat" value="{{$price['vat']}}"><br><br>



<div class="clearfix" style="padding:15px 0">
	<label style="display:block;text-align:center;color:#333"><span style="color:red">Residential</span> (Regular Cost. E.I. for the first 20 cubic meter = 250 PHP)</label><br>
	<div class="col-50">
		<div class="inner">
			<label style="display:block">UNIT / Cubic Meter <span class="fa fa-asterisk"></span> </label>
			<input type="number" min="1" style="width:100%" name="billing_a_key" style="width:50%" value="{{$unit['a']['normal']}}">
		</div>
	</div>
	<div class="col-50">
		<div class="inner">
			<label style="display:block">PRICE / php <span class="fa fa-asterisk"></span></label>
			<input type="number" min="1" style="width:100%" name="billing_a_value" style="width:50%" value="{{$price['a']['normal']}}">
		</div>
	</div>
</div>
<div class="clearfix" style="padding:15px 0">
	<label style="display:block;text-align:center;color:#333"><span style="color:red">Residential</span> (succeeding Cost. E.I. after 20 cubic meters, 1 cubic meter = 20 PHP)</label><br>
	<div class="col-50">
		<div class="inner">
			<label style="display:block">UNIT / Cubic Meter <span class="fa fa-asterisk"></span> </label>
			<input type="number" min="1" style="width:100%" name="billing_a_excess_key" style="width:50%" value="{{$unit['a']['excess']}}">
		</div>
	</div>
	<div class="col-50">
		<div class="inner">
			<label style="display:block">PRICE / php <span class="fa fa-asterisk"></span></label>
			<input type="number" min="1" style="width:100%" name="billing_a_excess_value" style="width:50%" value="{{$price['a']['excess']}}">
		</div>
	</div>
</div>
<div class="clearfix" style="padding:15px 0">
	<label style="display:block;text-align:center;color:#333"><span style="color:green">Commercial</span> (regular Cost. E.I. for the first 15 cubic meter = 300 PHP)</label><br>
	<div class="col-50">
		<div class="inner">
			<label style="display:block">UNIT / Cubic Meter<span class="fa fa-asterisk"></span> </label>
			<input type="number" min="1" style="width:100%" name="billing_b_key" style="width:50%" value="{{$unit['b']['normal']}}">
		</div>
	</div>
	<div class="col-50">
		<div class="inner">
			<label style="display:block">PRICE / php <span class="fa fa-asterisk"></span></label>
			<input type="number" min="1" style="width:100%" name="billing_b_value" style="width:50%" value="{{$price['b']['normal']}}">
		</div>
	</div>
</div>
<div class="clearfix" style="padding:15px 0">
	<label style="display:block;text-align:center;color:#333"><span style="color:green">Commericial</span> (succeeding Cost. E.I. after 20 cubic meters, 1 cubic meter = 25 PHP)</label><br>
	<div class="col-50">
		<div class="inner">
			<label style="display:block">UNIT / Cubic Meter<span class="fa fa-asterisk"></span> </label>
			<input type="number" min="1" style="width:100%" name="billing_b_excess_key" style="width:50%" value="{{$unit['b']['excess']}}">
		</div>
	</div>
	<div class="col-50">
		<div class="inner">
			<label style="display:block">PRICE / php <span class="fa fa-asterisk"></span></label>
			<input type="number" min="1" style="width:100%" name="billing_b_excess_value" style="width:50%" value="{{$price['b']['excess']}}">
		</div>
	</div>
</div>

@endif
<p><button class="btn">Update</button></p>
</form>
</div>
</div>
@stop