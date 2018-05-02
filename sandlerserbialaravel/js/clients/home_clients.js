// check client status, legal status, select order_by value, input search value
function validateSearchClients(client_status,legal_filter,sort_filter,local_search ){
    if(!isValidClientStatus(client_status)){
        return 1;    
    }else if(!isValidSortLegal(legal_filter)){
        return 2;
    }else if(!isValidSortOrder(sort_filter)){      
        return 3;        
    }else if(!isValidString(local_search)){   
        return 4;        
    }else{
      return false;
    }
}

   
$(document).ready(function(){

    $(".sandler_db").on('click',function(event){
        var myurl = $(this).attr('href');
        var client_status = myurl.split("/").pop();
        var legal_filter = '0';
        var sort_filter = '0';
        var local_search = '';
        event.preventDefault();
        var validate = validateSearchClients(client_status,legal_filter,sort_filter,local_search);
        if(validate){
             event.preventDefault();
             showErrorSearchClients(validate);
        }else{
            $.ajax({
                async: true,
                type:'GET',
                data:{client_status:client_status,legal_filter:legal_filter,sort_filter:sort_filter,local_search:local_search},
                url: url + 'clients',
                success: function(result){               
                    $('html,body').animate({
                    scrollTop: $("#search_result").html(result).css({'padding-top':'70px','min-height':'700px'}).offset().top},
                    'slow');
                    $('#search').addClass('hidden');
                    $('#local_search').removeClass('hidden');
                    $(".pagination").addClass('client-pagination');
                  },
                error: function(){
                    noDataFromDB();
                }
            });
        }
    });

    $(document).on('click', '.client-pagination a',function(event){
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');
        event.preventDefault();
        var client_status = $('#legal_filter').attr('name');
        var legal_filter = $('#legal_filter').val();
        var sort_filter = $('#sort_filter').val();
        var local_search = $('#local_search').val();
        var myurl = $(this).attr('href');
        var validate = validateSearchClients(client_status,legal_filter,sort_filter,local_search);
        if(validate){
             event.preventDefault();
             showErrorSearchClients(validate);;
        }else{           
            $.ajax({
                async: true,
                type:'GET',
                data:{client_status: client_status, legal_filter:legal_filter, sort_filter:sort_filter, local_search: local_search},
                url: myurl,
                success: function(result){               
                    $('html,body').animate({
                    scrollTop: $("#search_result").html(result).offset().top},
                    'slow');
                    $(".pagination").addClass('client-pagination');
                  },
                error: function(){
                    noDataFromDB();
                }
            });
        }
    });


    $(document).on('input', '#legal_filter, #sort_filter, #local_search',function(event){  
        var client_status = $('#legal_filter').attr('name');
        var legal_filter = $('#legal_filter').val();
        var sort_filter = $('#sort_filter').val();
        var local_search = $('#local_search').val(); 
        event.preventDefault();
        var validate = validateSearchClients(client_status,legal_filter,sort_filter,local_search);
        if(validate){
             event.preventDefault();
             showErrorSearchClients(validate);
        }else{
            $.ajax({
                async: true,
                type:'GET',
                data:{client_status: client_status, legal_filter:legal_filter, sort_filter:sort_filter, local_search: local_search},
                url: url + 'clients',
                success: function(result){               
                    $('html,body').animate({
                    scrollTop: $("#search_result").html(result).offset().top},
                    'slow');
                    $(".pagination").addClass('client-pagination');
                  },
                error: function(){
                    noDataFromDB();
                }
            });
        }
    });

});

