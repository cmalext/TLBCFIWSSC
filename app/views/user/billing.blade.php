@extends('user')
@section('content')
@if($sub == 'create')
@include('template.billing_create')
@elseif($sub == 'list')
@include('template.billing')
@elseif($sub == 'add')
	@if(Input::get('sucess') == 1)
	<script>alert('successfully updated'); window.location.href="{{url('/billing/add')}}"; </script>
	@endif
	<!-- MANUAL ADD BILLING -->
	<script>
	$(function(){
		$('.dataTables_filter input').attr('placeholder', 'Search');
	});
	function validate(x){
		var ref = $('#ref-'+x).val(),act=$('#client-'+x).val();
		if(parseInt(ref) > parseInt(act)){
			$('#client-'+x).val(ref);
			alert('meter reading must not be less than previous meter reading ');
		}
	}
	</script>
	<form method="POST">
	<p class="caption-1 caption-2"><span class="no-mobile">Create billing for <span style="color:red">{{date("F Y",strtotime($billings['current']['name']))}}</span></span></p>
	<table class="datatable datatable-basic">
		<thead>
			<th style="width:80px">Meter #
			<th style="width:170px">Client
			<th style="width:150px;background:#">Prev. Mtr Rdg.
			<th style="width:130px">Month Cons.
			<th style="width:300px;">Meter Reading <span class="fa fa-asterisk"></span>
		</thead>
		@foreach($clients as $c)
		{{--*/$total['prev'] = 0 /*--}}
		{{--*/$set['total'] = 0 /*--}}
		{{--*/$overall = 0/*--}}
		@if(date("Y-m",strtotime($c->start_billing)) <= date("Y-m",strtotime($billings['current']['name'])))
			<tr style="padding:1px 10px">
			<td style="width:80px;padding:0">{{$c->meter_id}}
			<td style="width:170px;padding:0">{{$c->lastname.', '.$c->firstname.' ' }}{{strlen($c->middlename)>0?$c->middlename[0].'.':''}}
			@foreach($billing as $b)
				@if(date("Y-m",strtotime($b->month_year)) < $billings['current']['name'] && $b->client == $c->id)
				{{--*/ $total['prev'] += ($b->consumption) /*--}}
				@endif
				@if(date("Y-m",strtotime($b->month_year)) == $billings['current']['name'] && $b->client == $c->id)
				{{--*/$set['total'] = ($b->consumption) /*--}}
				@endif
			@endforeach
			<td style="width:150px;padding:0;background:#">{{$total['prev']}}
			<td style="width:130px;padding:0">{{isset($set['total'])? $set['total']:'not set'}}
			{{--*/$overall = $set['total'] + $total['prev']/*--}}
			<td style="padding:0"><input type="hidden" value="{{$total['prev']}}"  id="ref-{{$c->id}}"><input type="text" id="client-{{$c->id}}" class="money" onblur="validate({{$c->id}})" name="client-{{$c->id}}" value="{{$overall}}">
		@endif
		@endforeach

		
	</table>
	<p class="caption-1 caption-2 caption-3" style="padding:10px"><button class="btn btn-sm">Submit</button></p>
	</form>
@else
<script>
$(function(){
	$('#search').val(''),$('#id').val('');
	document.getElementById('search').disabled = false;
	$('#search').keyup(function(){
		var x = $(this).val();
		if(x.length > 3){
			$.ajax({
	        	type: "GET",
	        	url: "{{url('/billing/list')}}",
	        	data: {x:x},
	        	success: function(data){$('#result').html(data);}
       		});
		}
	});
});
function addMe(x,y){
	$('#id').val(x);
	$('#search').val('meter # : '+y);
	document.getElementById('search').disabled = true;
	$('#result').html('');
	$('#clear').show();
}
function clearMe(){
	$('#id').val('');
	$('#search').val('');
	document.getElementById('search').disabled = false;
	$('#clear').hide();	
}
</script>
<p class="caption-1 caption-2">Add Extra Billing</p>
<form method="POST">
<div class="outer">
	<div class="form-center">
		@if(\Input::get('success') == 1)
		<p class="success">Extra Billing Successfully added</p>
		@endif
		@if($date['schedules']['release'] > $date['today'])
			{{--*/ $extra_date = $billings['current']['name'] /*--}}
		@else
			{{--*/ $extra_date = $billings['next']['name'] /*--}}
		@endif
		<p class="caption-4">Note: This will be added to the  {{date("F Y",strtotime($extra_date))}} Billing  </p>
		<input type="text" name="month" value="{{$extra_date}}" required readonly>
		<input type="text" style="display:none" name="client" id="id" required>
		<label>Search For Client Meter ID / Name <span class="fa fa-asterisk"></span></label>
		<div style="position:relative;">
			<a href="javascript:void(0)" id="clear" onclick="clearMe()" style="display:none;position:absolute;right:0;top:4px" class="btn btn-sm btn-danger"><i class="fa fa-close" style="position:relative;top:-1px"></i></a>
			<input type="text" id="search" placeholder="Search">
		</div>
		<div id="result" style="max-height:130px;overflow:auto;background:#fff;box-shadow:0 0 3px rgba(0,0,0,0.2);position:relative;top:-20px"></div>
		<label>Amount  <span class="fa fa-asterisk"></span></label>
		<input type="number" class="money" min="1" name="price" placeholder="Amount" required>
		<label>Brief Description about this extra bill <span class="fa fa-asterisk"></span></label>
		<textarea style="height:130px" name="description" required></textarea>
		<p><button class="btn">Submit</button>
	</div>
</div>
</form>
@endif
@stop