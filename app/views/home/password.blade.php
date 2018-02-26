@extends('home')
@section('content')
<div class="clearfix section-3" style="padding-bottom:20px;background:rgba(0,0,0,0.8)">
	<div class="inner">
		<p class="caption-6 text-center">CHANGE PASSWORD</p>
		<p class="paragraph-1">You have successfully verified your account. Please change your password.</p>
		<p class="paragraph-1">Your token will expire after {{date("h:ia", strtotime($date .'+ 9 hours'))}} or once you have successfully changed your password</p>
	</div>
</div>
<div class="clearfix section-6" style="background:rgba(0,0,0,0.8);padding:20px 0">
	<div class="inner">
		<div class="form-space">
				<p class="{{ $error['type'] or '' }}">{{ $error['message'] or '' }}</p>
				{{ Form::open(array('url' => 'verify')) }}
					<input type="hidden" name="key" value="{{$key}}">
					<label>New password</label>
					<input type="password" name="email" placeholder="New password" required>
					<label>Verify password</label>
					<input type="password" name="meter" placeholder="Verify password" required>
					<p><button class="btn btn-lg-wt-empty">Change Password</button></p>
				</form>
		</div>
	</div>
</div>
@stop