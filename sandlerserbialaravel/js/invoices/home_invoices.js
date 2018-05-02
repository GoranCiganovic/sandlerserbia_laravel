// validate invoices method
function validateInvoicesMethod(method){
    var methods_array = ['issue_today', 'from_proinvoices', 'confirm_issued', 'confirm_paid', 'all_paid'];
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
    $(".invoices").on('click',function(event){
        var myurl = $(this).attr('href');
        var method = myurl.split("/").pop();
        event.preventDefault();
        if(!validateInvoicesMethod(method)){
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
                    $(".pagination").addClass('invoices-'+method+'-pagination');          
                  },
                error: function(){
                    noDataFromDB();
                }
            });
        }
    });


    $(document).on('click', '.invoices-issue_today-pagination a, .invoices-from_proinvoices-pagination a, .invoices-confirm_issued-pagination a, .invoices-confirm_paid-pagination a,.invoices-all_paid-pagination a',function(event){
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
                $(".pagination").addClass('invoices-issue_today-pagination invoices-from_proinvoices-pagination invoices-confirm_issued-pagination invoices-confirm_paid-pagination invoices-all_paid-pagination');
              },
            error: function(){
                noDataFromDB();
            }
        });
    });

});


