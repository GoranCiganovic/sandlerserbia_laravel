$( document ).ready( function () {

      $( "#form" ).validate( {
        rules: {
          sandler: {
            required: true,
            number: true,
            step: 0.01,
            min: 0,
            max: 999.99
          },
          sandler_paying_day: {
            required: true,
            digits: true,
            number: true,
            range: [1, 31]
          }
        },
        messages: {
          sandler: {
            required: "Polje 'Sandler (procenat)' je obavezno!",
            number: "Polje 'Sandler (procenat)' može da bude samo decimalni broj!",
            step: "Polje 'Sandler (procenat)' može da ima do 2 decimale",
            min: "Polje 'Sandler (procenat)' ne može da bude manje od 0!",
            max: "Polje 'Sandler (procenat)' može da bude broj do 999.99!"
          },
          sandler_paying_day: {
            required: "Polje 'Dan plaćanja u mesecu' je obavezno!",
            digits: "Polje 'Dan plaćanja u mesecu' može da bude samo ceo broj!",
            number: "Polje 'Dan plaćanja u mesecu' može da bude samo broj!",
            range: "Polje 'Dan plaćanja u mesecu' može da bude između broj između 1 i 31!"
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
