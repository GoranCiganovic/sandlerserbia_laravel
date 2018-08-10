$( document ).ready( function () {

      $( "#form" ).validate( {
        rules: {
          name: {
            required: true,
            maxlength: 150,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          representative: {
            required: true,
            regex: /^[a-zA-ZŽžĐđŠšČčĆć\s\.\'-]+$/,
            minlength: 2,
            maxlength: 150,
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
            required: true,
            email: true,
            maxlength: 150
          },
          website: {
            required: true,
            minlength: 4,
            maxlength: 45,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          address: {
            required: true,
            minlength: 2,
            maxlength: 150,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          county: {
            required: true,
            regex: /^[a-zA-ZŽžĐđŠšČčĆć\s\.\'-]+$/,
            minlength: 2,
            maxlength: 45,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          postal: {
            required: true,
            digits: true,
            number: true,
            minlength: 5,
            maxlength: 5
          },
          city: {
            required: true,
            regex: /^[a-zA-ZŽžĐđŠšČčĆć\s\.\'-]+$/,
            minlength: 2,
            maxlength: 45,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          bank: {
            required: true,
            maxlength: 45,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          account: {
            required: true,
            digits: true,
            number: true,
            minlength: 6,
            maxlength: 45
          },
          pib: {
            required: true,
            digits: true,
            number: true,
            minlength: 6,
            maxlength: 45
          },
          identification: {
            required: true,
            digits: true,
            number: true,
            minlength: 6,
            maxlength: 45
          }
        },
        messages: {
          name: {
            required: "Polje 'Naziv' je obavezno!",
            maxlength: "Polje 'Naziv' može da ima najviše 150 karaktera!"
          },
          representative: {
            required: "Polje 'Ovalšćeni zastupnik' je obavezno!",
            regex: "Polje 'Ovalšćeni zastupnik' može da ima samo slova, razmake, srednje crte, tačke i apostrofe!",
            minlength: "Polje 'Ovalšćeni zastupnik' mora da ima najmanje 2 karaktera!",
            maxlength: "Polje 'Ovalšćeni zastupnik' može da ima najviše 45 karaktera!"
          },
          phone: {
            required: "Polje 'Telefon' je obavezno!",
            regex: "Polje 'Telefon' može da ima brojeve, znak + i razmake!",
            minlength: "Polje 'Telefon' mora da ima najmanje 6 karaktera!",
            maxlength: "Polje 'Telefon' može da ima najviše 30 karaktera!"
          },
          email: {
            required: "Polje 'Email adresa' je obavezno!",
            email: "Neispravan unos polja 'Email adresa'!",
            maxlength: "Polje 'Email adresa' može imati najviše 150 karaktera!"
          },
          website: {
            required: "Polje 'Website' je obavezno!",
            minlength: "Polje 'Website' mora da ima najmanje 4 karaktera!",
            maxlength: "Polje 'Website' može da ima najviše 45 karaktera!"
          },
          address: {
            required: "Polje 'Sedište' je obavezno!",
            minlength: "Polje 'Sedište' mora da ima najmanje 2 karaktera!",
            maxlength: "Polje 'Sedište' može da ima najviše 150 karaktera!"
          },
          county: {
            required: "Polje 'Opština' je obavezno!",
            regex: "Polje 'Opština' može da ima samo slova, razmake, srednje crte, tačke i apostrofe!",
            minlength: "Polje 'Opština' mora da ima najmanje 2 karaktera!",
            maxlength: "Polje 'Opština' može da ima najviše 45 karaktera!"
          },
          postal: {
            required: "Polje 'Poštanski broj' je obavezno!",
            digits: "Polje 'Poštanski broj' može da bude samo ceo broj!",
            number: "Polje 'Poštanski broj' može da bude samo broj!",
            minlength: "Polje 'Poštanski broj' mora da ima 5 cifara!",
            maxlength: "Polje 'Poštanski broj' mora da ima 5 cifara!"
          },
          city: {
            required: "Polje 'Grad' je obavezno!",
            regex: "Polje 'Grad' može da ima samo slova, razmake, srednje crte, tačke i apostrofe!",
            minlength: "Polje 'Grad' mora da ima najmanje 2 karaktera!",
            maxlength: "Polje 'Grad' može da ima najviše 45 karaktera!"
          },
          bank: {
            required: "Polje 'Banka' je obavezno!",
            maxlength: "Polje 'Banka' može da ima najviše 45 karaktera!"
          },
          account: {
            required: "Polje 'Račun' je obavezno!",
            digits: "Polje 'Račun' može da bude samo ceo broj!",
            number: "Polje 'Račun' može da bude samo broj!",
            minlength: "Polje 'Račun' mora da ima najmanje 6 cifara!",
            maxlength: "Polje 'Račun' može da ima najviše 45 cifara!"
          },
          pib: {
            required: "Polje 'PIB' je obavezno!",
            digits: "Polje 'PIB' može da bude samo ceo broj!",
            number: "Polje 'PIB' može da bude samo broj!",
            minlength: "Polje 'PIB' mora da ima najmanje 6 cifara!",
            maxlength: "Polje 'PIB' može da ima najviše 45 cifara!"
          },
          identification: {
            required: "Polje 'Matični broj firme' je obavezno!",
            digits: "Polje 'Matični broj firme' može da bude samo ceo broj!",
            number: "Polje 'Matični broj firme' može da bude samo broj!",
            minlength: "Polje 'Matični broj firme' mora da ima najmanje 6 cifara!",
            maxlength: "Polje 'Matični broj firme' može da ima najviše 45 cifara!"
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






