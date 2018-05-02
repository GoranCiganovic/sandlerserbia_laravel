$( document ).ready( function () {

      $( "#form" ).validate( {
        rules: {
          description: {
            maxlength: 5000,
            normalizer: function( value ) {
              return $.trim( value );
            }
          }
        },
        messages: {
          description: {
            maxlength: "Polje 'Opis Ugovora' može da ima najviše 5000 karaktera!"
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






