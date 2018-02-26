$(function(){
	$('.menu').click(function(){
		$('.navlink').toggle();
	});
	$(window).resize(function(){
		if($(window).width() > 784){
			$('.navlink').show();
		}else{
			$('.navlink').hide();
        }
	});
});
