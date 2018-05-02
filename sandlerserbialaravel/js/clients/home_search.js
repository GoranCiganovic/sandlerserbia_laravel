// check legal status, select order_by value, input search value
function validateSearchHome(legal_filter,sort_filter,local_search){
    if(legal_filter && !isValidSortLegal(legal_filter)){
        return 2;
    }else if(sort_filter && !isValidSortOrder(sort_filter)){      
        return 3;        
    }else if(!isValidString(local_search)){   
        return 4;        
    }else{
      return false;
    }
}


$(document).ready(function(){

    $("input#search").on('input',function(event){
        var search = $('#search').val(); 
        var legal_filter;
        var sort_filter;
        event.preventDefault();
        isValidSortLegal($('#legal_filter_search').val()) ? legal_filter = $('#legal_filter_search').val() : legal_filter = '0';
        isValidSortOrder($('#sort_filter_search').val()) ? sort_filter = $('#sort_filter_search').val() : sort_filter = '0';
        var validate = validateSearchHome(legal_filter,sort_filter,search);
        if(validate){
             event.preventDefault();
             showErrorSearchClients(validate);
        }else{
            $.ajax({
                async: true,
                type:'GET',
                data:{search: search},
                url: url + 'search/' + legal_filter+ '/' + sort_filter,
                success: function(result){
                    $('html,body').animate({
                    scrollTop: $("#search_result").html(result).css({'padding-top':'70px','min-height':'700px'}).offset().top},
                    'slow');
                    $(".pagination").addClass('search-pagination');
                  },
                error: function(){
                    noDataFromDB();
                }
            });
          }
    });

    $(document).on('input', '#legal_filter_search, #sort_filter_search',function(event){
        var search = $('#search').val(); 
        var legal_filter = $('#legal_filter_search').val();
        var sort_filter = $('#sort_filter_search').val(); 
        event.preventDefault();
        var validate = validateSearchHome(legal_filter,sort_filter,search);
        if(validate){
             event.preventDefault();
             showErrorSearchClients(validate);
        }else{
            $.ajax({
                async: true,
                type:'GET',
                data:{search: search},
                url: url + 'search/' + legal_filter+ '/' + sort_filter,
                success: function(result){               
                    $('html,body').animate({
                    scrollTop: $("#search_result").html(result).offset().top},
                    'slow');
                    $(".pagination").addClass('search-pagination');
                  },
                error: function(){
                    noDataFromDB();
                }
            });
        }

    });


    $(document).on('click', '.search-pagination a',function(event){
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');
        event.preventDefault();
        var search = $('#search').val(); 
        var legal_filter = $('#legal_filter_search').val();
        var sort_filter = $('#sort_filter_search').val();  
        var myurl = $(this).attr('href');
        var pagination_url = myurl.split("?").pop();
        var validate = validateSearchHome(legal_filter,sort_filter,search);
        if(validate){
             event.preventDefault();
             showErrorSearchClients(validate);
        }else{
            $.ajax({
                async: true,
                type:'GET',
                data:{search: search},
                url: url + 'search/' + legal_filter+ '/' + sort_filter + '?' + pagination_url,
                success: function(result){               
                    $('html,body').animate({
                    scrollTop: $("#search_result").html(result).offset().top},
                    'slow');
                    $(".pagination").addClass('search-pagination');
                  },
                error: function(){
                    noDataFromDB();
                }
            });
        }
    });
    
});





