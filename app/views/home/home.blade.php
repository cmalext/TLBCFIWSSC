@extends('home')
@section('content')
<div class="section-1">
	<div class="overlay-1">
		<p class="text-center caption-3">WELCOME TO </p>
		<p class="text-center caption-4">TBLCFIWSSC</p>
		<p class="text-center caption-2">{{ ucwords('Tingusbawan bagong lipunan community foundation inc. water service and sanitation cooperative')}}</p>
		<div class="text-center" style="padding-top:100px;"><a href="{{url('/signin')}}" class="btn btn-lg-wt-empty">SIGN IN TO OUR SYSTEM</a></div>
	</div>
</div>
<div class="section-2">
	{{ ucwords('tingusbawan bagong lipunan community foundation inc. water service and sanitation cooperative') }}
</div>
<div class="section-5 clearfix">
	<div class="clearfix">
		<div class="col-20">
			<div class="inner">
				<div class="circled-border">
					<i class="fa fa-calendar"></i>
				</div>
			</div>
			<p class="caption-5 text-center">payment history</p>
		</div>
		<div class="col-20">
			<div class="inner">
				<div class="circled-border">
					<i class="fa fa-calculator"></i>
				</div>
			</div>
			<p class="caption-5 text-center">calculate bill</p>
		</div>
		<div class="col-20">
			<div class="inner">
				<div class="circled-border">
					<i class="fa fa-search"></i>
				</div>
			</div>
			<p class="caption-5 text-center">Check  bill</p>
		</div>
		<div class="col-20">
			<div class="inner">
				<div class="circled-border">
					<i class="fa fa-bell"></i>
				</div>
			</div>
			<p class="caption-5 text-center">send alert</p>
		</div>
		<div class="col-20">
			<div class="inner">
				<div class="circled-border">
					<i class="fa fa-user"></i>
				</div>
			</div>
			<p class="caption-5 text-center">check account</p>
		</div>
	</div>
	<!--<div class="clearfix">
		<p class="caption-6 text-center">ANOTHER THING I DONT KNOW WHAT TO PUT</p>
		<p class="paragraph-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	</div>-->
</div>
<div class="clearfix section-3">
	<div class="inner">
		<p class="caption-1">About Us</p>
		<p class="paragraph-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		<p class="paragraph-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		<div class="text-center" style="padding-top:50px;padding-bottom:50px">
			<!--<a href="{{url('/about')}}" class="btn btn-lg-wt-empty">Read More about us</a>-->
		</div>
	</div>
</div>	
</div>
@stop