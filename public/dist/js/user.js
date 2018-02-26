$(function(){
	var url = $("#url").val();
	$(".numbers-only").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 173]) !== -1 ||
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
    $(".money").keydown(function (e) {
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
	$('.menu').click(function(){
		$('.sidebar').toggle();
		$('#row').toggleClass('expanded');
		$('.caption-2').toggleClass('expanded');
		$('.datatable thead').toggleClass('expanded');
		$('.dataTables_length').toggle();
		$('.dataTables_filter').toggle();
	});
	$('#all').click(function(event) {   
		if(this.checked){
			$(':checkbox').each(function() {
            	this.checked = true;                        
        	});
    	}else{
    		$(':checkbox').each(function() {
            	this.checked = false;                        
        	});
    	}
	});
	$('#row').click(function(){
		$('.dropdown ul').hide();
	});
	$(window).resize(function(){
		if($(window).width() > 784){
			$('.sidebar').show();
			$('#row').addClass('row-expanded');
			$('.caption-2').removeClass('expanded');
		}else{
			$('.sidebar').hide();
			$('#row').removeClass('row-expanded');
			$('.caption-2').removeClass('expanded');
			$('.datatable thead').removeClass('expanded');
        }
	});
	$('.sidebar ul li').click(function(){
		$(this).children('ul').slideToggle(200);
	});
	$("#form").submit(function() {
		var url2 = $("#url").val();
		var url = $("#form").val();
		$.ajax({
	        type: "POST",
	        url: document.URL,
	        data: $("#form").serialize(),
	        beforeSend: function(){ $('.error').html(''); $("#form button").html('<i class="fa fa-spin"><i class="fa fa-circle-o-notch fa-2x"></fa></i>');},
	        success: function(data){
	        	if(data == 'amount'){
	        		$('.error').html('The amount is not enough for the membership fee');
	        	}else if(data == 'meter2'){
	        		$('.error').html('Meter id should be in this format 000-000-000');
	        	}else if(data == 'meter'){
	        		$('.error').html('The meter id is already taken');
	        	}else if(data == 'email'){
	        		$('.error').html('The email address is already taken');
	        	}else{
	        		if($('#add').val() == 1){
	        			alert("You have succesfully added client information");
	        			window.open(url2+'/membership.php?id='+data);
	        			window.location.href=url2+"/client/profile/"+data;
	        		}else{
	        			$('.error').html('<span style="color:green">S</span>');
	        		}
	        		//window.location.href=url2+'/client/profile/'+data;
	        	} 
	        	$('#form button').html('add client');
	        }
       	});
		return false; 
	});		
	$('.datatable-basic').dataTable({
		"paging":   false,
		"order": [[ 1, "asc" ]]
	});
	$('.datatable-no-order').dataTable({
		"paging":   false,
		"ordering": false,
		"info":     false,
		"order": [[ 1, "asc" ]]
	});
});
function navtoggle(x){
	var i = 1;
	for(i=1;i<4;i++){
		if(x == i){
			if($('#child-'+i).is(':visible')){
				$('#child-'+i).hide();
			}else{
				$('#child-'+i).show();
			}
		}else{
			$('#child-'+i).hide();
		}
	}
}
function updateAccontStatus(x,y,z){
	var url = $('#url').val();
	if(y == 0){
		var check = $("#status_change_process").val();
		if(check > 0){
			alert("This client has remaining balance that must be paid to be reactivated");
			return false;
		}
		var message = 'You are about to reactivate this account. please confirm this action';
	}else if(y == 1){
		var message = 'You are about to delete this account please confirm';
	}else{
		var message = 'You are about to ban this account, please confirm';
	}
	if(confirm(message)){
		window.location.href=url+'/user/update?tb='+x+'&id='+z+'&st='+y;
	}
}
function updateNotification(x){
	var url = $('#url').val();

	$.ajax({
		url: url+'/user/notification',
		type:'GET',
		data: {x:x},
		success: function(data){window.location.href=$('#notification-'+x).attr('xhref');}
	});
}
function clearNotification(x){
	var url = $('#url').val();

	$.ajax({
		url: url+'/user/notification/clear',
		type:'GET',
		success: function(data){$('#child-2').html(''); $('#child-2').css("display","none");}
	});
}
function deleteCurrentBill(){
	if(confirm("This action will truncate the billings for this month. Please confirm")){
		window.location.href=$('#url').val()+'/billing/delete';
	}
}
function modal_in(){
	$('.modal').show();
}
function modal_out(){
	$('.modal').hide();
}
function updateBill(x){
	modal_in();
	var url = $('#url').val();
	$.ajax({
		url: url+"/billing/update",
		type: "GET",
		data: {x:x},
		beforeSend: function(){$('.ajax').html('<div style="text-align:center"><i class="fa fa-cog fa-spin" style="font-size:50px;color:#34495e"></i></div>');},
		success: function(data){$('.ajax').html(data);}
	});
	//$('.ajax').html("<div class='form-center' style='padding-top:20px;padding-bottom:5px'><label>Liter Consumed </label><input type='number'><div style='text-align:right'><button class='btn'>update</button></div></form>");
}
function removeExtra(x){
	if(confirm("Are you sure you want to remove this extra billing?")){
		$('#extra-'+x).slideUp();
		var action = 1;
		var url = $('#url').val();
		$.ajax({
			url: url+"/billing/update",
			type: "POST",
			data: {action:action,x:x},
			success: function(data){}
		});
	}
}
function setUpdateBill(x,z,a){
	var y = $("#consumption").val();
	if(isNaN(y) || y.length == 0){
		alert("Consumption must be a number");
		$("#consumption").val('');
	}else if(y < 0){
		alert("Consumption must not be a negative number");
	}else if(y < a){
		alert("Meter reading must not be less than previous consumptions");
	}else{
		var action = 2;
		var url = $("#url").val();
		$.ajax({
			url: url+"/billing/update",
			type: "POST",
			data: {action:action,x:x,y:y},
			beforeSend:function(){$('#placeholder').html('<div style="text-align:center"><i class="fa fa-cog fa-spin" style="font-size:50px;color:#34495e"></i></div>');},
			success: function(data){if(data == 1){$('#placeholder').html("<div class='success'>Successfully updated. <a href=''><i class='fa fa-refresh' style='color:#34495e;font-size:20px'></i></a> to reload page.</div>");}}
		});
	}
}
