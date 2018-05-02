function ezBSAlert (options) {
  var deferredObject = $.Deferred();
  var defaults = {
    type: "alert", //alert, prompt,confirm 
    modalSize: 'modal-sm', //modal-sm, modal-lg
    okButtonText: 'U redu',//Ok
    cancelButtonText: 'Cancel',//Cancel
    yesButtonText: 'Potvrdi',// Yes
    noButtonText: 'Odustani',// No
    headerText: 'Upozorenje',//Attention
    messageText: 'Message',
    alertType: 'default', //default, primary, success, info, warning, danger
    inputFieldType: 'text', //could ask for number,email,etc
  }
  $.extend(defaults, options);
  
  var _show = function(){
    var headClass = "navbar-default";
    var textTitle = "text-primary";
    switch (defaults.alertType) {
      case "primary":
        headClass = "alert-san-blue";
        textTitle = "text-primary";
        break;
      case "success":
        headClass = "alert-san-blue";
        textTitle = "text-success";
        break;
      case "info":
        headClass = "alert-san-blue";
        textTitle = "text-info";
        break;
      case "warning":
        headClass = "alert-san-blue";
        textTitle = "text-warning";
        break;
      case "danger":
        headClass = "alert-san-blue";
        textTitle = "text-danger";
        break;
      case "san-blue":
        headClass = "alert-san-blue";
        textTitle = "text-warning";
        break;
      case "san-yell":
        headClass = "alert-san-yell";
        textTitle = "text-primary";
        break;
      case "msg":
        headClass = "alert-msg";
        textTitle = "text-white";
        break;
        }
    $('BODY').append(
      '<div id="ezAlerts" class="modal fade text-primary ">' +
      '<div class="modal-dialog" class="' + defaults.modalSize + '">' +
      '<div class="modal-content">' +
      '<div id="ezAlerts-header" class="modal-header ' + headClass + '">' +
      '<button id="close-button" type="button" class="close" data-dismiss="modal"><span class="text-warning" aria-hidden="true">×</span><span class="sr-only">Close</span></button>' +
      '<h4 id="ezAlerts-title" class="modal-title ' + textTitle + '">Modal title</h4>' +
      '</div>' +
      '<div id="ezAlerts-body" class="modal-body text-primary">' +
      '<div id="ezAlerts-message"></div>' +
      '</div>' +
      '<div id="ezAlerts-footer" class="modal-footer">' +
      '</div>' +
      '</div>' +
      '</div>' +
      '</div>'
    );

    $('.modal-header').css({
      'padding': '15px 15px',
      '-webkit-border-top-left-radius': '5px',
      '-webkit-border-top-right-radius': '5px',
      '-moz-border-radius-topleft': '5px',
      '-moz-border-radius-topright': '5px',
      'border-top-left-radius': '5px',
      'border-top-right-radius': '5px'
    });
    
    $('#ezAlerts-title').text(defaults.headerText);
    $('#ezAlerts-message').html(defaults.messageText);

    var keyb = "false", backd = "static";
    var calbackParam = "";
    switch (defaults.type) {
      case 'alert':
        keyb = "true";
        backd = "true";
        $('#ezAlerts-footer').html('<button class="btn alert-san-blue pull-right col-lg-2 btn-' + defaults.alertType + '">' + defaults.okButtonText + '</button>').on('click', ".btn", function () {
          calbackParam = true;
          $('#ezAlerts').modal('hide');
        });
        break;
      case 'confirm':
      
        var btnhtml = '<button id="ezok-btn" class="btn btn-primary pull-right col-lg-2">' + defaults.yesButtonText + '</button>';
        if (defaults.noButtonText && defaults.noButtonText.length > 0) {
          btnhtml += '<button id="ezclose-btn" class="btn btn-default pull-right col-lg-2">' + defaults.noButtonText + '</button>';
        }
        $('#ezAlerts-footer').html(btnhtml).on('click', 'button', function (e) {
            if (e.target.id === 'ezok-btn') {
              calbackParam = true;
              $('#ezAlerts').modal('hide');
            } else if (e.target.id === 'ezclose-btn') { 
              calbackParam = false;
              $('#ezAlerts').modal('hide');
            }
          });
        break;
      case 'prompt':
        $('#ezAlerts-message').html(defaults.messageText + '<br /><br /><div class="form-group"><input type="' + defaults.inputFieldType + '" class="form-control" id="prompt" /></div>');
        $('#ezAlerts-footer').html('<button class="btn btn-primary">' + defaults.okButtonText + '</button>').on('click', ".btn", function () {
          calbackParam = $('#prompt').val();
          $('#ezAlerts').modal('hide');
        });
        break;
    }
   
    $('#ezAlerts').modal({ 
          show: false, 
          backdrop: backd, 
          keyboard: keyb 
        }).on('hidden.bs.modal', function (e) {
      $('#ezAlerts').remove();
      deferredObject.resolve(calbackParam);
    }).on('shown.bs.modal', function (e) {
      if ($('#prompt').length > 0) {
        $('#prompt').focus();
      }
    }).modal('show');
  }
    
  _show();  
  return deferredObject.promise();    
}





$(document).ready(function(){
  $("#btnAlert").on("click", function(){    
    var prom = ezBSAlert({
      messageText: "hello world",
      alertType: "danger"
    }).done(function (e) {
      $("body").append('<div>Callback from alert</div>');
    });
  });   
  
  $("#btnConfirm").on("click", function(){    
    ezBSAlert({
      type: "confirm",
      messageText: "hello world",
      alertType: "info"
    }).done(function (e) {
      $("body").append('<div>Callback from confirm ' + e + '</div>');
    });
  });   

  $("#btnPrompt").on("click", function(){   
    ezBSAlert({
      type: "prompt",
      messageText: "Enter Something",
      alertType: "primary"
    }).done(function (e) {
      ezBSAlert({
        messageText: "You entered: " + e,
        alertType: "success"
      });
    });
  }); 

  
});