$( document ).ready( function () {

      $( "#form" ).validate( {
        rules: {
          disc: {
            required: true,
            number: true,
            step: 0.01,
            min: 0,
            max: 9999.99
          },
          devine: {
            required: true,
            number: true,
            step: 0.01,
            min: 0,
            max: 9999.99
          },
          dd_paying_day: {
            required: true,
            digits: true,
            number: true,
            range: [1, 31]
          }
        },
        messages: {
          disc: {
            required: "Polje 'DISC iznos u dolarima' je obavezno!",
            number: "Polje 'DISC iznos u dolarima' može da bude samo decimalni broj!",
            step: "Polje 'DISC iznos u dolarima' može da ima do 2 decimale",
            min: "Polje 'DISC iznos u dolarima' ne može da bude manje od 0!",
            max: "Polje 'DISC iznos u dolarima' može da bude broj do 9999.99!"
          },
          devine: {
            required: "Polje 'Devine iznos u dolarima' je obavezno!",
            number: "Polje 'Devine iznos u dolarima' može da bude samo decimalni broj!",
            step: "Polje 'Devine iznos u dolarima' može da ima do 2 decimale",
            min: "Polje 'Devine iznos u dolarima' ne može da bude manje od 0!",
            max: "Polje 'Devine iznos u dolarima' može da bude broj do 9999.99!"
          },
          dd_paying_day: {
            required: "Polje 'Dan plaćanja u mesecu' je obavezno!",
            digits: "Polje 'Dan plaćanja u mesecu' može da bude samo ceo broj!",
            number: "Polje 'Dan plaćanja u mesecu' može da bude samo broj!",
            range: "Polje 'Dan plaćanja u mesecu' bude između broj između 1 i 31!"
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


