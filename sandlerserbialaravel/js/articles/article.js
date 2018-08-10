
$( document ).ready( function () {

      $( "#form" ).validate( {
        rules: {
          title: {
            required: true,
            maxlength: 100,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          article: {
            required: true,
            maxlength: 10000,
            normalizer: function( value ) {
              return $.trim( value );
            }
          }
        },
        messages: {
          title: {
            required: "Polje 'Naziv' je obavezno!",
            maxlength: "Polje 'Naziv' može da ima najviše 100 karaktera!"
          },
          article: {
            required: "Polje 'Sadržaj' je obavezno!",
            maxlength: "Polje 'Sadržaj' može da ima najviše 10000 karaktera!"
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




