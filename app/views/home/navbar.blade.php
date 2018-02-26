<div class="navbar">
	<a href="{{url()}}" class="logo">TBLCFIWSSC</a>
	<a href="javascript:void(0)" class="menu"><span>MENU</span> <i class="fa fa-bars"></i></a>
	<div class="navlink">
		<ul>
			<li class="{{($page == 'home')?'active':'' }}"><a href="{{url()}}">HOME</a></li><!--<li class="{{($page == 'about')?'active':'' }}">
			<a href="{{url('/about')}}">ABOUT US</a></li><li class="{{($page == 'newsfeed')?'active':'' }}">
			<a href="{{url('/newsfeed')}}">NEWSFEED</a></li><li class="{{($page == 'contact us')?'active last':'last' }}">
			<a href="{{url('/contact')}}">CONTACT</a></li>--><li class="float-right signup {{($page == 'sign in help')?'active':'' }}">
			<a href="{{url('/help')}}">FORGOT PASSWORD</a></li><li class="float-right signin {{($page == 'sign in')?'active':'' }}">
			<a href="{{url('/signin')}}">SIGN IN</a></li>
		</ul>
	</div>
</div>