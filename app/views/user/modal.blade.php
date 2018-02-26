@if($sub == 'billing_update')
<script>
$(function(){
	 $("#consumption").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});
</script>
@foreach($bill as $b)
<div class="form-center" style="padding:20px 0">
	<p class="caption-4">NOTE: Meter reading is the overall total meters consumed and will automatically be deducted by the previous billing to get this month's bill </p>
	<div id="placeholder"></div>
	{{--*/ $spec['prev'] = $spec['total'] - ($b->consumption) /*--}}
	<div style="position:relative;padding-bottom:20px;border-bottom:1px solid rgba(0,0,0,0.1);margin-bottom:20px">
	<label>Meter Reading (Meter)</label>
	<input type="text" id="consumption" value="{{$spec['total']}}">
	<label>Previous Consumption </label>
	<input type="text" id="consumption" value="{{$spec['prev']}}" disabled>
	<label>Total Consumption for this month</label>
	<input type="text" id="consumption" value="{{$spec['total'] - $spec['prev']}}" disabled>
	<p><a href="javascript:void(0)" onclick="setUpdateBill({{$b->id}}, {{$spec['total']}}, {{$spec['prev']}})" style="" class="btn btn-hover">Update</a></p>
	</div>
	@if(count($extra)>0)
	<label>Extra Billings </label>
	<table cellspacing=0 cellpadding=0 style="width:100%;border:1px solid rgba(0,0,0,0.1);margin-top:10px;font-size:12px;font-family:sans-serif;font-weight:300;">
	<tr style="background:#187D99;color:#fff;text-transform:uppercase;text-align:left!important"><th style="padding:10px">Description<th>Price<th>
	@foreach($extra as $ex)
	<tr id="extra-{{$ex->id}}" style="border-bottom:1px solid rgba(0,0,0,0.1)"><td style="padding:13px;border-bottom:1px solid rgba(0,0,0,0.1)">{{$ex->description}}<td style="border-bottom:1px solid rgba(0,0,0,0.1)">{{number_format($ex->total,2,'.',',')}} PHP<td style="text-align:right"><a href="javascript:void(0)" onclick="removeExtra({{$ex->id}})" class="btn btn-hover btn-circle btn-danger" style="padding:5px;position:relative;top:-2px;right:10px"><i class="fa fa-remove"></i></a>
	@endforeach
	</table>
	@endif
</div>
@endforeach


@endif