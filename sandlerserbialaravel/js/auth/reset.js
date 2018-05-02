$( document ).ready( function () {

      $( "#form" ).validate( {
        rules: {
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
          email: {
            required: "Polje 'Email Adresa' je obavezno!",
            email: "Neispravan unos polja 'Email adresa'!",
            maxlength: "Polje 'Email adresa' može imati najviše 255 karaktera!"
          },
          password: {
            required: "Polje 'Lozinka' je obavezno!",
            minlength: "Polje 'Lozinka' mora da ima najmanje 6 karaktera!",
            maxlength: "Polje 'Lozinka' može da ima najviše 255 karaktera!"
          },
          password_confirmation: {
            required: "Polje 'Potvrdi lozinku' je obavezno!",
            equalTo: "Polje 'Potvrdi lozinku' se ne poklapa sa poljem 'Lozinka'!",
            minlength: "Polje 'Potvrdi lozinku' mora da ima najmanje 6 karaktera!",
            maxlength: "Polje 'Potvrdi lozinku' može da ima najviše 255 karaktera!"
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