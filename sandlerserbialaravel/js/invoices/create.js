$(document).ready(function(){

    $("input").on("input", function(){  
        var euro = $('#value_euro').val();
        var exchange = $('#exchange_euro').val();
        var value_din = round_number(euro*exchange);
        var pdv = $('#pdv').val();
        var pdv_din = round_number((value_din/100)*pdv);
        var value_din_tax = round_number(value_din+pdv_din);
        $('#value_din').val(value_din);
        $('.value_din').text(value_din);
        $('#pdv_din').val(pdv_din);
        $('.pdv_din').text(pdv_din);
        $('#value_din_tax').val(value_din_tax);
        $('.value_din_tax').text(value_din_tax);

    }); 

    $( function() {

      var contract_date = $("#contract_date").val();
      contract_date = $.datepicker.formatDate('dd.mm.yy.', new Date(contract_date));

        $("#format_issue_date").datepicker({

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
            altField: "#issue_date",
            altFormat: "yy-mm-dd",
            minDate: contract_date
        });

        $("#format_traffic_date").datepicker({

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
            altField: "#traffic_date",
            altFormat: "yy-mm-dd",
            minDate: contract_date
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
          exchange_euro: {
            required: true,
            number: true,
            step: 0.0001,
            min: 0,
            max: 99999999.99
          },
          value_din: {
            required: true,
            number: true,
            step: 0.01,
            min: 0,
            max: 99999999.99
          },
          pdv: {
            required: true,
            number: true,
            step: 0.01,
            min: 0,
            max: 999.99
          },
          pdv_din: {
            required: true,
            number: true,
            step: 0.01,
            min: 0,
            max: 99999999.99
          },
          value_din_tax: {
            required: true,
            number: true,
            step: 0.01,
            min: 0,
            max: 99999999.99
          },
          format_issue_date: {
            required: true,
            regex: /^\d{1,2}\.\d{1,2}\.\d{4}.$/,
            afterDate: [contract_date, issue_date]
          },
          issue_date: {
            required: true,
            regex: /^\d{4}-\d{1,2}-\d{1,2}.$/,
            afterDate: [contract_date, issue_date]
          },
          format_traffic_date: {
            required: true,
            regex: /^\d{1,2}\.\d{1,2}\.\d{4}.$/,
            afterDate: [contract_date, traffic_date]
          },
          traffic_date: {
            required: true,
            regex: /^\d{4}-\d{1,2}-\d{1,2}.$/,
            afterDate: [contract_date, traffic_date]
          },
          description: {
            required: true,
            maxlength: 255,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          note: {
            required: true,
            maxlength: 255,
            normalizer: function( value ) {
              return $.trim( value );
            }
          },
          contract_date: {
            required: true,
            regex: /^\d{4}-\d{1,2}-\d{1,2}.$/
          }
        },
        messages: {
          value_euro: {
            required: "Polje 'Vrednost u evrima' je obavezno!",
            number: "Polje 'Vrednost u evrima' može da bude samo decimalni broj!",
            step: "Polje 'Vrednost u evrima' može da ima do 2 decimale",
            min: "Polje 'Vrednost u evrima' ne može da bude manje od 0!",
            max: "Polje 'Vrednost u evrima' može da bude broj do 99999999.99!"
          },
          exchange_euro: {
            required: "Polje 'Srednji kurs evra' je obavezno!",
            number: "Polje 'Srednji kurs evra' može da bude samo decimalni broj!",
            step: "Polje 'Srednji kurs evra' može da ima do 4 decimale",
            min: "Polje 'Srednji kurs evra' ne može da bude manje od 0!",
            max: "Polje 'Srednji kurs evra' može da bude broj do 99999999.99!"
          },
          value_din: {
            required: "Polje 'Vrednost u dinarima' je obavezno!",
            number: "Polje 'Vrednost u dinarima' može da bude samo decimalni broj!",
            step: "Polje 'Vrednost u dinarima' može da ima do 2 decimale",
            min: "Polje 'Vrednost u dinarima' ne može da bude manje od 0!",
            max: "Polje 'Vrednost u dinarima' može da bude broj do 99999999.99!"
          },
          pdv: {
            required: "Polje 'PDV' je obavezno!",
            number: "Polje 'PDV' može da bude samo decimalni broj!",
            step: "Polje 'PDV' može da ima do 2 decimale",
            min: "Polje 'PDV' ne može da bude manje od 0!",
            max: "Polje 'PDV' može da bude broj do 999.99!"
          },
          pdv_din: {
            required: "Polje 'PDV u dinarima' je obavezno!",
            number: "Polje 'PDV u dinarima' može da bude samo decimalni broj!",
            step: "Polje 'PDV u dinarima' može da ima do 2 decimale",
            min: "Polje 'PDV u dinarima' ne može da bude manje od 0!",
            max: "Polje 'PDV u dinarima' može da bude broj do 99999999.99!"
          },
          value_din_tax: {
            required: "Polje 'Vrednost u dinarima sa pdv-om' je obavezno!",
            number: "Polje 'Vrednost u dinarima sa pdv-om' može da bude samo decimalni broj!",
            step: "Polje 'Vrednost u dinarima sa pdv-om' može da ima do 2 decimale",
            min: "Polje 'Vrednost u dinarima sa pdv-om' ne može da bude manje od 0!",
            max: "Polje 'Vrednost u dinarima sa pdv-om' može da bude broj do 99999999.99!"
          },
          format_issue_date: {
            required: "Polje 'Datum izdavanja' je obavezno!",
            regex: "Polje 'Datum izdavanja' nije u ispravnom formatu!",
            afterDate: "Polje 'Datum izdavanja' ne može da bude pre datuma Ugovora!"
          },
          issue_date: {
            required: "Polje 'Datum izdavanja-skriveno' je obavezno!",
            regex: "Polje 'Datum izdavanja-skriveno' nije u ispravnom formatu!",
            afterDate: "Polje 'Datum izdavanja-skriveno' ne može da bude pre datuma Ugovora!"
          },
          format_traffic_date: {
            required: "Polje 'Datum prometa' je obavezno!",
            regex: "Polje 'Datum prometa' nije u ispravnom formatu!",
            afterDate: "Polje 'Datum prometa' ne može da bude pre datuma Ugovora!"
          },
          traffic_date: {
            required: "Polje 'Datum prometa-skriveno' je obavezno!",
            regex: "Polje 'Datum prometa-skriveno' nije u ispravnom formatu!",
            afterDate: "Polje 'Datum prometa-skriveno' ne može da bude pre datuma Ugovora!"
          },
          description: {
            required: "Polje 'Opis usluge' je obavezno!",
            maxlength: "Polje 'Opis usluge' može da ima najviše 255 karaktera!"
          },         
          note: {
            required: "Polje 'Napomena' je obavezno!",
            maxlength: "Polje 'Napomena' može da ima najviše 255 karaktera!"
          },
          contract_date: {
            required: "Polje 'Datum Ugovora-skriveno' je obavezno!",
            regex: "Polje 'Datum Ugovora-skriveno' nije u ispravnom formatu!"
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





 