<script>
$(function(){
	$('.dataTables_filter input').attr('placeholder', 'Search');
});
</script>
@if(Input::get('date')!='') {{--*/ $pick = Input::get('date')/*--}} @else {{--*/ $pick = $date_ym /*--}} @endif
<p class="caption-1 caption-2"><span class="no-mobile">Billings for <span style="color:red">{{date("F Y",strtotime($date_ym))}}</span></span></p>
<table class="datatable datatable-basic">
	<thead>
		<tr>
			<th style="width:90px;min-width:90px;"><span class="">METER</span> #
			<th style="width:170px;min-width:170px;">Name
			<th style="width:30px;min-width:30px;">Consumption
			<th style="width:95px;min-width:50px;">Extra
			<th style="width:100px;min-width:100px">Total
			<th style="width:50px;min-width:50px;">Paid
			<th>Option
		@foreach($clients as $k => $v)
	</thead>
		@foreach($bills as $b)
		@if($b->client == $v['id'])
		@if(\Input::get('filter') == '' || Input::get('filter') == $b->status)
			{{--*/ $total = $b->total+ $v['extra'] /*--}}
			@if($price['vat']>0) {{--*/ $total += ($total/100)*$price['vat'] /*--}} @endif
			<tr>
			<td style="width:90px;min-width:90px;" class="link"><a href="{{url('/client/result?user='.$v['id'])}}">{{$v['meter_id']}}</a>
			<td style="width:170px;min-width:170px;" class="link"><a href="{{url('/client/result?user='.$v['id'])}}">{{$v['name']}}</a>
			<td style="width:90px;min-width:31px;">{{$b->consumption}}
			<td style="width:95px;min-width:50px;">@if($v['extra']> 0) PHP {{number_format($v['extra'],2,'.',',')}}  @else - @endif
			<td style="width:100px;min-width:100px">PHP {{number_format($total + $b->penalty,2,'.',',')}} 
			<td style="width:50px;min-width:50px">@if($b->status == 0)<b style="color:red">NO</b> @else <b style="color:green">Paid</b> @endif
			<td class="mobile-hide" style="text-align:right">
			@if($b->status == 0)
				<a href="{{url('/reading.php?client='.$v['id'].'&month='.$pick)}}" target="_blank" class="btn btn-circle btn-info"><i class="fa fa-print" style="font-size:15px"></i></a>
				@if($session['type'] != 0 && $date['schedules']['release'] <= $date['today'])
				<a href="{{url('/payment/bill?client='.$v['id'].'&month='.$pick)}}" target="_blank" class="btn btn-circle btn-weird"><i class="fa fa-paypal" style="font-size:15px"></i></a>
				@endif
			@else
				<a href="{{url('/payment.php?client='.$v['id'].'&month='.$pick)}}" target="_blank" class="btn btn-circle btn-info"><i class="fa fa-print" style="font-size:15px"></i></a>
			@endif
		@endif
		@endif
		@endforeach
		@endforeach
</table>
<p class="caption-1 caption-2 caption-3">
<a href="{{url('/billing?date=')}}{{date("Y-m",strtotime($pick."- 1 months"))}}" class="btn btn-sm"><i class="fa fa-chevron-left"></i></a>
<a href="{{url('/reading.php?month='.$pick)}}" target="_blank" class="btn btn-sm btn-info">Print All</a>
<a href="{{url('/billing')}}" class="btn btn-sm btn-danger">UnFilter</a>
<a href="{{url('/billing?date=')}}{{date("Y-m",strtotime($pick."+ 1 months"))}}" class="btn btn-sm"><i class="fa fa-chevron-right"></i></a>
</p>
