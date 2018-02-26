@extends('user')
@section('content')
@if($sub == 'basic')
{{--*/$extra_bill = 0/*--}}
@foreach($extra as $ex)
{{--*/$extra_bill+= $ex->total/*--}}
@endforeach
@foreach($client as $c)
@foreach($bill as $b)
{{--*/$final_total = $b->total + $extra_bill + $b->penalty /*--}}
<script>
$(function(){
	$("#payment").submit(function() {
		var e = document.getElementById("type");
		var type = e.options[e.selectedIndex].value;
		if(type == 1 && $("#change2").val()<0){
			$(".error").html("Cash inputted is not enough");
		}else if(type == 2 && $("#check_number").val().length < 1){
			$(".error").html("Check number is required");
		}else{
			$.ajax({
	        	type: "POST",
	        	url: document.URL,
	        	data: $("#payment").serialize(),
	        	beforeSend: function(){ $('.error').html(''); $("#payment button").html('<i class="fa fa-spin"><i class="fa fa-circle-o-notch fa-2x"></fa></i>');},
	        	success: function(data){
	        		$("#payment button").html('Process'); 
	        		if(data!=1){
	        			$(".error").html(data);
	        		}else{
	        			window.location.href="{{url('/payment.php?client='.Input::get('client').'&month='.Input::get('month'))}}";
	        		}}
       		});
		}
		location.hash = "#";
		return false; 
	});		
	$('#cash_number').val('');
	$('#change').val(0);
	$('#change2').val(-1);
	var total = "{{$final_total + (($final_total / 100)*$price['vat'])}}"
	$("#cash_number").keyup(function(){
		if(isNaN($(this).val())){
			alert("not a valid cash");
			$(this).val('');
		}else{
			var x = $(this).val();
			if(x.length > 0){
				var profits=x-total;
				$("#change2").val(profits);
  				$("#change").val(profits.toFixed(2));
			}
		}
	});
});
function togglePayment(){
	var e = document.getElementById("type");
	var type = e.options[e.selectedIndex].value;
	if(type == 1){
		$("#check").hide();
		$("#cash").show();
		document.getElementById('cash_number').required = true;
		document.getElementById('check_number').required = false;
	}else{
		$("#cash").hide();
		$("#check").show();
		document.getElementById('cash_number').required = false;
		document.getElementById('check_number').required = true;
	}
}
</script>
<p class="caption-1 caption-2">Payment Module  </p>
<div class="outer">
	<div class="form-center">
		<p class="error"></p>
		<form method="POST" id="payment" action="{{url('/payment/bill')}}">
			<input type="hidden" name="client" value="{{$c->id}}">
			<input type="hidden" name="month" value="{{$b->month_year}}">
			<label>Client : </label>
			<input type="text" name="exta1" value="{{$c->lastname.', '.$c->firstname.' ',$c->middlename}}" disabled>
			<label>Meter ID : </label>
			<input type="text" name="exta5" value="{{$c->meter_id}}" disabled>
			<label>Billing Month : </label>
			<input type="text" name="exta2" value="{{date("F Y",strtotime($b->month_year))}}" disabled>
			<label>Extra Billing : </label>
			<input type="text" name="exta3" value="{{number_format($extra_bill,2,'.',',')}} PHP" disabled>
			<label>Total : </label>
			<input type="text" name="exta3" value="{{number_format($final_total + (($final_total / 100)*$price['vat']),2,'.',',')}} PHP" disabled>
			<!--<label>Payment Type : </label>-->
			<select name="type" style="display:none" id="type" onchange="togglePayment()">
				<option value="1" selected>Cash</option>
				<option value="2">Check</option>
			</select>
			<div id="check" style="display:none">
				<label>Check Number : </label>
				<input type="text" name="check_number" id="check_number">
			</div>
			<div id="cash">
				<label>Cash Recieved <span style="color:red">*</span> </label>
				<input type="text" name="cash_number" id="cash_number" required>
				<label>Total Change : </label>
				<input type="text" name="extra4"  id="change" value="0" disabled>
				<input type="hidden" name="extra4"  id="change2" value="0" disabled>
			</div>
			<p><button class="btn">Process</button></p>
		</form>
	</div>
</div>
@endforeach
@endforeach
@elseif($sub == 'list')
@include('template.billing')
@else
@include('template.billing_filter')
@endif
@stop