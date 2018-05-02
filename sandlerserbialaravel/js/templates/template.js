$( document ).ready( function () {

      $( "#form" ).validate( {
        rules: {
          logo_bg: {
            digits: true,
            range: [0, 1]
          },
          logo_hd: {
            digits: true,
            range: [0, 1]
          },
          line_hd: {
            digits: true,
            range: [0, 1]
          },
          line_ft: {
            digits: true,
            range: [0, 1]
          },
          paginate: {
            digits: true,
            range: [0, 1]
          },
          margin_top: {
            required: true,
            digits: true,
            number: true,
            min: 0,
            max: 50
          },
          margin_right: {
            required: true,
            digits: true,
            number: true,
            min: 0,
            max: 30
          },
          margin_bottom: {
            required: true,
            digits: true,
            number: true,
            min: 0,
            max: 30
          },
          margin_left: {
            required: true,
            digits: true,
            number: true,
            min: 0,
            max: 30
          }
        },
        messages: {
          logo_bg: {
            digits: "Polje 'Prikaži logo u pozadini' može da bude samo broj!",
            range: "Neispravan unos polja 'Prikaži logo u pozadini'!"
          },
          logo_hd: {
            digits: "Polje 'Prikaži logo u zaglavlju' može da bude samo broj!",
            range: "Neispravan unos polja 'Prikaži logo u zaglavlju'!"
          },
          line_hd: {
            digits: "Polje 'Prikaži liniju gornjeg zaglavlja' može da bude samo broj!",
            range: "Neispravan unos polja 'Prikaži liniju gornjeg zaglavlja'!"
          },
          line_ft: {
            digits: "Polje 'Prikaži liniju donjeg zaglavlja' može da bude samo broj!",
            range: "Neispravan unos polja 'Prikaži liniju donjeg zaglavlja'!"
          },
          paginate: {
            digits: "Polje 'Prikaži obeležavanje strana' može da bude samo broj!",
            range: "Neispravan unos polja 'Prikaži obeležavanje strana'!"
          },
          margin_top: {
            required: "Polje 'Margina gore' je obavezno!",
            digits: "Polje 'Margina gore' može da bude samo ceo broj!",
            number: "Polje 'Margina gore' može da bude samo broj!",
            min: "Polje 'Margina gore' ne može da bude manje od 0!",
            max: "Polje 'Margina gore' može da bude broj do 50!"
          },
          margin_right: {
            required: "Polje 'Margina desno' je obavezno!",
            digits: "Polje 'Margina desno' može da bude samo ceo broj!",
            number: "Polje 'Margina desno' može da bude samo broj!",
            min: "Polje 'Margina desno' ne može da bude manje od 0!",
            max: "Polje 'Margina desno' može da bude broj do 30!"
          },
          margin_bottom: {
            required: "Polje 'Margina dole' je obavezno!",
            digits: "Polje 'Margina dole' može da bude samo ceo broj!",
            number: "Polje 'Margina dole' može da bude samo broj!",
            min: "Polje 'Margina dole' ne može da bude manje od 0!",
            max: "Polje 'Margina dole' može da bude broj do 30!"
          },
          margin_left: {
            required: "Polje 'Margina levo' je obavezno!",
            digits: "Polje 'Margina levo' može da bude samo ceo broj!",
            number: "Polje 'Margina levo' može da bude samo broj!",
            min: "Polje 'Margina levo' ne može da bude manje od 0!",
            max: "Polje 'Margina levo' može da bude broj do 30!"
          }
        },
        errorElement: "span",
        errorPlacement: function ( error, element ) {
          error.addClass( "text-danger h5" );
          if(element.attr('type') == 'checkbox'){
              error.insertAfter(element.parent().parent());
          }else{
              error.insertAfter(element.parent());
          }
         
        },
        highlight: function ( element, errorClass, validClass ) {

          $( element ).parent().next().find('b').addClass( "text-danger" );//chechbox
          $( element ).prev().find('b').addClass( "text-danger" );//input number
          $( element ).parents('.input-group').addClass( "alert-border" );
        },
        unhighlight: function (element, errorClass, validClass) {
          
          $( element ).parent().next().find('b').removeClass( "text-danger" );//chechbox
          $( element ).prev().find('b').removeClass( "text-danger" );//input number
 		      $( element ).parents('.input-group').removeClass( "alert-border" );
        }
      } );


} );