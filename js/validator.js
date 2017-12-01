var validator = {
    regEx : {"name":/^([\u0020]|[\u002d]|[\u0041-\u005a]|[\u0061-\u007a]|[\u00c0-\u00d6]|[\u00d8-\u00f6]|[\u00f8-\u024f])+$/,
             "text":/^([\u000a]|[\u0020-\u003b]|[\u0041-\u005a]|[\u0061-\u007a]|[\u00c0-\u00d6]|[\u00d8-\u00f6]|[\u00f8-\u024f])+$/,
             "phone":/^['+']?([\u0020]|[0-9])+$/,
             "email":/^([a-z]|[A-Z]|[0-9]|[.]|[_]|[-])+\u0040([a-z]|[A-Z]|[0-9])([a-z]|[A-Z]|[0-9]|[-])+([a-z]|[A-Z]|[0-9])(.([a-z]|[A-Z]|[0-9]|[-])+)+$/},
    evalRegEx : function(str,re){
        var r = str.trim().match(re);
        if(r != null) return r[0];
        return null;
    },
    allRequired : function(s){
        var el = s.elements;
        var l = el.length;
        var required = true;
        for(var i=0;i < l; i++){
            if((el[i].required == true) && (el[i].value == "")){
                required = false;
                break;
            }
        }
        return required;
    },
    validate : function(s){
        var el = s.elements;
        var l = el.length;
        var r = null;
        var isValid = true;
        var re = null;
        for(var i=0;i < l; i++){
            if(!el[i].attributes.validate) continue;
            re = validator.regEx[el[i].attributes.validate.value];
            if(re != undefined) r = validator.evalRegEx(el[i].value,re);
            if(r == null){
                isValid = false;
                break;
            }
        }
        return isValid;
    },
    activateSubmit : function(f){
        var v = validator;
        var submit = f.querySelector("#"+f.attributes.submitId.value);
        if((v.validate(f) == true) && (v.allRequired(f) == true)){
            submit.disabled = false;
        }
        else submit.disabled = true;
    }
}
