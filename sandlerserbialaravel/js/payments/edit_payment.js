$( document ).ready( function () {

    $( function() {
      $("#format_pay_date").datepicker({
          beforeShow: function (textbox, instance) {
              instance.dpDiv.css({
                  position: 'relative',
                  margin: '-70px 0 0 0 '
              });
          },
          minDate: 0,
          changeYear: true,
          changeMonth: true,
          defaultDate: '-1w',
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
          altField: "#pay_date",
          altFormat: "yy-mm-dd"
      });  
    });

    $( "#form" ).validate( {
        rules: {
          value_euro: {
            required: true,
            number: true,
            step: 0.01,
            min: 0,
            max: 99999999.99
          },
          format_pay_date: {
            required: true,
            regex: /^\d{1,2}\.\d{1,2}\.\d{4}.$/,
            afterAndToday: pay_date
          },
          pay_date: {
            required: true,
            regex: /^\d{4}-\d{1,2}-\d{1,2}.$/,
             afterAndToday: pay_date
          },
          pay_date_desc: {
            required: true,
            maxlength: 255,
            normalizer: function( value ) {
              return $.trim( value );
            }
          }
        },
        messages: {
          value_euro: {
            required: "Polje 'Vrednost' je obavezno!",
            number: "Polje 'Vrednost' može da bude samo decimalni broj!",
            step: "Polje 'Vrednost' može da ima do 2 decimale",
            min: "Polje 'Vrednost' ne može da bude manje od 0!",
            max: "Polje 'Vrednost' može da bude broj do 99999999.99!"
          },
          format_pay_date: {
            required: "Polje 'Datum plaćanja' je obavezno!",
            regex: "Polje 'Datum plaćanja' nije u ispravnom formatu!",
            afterAndToday: "Polje 'Datum plaćanja' ne može da bude pre današnjeg datuma!"
          },
          pay_date: {
            required: "Polje 'Datum plaćanja-skriveno' je obavezno!",
            regex: "Polje 'Datum plaćanja-skriveno' nije u ispravnom formatu!",
            afterAndToday: "Polje 'Datum plaćanja-skriveno' ne može da bude pre današnjeg datuma!"
          },
          pay_date_desc: {
            required: "Polje 'Opis' je obavezno!",
            maxlength: "Polje 'Pozicija' može da ima najviše 255 karaktera!"
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
