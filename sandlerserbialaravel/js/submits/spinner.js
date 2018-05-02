  $(document).ready(function(){

    $('button').on('click', function(){
    	var spinnerIcon = $(this).find('.spinner');
    	var confirmIcon = $(this).find('.no_spinner');
      	spinnerIcon.show();
      	confirmIcon.hide();
        setTimeout(function(){
		   spinnerIcon.hide();
      	   confirmIcon.show();
		}, 3000);
    });

  });