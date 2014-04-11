/**
 * Created by edesimone on 2/23/14.
 */

var invalidrule = new Array();

function getselect(prod) {

    var  multizone2= 'ksim20912-h216-custom',multizone3='ksim30912-h216-custom',multizone4='ksim40912-h216-custom';
    var url= document.URL;

    invalidrule=loadarray();

    /*if not found, it will return -1:*/
    if (url.indexOf(multizone2) != -1){
        var res=validationzone2(invalidrule);

        if(res){
            productAddToCartForm.submit(this)
        }else{
//            var productAddToCartForm = new VarienForm('product_addtocart_form');
//            productAddToCartForm.submit =false;
            alert("Combinations are wrong, please check the possible combination on capacity's tab");
            return false;
        }

    }else if (url.indexOf(multizone3) != -1){
        var res=validationzone3(invalidrule);

        if(res){
            productAddToCartForm.submit(this)
        }else{
//            var productAddToCartForm = new VarienForm('product_addtocart_form');
//            productAddToCartForm.submit =false;
            alert("Combinations are wrong, please check the possible combination on capacity's tab");
            return false;
        }

    }else if(url.indexOf(multizone4) != -1){
        var res=validationzone4(invalidrule);
        if(res){
            productAddToCartForm.submit(this)
        }else{
            alert("Combinations are wrong, please check the possible combination on capacity's tab");
            return false;
        }

    }else{
        productAddToCartForm.submit(this);
    }

}


function loadarray() {

    var arrayofselect = new Array();
    var selects = document.getElementsByTagName('select');
    var sel;
    var relevantSelects = [];
    for(var z=0; z<selects.length; z++){
        sel = selects[z];

        selid=sel.id;
        var keyselection = document.getElementById(selid);
        var keyvalue = keyselection.options[keyselection.selectedIndex];

        var name=keyvalue.innerHTML;
        /*take out price*/
        var res = name.split("&nbsp;");

        var name=  res[0].replace(/^\s+|\s+$/g,'');//trim prototype
        arrayofselect.push(name);

    }
    return arrayofselect;
}

function validationzone2(prod) {
    
    var onlywallmounttype9 = qtyof9 = qtyof12 = 0;

    var total=prod.length;

    for (var i = 0; i < total ; i++) {

        if ((prod[i] == 'KWIM09-H2') || (prod[i] == 'KWIL09-H2'))
        {
            onlywallmounttype9++;/*for rule E. Use only wall mount type when an 18000 Btu/h fan coil unit is required.*/
        }
        if((prod[i] == 'KWIM09-H2') || (prod[i] == 'KWIL09-H2'))
        {
            qtyof9++;
        }
        if((prod[i] == 'KWIL12-H2') || (prod[i] == 'KWIM12-H2') || (prod[i] == 'KDIM012-H2') || (prod[i] == 'KFIM012-H2') || (prod[i] == 'KTIM012-H2') || (prod[i] == 'KUIM012-H2'))
        {
            qtyof12++;
        }
    }


    if(qtyof9==2){
        return true;
    }else if((qtyof9==1)&&(qtyof12==1)&&(onlywallmounttype9==1)){
        return true;
    }else if((qtyof9==2)&&(qtyof12==1)&&(onecomercialtype12<=1)){
        return true;
    }else
    {return false;}

}

