<form id="bulk-checklist" method="POST">
<p class="caption-1 caption-2" style="padding-left:70px"><span class="no-mobile">Newsfeed {{($sub == 'archive')?'Archive':'List'}}</span></p>
<table class="datatable">
	<thead>
		<tr>
			<th style="width:26px;min-width:26px;"><input type="checkbox" id="all" onclick="checkall()">
			<th style="width:500px;min-width:95px;">Title
				<th style="width:100px;min-width:95px;">Date
			<th>Option
		@foreach($newsfeeds as $newsfeed)
	</thead>
		<tr>
			<td style="width:27px;min-width:27px;">&nbsp;<input type="checkbox" name="check-{{$newsfeed->id}}">
			<td style="width:500px;min-width:95px;"><a href="{{url('/profile/'.$newsfeed->id)}}">{{$newsfeed->title}}</a>
			<td style="width:100px;min-width:95px;">{{date("F d, Y", strtotime($newsfeed->created_at))}}
			<td class="mobile-hide" style="text-align:right">
				<a href="" class="btn btn-sm btn-info"><i class="fa fa-edit" style="font-size:15px"></i></a>
		@endforeach
</table>
<p class="caption-1 caption-2" style="bottom:-20px;top:auto;">
@if($sub == 'archive')
	<button class="btn btn-sm btn-success" name="activate"><i class="fa fa-leaf" style="position:relative;top:-1px;font-size:10px"></i></button>
@else
	<button class="btn btn-sm btn-danger" name="deactivate"><i class="fa fa-trash" style="position:relative;top:-1px;font-size:10px"></i></button>
	<button class="btn btn-sm btn-danger" name="ban"><i class="fa fa-ban" style="position:relative;top:-1px;font-size:10px"></i></button>
@endif
</p>
</form>