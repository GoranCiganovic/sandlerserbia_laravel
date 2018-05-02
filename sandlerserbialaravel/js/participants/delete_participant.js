$( document ).ready( function () {

      $("#delete_participant").on("click", function(event){  
        var confirmIcon = $(this).find('.no_spinner');
        var spinnerIcon = $(this).find('.spinner');
        confirmIcon.hide();
        spinnerIcon.show();
        var confirmUrl = $(this).attr('href');
        var participant = $('#confirm_name').html();
        var messageText = "Želiš da obrišeš učesnika " + participant + "?";
        event.preventDefault();
        ezBSAlert({
          type: "confirm",
          headerText: 'Potvrda',
          messageText: messageText,
          alertType: "warning"
        }).done(function (e) {
          if(e)window.location = confirmUrl;
              setTimeout(function(){
                confirmIcon.show();
                spinnerIcon.hide();
              }, 1000);

        });
    }); 

} );



 