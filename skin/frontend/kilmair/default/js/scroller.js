/* Scroller
----------------------------------------------------------------------------------------*/
var Scroller = Class.create({
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
	nextIncrement : function (){
		var inc = ((this.current * this.options.incrementCount) > this.itemcount) ? 
						((this.itemcount % this.options.incrementCount) * this.itemwidth) : 
						(this.itemwidth * this.options.incrementCount);
		return inc + ( this.atEnd() ? this.options.endPad : 0);
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
		this.afterRemove();
		this.syncButtons();
	}
});

/* ProductScroller
----------------------------------------------------------------------------------------*/
var ProductScroller = Class.create(Scroller, {
	initialize : function($super,opts){
		opts = Object.extend({endPad : 0}, opts || {});
		$super(opts);
		
		if (opts.enableHover) {
			this.items.each(function(el) { 
				new HoverDelay(el, { 
					delay : 0.035,
					enterCb : function() { 
						if (el.hasClassName("rTucked")) {
							this.shift(-1 * Math.abs(this.options.endPad));
						} else if (el.hasClassName("lTucked")) {
							this.shift(Math.abs(this.options.endPad));
						}
					}.bind(this),
					leaveCb : function() {
						if (el.hasClassName("rTucked")) {
							this.shift(Math.abs(this.options.endPad));
						} else if(el.hasClassName("lTucked")) {
							this.shift(-1 * Math.abs(this.options.endPad));
						}
					}.bind(this)
				});
			}.bind(this)); 
		}
		
		// intro motion
		setTimeout(function(){
			if (this.itemcount > this.options.incrementCount){
				this.slider.style.left = -(this.itemwidth)+'px';
				this.slider.morph({left: '0px', mode :'relative'}, {duration: .7});
			}
		}.bind(this), 200);
		this.working = false;
	},
	setup : function($super){
		$super();
		this.calcLast();
	},
	calcLast : function(){
		this.slider.select('.rTucked, .lTucked').each(function(el){el.removeClassName("rTucked").removeClassName("lTucked");});
		if (this.items.length >= this.options.incrementCount){
			var l = this.current * this.options.incrementCount;
			if (l < this.items.length || (this.atEnd() && (l == this.items.length) && (this.current != 1))) {
				this.items[l-1].addClassName("rTucked");
			}
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
	},
	beforeRemove : function(item){
		if (item != null){
			if (item.hasClassName("rTucked")) this.shift(Math.abs(this.options.endPad));
			else if (item.hasClassName("lTucked")) this.shift(-1 * Math.abs(this.options.endPad));
		}
	},
	shift : function(amt){
		if (this.working) { return; } 
		this.working = true;
		new Effect.Move(this.slider, {x: amt, duration: 0.5, queue: 'end', limit: 1, afterFinish: function() {
			this.working = false; }.bind(this)});
	},
	removeItem : function($super, ev){
		$super(ev);
	},
	reset : function($super){
		$super();
	}
});