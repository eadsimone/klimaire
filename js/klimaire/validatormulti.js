/**
 * Created by edesimone on 2/23/14.
 */


//sacar todos los select ponerlo en un array

var invalidruleD = new Array();
mycars[0] = "KDIM012-H2";
mycars[1] = "KDIM012-H2";
mycars[2] = "BMW";

/*refer to rule number D*//*
function onecomercialtype12(prod) {
    var result = 0;

    for (i = 0; i <= prod.length(); i++) {
        if ((prod[i] == 'KDIM012-H2') || (prod[i] == 'KFIM012-H2')|| (prod[i] == 'KTIM012-H2') || (prod[i] == 'KUIM012-H2'))
        {
            result++;
        }
    }

    if (result <     2) {
       return true;
    }else{
       return false;
    }
}

*//* return true is contain only one 18000 Btu/h fan coil unit is required , more than one return false*//*
function onecontain18(prod) {
    var result = 0;

    for (i = 0; i <= prod.length(); i++) {
        if ((prod[i] == 'KWIL18-H2') || (prod[i] == 'KWIM18-H2'))
        {
            result++;
        }
    }

    if (result <     2) {
        return true;
    }else{
        return false;
    }
}

*//* Use only wall mount type when an 18000 Btu/h fan coil unit is required.*//*

function onlywallmounttype(prod) {
    var result = 0;

    for (i = 0; i <= prod.length(); i++) {
        if ((prod[i] == 'KWIL09-H2') || (prod[i] == 'KWIL12-H2')|| (prod[i] == 'KWIM09-H2') || (prod[i] == 'KWIM12-H2'))
        {
            result++;
        }
    }

    if (result < 2) {
        return true;
    }else{
        return false;
    }
}*/

function getselect(prod) {
var selects = document.getElementsByTagName('select');
var sel;
var relevantSelects = [];
for(var z=0; z<selects.length; z++){
    sel = selects[z];
    if(sel.name.indexOf('salut-') === 0){
        relevantSelects.push(sel);
    }
}
console.log(relevantSelects);
}

function validationzone3(prod) {
    var onlywallmounttype,onecontain18,onecomercialtype12,qtyof9,qtyof12,qtyof18 = 0;


    for (i = 0; i <= prod.length(); i++) {
        if ((prod[i] == 'KWIL09-H2') || (prod[i] == 'KWIL12-H2')|| (prod[i] == 'KWIM09-H2') || (prod[i] == 'KWIM12-H2'))
        {
            onlywallmounttype++;
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

l
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