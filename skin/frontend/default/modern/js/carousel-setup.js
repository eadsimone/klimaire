
var s=800;
var stepswitch=false;
var steppause=5000;

setInterval ( "shiftPanels()", 6000 );

function shiftPanels ( )
{
  stepcarousel.stepBy('mygallery', 1),
  stepcarousel.stepBy('mygallery2', 1),
  stepcarousel.stepBy('mygallery3', 1)
}


stepcarousel.setup({
	galleryid: 'mygallery', //id of carousel DIV
	beltclass: 'belt', //class of inner "belt" DIV containing all the panel DIVs
	panelclass: 'panel', //class of panel DIVs each holding content
	autostep: {enable:stepswitch, moveby:1, pause:steppause-400},
	panelbehavior: {speed:s+400, wraparound:true, wrapbehavior:'slide', persist:false},
	defaultbuttons: {enable: false, moveby: 1, leftnav: ['images/left_button.png', -20, 200], rightnav: ['images/right_button.png', -20, 200]},
	statusvars: ['statusA', 'statusB', 'statusC'], //register 3 variables that contain current panel (start), current panel (last), and total panels
	contenttype: ['inline']//content setting ['inline'] or ['ajax', 'path_to_external_file']
	
})
//

stepcarousel.setup({
	galleryid: 'mygallery2', //id of carousel DIV
	beltclass: 'belt', //class of inner "belt" DIV containing all the panel DIVs
	panelclass: 'panel', //class of panel DIVs each holding content
	autostep: {enable:stepswitch, moveby:1, pause:steppause-200},
	panelbehavior: {speed:s+200, wraparound:true, wrapbehavior:'slide', persist:false},
	defaultbuttons: {enable: false, moveby: 1, leftnav: ['images/left_button.png', -20, 200], rightnav: ['images/right_button.png', -20, 200]},
	statusvars: ['statusA', 'statusB', 'statusC'], //register 3 variables that contain current panel (start), current panel (last), and total panels
	contenttype: ['inline']//content setting ['inline'] or ['ajax', 'path_to_external_file']
	
})


stepcarousel.setup({
	galleryid: 'mygallery3', //id of carousel DIV
	beltclass: 'belt', //class of inner "belt" DIV containing all the panel DIVs
	panelclass: 'panel', //class of panel DIVs each holding content
	autostep: {enable:stepswitch, moveby:1, pause:steppause},
	panelbehavior: {speed:s, wraparound:true, wrapbehavior:'slide', persist:false},
	defaultbuttons: {enable: false, moveby: 1, leftnav: ['images/left_button.png', -20, 200], rightnav: ['images/right_button.png', -20, 200]},
	statusvars: ['statusA', 'statusB', 'statusC'], //register 3 variables that contain current panel (start), current panel (last), and total panels
	contenttype: ['inline'],//content setting ['inline'] or ['ajax', 'path_to_external_file']
	oninit:function(){
this.$toclinks=jQuery('.toclinks') //get all links with "toclinks" class
},
onslide:function(){
/////
this.$toclinks.eq(i).click(function(e) {e.preventDefault();})
/////
for (var i=0; i<statusC; i++){
if (i==statusA-1) //if this is the current slide
this.$toclinks.eq(i).addClass('selected')
else //not current slide
this.$toclinks.eq(i).removeClass('selected')
//////
this.$toclinks.eq(i).click(function(e) {e.onslide();})
//////
}
}
})


