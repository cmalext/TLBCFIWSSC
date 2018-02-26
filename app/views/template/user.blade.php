<script>
$(function(){
	$('.dataTables_filter input').attr('placeholder', 'Search');
});
</script>
<!--<form id="bulk-checklist" method="POST">-->
<p class="caption-1 caption-2"><span class="no-mobile">Account {{($sub == 'archive')?'Archive':'List'}}</span></p>
<table class="datatable datatable-basic">
	<thead>
		<tr>
			<!--<th style="width:26px;min-width:26px;"><input type="checkbox" id="all" onclick="checkall()">-->
			<th style="width:250px;min-width:250px;">Name
			<th style="width:100px;min-width:100px;">Position
			<th>Option
		@foreach($clients as $client)
	</thead>
		<tr>
			<!--<td style="width:27px;min-width:27px;">&nbsp;<input type="checkbox" name="check-{{$client->id}}">-->
			<td style="width:250px;min-width:250px;" class="link"><a href="{{url('/accounts/profile/'.$client->id)}}">{{ucfirst($client->lastname).', '.ucfirst($client->firstname).' '.strtoupper($client->middlename).'' }}</a>
			<td style="width:100px;min-width:100px;" class="link"> @if($client->type == 0) Secretary @elseif($client->type == 1) Treasurer @else President @endif
			<td class="mobile-hide" style="text-align:right">
				@if($session['type'] == 2 && $client->id != $session['id'])
					@if($client->status == 0)
						<a href="{{url('/user/delete?id='.$client->id.'&status=1')}}" class="btn btn-circle btn-danger"><i class="fa fa-trash" style="font-size:15px"></i></a>
						@if($session['type'] == 2 || $session['id'] == $client->id)
						<a href="{{url('/accounts/password/'.$client->id)}}" class="btn btn-circle"><i class="fa fa-lock" style="font-size:15px"></i></a>
						<a href="{{url('/accounts/edit/'.$client->id)}}" class="btn btn-circle btn-warning"><i class="fa fa-edit" style="font-size:15px"></i></a>
						@endif
					@else
						<a href="{{url('/user/delete?id='.$client->id.'&status=0')}}" class="btn btn-circle btn-success"><i class="fa fa-leaf" style="font-size:15px"></i></a>
					@endif
				@endif
		@endforeach
</table>
<p class="caption-1 caption-2" style="bottom:-20px;top:auto;height:25px">
</p>
<!--</form>-->