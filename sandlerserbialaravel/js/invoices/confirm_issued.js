$(document).ready(function(){

    $("#issued").on("click", function(event){  
        /* Issued Invoice/Proinvoice Route */
        var confirmUrl = $('#form_issued_action').val();
        /* Invoice/Proinvoice Confirm Message */
        var typeName = $('#issuedTypeName').text();
        var messageText = typeName+" je izdata?";
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

