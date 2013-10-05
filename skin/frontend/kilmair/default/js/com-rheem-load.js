/* BELOW code will need to be deleted once determined not in use */
/* function slide()
{
	Effect.SlideUpAndDown = function(element) {
  element = $('products');
  if(Element.visible(element)) new Effect.SlideUp(element);
  else new Effect.SlideDown(element);
	}
}

function switchItOLD(){
	var div = $('products')
	var header = $('header')
	if (div.style.display == 'none') {
		div.show();
	} else {
		div.hide();
	}
} 
function switchIt(){
	var div = $('products')
	var header = $('header')
	if (div.style.display == 'none') {
		Effect.SlideDown(div, {duration:.25});
		Effect.SlideDown(header, {duration:.25});
	} else {
		Effect.SlideUp(div, {duration:.25});
		Effect.SlideDown(header, {duration:.25});
	}
}
*/

/* END ABOVE code will need to be deleted once determined not in use */


function checkText(theField) {
	if (theField.value == '') {
		theField.className = 'searchField';
		theField.value = theField.defaultValue;
	}
}

function clearText(thefield){
	if (thefield.defaultValue==thefield.value)
	thefield.value = ""
}

function clearStyle(theField) {
	if (theField.className == 'searchField') {
		theField.className = 'searchActive';
	}
}

/* 
Product Slider Menu
Below Code is used to slide the Product menu up and down.
*/

$(document).ready(function(){
	$("#products").hide();
	$("#productsBtn").click(function () {
		$("#products").toggle("blind", { direction: "vertical" }, 100);
		return false;
	});	
});

/* 
END Product Slider Menu
*/

/*

function init(){
	var div = $('products')
	div.hide();
}

*/