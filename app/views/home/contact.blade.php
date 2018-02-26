@extends('home')
@section('content')
<div class="clearfix section-3" style="padding-bottom:20px">
	<div class="inner">
		<p class="caption-6 text-center">CONTACT US</p>
		<p class="paragraph-1">For inquiries, call us at our hotline 000-00-00 or fill up the form below and we will reply you through your email. For our current customer, you can sign in with your account and your question there </p>
	</div>
</div>
<div class="clearfix section-6" style="background:#1C1A1C;padding:20px 0">
	<div class="inner">
		<div class="form-space">
				<p class="{{ $error['type'] or '' }}">{{ $error['message'] or '' }}</p>
				{{ Form::open(array('url' => 'contact')) }}
					<label>Email Address <small>(where we will send the reply)</small></label>
					<input type="email" name="email" placeholder="Email Address" required>
					<label>MESSAGE <small>(Your concern, question or suggestion)</small></label>
					<textarea name="content" placeholder="Your concern, question or suggestion" required></textarea>
					<p><button class="btn btn-lg-wt-empty">SUBMIT</button></p>
				</form>
		</div>
	</div>
</div>
@stop