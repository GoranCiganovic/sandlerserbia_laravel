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
          position: {
            minlength: 2,
            maxlength: 255,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          email: {
            email: true,
            maxlength: 255
          },
          phone: {
            regex: /(^[0-9+ ]+$)+/,
            minlength: 6,
            maxlength: 30
          }
        },
        messages: {
          name: {
            required: "Polje 'Ime i prezime' je obavezno!",
            regex: "Polje 'Ime i prezime' može da ima slova i razmake!",
            minlength: "Polje 'Ime i prezime' mora da ima najmanje 2 karaktera!",
            maxlength: "Polje 'Ime i prezime' može da ima najviše 255 karaktera!"
          },
          position: {
            minlength: "Polje 'Pozicija' mora da ima najmanje 2 karaktera!",
            maxlength: "Polje 'Pozicija' može da ima najviše 255 karaktera!"
          },
          email: {
            email: "Neispravan unos polja 'Email adresa'!",
            maxlength: "Polje 'Email adresa' može imati najviše 255 karaktera!"
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
    
} );



 