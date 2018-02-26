<div class="outer">
<form method="POST">
	<div class="form-center">
		<p class="caption-1 caption-2">CREATE ACCOUNT</p>
		<input type="hidden" name="table" value="{{$table}}" >
		<p class="{{$error['type'] or ''}}">{{$error['message'] or ''}}</p>
		<label>Lastname : <span class="fa fa-asterisk"></span></label>
		<input type="text" name="lastname" value="" placeholder="Lastname" required>
		<label>Firstname : <span class="fa fa-asterisk"></span></label>
		<input type="text" name="firstname" value="" placeholder="Firstname" required>
		<label>Middlename : </label>
		<input type="text" name="middlename" value="" placeholder="Middlename">
		<label>Position : </label>
		<select name="type">
			<option value="0">Secretary</option>
			<option value="1">Treasurer</option>
			<option value="2">President</option>
		</select>
		<label>Password : <span class="fa fa-asterisk"></span></label>
		<input type="password" name="password" value="" placeholder="Password" required>
		<label>Retype Password : <span class="fa fa-asterisk"></span></label>
		<input type="password" name="retype" value="" placeholder="Retype password" required>
		<label>Address : <span class="fa fa-asterisk"></span></label>
		<input type="text" name="address" value="" placeholder="Address" required>
		<label>Email : <span class="fa fa-asterisk"></span> </label>
		<input type="email" name="email" value="" placeholder="Email Address" required>
		<label>Contact Number : (Optional) </label>
		<input type="text" name="contact" placeholder="Contact">
		<p  class="option"><button class="btn">&nbsp;CREATE ACCOUNT&nbsp;</button></p>
	</div>
</form>
</div>
