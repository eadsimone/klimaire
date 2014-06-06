/**
 * Created by edesimone on 2/23/14.
 */

var invalidrule = new Array();


var obj = {
    'row1' : {
        'key1' : 'input1',
        'key2' : 'inpu2'
    },
    'row2' : {
        'key3' : 'input3',
        'key4' : 'input4'
    }
};
obj.row1.key1 == 'input1';
obj.row1.key2 == 'input2';
obj.row2.key1 == 'input3';
obj.row2.key2 == 'input4';


var arrayofobj = new Array();

var ArraySelect= {};

function getname(name) {
var res = name.split("&nbsp;");

var name=  res[0].replace(/^\s+|\s+$/g,'');//trim prototype

    return name;
}

jQuery.noConflict();

jQuery(document).ready(function( $ ) {
    // Your jQuery code here, using $ to refer to jQuery.

    // Named function expression.
        $( "#bundle-option-177" ).change(function() {

            /*poner en como seteado
            verificar si cumple como tope maximo
            sacar de los nos seleccionados la condiciion de rule

             */


            var MyArray = {id1: 100, id2: 200, "tag with spaces": 300};
           /* MyArray.id3 = 400;
            MyArray["id4"] = 500;
            */

            var MyArray = {};

            var caca = {id1: 100, id2: 200, "tag with spaces": 300};

            MyArray["uno"] = caca;
            MyArray["tres"] = 3;
            MyArray["dos"] = 2;


            /*
            for(var key in MyArray)
            {
                alert("key " + key + " has value " + MyArray[key]);
            }*/

           // $( "#myselect option:selected" ).text();

            var idselect= "#"+this.id;
            var idselected= idselect+" option:selected";
            var valselected=$(idselected).val();
            var textselected=$(idselected).text();
            var nameselected =getname(textselected);

            var product = {
                valor:valselected,
                texto :textselected,
                name: nameselected
            };

            /*arrayofobj.push(product);*/

            ArraySelect[idselect]=product;

            /*validate*/
            for(var key in ArraySelect)
            {
                alert("key " + key + " has value " + ArraySelect[key].name);
            }

            console.log ( '#someButton was clicked' );



        });




    $( "#bundle-option-178" ).change(function() {
        alert( "Handler for .change() called." );

        var idselect= "#"+this.id;
        var valselected=$(idselect).val();
        var textselected=$(idselect).text();

        alert (a);


        var product = {
            valor:valselected,
            name :textselected
        };

        arrayofobj.push(product);


        console.log ( '#someButton was clicked' );

    });


});




var jqpeche = function() {
    alert('hello world');
};



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
    }/*is not onte table*/
    else if((qtyof12==1)&&(qtyof18==1)){
        return true;
    }
    else if((qtyof18==2)){
        return true;
    }
    else if(qtyof9==3){
        return true;
    }
    else if((qtyof9==2)&&(qtyof12==1)){
        return true;
    }
    else if((qtyof9==2)&&(qtyof18==1)){
        return true;
    }
    else if((qtyof9==1)&&(qtyof12==2)){
        return true;
    }
    else if((qtyof9==2)&&(qtyof12==1)){
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

/*****validation for onchange*////////


function provalidationzone4(prod) {
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
    }/*is not onte table*/
    else if((qtyof12==1)&&(qtyof18==1)){
        return true;
    }
    else if((qtyof18==2)){
        return true;
    }
    else if(qtyof9==3){
        return true;
    }
    else if((qtyof9==2)&&(qtyof12==1)){
        return true;
    }
    else if((qtyof9==2)&&(qtyof18==1)){
        return true;
    }
    else if((qtyof9==1)&&(qtyof12==2)){
        return true;
    }
    else if((qtyof9==2)&&(qtyof12==1)){
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