// validate contracts method
function validateContractsMethod(method){
    var methods_array = ['in_progress', 'unsigned', 'finished','broken'];
    if(methods_array.indexOf(method) > -1){ 
        return true;
    }
    return false;
}

// message error invalid url
function showErrorInvalidMethod(){
    var prom = ezBSAlert({
      type: "alert",
      messageText: "Neipravan url!",
      alertType: "san-blue"
    });

}

$(document).ready(function(){

    $(".contracts").on('click',function(event){
        var myurl = $(this).attr('href');
        var method = myurl.split("/").pop();
        event.preventDefault();
        if(!validateContractsMethod(method)){
             event.preventDefault();
             showErrorInvalidMethod();
        }else{
            $.ajax({
                async: true,
                type:'GET',
                url: myurl,
                success: function(result){   
                    $('html,body').animate({
                    scrollTop: $("#search_result").html(result).css({'padding-top':'70px','min-height':'700px'}).offset().top},
                    'slow');  
                    $(".pagination").addClass('contracts-'+method+'-pagination');          
                  },
                error: function(){
                    noDataFromDB();
                }
            });
        }
    });

    /* Contracts Pagination - In Progress, Unsigned, Finished, Broken*/
    $(document).on('click', '.contracts-in_progress-pagination a, .contracts-unsigned-pagination a, .contracts-finished-pagination a, .contracts-broken-pagination a',function(event){
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');
        event.preventDefault();
        var myurl = $(this).attr('href');
        $.ajax({
            async: true,
            type:'GET',
            url: myurl,
            success: function(result){               
                $('html,body').animate({
                scrollTop: $("#search_result").html(result).offset().top},
                'slow');
                $(".pagination").addClass('contracts-in_progress-pagination contracts-unsigned-pagination contracts-finished-pagination contracts-broken-pagination');
              },
            error: function(){
                noDataFromDB();
            }
        });
    });



});