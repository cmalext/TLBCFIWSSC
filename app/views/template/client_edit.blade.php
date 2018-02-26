<input type="hidden" id="add" value="0">
@foreach($users as $u)
<div class="outer">
<form method="POST" id="form">
<p class="caption-1 caption-2">Update Client</p>
<p class="error"></p>
<div class="form-block">
<div class="clearfix">
	<div class="col-30">
		<label>Meter id <span class="fa fa-asterisk"></span> </label>
		<input type="text" name="meter" class="numbers-only" placeholder="000-000-000" id="meter-id" value="{{$u->meter_id}}" required>
	</div>
	<div class="col-30">
		<label>Account Type <span class="fa fa-asterisk"></span> </label>
		<select name="type">
			<option value="0" @if($u->type == 0) selected @endif>Residential</option>
			<option value="1" @if($u->type == 1) selected @endif>Commercial</option>
		</select>
	</div>
</div>
<div class="clearfix">
	<div class="col-30">
		<label>Lastname <span class="fa fa-asterisk"></span> </label>
		<input type="text" name="lastname" placeholder="Lastname" value="{{$u->lastname}}" required>
	</div>
	<div class="col-30">
		<label>Firstname <span class="fa fa-asterisk"></span> </label>
		<input type="text" name="firstname" placeholder="Firstname" value="{{$u->firstname}}" required>
	</div>
	<div class="col-30">
		<label>Middlename  </label>
		<input type="text" name="middlename" placeholder="Middlename"  value="{{$u->middlename}}">
	</div>
</div>
<div class="clearfix">
	<div class="col-100">
		<label>Address <span class="fa fa-asterisk"></span> </label>
		<input type="text" name="address" placeholder="Address" value="{{$u->address}}" required>
	</div>
</div>
<div class="clearfix">
	<div class="col-50">
		<label>Email Address : (Optional) </label>
		<input type="text" name="email" value="{{$u->email}}" placeholder="Email Address">
	</div>
	<div class="col-50">
		<label>Contact number : (Optional) </label>
		<input type="text" name="contact" value="{{$u->contact}}" placeholder="Contact Number">
	</div>
</div>

<p><button class="btn" id="form-btn">Update client</button></p>
</form>
</div>
<p class="caption-1 caption-2 caption-3">
	<a href="{{url('/client/profile/'.$u->id)}}" class="btn btn-sm"><i class="fa fa-chevron-left"></i></a>
	<a href="{{url('/client/result?user='.$u->id)}}" class="btn btn-sm btn-success"><i class="fa fa-bar-chart"></i></a>
	<a href="{{url('/summary.php?user='.$u->id)}}" target="_blank" class="btn btn-sm btn-info"><i class="fa fa-print"></i></a>
	@if($u->status == 0)
	<a href="{{url('/client/edit/'.$u->id)}}" class="btn btn-sm btn-hover btn-warning"><i class="fa fa-edit"></i></a>
	<a href="javascript:void(0)" onclick="updateAccontStatus(1,1,{{$u->id}})" class="btn btn-sm btn-danger"><i class="fa fa-archive"></i></a>
	<a href="javascript:void(0)" onclick="updateAccontStatus(1,2,{{$u->id}})" class="btn btn-sm btn-deep"><i class="fa fa-ban"></i></a>
	@else
	<a href="javascript:void(0)" onclick="updateAccontStatus(1,0,{{$u->id}})" class="btn btn-success btn-sm" ><i class="fa fa-leaf"></i></a>
	@endif
</p>
@endforeach