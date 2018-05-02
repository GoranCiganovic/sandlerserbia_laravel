$( document ).ready( function () {

    $( function() {
      $("#format_dd_date").datepicker({
          beforeShow: function (textbox, instance) {
              instance.dpDiv.css({
                  position: 'relative',
                  margin: '-70px 0 0 0 '
              });
          },
          minDate: new Date(2017, 1 - 1, 1),
          maxDate: '0',
          changeYear: true,
          changeMonth: true,
          defaultDate: 0,
          numberOfMonths: 1,
          dateFormat: "dd.mm.yy.",
          dayNames: dayNames,
          dayNamesMin: dayNamesMin,
          dayNamesShort: dayNamesShort,
          monthNames: monthNames,
          monthNamesShort: monthNamesShort,
          duration: "slow",
          autoSize: true,
          gotoCurrent: true,
          hideIfNoPrevNext: true,
          altField: "#dd_date",
          altFormat: "yy-mm-dd"
      });  
    });

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
          },
          format_dd_date: {
            regex: /^\d{1,2}\.\d{1,2}\.\d{4}.$/,
            beforeAndToday: dd_date
          },
          dd_date: {
            regex: /^\d{4}-\d{1,2}-\d{1,2}.$/,
            beforeAndToday: dd_date
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
          },
          format_dd_date: {
            regex: "Polje 'Datum Datum izrade DISC/Devine' nije u ispravnom formatu!",
            beforeAndToday: "Polje 'Datum izrade DISC/Devine' ne može da bude posle današnjeg datuma!"
          },
          dd_date: {
            regex: "Polje 'Datum izrade DISC/Devine-skriveno' nije u ispravnom formatu!",
            beforeAndToday: "Polje 'Datum izrade DISC/Devine-skriveno' ne može da bude posle današnjeg datuma!"
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



 