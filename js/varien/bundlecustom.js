/*hack function for check and uncheck all product*/

function myFunction(selection)
{
    var checktrue=false;
        var parts = selection.id.split('-');
//        if (this.config['options'][parts[2]].isMulti) {
            selected = new Array();
            if (selection.tagName == 'SELECT') {
                for (var i = 0; i < selection.options.length; i++) {
                    if (selection.options[i].selected && selection.options[i].value != '') {
                        selected.push(selection.options[i].value);
                    }
                }
            } else if (selection.tagName == 'INPUT') {
                selector = parts[0]+'-'+parts[1]+'-'+parts[2];
                selections = $$('.'+selector);
                for (var i = 0; i < selections.length; i++) {
                    if(parts[3]==selections[i].value){
                        if(selections[i].checked){
                            checktrue=true;
                        }else{
                            checktrue=false;
                        }
                    }
                }
                if(checktrue){
                    for (var i = 0; i < selections.length; i++) {
                        selections[i].setAttribute('checked', true);
                        selections[i].checked = true;
                        selected.push(selections[i].value);
                    }
                }else{
                    for (var i = 0; i < selections.length; i++) {
                        selections[i].setAttribute('checked', false);
                        selections[i].checked = false;
                    }
                }
            }

}
