$(document).ready(function(){
   
    $('#articles').hide();

    $('.preview').on('click',function(){
      $('#form').attr('action', $('#form_preview').val());
    });
    
});
