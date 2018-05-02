// validate input search value
function isValidString(str){
 return !/[~`!#$%\^&*+=\-\[\]\\';/{}|\\":<>\?]/g.test(str);
}
 
// validate select lagal_status id 
function isValidSortLegal(id){
    var select_array = ['0','1','2'];
    if(select_array.indexOf(id) > -1){
        return true;
    }
    return false;
}

// validate select order_by value
function isValidSortOrder(id){
    var select_array = ['0','1','2','3','4'];
    if(select_array.indexOf(id) > -1){
        return true;
    }
    return false;
}

// validate client status
function isValidClientStatus(id){
    var select_array = ['1','2','3','4','5','6'];
    if(select_array.indexOf(id) > -1){
        return true;
    }
    return false;
}

// show error message by validation
function showErrorSearchClients(error){
  switch (error) {
      case 1:
        return invalidClientStatus(); 
        break;
      case 2: 
        return invalidLegalStatus();
        break;
      case 3:
        return invalidSortFilter();  
        break;
      case 4:
        return unauthorizedCharacter();     
        break;
      default:
        return unknownError();
        break;
  }
}

// message error db
function noDataFromDB(){
    var error = ezBSAlert({
        type: "alert",
        messageText: "Nemoguće je dobiti podatke iz baze!",
        alertType: "san-blue"
        });
}

// message error input search value
function unauthorizedCharacter(){
    var error = ezBSAlert({
          type: "alert",
          messageText: "Nedozvoljen karakter u polju za pretragu!",
          alertType: "san-blue"
     });
}

/// message error legal status id
function invalidLegalStatus(){
    var prom = ezBSAlert({
      type: "alert",
      messageText: "Neipravan unos pravnog statusa!",
      alertType: "san-blue"
    });
    
}

// message error client status id
function invalidClientStatus(){
    var prom = ezBSAlert({
      type: "alert",
      messageText: "Neipravan unos statusa klijenta!",
      alertType: "san-blue"
    });
}

// message error select order by value
function invalidSortFilter(){
    var prom = ezBSAlert({
      type: "alert",
      messageText: "Neipravan način sortiranja!",
      alertType: "san-blue"
    });

}

// message unknown error
function unknownError(){
    var error = ezBSAlert({
          type: "alert",
          messageText: "Nepoznata greška!",
          alertType: "san-blue"
     });
}

// round number for proinvoices, invoices, disc/devines debt, sandler debt
function round_number(number){
  return  Math.round(number * 100) / 100;
}


