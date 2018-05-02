$( document ).ready( function () {

      $( "#form" ).validate( {
        rules: {
          pdv: {
            required: true,
            number: true,
            step: 0.01,
            min: 0,
            max: 999.99
          },
          pdv_paying_day: {
            required: true,
            digits: true,
            number: true,
            range: [1, 31]
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
          pdv: {
            required: "Polje 'PDV (procenat)' je obavezno!",
            number: "Polje 'PDV (procenat)' može da bude samo decimalni broj!",
            step: "Polje 'PDV (procenat)' može da ima do 2 decimale",
            min: "Polje 'PDV (procenat)' ne može da bude manje od 0!",
            max: "Polje 'PDV (procenat)' može da bude broj do 999.99!"
          },
          pdv_paying_day: {
            required: "Polje 'Dan plaćanja PDV-a u mesecu' je obavezno!",
            digits: "Polje 'Dan plaćanja PDV-a u mesecu' može da bude samo ceo broj!",
            number: "Polje 'Dan plaćanja PDV-a u mesecu' može da bude samo broj!",
            range: "Polje 'Dan plaćanja PDV-a u mesecu' može da bude između broj između 1 i 31!"
          },
          ppo: {
            required: "Polje 'Porez po odbitku (procenat)' je obavezno!",
            number: "Polje 'Porez po odbitku (procenat)' može da bude samo decimalni broj!",
            step: "Polje 'Porez po odbitku (procenat)' može da ima do 2 decimale",
            min: "Polje 'Porez po odbitku (procenat)' ne može da bude manje od 0!",
            max: "Polje 'Porez po odbitku (procenat)' može da bude broj do 999.99!"
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

} );


