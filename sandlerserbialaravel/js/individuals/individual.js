$( document ).ready( function () {

      $( "#form" ).validate( {
        rules: {
          first_name: {
            required: true,
            regex: /^[a-zA-ZŽžĐđŠšČčĆć\s\.\'-]+$/,
            minlength: 2,
            maxlength: 45,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          last_name: {
            required: true,
            regex: /^[a-zA-ZŽžĐđŠšČčĆć\s\.\'-]+$/,
            minlength: 2,
            maxlength: 45,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          phone: {
            required: true,
            regex: /(^[0-9+ ]+$)+/,
            minlength: 6,
            maxlength: 30
          },
          email: {
            email: true,
            maxlength: 150
          },
          jmbg: {
            digits: true,
            number: true,
            minlength: 13,
            maxlength: 45
          },
          id_card: {
            digits: true,
            number: true,
            minlength: 6,
            maxlength: 45
          },
          works_at: {
            maxlength: 45,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          address: {
            minlength: 2,
            maxlength: 150,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          county: {
            regex: /^[a-zA-ZŽžĐđŠšČčĆć\s\.\'-]+$/,
            minlength: 2,
            maxlength: 45,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          postal: {
            digits: true,
            number: true,
            minlength: 5,
            maxlength: 5
          },
          city: {
            regex: /^[a-zA-ZŽžĐđŠšČčĆć\s\.\'-]+$/,
            minlength: 2,
            maxlength: 45,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          comment: {
            maxlength: 5000,
            normalizer: function( value ) {
              return $.trim( value );
            }
          }
        },
        messages: {
          first_name: {
            required: "Polje 'Ime' je obavezno!",
            regex: "Polje 'Ime' može da ima samo slova, razmake, srednje crte, tačke i apostrofe!",
            minlength: "Polje 'Ime' mora da ima najmanje 2 karaktera!",
            maxlength: "Polje 'Ime' može da ima najviše 45 karaktera!"
          },
          last_name: {
            required: "Polje 'Prezime' je obavezno!",
            regex: "Polje 'Prezime' može da ima samo slova, razmake, srednje crte, tačke i apostrofe!",
            minlength: "Polje 'Prezime' mora da ima najmanje 2 karaktera!",
            maxlength: "Polje 'Prezime' može da ima najviše 45 karaktera!"
          },
          phone: {
            required: "Polje 'Telefon' je obavezno!",
            regex: "Polje 'Telefon' može da ima brojeve, znak + i razmake!",
            minlength: "Polje 'Telefon' mora da ima najmanje 6 karaktera!",
            maxlength: "Polje 'Telefon' može da ima najviše 30 karaktera!"
          },
          email: {
            email: "Neispravan unos polja 'Email adresa'!",
            maxlength: "Polje 'Email adresa' može imati najviše 150 karaktera!"
          },
          jmbg: {
            digits: "Polje 'JMBG' može da bude samo ceo broj!",
            number: "Polje 'JMBG' može da bude samo broj!",
            minlength: "Polje 'JMBG' mora da ima najmanje 13 cifara!",
            maxlength: "Polje 'JMBG' može da ima najviše 45 cifara!"
          },
          id_card: {
            digits: "Polje 'Broj lične karte' može da bude samo ceo broj!",
            number: "Polje 'Broj lične karte' može da bude samo broj!",
            minlength: "Polje 'Broj lične karte' mora da ima najmanje 6 cifara!",
            maxlength: "Polje 'Broj lične karte' može da ima najviše 45 cifara!"
          },
          works_at: {
            maxlength: "Polje 'Zaposlen u' može da ima najviše 45 karaktera!"
          },
          address: {
            minlength: "Polje 'Adresa' mora da ima najmanje 2 karaktera!",
            maxlength: "Polje 'Adresa' može da ima najviše 150 karaktera!"
          },
          county: {
            regex: "Polje 'Opština' može da ima samo slova, razmake, srednje crte, tačke i apostrofe!",
            minlength: "Polje 'Opština' mora da ima najmanje 2 karaktera!",
            maxlength: "Polje 'Opština' može da ima najviše 45 karaktera!"
          },
          postal: {
            digits: "Polje 'Poštanski broj' može da bude samo ceo broj!",
            number: "Polje 'Poštanski broj' može da bude samo broj!",
            minlength: "Polje 'Poštanski broj' mora da ima 5 cifara!",
            maxlength: "Polje 'Poštanski broj' mora da ima 5 cifara!"
          },
          city: {
            regex: "Polje 'Grad' može da ima samo slova, razmake, srednje crte, tačke i apostrofe!",
            minlength: "Polje 'Grad' mora da ima najmanje 2 karaktera!",
            maxlength: "Polje 'Grad' može da ima najviše 45 karaktera!"
          },
          comment: {
            maxlength: "Polje 'Komentar' može da ima najviše 5000 karaktera!"
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






