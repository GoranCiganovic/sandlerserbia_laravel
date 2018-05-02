$( document ).ready( function () {

      $( "#form" ).validate( {
        rules: {
          name: {
            required: true,
            regex: /^[a-zA-ZŽžĐđŠšČčĆć," "]+$/,
            minlength: 2,
            maxlength: 255,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          email: {
            required: true,
            email: true,
            maxlength: 255
          },
          password: {
            required: true,
            minlength: 6,
            maxlength: 255,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          password_confirmation: {
            required: true,
            equalTo: "#password",
            minlength: 6,
            maxlength: 255,
            normalizer: function( value ) {
              return $.trim( value );
            }
          }
        },
        messages: {
          name: {
            required: "Name is required!",
            regex: "Invalid Name!",
            minlength: "Name is too short!",
            maxlength: "Name is too long!"
          },
          email: {
            required: "E-Mail Address is required!",
            email: "Invalid E-Mail Address!",
            maxlength: "E-Mail Address is too long!"
          },
          password: {
            required: "Password is required!",
            minlength: "Password is too short!",
            maxlength: "Password is too long!"
          },
          password_confirmation: {
            required: "Confirm Password is required!",
            equalTo: "Invalid Confirm Password!",
            minlength: "Confirm Password is too short!",
            maxlength: "Confirm Password is too long!"
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
