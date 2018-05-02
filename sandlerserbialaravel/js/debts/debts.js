$(document).ready(function(){
    $(".debts").on('click',function(event){
        event.preventDefault();
        $.ajax({
            async: true,
            type:'GET',
            url: 'debts',
            success: function(result){   
                $('html,body').animate({
                scrollTop: $("#search_result").html(result).css({'padding-top':'70px','min-height':'700px'}).offset().top},
                'slow');            
              },
            error: function(){
                noDataFromDB();
            }
        });

    });

});