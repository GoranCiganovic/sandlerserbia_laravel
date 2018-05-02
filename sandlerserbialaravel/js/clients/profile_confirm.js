$(document).ready(function(){

    /* Change Status */
    $(".change_status").on("click", function(event){  
        var confirmUrl = $(this).attr('href');
        var child = $(this).find('span').html();
        var text_color = $(this).attr('class').split("-").pop();
        var messageText = "Želiš da promeniš status u <span class='text-" + text_color + "'>'" + child + "'</span> ?";
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

    /* Delete Profile */
    $("#delete_profile").on("click", function(event){  
        var confirmIcon = $(this).find('.no_spinner');
        var spinnerIcon = $(this).find('.spinner');
        confirmIcon.hide();
        spinnerIcon.show();
        var confirmUrl = $(this).attr('href');
        var client = $('#confirm_name').html();
        var messageText = "Želiš da obrišeš " + client + "?";
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

