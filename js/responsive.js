/*Loading stylesheet depends on device */
var espc = false;
var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};
if(isMobile.Android()){
    $("head").append("<link href='css/layout1/mobile.css' rel='stylesheet' type='text/css' media='all' />");
}
else if(isMobile.iOS()){
    $("head").append("<link href='css/layout1/mobile.css' rel='stylesheet' type='text/css' media='all' />");
}
else if(isMobile.Opera()){
    $("head").append("<link href='css/layout1/mobile.css' rel='stylesheet' type='text/css' media='all' />");
}
else if(isMobile.Windows()){
    $("head").append("<link href='css/layout1/mobile.css' rel='stylesheet' type='text/css' media='all' />");
}
else{
    espc = true;
    $("head").append("<link href='css/layout1/style.css' rel='stylesheet' type='text/css' media='all' />");
}
