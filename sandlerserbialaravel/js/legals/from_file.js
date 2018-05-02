$( document ).ready( function () {

      $( "#submit" ).click(function(event) {

        var userfile = $("#excel_file").val(); 
        var msg_empty = 'Nije izabran fajl';
        var msg_ext = 'Dozvoljene su samo Excel ekstenzije XLS, XLSX, XLA, XLAM, XLSM, XLT, XLTX i XLTM!';
        var msg_size = 'Dozvoljeni su fajlovi veličine do 2048KB!';
        if(userfile == ""){
            event.preventDefault();
            $('.pick_excel').addClass('text-danger');
            $('.excel_label').addClass("alert-border");
            $('#excel_error').text(msg_empty);
        }else if (!(/\.(xls|xlsx|xla|xlam|xlsm|xlt|xltx|xltm)$/i).test(userfile)){             
            event.preventDefault();
            $('.pick_excel').addClass('text-danger');
            $('.excel_label').addClass("alert-border");
            $('#excel_error').text(msg_ext); 
        }else if(userfile){
          var file_size = $("#excel_file")[0].files[0].size;
          if(file_size > 2097152){
              event.preventDefault();
              $('.pick_excel').addClass('text-danger');
              $('.excel_label').addClass("alert-border");
              $('#excel_error').text(msg_size);          
          }
        }else{
            $('.pick_excel').removeClass('text-danger');
            $('.excel_label').removeClass("alert-border"); 
            $('#excel_error').empty();
        } 

      });


    $('.form_prevent_multiple_submits').on('submit', function(){
      var btn =  $('.button_prevent_multiple_submits');
      btn.attr('disabled', true);
      $('.spinner').show();//spinner icon
      $('.no_spinner').hide();//no spinner (check) icon
      setTimeout(function(){
        btn.attr('disabled', false);
        $('.spinner').hide();
        $('.no_spinner').show();
      }, 3000);
    });

 });














