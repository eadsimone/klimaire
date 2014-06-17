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

var ArrayOfSelect= {};

var ArrayOfSelectout= {};

var comercialtype12 = qtyof9 = qtyof12 = qtyof18 = 0;
var totalofwallmounttype9 = totalofwallmounttype12 = totalofwallmounttype18 = contain18= 0;

function getname(name) {
//var res = name.split("&nbsp;");
    var res = name.split("+");

    var name=  res[0].replace(/^\s+|\s+$/g,'');//trim prototype

    return name;
}

function sizeofobject(a){

    var count = 0;
    var i;

    for (i in a) {
        if (a.hasOwnProperty(i)) {
            count++;
        }
    }
    return count;
}

jQuery.noConflict();

jQuery(document).ready(function( $ ) {
    // Your jQuery code here, using $ to refer to jQuery.
    var emptyselect = {};
    var selected = {};



    function setproduct(id,arreglo) {

        var idselect= "#"+id;
        var idselected= idselect;
        var valselected=$(idselected).val();
        var textselected=$(idselected).text();
        var nameselected =getname(textselected);

        var product = {
            valor:valselected,
            texto :textselected,
            name: nameselected
        };

        arreglo[current.id]=product;

        /* var comercialtype12 = qtyof9 = qtyof12 = qtyof18 = totalofwallmounttype12 = totalofwallmounttype18 = contain18= 0;
         validationzone4(arreglo);*/
    }

    /*set prodcut selected*/
    function setproductselected(current,arreglo) {

        /* for(var key in ArrayOfSelect)
         {*/

        // $( "#myselect option:selected" ).text(); for option selected
        /*selected the current element*/
        var idselect= "#"+current.id;
        var idselected= idselect+" option:selected";
        var valselected=$(idselected).val();
        var textselected=$(idselected).text();
        var nameselected =getname(textselected);

        var product = {
            valor:valselected,
            texto :textselected,
            name: nameselected
        };

        arreglo[current.id]=product;


        var comercialtype12 = qtyof9 = qtyof12 = qtyof18 = totalofwallmounttype12 = totalofwallmounttype18 = contain18= 0;
        validationzone4(arreglo);
    }

    loadarray();

    // Named function expression.
    $( "#bundle-option-177" ).change(function() {

        /*poner en como seteado
         verificar si cumple como tope maximo
         sacar de los nos seleccionados la condiciion de rule
         */
        setproductselected(this,ArrayOfSelect);

    });


    $( "#bundle-option-178" ).change(function() {

        setproductselected(this,ArrayOfSelect);
        return;
    });

    $( "#bundle-option-179" ).change(function() {
        setproductselected(this,ArrayOfSelect);

    });

    $( "#bundle-option-180" ).change(function() {

        setproductselected(this,ArrayOfSelect);
        return;

    });
});

var jquery = jQuery.noConflict();

function removeselect(id){

    var idselect= "#"+id;
    var valselected=jquery(idselect).val();
    var textselected=jquery(idselect).text();

    var sel=idselect+" option";

    jquery(sel).each(function() {

        var name =getname(jquery(this).text());

        if((name == 'KWIL18-H2') && (name == 'KWIM18-H2') && (name == 'KWIO18-H2') && (name == 'KDIM018-H2') && (name == 'KTIM018-H2') && (name == 'KUIM018-H2'))/*falta KFIM*/
        {
            /*setproduct(id,ArrayOfSelectout);*/

            /*jquery("#selectBox option[value='option1']").remove();*/
            var val=jquery(this).val();
            var opt=sel+"[value="+val+"]";

            jquery(opt).remove();

        }
    });

    console.log(optionValues);
};

