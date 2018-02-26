@extends('home')
@section('content')
<div class="section-4">
<div class="form-center">
	<div class="inner">
		<p class="error">{{ $error }}</p>
		{{ Form::open(array('url' => 'signin')) }}
			<p>USER : lastname.president / 123123123 </p>
			<label>Username</label>
			<input type="text" name="username" value="{{ \Input::get('username')}}" placeholder="Username" required autofocus>
			<label>Password</label>
			<input type="password" name="password" placeholder="Password" required>
			<p style="position:relative;top:-10px"><a href="{{url('/help')}}" style="color:#fff;font-weight:600;text-transform:uppercase" >Need help logging in?</a></p>
			<p><button class="btn btn-lg-gr">SIGN IN</button></p>
		</form>
	</div>
</div>
</div>
<div class="section-7" style="background:rgba(0,0,0,0.8)">
	<p class="paragraph-1" style="padding-bottom:0;margin-bottom:0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</p>
</div>
@stop