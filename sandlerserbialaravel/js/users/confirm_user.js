$(document).ready(function(){
 
    $("#authorized_user").on("click", function(event){  

        var confirmIcon = $(this).find('.no_spinner');
        var spinnerIcon = $(this).find('.spinner');
        confirmIcon.hide();
        spinnerIcon.show();
        var confirmUrl = $(this).attr('href');
        var user = $('#user').html();
        event.preventDefault();
        ezBSAlert({
          type: "confirm",
          headerText: 'Potvrda',
          messageText: "Želiš da omogućiš pristup korisniku: " + user + "?",
          alertType: "warning"
        }).done(function (e) {
          if(e)window.location = confirmUrl;
              setTimeout(function(){
                confirmIcon.show();
                spinnerIcon.hide();
              }, 1000);
        });
    }); 

    $("#unauthorized_user").on("click", function(event){  

        var confirmIcon = $(this).find('.no_spinner');
        var spinnerIcon = $(this).find('.spinner');
        confirmIcon.hide();
        spinnerIcon.show();
        var confirmUrl = $(this).attr('href');
        var user = $('#user').html();
        event.preventDefault();
        ezBSAlert({
          type: "confirm",
          headerText: 'Potvrda',
          messageText: "Želiš da onemogućiš pristup korisniku: " + user + "?",
          alertType: "warning"
        }).done(function (e) {
          if(e)window.location = confirmUrl;
              setTimeout(function(){
                confirmIcon.show();
                spinnerIcon.hide();
              }, 1000);
        });
    }); 
    
    $("#delete_user").on("click", function(event){ 

        var confirmIcon = $(this).find('.no_spinner');
        var spinnerIcon = $(this).find('.spinner');
        confirmIcon.hide();
        spinnerIcon.show(); 
        var confirmUrl = $(this).attr('href');
        var user = $('#user').html();
        event.preventDefault();
        ezBSAlert({
          type: "confirm",
          headerText: 'Potvrda',
          messageText: "Želiš da obrišeš korisnika: " + user + "?",
          alertType: "warning"
        }).done(function (e) {
          if(e)window.location = confirmUrl;
              setTimeout(function(){
                confirmIcon.show();
                spinnerIcon.hide();
              }, 1000);
        });
    }); 
 
}); 