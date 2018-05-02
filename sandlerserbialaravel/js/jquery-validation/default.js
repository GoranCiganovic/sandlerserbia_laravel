//Regular Expression
$.validator.addMethod("regex", function(value, element, regexp) {
        if(regexp.constructor != RegExp)
            regexp = new RegExp(regexp);
        else if(regexp.global)
          regexp.lastIndex = 0;
          return this.optional(element) || regexp.test(value);
    },
    "Neispravan unos!"
);

// Returns True if Number is equal or lesser than Parameter
$.validator.addMethod("lessOrEqualThan", function(value, element, param) {
        var a = parseFloat(value);
        var v = param.value ? parseFloat(param.value) : 0;
        return (a <= v) ? true : false;
});

 // Returns True in case Payment is 0 and Advance is Equal to Contract Value
$.validator.addMethod("advance_zero", function(value, element, params) {
        var advance = parseFloat(value); 
        var payments = parseFloat(params[0].value);
        var contract_value = parseFloat(params[1].value);
        if(payments == 0 && advance != contract_value){
            return false;
        }else{
            return true;
        }    
});

 // Returns True if the Payments or Advance is not 0
$.validator.addMethod("payments_zero", function(value, element, param) {
        var payments = parseFloat(value); 
        var advance = parseFloat(param.value); 
        if(payments != 0 || advance != 0){
            return true;
        }else{
            return false;
        }
});

 // Returns True if Number is equal or greater than Parameter
$.validator.addMethod("greaterOrEqualThan", function(value, element, param) {
        var v = parseFloat(value);
        var a = param.value ? parseFloat(param.value) : 0;
        return (a <= v) ? true : false;
});

 // Returns True if Date is equal or after Today
$.validator.addMethod("afterAndToday", function(value, element, param) {
        var paramDate = param.value ? param.value : new Date();
        var date = new Date(paramDate);
        var after = date.setDate(date.getDate() + 1);
        var today = new Date();
        return (after > today) ? true : false;     
});

 // Returns True if Date is equal or before Today
$.validator.addMethod("beforeAndToday", function(value, element, param) {
        var paramDate = param.value ? param.value : new Date();
        var date = new Date(paramDate);
        var before = date.setDate(date.getDate());
        var today = new Date();
        return (before <= today) ? true : false;     
});

 // Returns True if Date is equal or after Parameter Date
$.validator.addMethod("afterDate", function(value, element, params) {
        var limitDate = new Date(params[0].value);
        var date = new Date(params[1].value);
        return (limitDate <= date) ? true : false;     
});



