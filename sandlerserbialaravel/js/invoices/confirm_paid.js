$(document).ready(function(){

    $("#paid_invoice").on("click", function(event){  
        var confirmUrl = $('#form_invoice_paid').attr('action');
        var messageText = "Faktura je plaćena?";
        event.preventDefault();
        ezBSAlert({
          type: "confirm",
          headerText: 'Potvrda',
          messageText: messageText,
          alertType: "warning"
        }).done(function (e) {
          if(e)window.location = confirmUrl;
        });
    }); 

    $("#paid_proinvoice").on("click", function(event){  
        var confirmUrl = $('#form_proinvoice_paid').attr('action');
        var messageText = "Profaktura je plaćena?";
        event.preventDefault();
        ezBSAlert({
          type: "confirm",
          headerText: 'Potvrda',
          messageText: messageText,
          alertType: "warning"
        }).done(function (e) {
          if(e)window.location = confirmUrl;
        });
    }); 

});

