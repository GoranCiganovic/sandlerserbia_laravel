  $(document).ready(function(){

    $('.form_prevent_multiple_submits').on('submit', function(){
    	var btn =  $('.button_prevent_multiple_submits');
	    btn.attr('disabled', true);
	    setTimeout(function(){
		    btn.attr('disabled', false);
		}, 3000);
    });

  });