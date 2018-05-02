$(document).ready(function(){

    $( function() {

      $("#format_meeting_date").datetimepicker({

          beforeShow: function (textbox, instance) {
              instance.dpDiv.css({
                  position: 'relative',
                  margin: '-70px 0 0 0 '
              });
          },
          changeYear: true,
          changeMonth: true,
          dayNames: dayNames,
          dayNamesMin: dayNamesMin,
          dayNamesShort: dayNamesShort,
          monthNames: monthNames,
          monthNamesShort: monthNamesShort,
          duration: "slow",
          dateFormat: "dd.mm.yy.",
          altField: "#meeting_date",
          altFormat: "yy-mm-dd",
          gotoCurrent: true,
          hideIfNoPrevNext: true,
          currentText: 'Trenutno vreme',
          closeText: "Unesi",
          timeFormat: 'HH:mm',
          timeText: 'Vreme',
          hourText: 'Sat',
          minuteText: 'Minut',
          altFieldTimeOnly: false,
          altTimeFormat: 'HH:mm',
          controlType: 'slider',//or select
          oneLine: true, //for controlType 'select'
          stepMinute: 5,
          hourMin: 6,
          hourMax: 22,
          minute: 0,
          hourGrid: 16,
          minuteGrid: 55,
          pickerTimeFormat: 'HH:mm TT',
          minDate: 0
      });

    });

    $( "#form" ).validate( {
        rules: {
          format_meeting_date: {
            required: true,
            regex: /^\d{1,2}\.\d{1,2}\.\d{4}.\s([01]?[0-9]|2[0-3]):[0-5][0-9]$/,
            afterAndToday: meeting_date
          },
          meeting_date: {
            required: true,
            regex: /^\d{4}-\d{1,2}-\d{1,2}.\s([01]?[0-9]|2[0-3]):[0-5][0-9]$/,
            afterAndToday: meeting_date
          }
        },
        messages: {
          format_meeting_date: {
            required: "Polje 'Datum sastanka' je obavezno!",
            regex: "Polje 'Datum sastanka' nije u ispravnom formatu!",
            afterAndToday: "Polje 'Datum sastanka' ne može da bude pre današnjeg datuma!"
          },
          meeting_date: {
            required: "Polje 'Datum sastanka-skriveno' je obavezno!",
            regex: "Polje 'Datum sastanka-skriveno' nije u ispravnom formatu!",
            afterAndToday: "Polje 'Datum sastanka-skriveno' ne može da bude pre današnjeg datuma!"
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



