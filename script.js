jQuery(document).ready(function($){
	$('.replytrigger').click(function(){
		$('.triggered').removeClass('triggered');
		$(this).closest('.decode-reply-tool-plugin').addClass('triggered');
	});
});