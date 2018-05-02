$(document).ready(function(){
	$('#contract').html($('#articles').html());
	$('#html').val($('#contract').val());
	$('#articles').hide();
	$('.preview').on('click',function(){
		$('#form').attr('action', $('#form_preview').val());
	});
});
