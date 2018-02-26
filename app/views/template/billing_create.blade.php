<p class="caption-1 caption-2">Create Monthly Billing</p>
<div class="outer">
	<div class="form-center">
	<p class="caption-4">This option enables you to upload a csv file containing all the meter readings of our clients. This action is available starting from the 20th to 25th day of every month.</p>
	<form method="POST" enctype="multipart/form-data" action="">
		<br>
		@if(isset($error))
		<p class="success">Successfully imported</p>
		@if(count($error['exist'])>0 || count($error['unknown'])> 0)
		
		<!--<p class="error">There were some issues regarding your list. @if(count($error['exist'])>0) The clients with meter id @foreach($error['exist'] as $k => $v) {{$v}}, @endforeach has already a bill for this month, to update their bills, you must manually go to their profile and update their bill to avoid confusion of paid and unpaid bills @endif </p>-->
		@endif
		@endif
		<label style="display:block;text-align:center;">Reminder: You are uploading for the bills of  {{date("F Y",strtotime($billings['current']['name']))}} </label>
		<br><br>
		<label>Select CSV File <span class="fa fa-asterisk"></span></label>
		<input type="file" id="file" name="file" required>
		<button class="btn" name="csv">Upload FILE</button>
	</form>
	</div>
</div>