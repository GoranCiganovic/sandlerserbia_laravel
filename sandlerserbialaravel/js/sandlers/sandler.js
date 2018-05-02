$(document).ready(function(){

    $("#middle_ex_dollar").on("input", function(){  
        var invoice_din = $('#invoice_din').val();
        var sandler_percent = $('#sandler_percent').val();
        var ppo = $('#ppo').val();
        var middle_ex_dollar = $('#middle_ex_dollar').val();

        var invoice_dollar = round_number(invoice_din/middle_ex_dollar);
        var sandler_dollar = round_number((invoice_dollar*sandler_percent)/100);
        var sandler_din = round_number((invoice_din*sandler_percent)/100);
        var ppo_din = round_number((sandler_din*ppo)/100);
        
        $('#sandler_dollar').val(sandler_dollar);
        $('#sandler_din').val(sandler_din);
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
          sandler_din: {
            required: true,
            number: true,
            step: 0.01,
            min: 0,
            max: 99999999.99
          },
          sandler_dollar: {
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
          invoice_din: {
            required: true,
            number: true,
            step: 0.01,
            min: 0,
            max: 99999999.99
          },
          sandler_percent: {
            required: true,
            number: true,
            step: 0.01,
            min: 0,
            max: 999.99
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
          sandler_din: {
            required: "Polje 'Sandler (RSD)' je obavezno!",
            number: "Polje 'Sandler (RSD)' može da bude samo decimalni broj!",
            step: "Polje 'Sandler (RSD)' može da ima do 2 decimale",
            min: "Polje 'Sandler (RSD)' ne može da bude manje od 0!",
            max: "Polje 'Sandler (RSD)' može da bude broj do 99999999.99!"
          },
          sandler_dollar: {
            required: "Polje 'Sandler (USD)' je obavezno!",
            number: "Polje 'Sandler (USD)' može da bude samo decimalni broj!",
            step: "Polje 'Sandler (USD)' može da ima do 2 decimale",
            min: "Polje 'Sandler (USD)' ne može da bude manje od 0!",
            max: "Polje 'Sandler (USD)' može da bude broj do 99999999.99!"
          },
          ppo_din: {
            required: "Polje 'Porez po odbitku (RSD)' je obavezno!",
            number: "Polje 'Porez po odbitku (RSD)' može da bude samo decimalni broj!",
            step: "Polje 'Porez po odbitku (RSD)' može da ima do 2 decimale",
            min: "Polje 'Porez po odbitku (RSD)' ne može da bude manje od 0!",
            max: "Polje 'Porez po odbitku (RSD)' može da bude broj do 99999999.99!"
          },
          invoice_din: {
            required: "Polje 'Vrednost u dinarima-skriveno' je obavezno!",
            number: "Polje 'Vrednost u dinarima-skriveno' može da bude samo decimalni broj!",
            step: "Polje 'Vrednost u dinarima-skriveno' može da ima do 2 decimale",
            min: "Polje 'Vrednost u dinarima-skriveno' ne može da bude manje od 0!",
            max: "Polje 'Vrednost u dinarima-skriveno' može da bude broj do 99999999.99!"
          },
          sandler_percent: {
            required: "Polje 'Sandler procenat-skriveno' je obavezno!",
            number: "Polje 'Sandler procenat-skriveno' može da bude samo decimalni broj!",
            step: "Polje 'Sandler procenat-skriveno' može da ima do 2 decimale",
            min: "Polje 'Sandler procenat-skriveno' ne može da bude manje od 0!",
            max: "Polje 'Sandler procenat-skriveno' može da bude broj do 999.99!"
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
 