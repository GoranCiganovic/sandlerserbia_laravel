$(document).ready(function(){
 
    $("#signed_contract").on("click", function(event){  
        var confirmIcon = $(this).find('.no_spinner');
        var spinnerIcon = $(this).find('.spinner');
        confirmIcon.hide();
        spinnerIcon.show();
        var confirmUrl = $(this).attr('href');
        var contract = $('#confirm_name').html();
        var contract_status = $('#contract_status').html();
        var messageText = contract + " je " + contract_status + "?";
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

    $("#break_up_contract").on("click", function(event){  
        var confirmIcon = $(this).find('.no_spinner');
        var spinnerIcon = $(this).find('.spinner');
        confirmIcon.hide();
        spinnerIcon.show();
        var confirmUrl = $(this).attr('href');
        var contract = $('#confirm_name').html();
        var messageText = "Želiš da raskineš " + contract + "?";
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
    
    $("#delete_contract").on("click", function(event){  
        var confirmIcon = $(this).find('.no_spinner');
        var spinnerIcon = $(this).find('.spinner');
        confirmIcon.hide();
        spinnerIcon.show();
        var confirmUrl = $(this).attr('href');
        var contract = $('#confirm_name').html();
        var messageText = "Želiš da obrišeš " + contract + "?";
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


 
}); 