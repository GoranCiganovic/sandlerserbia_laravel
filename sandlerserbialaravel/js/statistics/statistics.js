// validate statistics method
function validateStatisticsMethod(method){
    var methods_array = ['conversation_ratio', 'closing_ratio', 'sandler_traffic', 'disc_devine_traffic', 'total_traffic'];
    if(methods_array.indexOf(method) > -1){ 
        return true;
    }
    return false;
}

// message error invalid method
function showErrorInvalidMethod(){
    var prom = ezBSAlert({
      type: "alert",
      messageText: "Neipravan url!",
      alertType: "san-blue"
    });
 
}

$(document).ready(function(){
    $(".statistics").on('click',function(event){
        var myurl = $(this).attr('href');
        var method = myurl.split("/").pop();
        event.preventDefault();
        if(!validateStatisticsMethod(method)){
             event.preventDefault();
             showErrorInvalidMethod();
        }else{
            $.ajax({
                async: true,
                type:'GET',
                data:{method: method},
                url: 'statistics',
                success: function(result){   
                    $('html,body').animate({
                    scrollTop: $("#search_result").html(result).css({'padding-top':'70px','min-height':'700px'}).offset().top},
                    'slow');            
                  },
                error: function(){
                    noDataFromDB();
                }
            });
        }
    });

});