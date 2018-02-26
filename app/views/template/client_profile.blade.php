<input type="hidden" id="status_change_process" value="{{$retrieve}}">
@foreach($users as $user)
<div class="outer">
<div class="">
<p class="caption-1 caption-2">CLIENT PROFILE </p>
<div class="profile">
<p class=""><span>Name : </span> {{$user->lastname.', '.$user->firstname.' '.$user->middlename}} 
<p class=""><span>Meter ID : </span>{{$user->meter_id}} </p>
<p class=""><span>Type : </span> {{($user->type==0)?'Residential':'Commercial'}} </p>
<p class=""><span>Account Status : </span>@if($user->status == 0) Active @elseif($user->status == 1) Disabled @else Banned @endif</p>
<p class=""><span>Address : </span>{{$user->address}} 
<p class=""><span>Billing Start :</span>{{date("F Y", strtotime($user->start_billing))}}</span>
<p class=""><span>Email Address : </span>{{($user->email == '')?'':$user->email}} 
<p class=""><span>Contact Number : </span>{{($user->contact == '')?'':$user->contact}} 
<p class=""><span>Date Created : </span>{{date("F d, Y h:i A ", strtotime($user->created_at."+ 8 hours"))}} 

<p  class="option">
	
</p>
</div>
</div>
</div>
<p class="caption-1 caption-2 caption-3">
	<a href="{{url('/client/')}}" class="btn btn-sm btn-hover"><i class="fa fa-chevron-left"></i></a>
	<a href="{{url('/client/result?user='.$user->id)}}" class="btn btn-sm btn-success"><i class="fa fa-bar-chart"></i></a>
	<a href="{{url('/summary.php?user='.$user->id)}}" class="btn btn-sm btn-info" target="_blank"><i class="fa fa-print"></i></a>
	@if($user->status == 0)
	<a href="{{url('/client/edit/'.$user->id)}}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
	@endif
	@if($user->status != 0)
	<a href="javascript:void(0)" onclick="updateAccontStatus(1,0,{{$user->id}})" class="btn btn-success btn-sm" ><i class="fa fa-leaf" style="font-size:15px;"></i></a>
	@else
	<a href="javascript:void(0)" onclick="updateAccontStatus(1,1,{{$user->id}})" class="btn btn-danger btn-sm" ><i class="fa fa-archive" style="font-size:15px;"></i></a>
	<a href="javascript:void(0)" onclick="updateAccontStatus(1,2,{{$user->id}})" class="btn btn-deep btn-sm" ><i class="fa fa-ban" style="font-size:15px;"></i></a>
	@endif
</p>
@endforeach
