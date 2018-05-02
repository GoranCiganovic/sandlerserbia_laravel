// validate proinvoices method
function validateProinvoicesMethod(method){
    var methods_array = ['issue_today', 'confirm_issued', 'confirm_paid'];
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
    $(".proinvoices").on('click',function(event){
        var myurl = $(this).attr('href');
        var method = myurl.split("/").pop();
        event.preventDefault();
        if(!validateProinvoicesMethod(method)){
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
                    $(".pagination").addClass('proinvoices-'+method+'-pagination');         
                  },
                error: function(){
                    noDataFromDB();
                }
            });
        }
    });

    $(document).on('click', '.proinvoices-issue_today-pagination a, .proinvoices-confirm_issued-pagination a, .proinvoices-confirm_paid-pagination a',function(event){
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
                $(".pagination").addClass('proinvoices-issue_today-pagination proinvoices-confirm_issued-pagination proinvoices-confirm_paid-pagination');
              },
            error: function(){
                noDataFromDB();
            }
        });
    });

});