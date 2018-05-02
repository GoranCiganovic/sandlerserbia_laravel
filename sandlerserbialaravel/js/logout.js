//logout confirm
$("#logout_confirm").on("click", function(event){  
    event.preventDefault();
    ezBSAlert({
      type: "confirm",
      headerText: 'Potvrda',
      messageText: "Želiš da se odjaviš?",
      alertType: "warning"
    }).done(function (e) {
      if(e)window.location = url + '/logout';
    });  
}); 