<script>
$(function(){
	$('.dataTables_filter input').attr('placeholder', 'Search');
});
</script>
<<!--form id="bulk-checklist" method="POST">-->
<p class="caption-1 caption-2"><span class="no-mobile">Client {{($sub == 'archive')?'Archive':'List'}}</span></p>
<table class="datatable datatable-basic">
	<thead>
		<tr>
			<!--<th style="width:26px;min-width:26px;"><input type="checkbox" id="all" onclick="checkall()">-->
			<th style="width:95px;min-width:95px;"><span class="">METER</span> #
			<th style="width:250px;min-width:250px;">Name
			<th style="width:100px;min-width:30px;">Type
			<th>Option
		@foreach($clients as $client)
	</thead>
		<tr>
			<!--<td style="width:27px;min-width:27px;">&nbsp;<input type="checkbox" name="check-{{$client->id}}">-->
			<td style="width:95px;min-width:95px;"   class="link"><a href="{{url('/client/profile/'.$client->id)}}" >{{$client->meter_id}}</a>
			<td style="width:250px;min-width:250px;" class="link"><a href="{{url('/client/profile/'.$client->id)}}">{{ucfirst($client->lastname).', '.ucfirst($client->firstname) }} {{strlen($client->middlename)>0?$client->middlename[0].'.':''}}</a>
			<td style="width:100px;min-width:31px;">{{($client->type == '0')?'Residential':'Commercial'}}
			<td class="mobile-hide" style="text-align:right">
				<a href="{{url('/client/result?user='.$client->id)}}" class="btn btn-circle btn-success"><i class="fa fa-bar-chart"></i></a>
				<a href="{{url('/summary.php?user='.$client->id)}}" target="_blank" class="btn btn-circle btn-info"><i class="fa fa-print"></i></a>
				@if($client->status == 0)
				<a href="{{url('/client/edit/'.$client->id)}}" class="btn btn-circle btn-warning"><i class="fa fa-edit"></i></a>
				@endif
		@endforeach
</table>
<p class="caption-1 caption-2" style="bottom:-20px;top:auto;">
<!--@if($sub == 'archive')
	<button class="btn btn-sm btn-success" name="activate"><i class="fa fa-leaf" style="position:relative;top:-1px;font-size:10px"></i></button>
@else
	<button class="btn btn-sm btn-danger" name="deactivate"><i class="fa fa-trash" style="position:relative;top:-1px;font-size:10px"></i></button>
	<button class="btn btn-sm btn-danger" name="ban"><i class="fa fa-ban" style="position:relative;top:-1px;font-size:10px"></i></button>
@endif-->
<a href="{{url('/client/create')}}" class="btn btn-sm btn-success"><i class="fa fa-plus-circle"></i></a>
<a href="{{url('/client')}}" class="btn btn-sm {{($sub == 'archive')?'':'btn-hover'}}"><i class="fa fa-bars"></i></a>
<a href="{{url('/client/archive')}}" class="btn btn-sm btn-danger {{($sub == 'archive')?'btn-hover':''}}"><i class="fa fa-archive"></i></a>
</p>
<!--</form>-->