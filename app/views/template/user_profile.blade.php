@foreach($users as $user)
<div class="outer">
<div class="form-center">
<p class="caption-1 caption-2">{{($table == 'User')?'ACCOUNT':'CLIENT'}} PROFILE </p>
<div class="profile">
<p class=""><span>Name : </span> {{$user->lastname.', '.$user->firstname.' '.$user->middlename}} 
@if($table == 'User')
<p class=""><span>Position : </span>@if($user->type==2) President @elseif($user->type==1) Treasurer @else Secretary @endif </p>
@else
<p><span>Using Password : </span> @if($user->password == '') NO, set password below so user can signin @else YES @endif</p>
<p class=""><span>Meter ID : </span>{{$user->meter_id}} </p>
<p class=""><span>Type : </span>{{($user->type==0)?'A':'B'}} </p>
@endif
<p class=""><span>Account Status : </span>@if($user->status == 0) Active @elseif($user->status == 0) Disabled @else Banned @endif</p>
<p class=""><span>Address : </span>{{$user->address}} 
<p class=""><span>Email Address : </span>{{($user->email == '')?'':$user->email}} 
<p class=""><span>Contact Number : </span>{{($user->contact == '')?'':$user->contact}} 
<p class=""><span>Date Created : </span>{{date("F d, Y", strtotime($user->created_at))}} 
<p  class="option">
	
</p>
</div>
</div>
</div>
@if($session['type'] == 2 || $user->id == $session['id'])
@if($page == 'accounts')
<p class="caption-1 caption-2 caption-3">
	<a href="{{url('/accounts/edit/'.$user->id)}}" class="btn btn-sm"><i class="fa fa-edit"></i></a>
	<a href="{{url('/accounts/password/'.$user->id)}}" class="btn btn-sm">&nbsp;<i class="fa fa-lock"></i>&nbsp;</a>
	@if($session['type'] == 2 && $session['id'] != $user->id)
		@if($user->status == 0)
			<a href="{{url('/user/delete?id='.$user->id.'&status=1')}}" class="btn btn-sm btn-danger"><i class="fa fa-trash" style="font-size:15px"></i></a>
		@else
			<a href="{{url('/user/delete?id='.$user->id.'&status=0')}}" class="btn btn-sm btn-success"><i class="fa fa-leaf" style="font-size:15px"></i></a>
		@endif
	@endif
</p>
@else
<p class="caption-1 caption-2 caption-3">
	<a href="{{url('/user/edit/'.$user->id)}}" class="btn btn-sm"><i class="fa fa-edit"></i></a>
	<a href="{{url('/user/password/'.$user->id)}}" class="btn btn-sm">&nbsp;<i class="fa fa-lock"></i>&nbsp;</a>
	@if($session['type'] == 2 && $session['id'] != $user->id)
	<a href="" class="btn btn-danger btn-sm" ><i class="fa fa-remove" style="font-size:15px;"></i></a>
	@endif
</p>
@endif
@endif
@endforeach