function quitar(number) {
    var nombre='';

    for(var key in ArrayOfSelect){

        if ((key !== undefined) && (typeof key !== "undefined")){

            nombre = ArrayOfSelect[key].name;

            if( (nombre != 'KWIL18-H2') && (nombre != 'KWIM18-H2') && (nombre != 'KWIO18-H2') && (nombre != 'KDIM018-H2') && (nombre != 'KTIM018-H2')&& (nombre != 'KUIM018-H2')){
                removeselect(key);
            }
        }
    }

}



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


    var selects = document.getElementsByTagName('select');
    var sel;
    var relevantSelects = [];
    for(var z=0; z<selects.length; z++){
        sel = selects[z];

        selid=sel.id;
        ArrayOfSelect[selid] ='';
    }
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



    var total=sizeofobject(prod);


    for (var key in prod) {

        //for (var i = 0; i < total ; i++) {
        var name=prod[key].name;
        if ((name == 'KWIL09-H2') || (name == 'KWIM09-H2')|| (name == 'KWIO09-H2'))
        {
            totalofwallmounttype9++;
        }
        if ((name == 'KWIL12-H2') || (name == 'KWIM12-H2')|| (name == 'KWIO12-H2'))
        {
            totalofwallmounttype12++;
        }

        if ((name == 'KWIL18-H2') || (name == 'KWIM18-H2')|| (name == 'KWIO18-H2'))
        {
            totalofwallmounttype18++;


        }
        /*
         if ((name == 'KWIL18-H2') || (name == 'KWIM18-H2')|| (name == 'KWIO18-H2') || (name == 'KDIM018-H2') || (name == 'KTIM018-H2')|| (name == 'KUIM018-H2'))/*falta KFIM*/
        /*{
         contain18++;
         }*/

        if( (name == 'KDIM012-H2') || (name == 'KFIM012-H2')|| (name == 'KTIM012-H2') ||(name == 'KUIM012-H2'))
        {
            comercialtype12++;
        }

        if((name == 'KWIL09-H2') || (name == 'KWIM09-H2') || (name == 'KWIO09-H2'))
        {
            qtyof9++;
        }

        if((name == 'KWIL12-H2') || (name == 'KWIM12-H2')|| (name == 'KWIO12-H2') || (name == 'KDIM012-H2') || (name == 'KFIM012-H2') || (name == 'KTIM012-H2') || (name == 'KUIM012-H2'))
        {
            qtyof12++;
        }

        if((name == 'KWIL18-H2') || (name == 'KWIM18-H2')|| (name == 'KWIO18-H2') || (name == 'KDIM018-H2') || (name == 'KTIM018-H2')|| (name == 'KUIM018-H2'))/*falta KFIM*/
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
        quitar(18);
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

        if ((name == 'KWIL09-H2') || (name == 'KWIM09-H2')|| (name == 'KWIO09-H2'))
        {
            totalofwallmounttype9++;
        }
        if ((name == 'KWIL12-H2') || (name == 'KWIM12-H2')|| (name == 'KWIO12-H2'))
        {
            totalofwallmounttype12++;
        }

        if ((name == 'KWIL18-H2') || (name == 'KWIM18-H2')|| (name == 'KWIO18-H2'))
        {
            totalofwallmounttype18++;
        }
        /*
         if ((name == 'KWIL18-H2') || (name == 'KWIM18-H2')|| (name == 'KWIO18-H2') || (name == 'KDIM018-H2') || (name == 'KTIM018-H2')|| (name == 'KUIM018-H2'))/*falta KFIM*/
        /*{
         contain18++;
         }*/

        if( (name == 'KDIM012-H2') || (name == 'KFIM012-H2')|| (name == 'KTIM012-H2') ||(name == 'KUIM012-H2'))
        {
            comercialtype12++;
        }

        if((name == 'KWIL09-H2') || (name == 'KWIM09-H2') || (name == 'KWIO09-H2'))
        {
            qtyof9++;
        }

        if((name == 'KWIL12-H2') || (name == 'KWIM12-H2')|| (name == 'KWIO12-H2') || (name == 'KDIM012-H2') || (name == 'KFIM012-H2') || (name == 'KTIM012-H2') || (name == 'KUIM012-H2'))
        {
            qtyof12++;
        }

        if((name == 'KWIL18-H2') || (name == 'KWIM18-H2')|| (name == 'KWIO18-H2') || (name == 'KDIM018-H2') || (name == 'KTIM018-H2')|| (name == 'KUIM018-H2'))/*falta KFIM*/
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