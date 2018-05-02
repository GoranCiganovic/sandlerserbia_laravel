$(document).ready(function(){

    $("#middle_ex_dollar").on("input", function(){  
        var dd_dollar = $('#dd_dollar').val();
        var ppo = $('#ppo').val();
        var middle_ex_dollar = $('#middle_ex_dollar').val();
        var dd_din = round_number(dd_dollar*middle_ex_dollar);
        var ppo_din = round_number((dd_din*ppo)/100);
        $('#dd_din').val(dd_din);
        $('#ppo_din').val(ppo_din);

    }); 

    $( "#form" ).validate( {
        rules: {
          middle_ex_dollar: {
            required: true,
            number: true,
            step: 0.0001,
            min: 0,
            max: 99999999.99
          },
          dd_din: {
            required: true,
            number: true,
            step: 0.01,
            min: 0,
            max: 99999999.99
          },
          ppo_din: {
            required: true,
            number: true,
            step: 0.01,
            min: 0,
            max: 99999999.99
          },
          dd_dollar: {
            required: true,
            number: true,
            step: 0.01,
            min: 0,
            max: 99999999.99
          },
          ppo: {
            required: true,
            number: true,
            step: 0.01,
            min: 0,
            max: 999.99
          }
        },
        messages: {
          middle_ex_dollar: {
            required: "Polje 'Srednji kurs dolara na dan plaćanja' je obavezno!",
            number: "Polje 'Srednji kurs dolara na dan plaćanja' može da bude samo decimalni broj!",
            step: "Polje 'Srednji kurs dolara' može da ima do 4 decimale",
            min: "Polje 'Srednji kurs dolara na dan plaćanja' ne može da bude manje od 0!",
            max: "Polje 'Srednji kurs dolara na dan plaćanja' može da bude broj do 99999999.99!"
          },
          dd_din: {
            required: "Polje 'DISC/Devine (RSD)' je obavezno!",
            number: "Polje 'DISC/Devine (RSD)' može da bude samo decimalni broj!",
            step: "Polje 'DISC/Devine (RSD)' može da ima do 2 decimale",
            min: "Polje 'DISC/Devine (RSD)' ne može da bude manje od 0!",
            max: "Polje 'DISC/Devine (RSD)' može da bude broj do 99999999.99!"
          },
          ppo_din: {
            required: "Polje 'Porez po odbitku (RSD)' je obavezno!",
            number: "Polje 'Porez po odbitku (RSD)' može da bude samo decimalni broj!",
            step: "Polje 'Porez po odbitku (RSD)' može da ima do 2 decimale",
            min: "Polje 'Porez po odbitku (RSD)' ne može da bude manje od 0!",
            max: "Polje 'Porez po odbitku (RSD)' može da bude broj do 99999999.99!"
          },
          dd_dollar: {
            required: "Polje 'DISC/Devine (USD)-skriveno' je obavezno!",
            number: "Polje 'DISC/Devine (USD)-skriveno' može da bude samo decimalni broj!",
            step: "Polje 'DISC/Devine (USD)-skriveno' može da ima do 2 decimale",
            min: "Polje 'DISC/Devine (USD)-skriveno' ne može da bude manje od 0!",
            max: "Polje 'DISC/Devine (USD)-skriveno' može da bude broj do 99999999.99!"
          },
          ppo: {
            required: "Polje 'Porez po odbitku (%)-skriveno' je obavezno!",
            number: "Polje 'Porez po odbitku (%)-skriveno' može da bude samo decimalni broj!",
            step: "Polje 'Porez po odbitku (%)-skriveno' može da ima do 2 decimale",
            min: "Polje 'Porez po odbitku (%)-skriveno' ne može da bude manje od 0!",
            max: "Polje 'Porez po odbitku (%)-skriveno' može da bude broj do 999.99!"
          }
        },
        errorElement: "span",
        errorPlacement: function ( error, element ) {
          error.addClass( "text-danger h5" );
          error.insertAfter( element );
        },
        highlight: function ( element, errorClass, validClass ) {
          $( element ).parents( ".form-group" ).addClass( "text-danger" );
          $( element ).addClass( "alert-border" );
        },
        unhighlight: function (element, errorClass, validClass) {
          $( element ).parents( ".form-group" ).removeClass( "text-danger" );
          $( element ).removeClass( "alert-border" );
        }
    } );

}); 