function validationzone3(prod) {
    var onlywallmounttype = onecontain18 = onecomercialtype12 = qtyof9 = qtyof12 = qtyof18 = 0;

    var total=prod.length;

    for (var i = 0; i < total ; i++) {

        if ((prod[i] == 'KWIL09-H2') || (prod[i] == 'KWIL12-H2')|| (prod[i] == 'KWIM09-H2') || (prod[i] == 'KWIM12-H2'))
        {
            onlywallmounttype++;/*for rule E. Use only wall mount type when an 18000 Btu/h fan coil unit is required.*/
        }
        if((prod[i] == 'KWIL18-H2') || (prod[i] == 'KWIM18-H2'))
        {
            onecontain18++;
        }
        if((prod[i] == 'KDIM012-H2') || (prod[i] == 'KFIM012-H2')|| (prod[i] == 'KTIM012-H2') || (prod[i] == 'KUIM012-H2'))
        {
            onecomercialtype12++;
        }
        if((prod[i] == 'KWIL09-H2') || (prod[i] == 'KWIM09-H2'))
        {
            qtyof9++;
        }
        if((prod[i] == 'KWIL12-H2') || (prod[i] == 'KWIM12-H2') || (prod[i] == 'KDIM012-H2') || (prod[i] == 'KFIM012-H2') || (prod[i] == 'KTIM012-H2') || (prod[i] == 'KUIM012-H2'))
        {
            qtyof12++;
        }
        if((prod[i] == 'KWIL18-H2') || (prod[i] == 'KWIM18-H2'))
        {
            qtyof18++;
        }
    }


    if(qtyof9==3){
        return true;
    }else if((qtyof9==2)&&(qtyof12==1)){
        return true;
    }else if((qtyof9==2)&&(qtyof12==1)&&(onecomercialtype12<=1)){
        return true;
    }else if((qtyof9==1)&&(qtyof12==2)&&(onecomercialtype12<=1)){
        return true;
    }/*startin just 2 */
    /*just two of 12 */
    else if((qtyof12==2)&&(onecomercialtype12<=1)){
        return true;
    }
    else if((qtyof18==1)&&(onlywallmounttype==1)){
        return true;
    }else
    {return false;}

}
function validationzone4(prod) {
    /*NOTE:
     Wall mount unit= KWIL,KWIM,KWIO

     -->Ducted free match= KDIM
     light commercial unit -->Console free match= KFIM
     -->Cassette free match= KTIM
     -->Floor/ceiling free match =KUIM
     */

    var comercialtype12 = qtyof9 = qtyof12 = qtyof18 = 0;
    var totalofwallmounttype9 = totalofwallmounttype12 = totalofwallmounttype18 = contain18= 0;

    var total=prod.length;

    for (var i = 0; i < total ; i++) {

        if ((prod[i] == 'KWIL09-H2') || (prod[i] == 'KWIM09-H2')|| (prod[i] == 'KWIO09-H2'))
        {
            totalofwallmounttype9++;
        }
        if ((prod[i] == 'KWIL12-H2') || (prod[i] == 'KWIM12-H2')|| (prod[i] == 'KWIO12-H2'))
        {
            totalofwallmounttype12++;
        }

        if ((prod[i] == 'KWIL18-H2') || (prod[i] == 'KWIM18-H2')|| (prod[i] == 'KWIO18-H2'))
        {
            totalofwallmounttype18++;
        }
        /*
         if ((prod[i] == 'KWIL18-H2') || (prod[i] == 'KWIM18-H2')|| (prod[i] == 'KWIO18-H2') || (prod[i] == 'KDIM018-H2') || (prod[i] == 'KTIM018-H2')|| (prod[i] == 'KUIM018-H2'))/*falta KFIM*/
        /*{
         contain18++;
         }*/

        if( (prod[i] == 'KDIM012-H2') || (prod[i] == 'KFIM012-H2')|| (prod[i] == 'KTIM012-H2') ||(prod[i] == 'KUIM012-H2'))
        {
            comercialtype12++;
        }

        if((prod[i] == 'KWIL09-H2') || (prod[i] == 'KWIM09-H2') || (prod[i] == 'KWIO09-H2'))
        {
            qtyof9++;
        }

        if((prod[i] == 'KWIL12-H2') || (prod[i] == 'KWIM12-H2')|| (prod[i] == 'KWIO12-H2') || (prod[i] == 'KDIM012-H2') || (prod[i] == 'KFIM012-H2') || (prod[i] == 'KTIM012-H2') || (prod[i] == 'KUIM012-H2'))
        {
            qtyof12++;
        }

        if((prod[i] == 'KWIL18-H2') || (prod[i] == 'KWIM18-H2')|| (prod[i] == 'KWIO18-H2') || (prod[i] == 'KDIM018-H2') || (prod[i] == 'KTIM018-H2')|| (prod[i] == 'KUIM018-H2'))/*falta KFIM*/
        {
            qtyof18++;
        }
    }


    if(qtyof9==4){
        return true;
    }
    else if((qtyof9==3)&&(qtyof12==1)){
        return true;
    }
    else if((qtyof9==3)&&(qtyof18==1)){
        return true;
    }
    else if((qtyof9==1)&&(qtyof18==2)){
        return true;
    }
    else if((qtyof9==2)&&(qtyof12==2)){
        return true;
    }
    else if((qtyof9==2)&&(qtyof12==1)&&(qtyof18==1)){
        return true;
    }
    else if((qtyof9==1)&&(qtyof12==3)){
        return true;
    }
    else if(qtyof12==3){
        return true;
    }
    else if((qtyof12==2)&&(qtyof18==1)){
        return true;
    }
    else if((qtyof12==1)&&(qtyof18==2)){
        return true;
    }
    else if(qtyof12==4){
        return true;
    }
    else if((qtyof9==1)&&(qtyof12==1)&&(qtyof18==1)){
        return true;
    }
    else
    {return false;}

}