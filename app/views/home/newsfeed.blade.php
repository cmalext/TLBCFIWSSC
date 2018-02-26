@extends('home')
@section('content')
<script>
$(function(){
	$('iframe').attr('width', '100%');
	$('iframe').attr('height', '270');
});
</script>
<div class="section-2 clearfix" style="padding:10px 0;text-transform:none;background:#f8f8f8">
	<div class="col-50">
		<div class="inner">
			<?php $i = 1; ?>
			@foreach($newsfeed as $news)
				@if($i % 2 != 0)
				<div class="news">
					<div class="media">
						@if($news->video != '')
							{{$news->video}}
						@elseif($news->image != '')
							@if(strpos($news->image,'[base_url]-') !== false)
								<img src="{{url()}}/{{str_replace('[base_url]-','',$news->image)}}">
	 						@else
	 							<img src="{{$news->image}}">
	 						@endif
						@endif
					</div>
					<p class="caption-8">{{$news->title}}</p>
					<p class="paragraph-3">{{ $news->description}}</p>
					<p style="color:rgba(0,0,0,0.7);text-align:right;font-style:italic">{{ strtoupper(date("l - F, d Y (h:i a)",strtotime($news->created_at)))}}</p>
				</div>
				@endif
				<?php $i++; ?>
			@endforeach
		</div>
	</div>
	<div class="col-50">
		<div class="inner">
			<?php $i = 1; ?>
			@foreach($newsfeed as $news)	
				@if($i % 2 == 0)
				<div class="news">
					<div class="media">
						@if($news->video != '')
							{{$news->video}}
						@elseif($news->image != '')
							@if(strpos($news->image,'[base_url]-') !== false)
								<img src="{{url()}}/{{str_replace('[base_url]-','',$news->image)}}">
	 						@else
	 							<img src="{{$news->image}}">
	 						@endif
						@endif
					</div>
					<p class="caption-8">{{$news->title}}</p>
					<p class="paragraph-3">{{ $news->description}}</p>
					<p style="color:rgba(0,0,0,0.7);text-align:right;font-style:italic">{{ strtoupper(date("l - F, d Y (h:i a)",strtotime($news->created_at)))}}</p>
				</div>
				@endif
				<?php $i++; ?>
			@endforeach
		</div>
	</div>
</div>
<div class="text-center" style="background:#f8f8f8">
	{{ $newsfeed->links() }}
</div>
@stop