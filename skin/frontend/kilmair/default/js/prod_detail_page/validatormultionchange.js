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

/*notes
var MyArray = {id1: 100, id2: 200, "tag with spaces": 300};
/* MyArray.id3 = 400;
 MyArray["id4"] = 500;
 */
/*
var MyArray = {};

var caca = {id1: 100, id2: 200, "tag with spaces": 300};

MyArray["uno"] = caca;
MyArray["tres"] = 3;
MyArray["dos"] = 2;

*/

jQuery(document).ready(function( $ ) {
    // Your jQuery code here, using $ to refer to jQuery.
    var emptyselect = {};
    var selected = {};



    function setproduct(current) {

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

            ArrayOfSelect[current.id]=product;


        var comercialtype12 = qtyof9 = qtyof12 = qtyof18 = totalofwallmounttype12 = totalofwallmounttype18 = contain18= 0;
            validationzone4(ArrayOfSelect);

        /*end selected currrent element*/

            /*arrayofobj.push(product);*/

           /* if(key==current.id){
                ArrayOfSelect[key]=product;
                selected.push(current.id);
            }
            else if(ArrayOfSelect[key]==''){
                emptyselect.push(key);
            }else{
                *//*varificar*//*
                selected[key]=nameselected;
            }

        }*/


    }

    loadarray();

    // Named function expression.
        $( "#bundle-option-177" ).change(function() {

            /*poner en como seteado
            verificar si cumple como tope maximo
            sacar de los nos seleccionados la condiciion de rule

             */

            setproduct(this);


            for(var key in ArrayOfSelect){
                alert("el selelcionador:"+key+" tiene el valor "+ArrayOfSelect[key]);
            }


        });




    $( "#bundle-option-178" ).change(function() {


        setproduct(this);
        return;

        $("#option1").remove();

    });

    $( "#bundle-option-179" ).change(function() {


        setproduct(this);
        return;

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

        $("#option1").remove();

    });

    $( "#bundle-option-180" ).change(function() {


        setproduct(this);
        return;

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

        $("#option1").remove();

    });

    var removeselect = function(id) {

        var idselect= "#"+id;
        var valselected=$(idselect).val();
        var textselected=$(idselect).text();

        alert("nada");
    };


});



function removeselect(number) {

    for(var key in ArrayOfSelect){

        var name=ArrayOfSelect[key].name;

        if((name != 'KWIL18-H2') || (name != 'KWIM18-H2')|| (name != 'KWIO18-H2') || (name != 'KDIM018-H2') || (name != 'KTIM018-H2')|| (name != 'KUIM018-H2'))/*falta KFIM*/
        {
            removeselect(key);

        }
    }

}

function quitar(number) {

    for(var key in ArrayOfSelect){

        var name=ArrayOfSelect[key].name;

        if((name != 'KWIL18-H2') || (name != 'KWIM18-H2')|| (name != 'KWIO18-H2') || (name != 'KDIM018-H2') || (name != 'KTIM018-H2')|| (name != 'KUIM018-H2'))/*falta KFIM*/
        {
            removeselect(key);

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


    for (key in prod) {

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