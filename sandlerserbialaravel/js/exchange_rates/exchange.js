$(document).ready(function(){

    $( "#form" ).validate( {
        rules: {
          exchange_value: {
            required: true,
            number: true,
            step: 0.0001,
            min: 0,
            max: 99999999.99
          }
        },
        messages: {
          exchange_value: {
            required: "Polje 'Srednji kurs (RSD)' je obavezno!",
            number: "Polje 'Srednji kurs (RSD)' može da bude samo decimalni broj!",
            step: "Polje 'Srednji kurs (RSD)' može da ima do 4 decimale",
            min: "Polje 'Srednji kurs (RSD)' ne može da bude manje od 0!",
            max: "Polje 'Srednji kurs (RSD)' može da bude broj do 99999999.99!"
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

