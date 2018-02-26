@extends('home')
@section('content')
<div class="clearfix section-3" style="padding-bottom:20px;background:rgba(0,0,0,0.5)">
	<div class="inner">
		<p class="caption-6 text-center">ACCOUNT RECOVERY</p>
		<p class="paragraph-1">This option is only available for accounts with attached email address. Just input the information needed below and we will send a link on your email to process your account password.</p>
		<p class="paragraph-1">If you haven't set up an email or somehow forgot the email you used for your account, you might need to contact us @ 000-00-00 or come visit our office to recover your account. </p>
	</div>
</div>
<div class="clearfix section-6" style="background:rgba(0,0,0,0.8);padding:20px 0">
	<div class="inner">
		<div class="form-space">
				<p class="{{ $error['type'] or '' }}">{{ $error['message'] or '' }}</p>
				{{ Form::open(array('url' => 'help')) }}
					<label>Email Address</label>
					<input type="email" name="email" placeholder="Email Address" required>
					<!--<label>METER ID</label>-->
					<input type="hidden" name="meter" placeholder="METER ID">
					<p><button class="btn btn-lg-wt-empty">RECOVER MY ACCOUNT</button></p>
				</form>
		</div>
	</div>
</div>
@stop