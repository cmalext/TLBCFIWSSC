@extends('user')
@section('content')
<script>
var randomScalingFactor = function(){ return Math.round(Math.random()*10)};
var lineChartData = {
	labels : ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sept","Oct","Nov","Dec"],
	datasets : [
		{
			label: "My First dataset",
			fillColor : "rgba(54, 74, 105, 0.2)",
			strokeColor : "rgba(54, 74, 105, 0.5)",
			pointColor : "rgba(54, 74, 105, 1)",
			pointStrokeColor : "#fff",
			pointHighlightFill : "#fff",
			pointHighlightStroke : "rgba(220,220,220,1)",
			data : ["{{$chart['consumption'][0]}}","{{$chart['consumption'][1]}}","{{$chart['consumption'][2]}}","{{$chart['consumption'][3]}}","{{$chart['consumption'][4]}}","{{$chart['consumption'][5]}}","{{$chart['consumption'][6]}}","{{$chart['consumption'][7]}}","{{$chart['consumption'][8]}}","{{$chart['consumption'][9]}}","{{$chart['consumption'][10]}}","{{$chart['consumption'][11]}}"]
		},
		
	]
}
var lineChartData2 = {
	labels : ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sept","Oct","Nov","Dec"],
	datasets : [
		{
			label: "Total PROFIT",
			fillColor : "rgba(54, 74, 105, 0.2)",
			strokeColor : "rgba(54, 74, 105, 0.5)",
			pointColor : "rgba(54, 74, 105, 1)",
			pointStrokeColor : "#fff",
			pointHighlightFill : "#fff",
			pointHighlightStroke : "rgba(220,220,220,1)",
			data : ["{{$chart['total'][0]}}","{{$chart['total'][1]}}","{{$chart['total'][2]}}","{{$chart['total'][3]}}","{{$chart['total'][4]}}","{{$chart['total'][5]}}","{{$chart['total'][6]}}","{{$chart['total'][7]}}","{{$chart['total'][8]}}","{{$chart['total'][9]}}","{{$chart['total'][10]}}","{{$chart['total'][11]}}"]
		},
		{
			label: "My Second dataset",
			fillColor : "rgba(37, 133, 63, 0.2)",
			strokeColor : "rgba(37, 133, 63, 0.5)",
			pointColor : "#fff",
			pointStrokeColor : "rgba(37, 133, 63,0.5)",
			pointHighlightFill : "#fff",
			pointHighlightStroke : "rgba(37, 133, 63, 1)",
			data : ["{{$chart['paid'][0]}}","{{$chart['paid'][1]}}","{{$chart['paid'][2]}}","{{$chart['paid'][3]}}","{{$chart['paid'][4]}}","{{$chart['paid'][5]}}","{{$chart['paid'][6]}}","{{$chart['paid'][7]}}","{{$chart['paid'][8]}}","{{$chart['paid'][9]}}","{{$chart['paid'][10]}}","{{$chart['paid'][11]}}"]
		}
	]
}
var doughnutData = [
	{
		value: "{{$billings['current']['total_unpaid_client']}}",
		color:"#E36666",
		highlight:"#9E0808",
		label: "Unpaid"
	},
	{
		value: "{{$billings['current']['total_paid_client']}}",
		color: "#90D4A4",
		highlight: "#366945",
		label: "Paid"
	},
];
var doughnutData2 = [
	{
		value: "{{$billings['next']['total_unpaid_client']}}",
		color:"#E36666",
		highlight:"#9E0808",
		label: "Unpaid"
	},
	{
		value: "{{$billings['next']['total_paid_client']}}",
		color: "#90D4A4",
		highlight: "#366945	",
		label: "Paid"
	},
];
window.onload = function(){
	var ctx = document.getElementById("current-area").getContext("2d");
	var ctx2 = document.getElementById("next-area").getContext("2d");
	window.myDoughnut = new Chart(ctx).Doughnut(doughnutData, {responsive : true});
	window.myDoughnut = new Chart(ctx2).Doughnut(doughnutData2, {responsive : true});
	var ctx3 = document.getElementById("statistic-1").getContext("2d");
		window.myLine = new Chart(ctx3).Line(lineChartData, {
			responsive: true
		});
	var ctx4 = document.getElementById("statistic-2").getContext("2d");
		window.myLine = new Chart(ctx4).Line(lineChartData2, {
			responsive: true
		});
};
$(function(){
	$('#search').val('');
	$('result').html('');
	$("#search").keyup(function(){
		var x = $(this).val();
		if(x.length > 3){
			$.ajax({
				url:"{{url('/client/list')}}",
				type:"POST",
				data:{x:x},
				success:function(data){$('#result').html(data);}
			});
		}else{
			$('#result').html('');
		}
	});
});
</script>
<div class="outer">
<p class="caption-1 caption-2">WELCOME {{$session['lastname'].', '.$session['firstname'].' '.$session['middlename'].''}}</p>

