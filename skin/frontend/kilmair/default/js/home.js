/* CustomScroller
----------------------------------------------------------------------------------------*/
var CustomScroller = Class.create({
	initialize : function(options){
		this.options = Object.extend({
			slideId : 'slides',
			prevId : 'slide_prev',
			nextId : 'slide_next',
			incrementCount : 5,
			itemSelector : 'ul.items > li',
			speed : .5, 
			endPad : 0
		}, options || {});
		this.slider = $(this.options.slideId);
		//this.slider.select('a.close').each(function(el){el.observe('click', this.removeItem.bind(this))}.bind(this));
		this.nextBtn = $(this.options.nextId).observe('click', this.next.bind(this));
		this.prevBtn = $(this.options.prevId).observe('click', this.prev.bind(this));
		this.current = 1;
		this.effect = null;
		this.setup();
		this.syncButtons();
	},
	
	setup : function(){
		this.items = this.slider.select(this.options.itemSelector);
		this.itemwidth = this.items.first().getWidth();
		this.itemcount = this.items.size();
		this.incrementCount = this.options.incrementCount * this.itemwidth;
		this.sets = Math.ceil(this.itemcount/this.options.incrementCount);
		if (this.current>this.sets) this.current = this.sets;
	},
	
	prev : function(e){
		e.stop();
		if (this.effect) return;
		if (this.atStart()) return;
		this.effect = new Effect.Move(this.slider, {x:this.nextIncrement(), mode : 'relative', duration : this.options.speed, queue:'end', afterFinish : function(){this.effect = null;this.syncButtons()}.bind(this)});
		this.current--;
	}, 
	
	next : function(e){
		if (e) e.stop();
		if (this.effect) return;
		if (this.atEnd()) return;
		this.current++;
		this.effect = new Effect.Move(this.slider, {x:-this.nextIncrement(), mode : 'relative', duration : this.options.speed, queue:'end', afterFinish : function(){this.effect = null;this.syncButtons()}.bind(this)});
	},
	
	removeItem : function(ev){
		ev.stop();
		ev.element().fire('hoverdelay:stop');
		var item =  ev.element().up(this.options.itemSelector);
		item.removeClassName("active");
		item.fade({to: .01, duration:1, afterFinish: function(){
				var shift = (this.atEnd() && this.current>1);
				if (shift){
					var tomove = this.itemwidth;
					if (this.atEnd()&&this.itemcount-1==this.options.incrementCount){tomove+= this.options.endPad;}
					new Effect.Move(this.slider, {x:tomove, mode : 'relative', duration : .5});
				}
				item.setStyle({overflow:'hidden'})
				.morph({width: Prototype.Browser.IE?'0em':'0px'}, {duration:.5, afterFinish: function(){
					//item.remove();
					this.beforeRemove(item);
					item.addClassName('inactive').setStyle({width:''}).setOpacity(1);
					this.setup();
					//this.afterRemove(item);
					this.syncButtons();
				}.bind(this)});
			}.bind(this)})
	},
	
	nextIncrement : function (){
		var inc = ((this.current*this.options.incrementCount) > this.itemcount)? 
			((this.itemcount%this.options.incrementCount)* this.itemwidth) : 
			  this.itemwidth*this.options.incrementCount;
		return inc+( this.atEnd() ? this.options.endPad : 0);
	},
	atEnd : function(){
		return this.current==this.sets;
	},
	atStart : function(){
		return this.current==1;
	},
	syncButtons : function(){
		if (this.atStart()) this.prevBtn.addClassName("disabled");else this.prevBtn.removeClassName("disabled");
		if (this.atEnd()) this.nextBtn.addClassName("disabled"); else this.nextBtn.removeClassName("disabled");
	},
	reset : function(){
		this.current=1;
		this.slider.style.left = 0;
		this.setup();
		//this.afterRemove();
		this.syncButtons();
	},
	afterRemove : function (){},
	beforeRemove : function(){}
});


var HomepageScroller = Class.create(CustomScroller, {
	initialize : function($super,opts){
		opts = Object.extend({endPad : 62}, opts || {});
		$super(opts);
		
		this.items.each(function(el){
			new HoverDelay(el, {
				enterCb : function(){if (el.hasClassName("rTucked")) this.shift(-this.options.endPad); else if(el.hasClassName("lTucked"))this.shift(this.options.endPad)}.bind(this),
				leaveCb : function(){if (el.hasClassName("rTucked")) this.shift(this.options.endPad); else if(el.hasClassName("lTucked")) this.shift(-this.options.endPad)}.bind(this)
		});}.bind(this));
		this.slider.observe('compare:reset', this.reset.bind(this));
		// intro motion
		setTimeout(function(){
			if (this.itemcount > this.options.incrementCount){
				this.slider.style.left = -(this.itemwidth)+'px';
				this.slider.morph({left: '0px', mode :'relative'}, {duration: 1});
			}
		}.bind(this), 500);
	},
	setup : function($super){
		$super();
		this.calcLast();
	},
	calcLast : function(){
		this.slider.select('.rTucked, .lTucked').each(function(el){el.removeClassName("rTucked").removeClassName("lTucked");});
		if (this.items.length >= this.options.incrementCount){
			var l = this.current * this.options.incrementCount;
			if (l < this.items.length || (this.atEnd()&&l==this.items.length && this.current!=1))
				this.items[l-1].addClassName("rTucked");
			if (this.atEnd() && this.current>1){
				l=this.itemcount-this.options.incrementCount;
				this.items[l].addClassName("lTucked");
			}
		}
	},
	next : function($super, e){
		$super(e);
		this.calcLast();
	},
	prev : function($super, e){
		$super(e);
		this.calcLast();
	},
	afterRemove : function(item){
		if (this.itemcount > this.options.incrementCount){
			$('courseCompare').addClassName("more6");
		}else
			$('courseCompare').removeClassName("more6");
		item.fire('course:removed');
	},
	beforeRemove : function(item){
		if (item != null){
			if (item.hasClassName("rTucked")) this.shift(this.options.endPad);
			else if (item.hasClassName("lTucked")) this.shift(-this.options.endPad);
		}
	},
	shift : function(amt){
		//new Effect.Move(this.slider, {x: amt,duration:.5, transition: bouncePast, queue:'end'});
		new Effect.Move(this.slider, {x: amt,duration:.3, transition: Effect.Transitions.easeOutSine, queue:'end'});
	},
	removeItem : function($super, ev){
		if (this.itemcount ==3)
			$$('.course .close').invoke('hide');
		$super(ev);
	},
	reset : function($super){
		$super();
		$$('.course .close').invoke(this.itemcount>2?'show':'hide');
	}
});


document.observe('dom:loaded', function(){
	if($('slides')) {
		//new HomepageScroller({ incrementCount : 5, endPad: 59, enableHover: true });
		var s = new HomepageScroller();
	}
	
	if($('slides_howto')) {
		new PageSlide($('slides_howto'), 4, $('slide_next_howto'), $('slide_prev_howto'), 283);
	}
	
	$$('.categories ul li.trigger').each(function(el){
		new KickOut(el, el.down('.overlay'), { duration: .4 });
	});
});
