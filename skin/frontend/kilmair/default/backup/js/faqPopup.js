

//SETTING UP OUR POPUP
//0 means disabled; 1 means enabled;
var popupStatus = 0;



//loading popup with jQuery magic!
function loadPopup(thisID) {
    var popupContact;
    popupContact = document.getElementById("popupContent" + thisID);

    //loads popup only if it is disabled
    if (popupStatus == 0) {
        jQuery("#backgroundPopup").css({
            "opacity": "0.7"
        });
        jQuery("#backgroundPopup").fadeIn("slow");
        jQuery(popupContact).fadeIn("slow");
        popupStatus = 1;
        jQuery.fx.off = true;
    }
}


//disabling popup with jQuery magic!
function disablePopup(thisID) {
    var popupContact;
    popupContact = document.getElementById("popupContent" + thisID);

    jQuery.fx.off = false;
    //disables popup only if it is enabled
    if (popupStatus == 1) {
        jQuery("#backgroundPopup").fadeOut("slow");
        jQuery(popupContact).fadeOut("slow");
        jQuery(".faqaTest").fadeOut("slow");

        popupStatus = 0;
       

    }
}

jQuery(document).ready(function () {

    //LOADING POPUP
    //Click the button event!
    jQuery(".go").click(function () {
        //load popup
        loadPopup();
    });

    //CLOSING POPUP
    //Click the x event!
    jQuery("#popupContactClose").click(function () {
        disablePopup();
    });
    //Click out event!
    jQuery("#backgroundPopup").click(function () {
        disablePopup();
    });
    //Press Escape event!
    jQuery(document).keypress(function (e) {
        if (e.keyCode == 27 && popupStatus == 1) {
            disablePopup();
        }
    });



});