<div style="text-align:center">
	<input class="search" type="search" id="search" placeholder="Quick Search Client">
	<div class="" id="result" style="margin-bottom:20px;max-height:200px;overflow:auto">
		
	</div>
</div>
	<div class="display-block">
		<div class="balloon">
			<div class="card {{($changes['collect']['action'] == 1)?'card-success':'card-success'}}">
				<div class="upper">
					<i class="fa fa-bars"></i>
					<span>{{$changes['collect']['day']}}</span>
				</div>
				<div class="lower">
					<a href="{{( $changes['collect']['action'] == 1)?url('/billing/create'):'#'}}">Import bills</a>
				</div>
			</div>
		</div>
		<div class="balloon">
			<div class="card {{($changes['release']['action'] == 1)?'card-info':'card-info'}}">
				<div class="upper">
					<i class="fa fa-paper-plane"></i>
					<span>{{$changes['release']['day']}}</span>
				</div>
				<div class="lower">
					<a target="_blank" href="{{( $changes['release']['action'] == 1)?url('/reading.php?month='.$billings['current']['name']):'#' }}">Print bills</a>
				</div>
			</div>
		</div>
		<div class="balloon">
			<div class="card {{($changes['notice']['action'] == 1)?'card-warning':'card-warning'}}">
				<div class="upper">
					<i class="fa fa-exclamation-triangle"></i>
					<span>{{$changes['notice']['day']}}</span>
				</div>
				<div class="lower">
					<a target="_blank" href="{{( $changes['notice']['action'] == 1)?url('/notice.php?month='.$billings['current']['name']):'#' }}">Disconnection notice</a>
				</div>
			</div>
		</div>
		<div class="balloon">
			<div class="card {{($changes['cutoff']['action'] == 1)?'card-danger':'card-danger'}}">
				<div class="upper">
					<i class="fa fa-trash"></i>
					<span>{{$changes['cutoff']['day']}}</span>
				</div>
				<div class="lower">
					<a href="{{( $changes['cutoff']['action'] == 1)? url('/billing?date='.$billings['current']['name'].'&filter=0'):'#' }}">Cut off</a>
				</div>
			</div>
		</div>
	</div>
</p>
<p class="caption-5" style="text-align:center">
	<a href="{{url('/user?date=')}}{{ (Input::get('date') != '')?date("Y-m-d",strtotime(Input::get('date')."- 2 months")):date("Y-m-d",strtotime($date['today']."- 2 months")) }}" style="float:left;"><i class="fa fa-chevron-left"></i></a>
	Monthly Billings
	<a href="{{url('/user?date=')}}{{ (Input::get('date') != '')?date("Y-m-d",strtotime(Input::get('date')."+ 2 months")):date("Y-m-d",strtotime($date['today']."+ 2 months")) }}" style="float:right;"><i class="fa fa-chevron-right"></i></a></p>
