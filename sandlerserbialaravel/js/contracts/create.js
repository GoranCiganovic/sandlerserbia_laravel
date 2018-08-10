$( document ).ready( function () {

    $( function() {

      var dateFormat = "dd.mm.yy.",
      contract_date = $("#format_contract_date").datepicker({

          beforeShow: function (textbox, instance) {
              instance.dpDiv.css({
                  position: 'relative',
                  margin: '-70px 0 0 0 '
              });
          },
          changeYear: true,
          changeMonth: true,
          defaultDate: '-1w',
          numberOfMonths: 1,
          dateFormat: dateFormat,
          dayNames: dayNames,
          dayNamesMin: dayNamesMin,
          dayNamesShort: dayNamesShort,
          monthNames: monthNames,
          monthNamesShort: monthNamesShort,
          duration: "slow",
          autoSize: true,
          gotoCurrent: true,
          hideIfNoPrevNext: true,
          altField: "#contract_date",
          altFormat: "yy-mm-dd",
          minDate: '0'
      })  
      .on( "change", function() { 
          var selectedDate = $(this).datepicker('getDate', '+1d');
          if(selectedDate){
             selectedDate.setDate(selectedDate.getDate());
             start_date.datepicker( "option", "minDate", selectedDate);
             start_date.datepicker( "option", "maxDate", null);
             end_date.datepicker( "option", "minDate", selectedDate);
          }else{
             start_date.datepicker( "option", "minDate", '0');
             end_date.datepicker( "option", "minDate", '0');
          }
          
        
      }),

      start_date = $("#format_start_date").datepicker({

          beforeShow: function (textbox, instance) {
              instance.dpDiv.css({
                  position: 'relative',
                  margin: '-70px 0 0 0 '
              });
          },
          changeYear: true,
          changeMonth: true,
          defaultDate: "-1w",
          numberOfMonths: 1,
          dateFormat: dateFormat,
          dayNames: dayNames,
          dayNamesMin: dayNamesMin,
          dayNamesShort: dayNamesShort,
          monthNames: monthNames,
          monthNamesShort: monthNamesShort,
          duration: "slow",
          autoSize: true,
          gotoCurrent: true,
          hideIfNoPrevNext: true,
          altField: "#start_date",
          altFormat: "yy-mm-dd",
          minDate: '0'
      })
      .on( "change", function() { 

          var endMinDate = $(this).datepicker('getDate', '+1d');
          if(endMinDate){
            endMinDate.setDate(endMinDate.getDate());
            end_date.datepicker( "option", "minDate", endMinDate);
          }else{
            end_date.datepicker( "option", "minDate", '0');
          }

      }),

      end_date = $("#format_end_date").datepicker({

          beforeShow: function (textbox, instance) {
              instance.dpDiv.css({
                  position: 'relative',
                  margin: '-70px 0 0 0 '
              });
          },
          changeYear: true,
          changeMonth: true,
          defaultDate: "-1w",
          numberOfMonths: 1,
          dateFormat: dateFormat,
          dayNames: dayNames,
          dayNamesMin: dayNamesMin,
          dayNamesShort: dayNamesShort,
          monthNames: monthNames,
          monthNamesShort: monthNamesShort,
          duration: "slow",
          autoSize: true,
          gotoCurrent: true,
          hideIfNoPrevNext: true,
          altField: "#end_date",
          altFormat: "yy-mm-dd",
          minDate: '0'
      })
      .on( "change", function() {
     
          var startMaxDate = $(this).datepicker('getDate', '+1d');
          if(startMaxDate){
              startMaxDate.setDate(startMaxDate.getDate());
              start_date.datepicker( "option", "maxDate", startMaxDate);
          }else{
              start_date.datepicker( "option", "maxDate", getDate( this )); 
          }

      });

      function getDate( element ) {
          var date;
          try {
            date = $.datepicker.parseDate( dateFormat, element.value );
          } catch( error ) {
            date = null;
          }
          return date;
      }

    });



    $( "#form" ).validate( {
        rules: {
          value: {
            required: true,
            number: true,
            step: 0.01,
            min: 0,
            max: 99999999.99,
            greaterOrEqualThan: advance
          },
          value_letters: {
            required: true, 
            regex: /^[a-zA-ZŽžĐđŠšČčĆć\s\.\'-]+$/,
            maxlength: 255,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          advance: {
            required: true,
            number: true,
            step: 0.01,
            min: 0,
            max: 99999999.99,
            lessOrEqualThan: value,
            advance_zero: [payments,value]
          },
          payments: {
            required: true,
            digits: true,
            number: true,
            min: 0,
            max: 9999,
            payments_zero: advance
          },
          participants: {
            required: true,
            digits: true,
            number: true,
            min: 0,
            max: 9999
          },
          format_contract_date: {
            required: true,
            regex: /^\d{1,2}\.\d{1,2}\.\d{4}.$/,
            afterAndToday: contract_date
          },
          contract_date: {
            required: true,
            regex: /^\d{4}-\d{1,2}-\d{1,2}.$/,
            afterAndToday: contract_date
          },
          format_start_date: {
            regex: /^\d{1,2}\.\d{1,2}\.\d{4}.$/,
            afterAndToday: start_date
          },
          start_date: {
            regex: /^\d{4}-\d{1,2}-\d{1,2}.$/,
            afterAndToday: start_date
          },
          format_end_date: {
            regex: /^\d{1,2}\.\d{1,2}\.\d{4}.$/,
            afterAndToday: end_date
          },
          end_date: {
            regex: /^\d{4}-\d{1,2}-\d{1,2}.$/,
            afterAndToday: end_date
          },
          event_place: {
            maxlength: 255,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          classes_number: {
            maxlength: 255,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          work_dynamics: {
            maxlength: 255,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          event_time: {
            maxlength: 255,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          description: {
            maxlength: 5000,
            normalizer: function( value ) {
              return $.trim( value );
            }
          }
        },
        messages: {
          value: {
            required: "Polje 'Vrednost Ugovora (EUR)' je obavezno!",
            number: "Polje 'Vrednost Ugovora (EUR)' može da bude samo decimalni broj!",
            step: "Polje 'Vrednost Ugovora (EUR)' može da ima do 2 decimale",
            min: "Polje 'Vrednost Ugovora (EUR)' ne može da bude manje od 0!",
            max: "Polje 'Vrednost Ugovora (EUR)' može da bude broj do 99999999,99!",
            greaterOrEqualThan: "Polje 'Vrednost Ugovora (EUR)' ne može da bude manje od polja ''Avans (EUR)'!"
          },
          value_letters: {
            required: "Polje 'Vrednost Ugovora slovima' je obavezno!",
            regex: "Polje 'Vrednost Ugovora slovima' može da ima samo slova, razmake, srednje crte, tačke i apostrofe!",
            maxlength: "Polje 'Vrednost Ugovora slovima' može da ima najviše 255 karaktera!"
          },
          advance: {
            required: "Polje 'Avans (EUR)' je obavezno!",
            number: "Polje 'Avans (EUR)' može da bude samo decimalni broj!",
            step: "Polje 'Avans (EUR)' može da ima do 2 decimale",
            min: "Polje 'Avans (EUR)' ne može da bude manje od 0!",
            max: "Polje 'Avans (EUR)' može da bude broj do 99999999,99!",
            lessOrEqualThan: "Polje 'Avans (EUR)' ne može da bude veće od polja 'Vrednost Ugovora (EUR)'!",
            advance_zero: "Polje 'Avans (EUR)' mora imati vrednost polja 'Vrednost Ugovora (EUR)'' ako polje 'Broj rata' ima vrednost 0"
          },
          payments: {
            required: "Polje 'Broj rata' je obavezno!",
            digits: "Polje 'Broj rata' može da bude samo ceo broj!",
            number: "Polje 'Broj rata' može da bude samo broj!",
            min: "Polje 'Broj rata' ne može da bude manje od 0!",
            max: "Polje 'Broj rata' može da bude broj do 9999!",
            payments_zero: "Polje 'Broj rata' mora biti veće od 0 ako polje 'Avans (EUR)' ima vrednost 0"
           
          },
          participants: {
            required: "Polje 'Broj učesnika' je obavezno!",
            digits: "Polje 'Broj učesnika' može da bude samo ceo broj!",
            number: "Polje 'Broj učesnika' može da bude samo broj!",
            min: "Polje 'Broj učesnika' ne može da bude manje od 0!",
            max: "Polje 'Broj učesnika' može da bude broj do 9999!"
          },
          format_contract_date: {
            required: "Polje 'Datum Ugovora' je obavezno!",
            regex: "Polje 'Datum Ugovora' nije u ispravnom formatu!",
            afterAndToday: "Polje 'Datum Ugovora' ne može da bude pre današnjeg datuma!"
          },
          contract_date: {
            required: "Polje 'Datum Ugovora-skriveno' je obavezno!",
            regex: "Polje 'Datum Ugovora-skriveno' nije u ispravnom formatu!",
            afterAndToday: "Polje 'Datum Ugovora-skriveno' je neispravno!"
          },
          format_start_date: {
            required: "Polje 'Datum početka' je obavezno!",
            regex: "Polje 'Datum početka' nije u ispravnom formatu!",
            afterAndToday: "Polje 'Datum početka' ne može da bude pre današnjeg datuma!"
          },
          start_date: {
            required: "Polje 'Datum početka-skriveno' je obavezno!",
            regex: "Polje 'Datum početka-skriveno' nije u ispravnom formatu!",
            afterAndToday: "Polje 'Datum početka-skriveno' je neispravno!"
          },
          format_end_date: {
            required: "Polje 'Datum završetka' je obavezno!",
            regex: "Polje 'Datum završetka' nije u ispravnom formatu!",
            afterAndToday: "Polje 'Datum završetka' ne može da bude pre današnjeg datuma!"
          },
          end_date: {
            required: "Polje 'Datum završetka-skriveno' je obavezno!",
            regex: "Polje 'Datum završetka-skriveno' nije u ispravnom formatu!",
            afterAndToday: "Polje 'Datum završetka-skriveno' je neispravno!"
          },
          event_place: {
            maxlength: "Polje 'Mesto održavanja' može da ima najviše 255 cifara!"
          },
          classes_number: {
            maxlength: "Polje 'Broj časova' može da ima najviše 255 karaktera!"
          },
          work_dynamics: {
            maxlength: "Polje 'Dinamika rada' može da ima najviše 255 karaktera!"
          },
          event_time: {
            maxlength: "Polje 'Vreme održavanja' može da ima najviše 255 karaktera!"
          },
          description: {
            maxlength: "Polje 'Opis Ugovora' može da ima najviše 5000 karaktera!"
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









