<input type="hidden" id="add" value="1">
<div class="outer">
<form method="POST" id="form">
<p class="caption-1 caption-2">Create Client</p>
<p class="error"></p>
<div class="form-block">
<div class="clearfix">
	<div class="col-30">
		<label>Meter id <span class="fa fa-asterisk"></span> </label>
		<input type="text" name="meter" class="numbers-only" placeholder="000-000-000" id="meter-id" required>
	</div>
	<div class="col-30">
		<label>Account Type <span class="fa fa-asterisk"></span> </label>
		<select name="type">
			<option value="0">Residential</option>
			<option value="1">Commercial</option>
		</select>
	</div>
	<div class="col-30">
		<label>Membership Fee : </label>
		<input type="text" disabled name="membership" style="background:none" value="PHP {{number_format($price['membership'],2,'.',',')}}"> 
	</div>
</div>
<div class="clearfix">
	<div class="col-30">
		<label>Lastname <span class="fa fa-asterisk"></span> </label>
		<input type="text" name="lastname" placeholder="Lastname" required>
	</div>
	<div class="col-30">
		<label>Firstname <span class="fa fa-asterisk"></span> </label>
		<input type="text" name="firstname" placeholder="Firstname" required>
	</div>
	<div class="col-30">
		<label>Middlename  </label>
		<input type="text" name="middlename" placeholder="Middlename" >
	</div>
</div>
<div class="clearfix">
	<div class="col-100">
		<label>Address <span class="fa fa-asterisk"></span> </label>
		<input type="text" name="address" placeholder="Address" required>
	</div>
</div>
<div class="clearfix">
	<div class="col-50">
		<label>Email Address : (Optional) </label>
		<input type="text" name="email" placeholder="Email Address">
	</div>
	<div class="col-50">
		<label>Contact number : (Optional) </label>
		<input type="text" name="contact" placeholder="Contact Number">
	</div>
</div>
<div class="clearfix">
	<div class="col-50">
		<label>Amount Recieved <span class="fa fa-asterisk"></span> </label>
		<input type="text" name="amount" class="money" id="amount" placeholder="Amount PHP"> 
	</div>
</div>

<p><button class="btn" id="form-btn">Add client</button></p>
</form>
</div>
<p class="caption-1 caption-2 caption-3">
<a href="{{url('/client/create')}}" class="btn btn-sm btn-success btn-hover"><i class="fa fa-plus-circle"></i></a>
<a href="{{url('/client')}}" class="btn btn-sm"><i class="fa fa-bars"></i></a>
<a href="{{url('/client/archive')}}" class="btn btn-sm btn-danger"><i class="fa fa-archive"></i></a>
</p>
</p>