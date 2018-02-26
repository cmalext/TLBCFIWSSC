<script>
$(function(){
	$('.dataTables_filter input').attr('placeholder', 'Search');
});
</script>
@foreach($client as $c)
<p class="caption-1 caption-2"><span class="no-mobile"> <span style="color:red">{{$c->lastname.', '.$c->firstname}} {{strlen($c->middlename)>0?$c->middlename[0].'.':''}}</span> <i class="fa fa-angle-double-right"></i> Payments</span></p>
<table class="datatable datatable-no-order">
	<thead>
		<tr>
			<th style="width:128px;min-width:128px;background:">Billing
			<th style="width:55px;min-width:55px;background:">Cons.
			<th style="width:80px;min-width:80px;background:">Ten. Total
			<th style="width:80px;min-width:80px;background:">Extra
			<th style="width:80px;min-width:80px;background:">Total
			<th style="width:80px;min-width:80px;background:">Paid
			<th style="width:80px;min-width:80px;background:">Recieved
			<th style="width:80px;min-width:80px;background:">Change
			<th>Options
	</thead>
	<tr>
		<td style="width:128px;min-width:128px;background:">Membership Fee
		<td style="width:55px;min-width:55px;background:"> - 
		<td style="width:80px;min-width:80px;background:"> - 
		<td style="width:80px;min-width:80px;background:"> -
		<td style="width:80px;min-width:80px;background:">PHP {{number_format($c->membership,2,'.',',')}}
		<td style="width:80px;min-width:80px;background:">Yes
		<td style="width:80px;min-width:80px;background:">PHP {{number_format($c->amount_paid,2,'.',',')}}
		<td style="width:80px;min-width:80px;background:">PHP {{number_format($c->amount_paid - $c->membership,2,'.',',')}}
		<td style="text-align:right"><a href="{{url('/membership.php?id='.$c->id)}}" target="_blank" class="btn btn-circle btn-info"><i class="fa fa-print"></i></a>
	{{--*/ $total['billing'] = $c->membership /*--}}
	{{--*/ $total['consumption'] = 0 /*--}}
	@foreach($billings as $b)
		{{--*/ $extra_bill = 0 /*--}}
		@foreach($extra as $ex)
			@if($ex->billing == $b->month_year)
				{{--*/ $extra_bill += $ex->total /*--}}
			@endif
		@endforeach
		{{--*/ $each_total = $extra_bill + $b->total /*--}}
		{{--*/ $total['billing'] += $b->total /*--}}
		{{--*/ $total['consumption'] += $b->consumption /*--}}
		{{--*/ $my = $b->month_year /*--}}
		<tr>
		<td style="width:128px;min-width:128px;background:">{{date("Y F", strtotime($my))}}
		<td style="width:55px;min-width:55px;background:">{{$b->consumption}} 
		<td style="width:80px;min-width:80px;background:">PHP {{number_format($b->total,2,'.',',')}}
		<td style="width:80px;min-width:80px;background:">PHP {{number_format($extra_bill,2,'.',',')}} 
		<td style="width:80px;min-width:80px;background:">PHP {{number_format($each_total + $b->penalty,2,'.',',')}} 
		@if($b->status==0)
		<td style="width:80px;min-width:80px;background:">NO
		<td style="width:80px;min-width:80px;background:"> - 
		<td style="width:80px;min-width:80px;background:"> - 
		@else
		<td style="width:80px;min-width:80px;background:">YeS
		<td style="width:80px;min-width:80px;background:">PHP {{number_format($b->dynamic_number,2,'.',',')}} 
		<td style="width:80px;min-width:80px;background:">PHP {{number_format($b->dynamic_number - ($each_total + $b->penalty) ,2,'.',',')}} 
		@endif
		<td style="text-align:right">
		@if($b->status==0)
			@if($my == $billing['current']['name'])
				<a href="javascript:void(0)" onclick="updateBill({{$c->id}})" class="btn btn-circle btn-warning"><i class="fa fa-edit"></i></a>
			@endif
			<a href="{{url('/reading.php?client='.$c->id.'&month='.$my)}}" target="_blank" class="btn btn-circle btn-info"><i class="fa fa-print"></i></a>
			@if($session['type'] != 0 && $date['schedules']['release'] <= $date['today'] || $session['type'] != 0 && $billing['current']['name'] != $b->month_year)
			<a href="{{url('/payment/bill?client='.$c->id.'&month='.$my)}}" target="_blank" class="btn btn-circle btn-weird"><i class="fa fa-paypal"></i></a>
			@endif
		@else 
			<a href="{{url('/payment.php?client='.$c->id.'&month='.$my)}}" target="_blank" class="btn btn-circle btn-info"><i class="fa fa-print"></i></a>
		@endif
	@endforeach
	<!--<tr>
		<td><td><td><td>
		<td colspan="2" style="width:200px;min-width:100px;text-align:right;font-weight:600;color:#000;border-right:1px solid rgba(0,0,0,0.1);background:#fff">Total Consumption :  
		<td colspan="2" style="text-align:right;font-weight:600;color:#000;border-right:1px solid rgba(0,0,0,0.1);background:#fff">{{$total['consumption']}} Cubic Meters
	<tr>
		<td><td><td><td>
		<td colspan="2" style="width:200px;min-width:100px;text-align:right;font-weight:600;color:#000;border-right:1px solid rgba(0,0,0,0.1);background:#fff">Tent. Total :  
		<td colspan="2" style="text-align:right;font-weight:600;color:#000;border-right:1px solid rgba(0,0,0,0.1);background:#fff">{{number_format($total['billing'],2,'.',',')}} PHP
	<tr>
		<td><td><td><td>
		<td colspan="2" style="width:200px;min-width:100px;text-align:right;font-weight:600;color:#000;border-right:1px solid rgba(0,0,0,0.1);background:#fff">VAT :  
		<td colspan="2" style="text-align:right;font-weight:600;color:#000;border-right:1px solid rgba(0,0,0,0.1);background:#fff">{{number_format(($vat=($total['billing']/100)*$price['vat']),2,'.',',')}} PHP
	<tr>
		<td><td><td><td>
		<td colspan="2" style="width:200px;min-width:100px;text-align:right;font-weight:600;color:#000;border-right:1px solid rgba(0,0,0,0.1);background:#fff">Total :  
		<td colspan="2" style="text-align:right;font-weight:600;color:#000;border-right:1px solid rgba(0,0,0,0.1);background:#fff">{{number_format($vat+$total['billing'],2,'.',',')}} PHP
	-->
</table>
<p class="caption-1 caption-2" style="bottom:-20px;top:auto;">
	<a href="{{url('/client/profile/'.$c->id)}}" class="btn btn-sm"><i class="fa fa-chevron-left"></i></a>
	<a href="{{url('/client/result?user='.$c->id)}}" class="btn btn-sm btn-hover btn-success"><i class="fa fa-bar-chart"></i></a>
	<a href="{{url('/summary.php?user='.$c->id)}}" target="_blank" class="btn btn-sm btn-info"><i class="fa fa-print"></i></a>
	@if($c->status == 0)
	<a href="{{url('/client/edit/'.$c->id)}}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
	<a href="javascript:void(0)" onclick="updateAccontStatus(1,1,{{$c->id}})" class="btn btn-sm btn-danger"><i class="fa fa-archive"></i></a>
	<a href="javascript:void(0)" onclick="updateAccontStatus(1,2,{{$c->id}})" class="btn btn-sm btn-deep"><i class="fa fa-ban"></i></a>
	@else
	<a href="javascript:void(0)" onclick="updateAccontStatus(1,0,{{$c->id}})" class="btn btn-success btn-sm" ><i class="fa fa-leaf"></i></a>
	@endif
</p>
@endforeach