<div class="clearfix" style="">
<div class="col-50">
	<div class="inner">
		<div class="frame">
			<div class="outbound">
				<div class="outframe">
					<div id="current-chart">
						<canvas id="current-area" width="100%" height="100%"/>
					</div>
				</div>
					<p> {{date("F Y", strtotime($billings['current']['name']))}} BILLING</p>
					<div class="list">
						<p class="">Total Clients : <a href="{{url('/billing?date='.$billings['current']['name'])}}">{{$billings['current']['total_client']}} Clients </a></p> 
						<p class="">Total Paid Clients : <a href="{{url('/billing?date='.$billings['current']['name'].'&filter=1')}}">{{$billings['current']['total_paid_client']}} Clients </a></p> 
						<p class="">Total Unpaid Clients : <a href="{{url('/billing?date='.$billings['current']['name'].'&filter=0')}}"> {{$billings['current']['total_unpaid_client']}} Clients </a></p> 
						<p class="">Total Collected Amout : {{number_format($billings['current']['total_paid_amount'],2,'.',',')}} PHP  </p> 
						<p class="">Total Remaining Amount: {{number_format($billings['current']['total_unpaid_amount'],2,'.',',')}} PHP  </p>
						<p class="">Total Amount : {{number_format($billings['current']['total_amount'],2,'.',',')}} PHP   </p>  
					</div>

				
			</div>
		</div>
	</div>
</div>
<div class="col-50">
	<div class="inner">
		<div class="frame">
			<div class="outbound">
				<div class="outframe">
					<div id="next-chart">
						<canvas id="next-area" width="100%" height="100%"/>
					</div>
				</div>
				<p> {{date("F Y", strtotime($billings['next']['name']))}} BILLING</p>
				<div class="list">
					<p class="">Total Clients : <a href="{{url('/billing?date='.$billings['next']['name'])}}">{{$billings['next']['total_client']}} Clients </a></p> 
					<p class="">Total Paid Clients : <a href="{{url('/billing?date='.$billings['next']['name'].'&filter=1')}}">{{$billings['next']['total_paid_client']}} Clients </a></p> 
					<p class="">Total Unpaid Clients : <a href="{{url('/billing?date='.$billings['next']['name'].'&filter=0')}}"> {{$billings['next']['total_unpaid_client']}} Clients </a></p> 
					<p class="">Total Collected Amout : {{number_format($billings['next']['total_paid_amount'],2,'.',',')}} PHP  </p> 
					<p class="">Total Remaining Amount: {{number_format($billings['next']['total_unpaid_amount'],2,'.',',')}} PHP  </p>
					<p class="">Total Amount : {{number_format($billings['next']['total_amount'],2,'.',',')}} PHP   </p>   
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<p class="caption-5" style="">Client Consumption Statistics (X = Cubic meter, Y = MONTH)</p>
<div class="clearfix" style="">
	<div class="inner">
		<div class="frame" style="padding:10px">
			<div >
				<canvas id="statistic-1" height="50px" width="100%"></canvas>
			</div>
		</div>
	</div>
</div>
<p class="caption-5" style="">PROFIT Statistics (X = PHP, Y = MONTH) &nbsp; | &nbsp; <span style="padding:auto 5px;background:rgba(54, 74, 105, 0.5)"> &nbsp; &nbsp;&nbsp;&nbsp; </span> &nbsp; Total  &nbsp; | &nbsp; <span style="padding:auto 5px;background:rgba(37, 133, 63, 0.5);"> &nbsp; &nbsp;&nbsp;&nbsp; </span> &nbsp; Paid</p>
<div class="clearfix" style="">
	<div class="inner">
		<div class="frame" style="padding:10px">
			<div >
				<canvas id="statistic-2" height="50px" width="100%"></canvas>
			</div>
		</div>
	</div>
</div>
</div>
</div>
@stop