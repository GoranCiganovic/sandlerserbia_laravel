$(document).ready(function(){
      $('body').append('<div id="backToTopLg" class="btn btn-default btn-lg"><i class="fa fa-chevron-up" aria-hidden="true"></i></div>');
      $(window).scroll(function () {
      if ($(this).scrollTop() !== 0) {
        $('#backToTopLg').fadeIn();
      } else {
        $('#backToTopLg').fadeOut();
      }
    }); 
    $('#backToTopLg').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });
});