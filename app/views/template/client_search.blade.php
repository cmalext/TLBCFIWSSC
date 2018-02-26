@if(count($clients)>0)
<table class="table-basic">
@foreach($clients as $c)
<tr><td class="link"><a href="{{url('/client/profile/'.$c->id)}}">{{$c->meter_id}}</a>
	<td class="link"><a href="{{url('/client/profile/'.$c->id)}}">{{$c->lastname}}, {{$c->firstname}} {{$c->middlename}}</a>
	<td class="hidden link"><a href="{{url('/client/profile/'.$c->id)}}">@if($c->status == 0) Active @elseif($c->status == 1) Deleted @else Banned @endif </a>
	<td class="hidden option">
		
		<a href="{{url('/client/result?user='.$c->id)}}" class="btn btn-success btn-circle"><i class="fa fa-bar-chart"></i></a>
		<a href="{{url('/summary.php?user='.$c->id)}}" target="_blank" class="btn btn-info btn-circle"><i class="fa fa-print"></i></a>
		@if($c->status == 0)
		<a href="{{url('/client/edit/'.$c->id)}}" class="btn btn-warning btn-circle"><i class="fa fa-edit"></i></a>
		@endif
@endforeach
</table>
@else
<p class="big notification">No Result Found</p>
@endif