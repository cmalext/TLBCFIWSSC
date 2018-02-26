@foreach($users as $user)
<div class="outer">
<form method="POST">
	<div class="form-center">
		<p class="caption-1 caption-2">EDIT {{($table == 'User')?'ACCOUNT':'CLIENT'}} PROFILE</p>
		<input type="hidden" name="table" value="{{$table}}" >
		<p class="{{$error['type'] or ''}}">{{$error['message'] or ''}}</p>
		<label>Lastname :<span class="fa fa-asterisk"></span> </label>
		<input type="text" name="lastname" value="{{$user->lastname}}" placeholder="Lastname" required>
		<label>Firstname :<span class="fa fa-asterisk"></span> </label>
		<input type="text" name="firstname" value="{{$user->firstname}}" placeholder="Firstname" required>
		<label>Middlename : </label>
		<input type="text" name="middlename" value="{{$user->middlename}}" placeholder="Middlename">

		@if($table == 'User')
			@if($session['id'] != $user->id)
			<label>Position : </label>
			<select name="type">
				<option value="0" @if($user->type == 0) selected @endif>Secretary</option>
				<option value="1" @if($user->type == 1) selected @endif>Treasurer</option>
				<option value="2" @if($user->type == 2) selected @endif>President</option>
			</select>
			@else
			<input name="type" type="hidden" value="{{$session['type']}}">
			@endif
		@else
		<label>Meter ID : <span class="fa fa-asterisk"></span></label>
		<input type="text" name="meter_id" value="{{$user->meter_id}}" placeholder="Meter ID" required>
		<label>Account type : </label>
		<select name="type">
			<option value="0" @if($user->type == 0) selected @endif>A</option>
			<option value="1" @if($user->type == 1) selected @endif>B</option>
		</select>
		@endif
		<label>Address : <span class="fa fa-asterisk"></span></label>
		<input type="text" name="address" value="{{$user->address}}" placeholder="Address" required>
		<label>Email :  @if($table == 'Client') (Optional : if you want to be recieve payment via email) @endif <span class="fa fa-asterisk"></span></label>
		<input type="email" name="email" value="{{$user->email}}" placeholder="Email Address" {{($table == 'User')?'required':''}}>
		<label>Contact Number : (Optional) </label>
		<input type="text" name="contact" value="{{$user->contact}}" placeholder="Contact">
		<p  class="option"><button class="btn">&nbsp;EDIT PROFILE&nbsp;</button></p>
	</div>
</form>
</div>
@endforeach
