$(document).ready(function(){

  $( function() {
    var minFromDate = new Date(2017, 1 - 1, 1);
    var minToDate = new Date(2017, 1 - 1, 1);
    minToDate.setDate(minToDate.getDate() + 1);
    var dateFormat = "dd.mm.yy.",
    from = $( "#from" ).datepicker({
        beforeShow: function (textbox, instance) {
            instance.dpDiv.css({
                position: 'relative',
                margin: '-70px 0 0 0 '
            });
        },
        defaultDate: "0",
        changeYear: true,
        changeMonth: true,
        numberOfMonths: 1,
        minDate: minFromDate,
        maxDate:'-1',
        dateFormat: dateFormat,
        altField: "#checkFrom",
        altFormat: "yy-mm-dd",
        dayNames: dayNames,
        dayNamesMin: dayNamesMin,
        dayNamesShort: dayNamesShort,
        monthNames: monthNames,
        monthNamesShort: monthNamesShort,
        duration: "slow",
        autoSize: true,
        gotoCurrent: true,
        hideIfNoPrevNext: true
      })
      .on( "change", function() { 
        var nextDayDate = $(this).datepicker('getDate', '+1d');
        if(nextDayDate){
          nextDayDate.setDate(nextDayDate.getDate() + 1);
          to.datepicker( "option", "minDate", nextDayDate);
        }else{
          to.datepicker( "option", "minDate", getDate(this));
        }
      }),
    to = $( "#to" ).datepicker({
          beforeShow: function (textbox, instance) {
              instance.dpDiv.css({
                  position: 'relative',
                  margin: '-70px 0 0 0 '
              });
          },
          defaultDate: "0",
          changeYear: true,
          changeMonth: true,
          numberOfMonths: 1,
          minDate: minToDate,
          maxDate:'0',
          dateFormat: dateFormat,
          altField: "#checkTo",
          altFormat: "yy-mm-dd",
          dayNames: dayNames,
          dayNamesMin: dayNamesMin,
          dayNamesShort: dayNamesShort,
          monthNames: monthNames,
          monthNamesShort: monthNamesShort,
          duration: "slow",
          autoSize: true,
          gotoCurrent: true,
          hideIfNoPrevNext: true
        })
        .on( "change", function() {
            var previuosDate = $(this).datepicker('getDate', '+1d');
            if(previuosDate){
                previuosDate.setDate(previuosDate.getDate() - 1);
                from.datepicker( "option", "maxDate", previuosDate);
            }else{
          from.datepicker( "option", "maxDate", getDate( this ));
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
        from: {
          required: true,
          regex: /^\d{1,2}\.\d{1,2}\.\d{4}.$/
        },
        checkFrom: {
          required: true,
          regex: /^\d{4}-\d{1,2}-\d{1,2}.$/
        },
        to: {
          required: true,
          regex: /^\d{1,2}\.\d{1,2}\.\d{4}.$/
        },
        checkTo: {
          required: true,
          regex: /^\d{4}-\d{1,2}-\d{1,2}.$/
        }
      },
      messages: {
        from: {
          required: "Polje 'Datum od' je obavezno!",
          regex: "Polje 'Datum od' nije u ispravnom formatu!"
        },
        checkFrom: {
          required: "Polje 'Datum od-skriveno' je obavezno!",
          regex: "Polje 'Datum od-skriveno' nije u ispravnom formatu!"
        },
        to: {
          required: "Polje 'Datum do' je obavezno!",
          regex: "Polje 'Datum do' nije u ispravnom formatu!"
        },
        checkTo: {
          required: "Polje 'Datum do-skriveno' je obavezno!",
          regex: "Polje 'Datum do-skriveno' nije u ispravnom formatu!"
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
  });

  $("#submit").on('click',function(event){

      var validator = $( "#form" ).validate();
      event.preventDefault();
      if(validator.form()){
          var myurl = $(this).attr('href');
          var method = myurl.split("/").pop();
          var from = $( "#checkFrom" ).val();
          var to = $( "#checkTo" ).val();
          var formated_from = $( "#from" ).val();
          var formated_to = $( "#to" ).val();
          if(!validateStatisticsMethod(method)){
               event.preventDefault();
               showErrorInvalidMethod();
          }else{
              $.ajax({
                  async: true,
                  type:'GET',
                  data:{from: from, to:to, formated_from: formated_from, formated_to: formated_to},
                  url: url + method,
                  success: function(result){     
                      $('html,body').animate({
                      scrollTop: $("#search_result").offset().top},
                      'slow');          
                      $('#statistics_result').html(result);
                    },
                  error: function(){
                      noDataFromDB();
                  }
              });
          }
      }

  });

});

 


 