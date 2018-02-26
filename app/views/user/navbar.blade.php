<input type="hidden" id="url" value="{{url('/')}}">
<div class="navbar">
	<a href="{{url()}}" class="logo"><img src="{{url('/logo.jpg')}}" style="width:400px;position:relative;top:-7px"></a>
	<div class="navlink">
		<ul>
			<li class="{{($page == 'dashboard')?'active':''}}"><a href="{{url('/user')}}"><i class="fa fa-home"></i></a></li>@if($session['type'] != 1) @if($date['schedules']['import'] == $date['today'] || $date['schedules']['import'] < $date['today'] && $date['today'] < $date['schedules']['release']) <li class="dropdown {{($page == 'inbox')?'active':''}}">
			<a href="javascript:void(0)" onclick="navtoggle(1)"><i class="fa fa-sliders"></i></a>
				<ul id="child-1">
					<li><a href="{{url('/template.php')}}" target="_blank">export billing template</a><li>
					@if($session['type'] != 1 ) <li><a href="javascript:void(0)" onclick="deleteCurrentBill()">Delete all bill for this month</a><li>@endif
				</ul>
			</li>@endif	@endif <li class="dropdown">
			<a href="javascript:void(0)" onclick="navtoggle(2)"><i class="fa fa-globe" style=""></i>@if($notification['count']>0)<span class="notification">{{$notification['count']}}</span> @endif </a>
				<ul id="child-2" style="width:370px;height:250px;overflow:auto">
					@foreach($notification['list'] as $h)
						<li style="text-overflow:ellipsis;overflow:hidden"><a href="javascript:void(0)" id="notification-{{$h->id}}" onclick="updateNotification({{$h->id}})" xhref="{{url('/'.$h->type)}}" style="font-weight:300;padding:;white-space:nowrap;text-overflow:ellipsis;overflow:hidden;@if($h->status==0) color:#fff; @endif">{{$h->content}}</a></li>
					@endforeach
					<li style="position:fixed;top:305px;background:rgba(0,0,0,0.7);width:370px;"><a href="#" onclick="clearNotification()" style="text-align:center;">CLEAR NOTIFICATION</a><li>	
				</ul>
			</li><li class="dropdown {{($page == 'account')?'active':''}}">
				<a href="javascript:void(0)" onclick="navtoggle(3)"><i class="fa fa-gears"></i></a>
				<ul id="child-3">
					<li><a href="{{url('/user/profile')}}">MY PROFILE</a><li>
					<li><a href="{{url('/user/password')}}">Change Password</a><li>
					<li><a href="{{url('/user/logout')}}">Sign Out</a><li>	
				</ul>
			</li><li class="float-right">
			<a href="javascript:void(0)" class="menu"><i class="fa fa-bars"></i></a></li>
		</ul>
	</div>
</div>
<div class="sidebar">
	<div class="space"></div>
	<a href="{{url()}}" class="logo">TBLCFIWSSC</a>
	<ul>
		<li class="{{$page=='client'?'active':''}}"><a href="javascript:void(0)"><i class="fa fa-chevron-down"></i> <span>Client</span></a>
			<ul @if($page == 'client') style="display:block" @endif>
				<li @if($page == 'client' && $sub == 'add') class="active" @endif><a href="{{url('/client/create')}}"><i class="fa fa-chevron-right"></i> <span>Add client</span></a></li>
				<li @if($page == 'client' && $sub == 'list') class="active" @endif><a href="{{url('/client')}}"><i class="fa fa-chevron-right"></i> <span>client List</span></a></li>
				<li @if($page == 'client' && $sub == 'archive') class="active" @endif><a href="{{url('/client/archive')}}"><i class="fa fa-chevron-right"></i> <span>Archive</span></a></li>
			</ul>
		</li>
		<li class="{{$page=='billing'?'active':''}}"><a href="javascript:void(0)"><i class="fa fa-chevron-down"></i><span>billing</span></a>
			<ul @if($page == 'billing') style="display:block" @endif>
					<li @if($page == 'billing' && $sub == 'add') class="active" @endif><a href="{{url('/billing/add')}}"><i class="fa fa-chevron-right"></i> <span>Add Billing</span></a></li>
					<li @if($page == 'billing' && $sub == 'create') class="active" @endif><a href="{{url('/billing/create')}}"><i class="fa fa-chevron-right"></i> <span>Import Billing</span></a></li>
					<li @if($page == 'billing' && $sub == 'extra') class="active" @endif><a href="{{url('/billing/extra')}}"><i class="fa fa-chevron-right"></i> <span>Add Extra Billing</span></a></li>
				<li @if($page == 'billing' && $sub == 'list') class="active" @endif><a href="{{url('/billing')}}"><i class="fa fa-chevron-right"></i> <span>Monthly Billing</span></a></li>
				
			</ul>
		</li>
		@if($session['type'] == 2)
		<li class="{{$page=='accounts'?'active':''}}"><a href="javascript:void(0)"><i class="fa fa-chevron-down"></i><span>Accounts</span></a>
			<ul @if($page == 'accounts') style="display:block" @endif>
				<li @if($page == 'accounts' && $sub == 'create') class="active" @endif><a href="{{url('/accounts/create')}}"><i class="fa fa-chevron-right"></i> <span>Add Account</span></a></li>
				<li @if($page == 'accounts' && $sub == 'list') class="active" @endif><a href="{{url('/accounts')}}"><i class="fa fa-chevron-right"></i> <span>Account List</span></a></li>
				<li @if($page == 'accounts' && $sub == 'archive') class="active" @endif><a href="{{url('/accounts/archive')}}"><i class="fa fa-chevron-right"></i> <span>Archive</span></a></li>
			</ul>
		</li>
		@endif
		<li class="{{$page=='report'?'active':''}}"><a href="javascript:void(0)"><i class="fa fa-chevron-down"></i><span>Statistics</span></a>
			<ul @if($page == 'report') style="display:block" @endif>
				<li @if($page == 'report' && $sub == 'client') class="active" @endif><a href="{{url('/statistics/client')}}"><i class="fa fa-chevron-right"></i> <span>Client Masterlist</span></a></li>
				<li @if($page == 'report' && $sub == 'bill') class="active" @endif><a href="{{url('/statistics/billing')}}"><i class="fa fa-chevron-right"></i> <span>Client Billing Status</span></a></li>
				<li @if($page == 'report' && $sub == 'income') class="active" @endif><a href="{{url('/statistics/income')}}"><i class="fa fa-chevron-right"></i> <span>Profit </span></a></li>
				<!--<li @if($page == 'report' && $sub == 'consumption') class="active" @endif><a href="{{url('/statistics/consumption')}}"><i class="fa fa-chevron-right"></i> <span>Consumption</span></a></li>-->
			</ul>
		</li>
		@if($session['type'] == 2)
		<li class="{{$page=='system'?'active':''}}"><a href="javascript:void(0)"><i class="fa fa-chevron-down"></i><span>System</span></a>
			<ul @if($page == 'system') style="display:block" @endif>
				<li @if($page == 'system' && $sub == 'schedule') class="active" @endif><a href="{{url('/system/schedule')}}"><i class="fa fa-chevron-right"></i> <span>Schedule</span></a></li>
				<li @if($page == 'system' && $sub == 'price') class="active" @endif><a href="{{url('/system/price')}}"><i class="fa fa-chevron-right"></i> <span>Price</span></a></li>
			</ul>
		</li>
		@endif
		
		
	</ul>
</div>