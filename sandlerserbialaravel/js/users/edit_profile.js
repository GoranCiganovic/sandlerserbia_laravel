$( document ).ready( function () {

      $( "#form" ).validate( {
        rules: {
          name: {
            required: true,
            regex: /^[a-zA-ZŽžĐđŠšČčĆć\s\.\'-]+$/,
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
          },
          phone: {
            regex: /(^[0-9+ ]+$)+/,
            minlength: 6,
            maxlength: 30
          }
        },
        messages: {
          name: {
            required: "Polje 'Ime' je obavezno!",
             regex: "Polje 'Ime' može da ima samo slova, razmake, srednje crte, tačke i apostrofe!",
            minlength: "Polje 'Ime' mora da ima najmanje 2 karaktera!",
            maxlength: "Polje 'Ime' može da ima najviše 255 karaktera!"
          },
          email: {
            required: "Polje 'Email adresa' je obavezno!",
            email: "Neispravan unos polja 'Email adresa'!",
            maxlength: "Polje 'Email adresa' može imati najviše 255 karaktera!"
          },
          password: {
            required: "Polje 'Lozinka' je obavezno!",
            minlength: "Polje 'Lozinka' mora da ima najmanje 6 karaktera!",
            maxlength: "Polje 'Lozinka' može da ima najviše 255 karaktera!"
          },
          password_confirmation: {
            required: "Polje 'Potvrda lozinke' je obavezno!",
            equalTo: "Polje 'Potvrda lozinke' se ne poklapa sa poljem 'Lozinka'!",
            minlength: "Polje 'Potvrda lozinke' mora da ima najmanje 6 karaktera!",
            maxlength: "Polje 'Potvrda lozinke' može da ima najviše 255 karaktera!"
          },
          phone: {
            regex: "Polje 'Telefon' može da ima brojeve, znak + i razmake!",
            minlength: "Polje 'Telefon' mora da ima najmanje 6 karaktera!",
            maxlength: "Polje 'Telefon' može da ima najviše 30 karaktera!"
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






