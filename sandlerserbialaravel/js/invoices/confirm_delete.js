$(document).ready(function(){

    $("#delete").on("click", function(event){  
        /* Delete Invoice/Proinvoice Route ( #form_proinvoice_delete For Pronivoice Route In Show Payment) */
        var confirmUrl = $('#form_delete_action').val() ? $('#form_delete_action').val() : $('#form_payment_delete').attr('action');
         /* Invoice/Proinvoice Confirm Message */
        var typeName = $('#deleteTypeName').text();
        var messageText = "Želiš da obrišeš "+typeName+"?";
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