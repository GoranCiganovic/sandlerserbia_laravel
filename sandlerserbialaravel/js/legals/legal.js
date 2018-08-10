$( document ).ready( function () {

      $( "#form" ).validate( {
        rules: {
          long_name: {
            required: true,
            maxlength: 255,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          short_name: {
            maxlength: 100,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          ceo: {
            regex: /^[a-zA-ZŽžĐđŠšČčĆć\s\.\'-]+$/,
            minlength: 2,
            maxlength: 45,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          phone: {
            regex: /(^[0-9+ ]+$)+/,
            minlength: 6,
            maxlength: 30
          },
          email: {
            email: true,
            maxlength: 150
          },
          contact_person: {
            regex: /^[a-zA-ZŽžĐđŠšČčĆć\s\.\'-]+$/,
            minlength: 2,
            maxlength: 45,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          contact_person_phone: {
            regex: /(^[0-9+ ]+$)+/,
            minlength: 6,
            maxlength: 30
          },
          identification: {
            digits: true,
            number: true,
            minlength: 6,
            maxlength: 45
          },
          pib: {
            digits: true,
            number: true,
            minlength: 6,
            maxlength: 45
          },
          company_size_id: {
            digits: true,
            number: true,
            range: [0, 5]
          },
          activity: {
            maxlength: 255,
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
            maxlength: 5,
          },
          city: {
            regex: /^[a-zA-ZŽžĐđŠšČčĆć\s\.\'-]+$/,
            minlength: 2,
            maxlength: 45,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          website: {
            minlength: 4,
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
          long_name: {
            required: "Polje 'Naziv' je obavezno!",
            maxlength: "Polje 'Naziv' može da ima najviše 255 karaktera!"
          },
          short_name: {
            maxlength: "Polje 'Kraći naziv' može da ima najviše 100 karaktera!"
          },
          ceo: {
            regex: "Polje 'Direktor' može da ima samo slova, razmake, srednje crte, tačke i apostrofe!",
            minlength: "Polje 'Direktor' mora da ima najmanje 2 karaktera!",
            maxlength: "Polje 'Direktor' može da ima najviše 45 karaktera!"
          },
          phone: {
            regex: "Polje 'Telefon' može da ima brojeve, znak + i razmake!",
            minlength: "Polje 'Telefon' mora da ima najmanje 6 karaktera!",
            maxlength: "Polje 'Telefon' može da ima najviše 30 karaktera!"
          },
          email: {
            email: "Neispravan unos polja 'Email adresa'!",
            maxlength: "Polje 'Email adresa' može imati najviše 150 karaktera!"
          },
          contact_person: {
            regex: "Polje 'Lice za razgovor' može da ima samo slova, razmake, srednje crte, tačke i apostrofe!",
            minlength: "Polje 'Lice za razgovor' mora da ima najmanje 2 karaktera!",
            maxlength: "Polje 'Lice za razgovor' može da ima najviše 45 karaktera!"
          },
          contact_person_phone: {
            regex: "Polje 'Telefon lica za razgovor' može da ima brojeve, znak + i razmake!",
            minlength: "Polje 'Telefon lica za razgovor' mora da ima najmanje 6 karaktera!",
            maxlength: "Polje 'Telefon lica za razgovor' može da ima najviše 30 karaktera!"
          },
          identification: {
            digits: "Polje 'Matični broj firme' može da bude samo ceo broj!",
            number: "Polje 'Matični broj firme' može da bude samo broj!",
            minlength: "Polje 'Matični broj firme' mora da ima najmanje 6 cifara!",
            maxlength: "Polje 'Matični broj firme' može da ima najviše 45 cifara!"
          },
          pib: {
            digits: "Polje 'PIB' može da bude samo ceo broj!",
            number: "Polje 'PIB' može da bude samo broj!",
            minlength: "Polje 'PIB' mora da ima najmanje 6 cifara!",
            maxlength: "Polje 'PIB' može da ima najviše 45 cifara!"
          },
          company_size_id: {
            digits: "Polje 'Veličina' može da bude samo ceo broj!",
            number: "Polje 'Veličina' može da bude samo broj!",
            range: "Neispravan unos polja 'Veličina'!"
          },
          activity: {
            maxlength: "Polje 'Delatnost' može da ima najviše 255 karaktera!"
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
          website: {
            minlength: "Polje 'Website' mora da ima najmanje 4 karaktera!",
            maxlength: "Polje 'Website' može da ima najviše 45 karaktera!"
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






