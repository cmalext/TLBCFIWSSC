<div class="outer">
<form method="POST" action="">
<div class="form-center">
	<p class="caption-1 caption-2">Change Password</p>
	<p class="{{$error['type'] or ''}}">{{$error['message'] or ''}}</p>
	@if($table == 'Client')
	<input type="hidden" name="extra" value="1">
	@endif
	@if($table == 'User' && $session['id'] == $id || $id == NULL)
	<label>Current Password <span class="fa fa-asterisk"></span></label>
	<input type="password" name="password" placeholder="Current Password" required>
	@endif
	<label>New Password <span class="fa fa-asterisk"></span></label>
	<input type="password" name="new_password" placeholder="New Password" required>
	<label>Retype Password<span class="fa fa-asterisk"></span></label>
	<input type="password" name="retype_password" placeholder="Retype Password" required>
	<br><br>
	<button class="btn btn-1">Change Password</button>
</div>
</div>