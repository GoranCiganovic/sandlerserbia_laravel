$( document ).ready( function () {

    $( "#form" ).validate( {
        rules: {
          email: {
            required: true,
            email: true,
            maxlength: 255
          }
        },
        messages: {
          email: {
            required: "E-Mail Address is required!",
            email: "Invalid E-Mail Address!",
            maxlength: "E-Mail Address is too long!"
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