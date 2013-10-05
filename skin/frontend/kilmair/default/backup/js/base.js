/* ClassToggler
----------------------------------------------------------------------------------------*/
var ClassToggler = Class.create({
	initialize: function(togglers, className, active) {	    
		this.togglers = $(togglers);
		this.active    = active || 0;
		this.className = className;
		this.setup();
	},
	setup: function() {
		this.togglers[this.active].addClassName(this.className);
		this.togglers.each(function(el, i) {
			el.observe('click', function() {
				if (i != this.active) {
					el.addClassName(this.className);
					this.togglers[this.active].removeClassName(this.className);
				}
				this.active = i;
				return false;
			}.bind(this));
		}.bind(this));
	}
});

/* CenteredPop
----------------------------------------------------------------------------------------*/
var CenteredPop = Class.create({
	initialize: function(trigger, popup, options) {
		if (!popup) return;  //PXP211:Reorder Pad:Hai:trigger can be null
		CenteredPop.i    = 0;
		CenteredPop.open = false;
		
		this.trigger = $(trigger);
		this.popup   = $(popup);
		this.working = false;
		this.options = Object.extend({
			modal:  false,
			cancel: false,
			closeSelector:  '.close',
			handleSelector: '.overlay_head'
		}, options);
		
		this.setup();
	},
	setup: function() {
		this.popup.hide();
		if (this.trigger) {
			this.trigger.observe('click', this.open.bind(this));
		} else {  // no trigger, observe error msg - PXP211:Reorder Pad:Hai
			document.observe('error:msg', this.open.bind(this));
		}
	},
	open: function(event) {
		// PXP211:Reorder Pad:Hai:move this check to beginning of function
		// only one popup is allowed at a time
		if (CenteredPop.open) { CenteredPop.open.close(false); }
		CenteredPop.open = this;

		this.to_top();
		this.center();
		
		// create draggable handle
		if (this.options.handleSelector != '') {
			this.handle    = this.popup.down(this.options.handleSelector);
			this.draggable = new Draggable(this.popup, { handle: this.handle, starteffect: false, endeffect: false });
		}
		
		// close the popup if the user clicks anywhere in the document
		this.close_listener = this.close.bindAsEventListener(this);
		
		// optionally setup the cancel button (?)
		if(this.options.cancel) {
			this.options.cancel.observe('click', this.close_listener); }
		
		// observe close button clicks
		if (this.options.closeSelector != '') {
			this.closebtn = this.popup.down(this.options.closeSelector);
			this.closebtn.observe('click', this.close_listener);
		}
		
		// add document click listeners
		Event.observe(document, 'click', this.close_listener);
		this.popup.observe('mouseenter', function() {
			Event.stopObserving(document, 'click', this.close_listener); }.bind(this));
		
		this.popup.observe('mouseleave', function() {
			Event.observe(document, 'click', this.close_listener); }.bind(this));
		
		// create modal window
		if(this.options.modal) {
			$('modal_overlay').style.height = $$('body').first().getHeight() + "px";
			$('modal_overlay').show();
		}
		
		// make sure that activating a select does not close the pop-up
		var selects = this.popup.select('select');
		if (selects.length > 0) {
			selects.each(function(select) {
				select.observe('blur',  function() { this.working = false; }.bind(this));
				select.observe('focus', function() { this.working = true;  }.bind(this));
			}.bind(this));
		}
		
		//this.toggle_selects();
		
		(this.options.onOpen || Prototype.emptyFunction)();
		
		if (typeof(event) == 'object') { event.stop(); }
	},
	close: function(event) {
		if (this.working) { return; }
		
		CenteredPop.open = false;
		this.popup.hide();
		
		if (this.draggable) {
			this.draggable.destroy(); }
		
		if (this.closebtn) {
			this.closebtn.stopObserving('click', this.close_listener); }
		
		if (this.options.modal) {
			$('modal_overlay').hide();
		}
		
		Event.stopObserving(document, 'click', this.close_listener);
		
		this.popup.stopObserving('mouseenter');
		this.popup.stopObserving('mouseleave');
		
		//this.toggle_selects();
		
		(this.options.onClose || Prototype.emptyFunction)();
		
		if (event) {
			event.stop(); }
	},
	to_top: function() {
		CenteredPop.i += 1;
		this.popup.style.zIndex = CenteredPop.i + 1000;
		this.popup.show();
	},
	center: function() {
		if (this.hasBeenCentered) { return; }
		var w, h, pw, ph;
		w = this.popup.offsetWidth;
		h = this.popup.offsetHeight;
		Position.prepare();
		var ws = this.get_window_size();
		pw = ws[0];
		ph = ws[1];
		this.popup.style.top = Math.round(Position.deltaY + 130) + 'px';
		this.popup.style.left = Math.round((pw/2) - (w/2) -  Position.deltaX) + "px";
		this.hasBeenCentered = true;
	},
	get_window_size: function(w) {
		w = w ? w : window;
		var width = w.innerWidth || (w.document.documentElement.clientWidth || w.document.body.clientWidth);
		var height = w.innerHeight || (w.document.documentElement.clientHeight || w.document.body.clientHeight);
		return [width, height];
	},
	toggle_selects: function() {
		if (Prototype.Browser.IE && navigator.userAgent.indexOf('MSIE 6') > -1) {
			$$('select').each(function(e) { $(e).toggle() });
		}
	}
});


/* CustomLocationPop - PXP201:Show minimum advertised price on prod summary & prod detail:12/13/2010:Hai
----------------------------------------------------------------------------------------*/
var CustomLocationPop = Class.create(CenteredPop, {
	initialize: function($super, trigger, popup, referenceElement, topOffset, leftOffset){
		this.trigger = $(trigger);
		this.popup = $(popup);
		$super(this.trigger, this.popup, null);
		this.referenceElement = $(referenceElement);

		this.topOffset = (topOffset) ? topOffset : 0;
		this.leftOffset = (leftOffset) ? leftOffset : 0;
	},
	center: function() {
		if (this.referenceElement) {    // calculate position of ref elem, then add offset
			this.topRefPos = 0;
			this.leftRefPos = 0;

			var oElement = this.referenceElement;
			while( oElement != null ) {
				this.topRefPos += oElement.offsetTop;
				this.leftRefPos += oElement.offsetLeft;
				oElement = oElement.offsetParent;
			}

			this.popup.style.top = this.topRefPos + this.topOffset + 'px';
			this.popup.style.left = this.leftRefPos + this.leftOffset + 'px';
			
		} else {    // center horizontally, and place vertically in viewport with given offset - PXP211:Reorder Pad:Hai
			var w, pw;
			w = this.popup.offsetWidth;
			Position.prepare();
			var ws = this.get_window_size();
			pw = ws[0];
			this.popup.style.left = Math.round((pw/2) - (w/2) -  Position.deltaX) + "px";
			this.popup.style.top = document.viewport.getScrollOffsets()[1] + this.topOffset + 'px';
		}
	},
	setReferenceElement: function(referenceElement) {  //PXP211:Reorder Pad:Hai
		this.referenceElement = $(referenceElement);
	},
	setTopOffset: function(topOffset) {  //PXP211:Reorder Pad:Hai
		this.topOffset = topOffset;
	},
	setLeftOffset: function(leftOffset) {  //PXP211:Reorder Pad:Hai
		this.leftOffset = leftOffset;
	}
});


/* YouTubePlayer
----------------------------------------------------------------------------------------*/
var YouTubePlayer = Class.create(CenteredPop, {
	initialize: function($super, trigger, popup){
		this.trigger = trigger;
		this.popup     = popup;
		
		this.options = {
			onOpen:  this._open.bind(this),
			onClose: this._close.bind(this),
			modal: true,
			headerSelector: ".hdr_common",
			videoSelector:  "video_player"
		};
		
		$super(this.trigger, this.popup, this.options);
	},
	_open: function() {
		if (this.trigger.title && this.options.headerSelector) {
			this.header = this.popup.down(this.options.headerSelector);
			if (this.header) {
				this.header.innerHTML = this.trigger.title;
			}
		}
		if(this.options.modal) {
			$('modal_overlay').show();
		}
		var matches = this.trigger.href.match(/v=([^&]+)/);
		if (matches && matches[1]) {
			var url = "http://www.youtube.com/v/" + matches[1] + "&hl=en";
			this.so = swfobject.embedSWF(url, this.options.videoSelector , "425", "344", "8.0.0","", {}, {allowscriptaccess: "always", wmode: "transparent"});
		}
	},
	_close: function() {
		if(this.options.modal) {
			$('modal_overlay').hide();
		}
	}
});

/* Tabs
----------------------------------------------------------------------------------------*/
var Tabs = Class.create({
	initialize: function(container, togglers, tabs, active) {	
		this.container = $(container);
		this.togglers = $(togglers);
		this.tabs = $(tabs);
		this.active    = active || 0;
		this.setup();
	},
	setup: function() {
		this.togglers.each(function(el, i) {
			if (i == this.active) {
				this.togglers[i].addClassName('active');
				this.tabs[i].addClassName('active');
			} else {
				this.togglers[i].removeClassName('active');
				this.tabs[i].removeClassName('active');
			}
			
			el.onclick = function() {
				if (i != this.active) {
					el.addClassName('active');
					this.togglers[this.active].removeClassName('active');
					
					if(this.tabs.length == this.togglers.length){
						this.tabs[this.active].removeClassName('active');
						this.tabs[i].addClassName('active');
					}
				}
				this.active = i;
				return false;
			}.bind(this);
		}.bind(this));
	}
});

/* SimpleToggler
----------------------------------------------------------------------------------------*/
var SimpleToggler = Class.create({
	initialize: function(trigger, content) {
		this.trigger = trigger;
		this.content = content;
		
		if(this.trigger && this.content)
			this.setup();
	},
	setup: function() {
		//this.calcHeight();
		this.trigger.observe('click', this.toggler.bind(this));
	},
	calcHeight: function() {
		var dimensions = this.content.getDimensions();
		this.content.style.height = dimensions.height + "px";
	},
	toggler: function(ev) {
		this.trigger.toggleClassName("active");
		Effect.toggle(this.content, 'slide', { duration: 0.2 }); 
		ev.stop();
	}
});

/* HoverDelay
----------------------------------------------------------------------------------------*/
var HoverDelay = Class.create({
	initialize : function(trigger, options){
		this.options = Object.extend({closeSelector : '.close', enterCb : function(){},	leaveCb : function(){},	delay : 0.5}, options || {});
		this.trigger = $(trigger);
		this.timeout = null; 
		this.active = false;
		this.setup();
		this.homeSlide = $('home_slide');
		this.modules = $('modules');
	},
	setup : function(){
		var eEvt = this.open.bindAsEventListener(this);
		var lEvt = this.close.bindAsEventListener(this);
		this.trigger.observe('click', function(event) { 
			if (event.element().hasClassName('trigger')) {
				event.stop();
			}
		}.bindAsEventListener(this));
		this.trigger.observe('mouseenter', eEvt);
		this.trigger.observe('mouseleave', lEvt);
		this.trigger.observe('hoverdelay:stop', function(){
			this.trigger.stopObserving('mouseenter', eEvt);
			this.trigger.stopObserving('mouseleave', lEvt);
		}.bind(this));
		document.observe('pop:active', function(){this.inactive=true;}.bind(this));
		document.observe('pop:inactive', function(){this.inactive=false;}.bind(this));
	}, 
	open : function(event){
		if (this.inactive) return;
		this.timeout = (function(){
			if (this.homeSlide && this.modules){
				this.homeSlide.style.zIndex = '99';
				this.modules.style.zIndex = '1';
			}
			this.trigger.addClassName("active");
			this.options.enterCb.bind(this)();
			this.active = true;
		}).bind(this).delay(this.options.delay);
	},
	close : function(){
		if (this.inactive) return;
		if (this.timeout) {
			window.clearTimeout(this.timeout);
			this.timeout = null;
		}
		if (this.active){
			this.options.leaveCb.bind(this)();
			this.active = false;
			if (this.homeSlide && this.modules){
				this.homeSlide.style.zIndex = '1';
				this.modules.style.zIndex = '99';
			}
			this.trigger.removeClassName("active");
		}
	}
});

/* Megas
----------------------------------------------------------------------------------------*/
var Megas = Class.create({
	initialize: function(container) {
		this.container = $(container);
		this.togglers  = this.container.select('li.menu');
		this.tabs      = this.container.select('div.overlay');
		this.selects   = [];
		this.working   = false;
		this.setup();
	},
	setup: function() {
		this.togglers.each(function(el, i) {
			el.observe('mouseenter', this.open.bindAsEventListener(this, i));
			el.observe('mouseleave', this.hide.bindAsEventListener(this, i));
		}.bind(this));
	},
	open: function(event, i) {
		this.timeout = setTimeout(this.show.bind(this, i), 150);
		event.stop();
	},
	show: function(i) {
		this.togglers.invoke('removeClassName', 'active');
		this.tabs.invoke('hide')
		
		this.togglers[i].addClassName('active');
		this.tabs[i].show();
		
		clearTimeout(this.timeout);
		
		if (!this.selects[i]) {
			this.selects[i] = this.tabs[i].down('select');
			this.selects[i].observe('mouseleave', this.hide.bindAsEventListener(this, i));
			this.selects[i].observe('change', function() {
				document.location.href = this.value; });
			this.selects[i].observe('focus', function() {
				this.working = true; }.bind(this));
		}
	},
	hide: function(event, i) {
		if (this.timeout) {
			clearTimeout(this.timeout);
		}
		
		if(this.working) { return; }
			
		if (this.isSelect(event)) {
			return false;
		}
		
		this.togglers[i].removeClassName('active');
		this.tabs[i].hide();
		
		event.stop();
	},
	isSelect: function(event) {
		var el = event.element().tagName.toLowerCase();
		return ($w('select option').indexOf(el) != -1) ? true : false;
	}
});

/* PopUp
----------------------------------------------------------------------------------------*/
var PopUp = Class.create({
	initialize : function(link, pop, opts){
		this.link = link;
		this.pop = pop;
		this.options = Object.extend({
			closeSelector : '.close', 
			modal: false, 
			fade: false,
			startOpen: false
			}, opts || {}
		);
		
		if (!this.options.startOpen) {
			pop.setStyle({display:'none'});
		}
		
		this.setup();
		this.pop.observe('pop:close', this.close.bind(this));
		
	},
	setup : function(){
		this.link.observe('click', this.open.bind(this));
		this.pop.select(this.options.closeSelector).each(function(el){
			el.observe('click', this.close.bind(this));
		}.bind(this));
		
	},
	open : function(ev){
		if (ev) ev.stop();
		this.link.addClassName("active");
		
		if(this.options.modal) {
			$('modal_overlay').show();
		}
		if(this.options.fade)
			this.pop.appear({duration:.2});
		else
			this.pop.show();		
	},
	close : function(ev){
		this.link.removeClassName("active");
		if(this.options.modal)
			$('modal_overlay').hide();
		if(this.options.fade)
			this.pop.fade({duration:.2});
		else
			this.pop.hide();

		if (ev) ev.stop();
	}
});

/* CustomPopUp
----------------------------------------------------------------------------------------*/
var CustomPopUp = Class.create({
	initialize : function(link, pop, opts){
		this.options = Object.extend({
			closeSelector: '.close',
			modal:     false,
			fade:      false,
			startOpen: false,
			openCb:    Prototype.emptyFunction,
			closeCb:   Prototype.emptyFunction
		}, opts || {});
		
		this.pop = pop;
		this.link = link;
		this.setup();
		
		if (!this.options.startOpen) {
			this.pop.setStyle({ display:'none' }); }
		
		this.pop.observe('pop:close', this.close.bind(this));
	},
	setup : function(){
		this.link.observe('click', this.open.bindAsEventListener(this));
		
		this.pop.select(this.options.closeSelector).each(function(el){
			el.observe('click', this.close.bind(this)); }.bind(this));
	},
	open: function(ev) {
		this.link.addClassName('active');
		
		this.closeListener = this.close.bind(this);
		
		Event.observe(document, 'click', this.closeListener);
		this.pop.observe('mouseenter', function() {
			Event.stopObserving(document, 'click', this.closeListener); }.bind(this));
		
		this.pop.observe('mouseleave', function() {
			Event.observe(document, 'click', this.closeListener); }.bind(this));
		
		this.pop.show();
		
		(this.options.openCb || Prototype.emptyFunction)();
		
		document.fire("pop:active");
		if (ev) { ev.stop(); }
	},
	close: function(ev) {
		document.fire("pop:inactive");
		
		this.link.removeClassName("active");
		this.pop.hide();
		
		Event.stopObserving(document, 'click', this.closeListener);
		this.pop.stopObserving('mouseenter');
		this.pop.stopObserving('mouseleave');
		
		(this.options.closeCb || Prototype.emptyFunction)();
		
		ev.stop();
	}
});

/* KickOut
----------------------------------------------------------------------------------------*/
var KickOut = Class.create(PopUp, {
	setup : function(){
		new HoverDelay(this.link, {
			delay   : 0.30,
			enterCb : this.open.bind(this),
			leaveCb : this.close.bind(this)
		});
	}
});

/* PageSlide
----------------------------------------------------------------------------------------*/
var PageSlide = Class.create({
	initialize : function(contents, num_slides, prev, next, width, options){
		this.options = Object.extend({}, options || {});
		
		this.width = width;
		this.contents = contents;
		this.offset = contents.positionedOffset()[0];
		
		this.pArrow = prev;
		this.nArrow = next;
		
		this.slideCount = num_slides;
		
		this.steps = this.contents.select('.step');
		this.steps.each(function(el, idx) {
			el.observe('click', function(ev) {
				this.go(idx);
				//new Effect.Move(this.contents, { mode: 'absolute', x: (-(idx*el.getWidth())+this.offset), duration: 1, transition:Effect.Transitions.EaseFromTo });
			}.bind(this));
		}.bind(this));
		
		this.pArrow.observe('click', this.next.bind(this));
		this.nArrow.observe('click', this.prev.bind(this));
		
		this.go(0);
	},
	go : function(idx){
		//this.contents.select('.step')[this.current || 0].fire('slide:go');
		if (this.current == idx) return;
		document.fire('slide:go');
		
		if (idx < 0 || idx >= this.slideCount) return;
		this.current = idx;
		
		if (this.moving) this.moving.cancel();
		
		this.moving = new Effect.Move(this.contents, {mode: 'absolute', x:(-(idx*this.width)+this.offset), duration: .5, transition:Effect.Transitions.EaseFromTo, afterFinish: function(){
			if(this.current == 0)
				this.pArrow.addClassName("inactive");
			else
				this.pArrow.removeClassName("inactive");
			if(this.current==this.slideCount-1)
				this.nArrow.addClassName("inactive");
			else
				this.nArrow.removeClassName("inactive");
		}.bind(this)});
		
	},
	next : function(ev){
		ev.stop();
		this.go(this.current+1);
	},
	prev : function(ev){
		ev.stop();
		this.go(this.current-1);
	}
});

/* MultiPager
----------------------------------------------------------------------------------------*/
var MultiPager = Class.create(PageSlide, {
	next : function(ev){
		ev.stop();
		this.go(Math.min(this.slideCount, this.current+3));
	},
	prev : function(ev){
		ev.stop();
		this.go(Math.max(0, this.current-3));
	}
});


/* Easing Equations
----------------------------------------------------------------------------------------*/
// Based on Easing Equations v2.0
// (c) 2003 Robert Penner, all rights reserved. 
// OPEN-SOURCE TERMS OF USE: http://www.robertpenner.com/easing_terms_of_use.html
// Adapted for Scriptaculous by Ken Snyder (kendsnyder.com) June 2006
//
var elastic = function(pos) {
    return -1*Math.pow(4,-8*pos)*Math.sin((pos*6-1)*(2*Math.PI)/2)+1;
  }
var bouncePast = function(pos){
	if(pos<(1/2.75)) { 
      return (7.5625*pos*pos);
    } else if(pos<(2/2.75)) {
      return 2-(7.5625*(pos-=(1.5/2.75))*pos+.75);
    } else if(pos<(2.5/2.75)) {
      return 2-(7.5625*(pos-=(2.25/2.75))*pos+.9375);
    } else {
      return 2-(7.5625*(pos-=(2.625/2.75))*pos+.984375);
    }
}
Effect.Transitions.EaseFromTo = function(pos) {
    if ((pos/=0.5) < 1) return 0.5*Math.pow(pos,4);
    return -0.5 * ((pos-=2)*Math.pow(pos,3) - 2);   
}; 
Effect.Transitions.easeOutSine = function(pos){
	return Math.sin(pos * (Math.PI/2));
}


/* ExternalLink
----------------------------------------------------------------------------------------*/
var ExternalLink = Class.create({
	initialize: function(selector) {
		this.selector = selector;
		this.setup();
	},
	setup: function() {
		if(this.selector.getAttribute("href") && this.selector.getAttribute("rel") == "external")
			this.selector.observe('click', this.open_window.bind(this));
	},
	open_window: function(ev) {
		window.open(this.selector.href);
		ev.stop();
	}
});

/* QuickLook
----------------------------------------------------------------------------------------*/
var QuickLook = Class.create({
	initialize: function(container, trigger) {
		this.container = container;
		this.trigger   = trigger;
		this.setup();
	},
	setup: function() {
		this.hoverDelay = new HoverDelay(this.container, {
			delay: 0.15,
			enterCb: this.onEnter.bind(this)
		});
	},
	onEnter: function() {
		if (this.viewLink) { return; }
		this.closeListener = this.close.bindAsEventListener(this);
		this.dispatchListener = this.viewLinkDispatcher.bindAsEventListener(this);
		
		this.viewLink = this.trigger.down('em:first');
		this.viewLink.observe('mouseover', this.viewLinkOver.bind(this));
		this.viewLink.observe('mouseout', this.viewLinkOut.bind(this));
		this.viewLink.observe('click', this.dispatchListener);
		
		this.overlay = this.container.down('.overlay');
		this.popup = new CustomPopUp(this.viewLink, this.overlay, { closeCb: this.close.bind(this) });
	},
	viewLinkOver: function() {
		this.container.addClassName('hover');
	},
	viewLinkOut: function() {
		if (!this.container.hasClassName('opened')) {
			this.container.removeClassName('hover');
		}
	},
	viewLinkDispatcher: function(event) {
		event.stop();
		
		if (this.container.hasClassName('opened')) {
			this.close();
		} else {
			this.open();
		}
	},
	open : function() {
		this.container.addClassName('opened');
		
		if (!this.closeLink) {
			this.closeLink = new Element('em', { 'class': 'close_link' }).update("Close Specs");
			this.container.down("a.img").insert(this.closeLink, { 'position' : 'bottom' });
		}
	},
	close: function(event) {
		this.container.removeClassName('active');
		this.container.removeClassName('opened');
		
		if (!this.overlay.visible()) {
			this.container.removeClassName('hover');
		}
	},
	teardown: function() {
		if (this.viewLink) {
			this.viewLink.stopObserving('mouseover');
			this.viewLink.stopObserving('mouseout');
			this.viewLink.stopObserving('click', this.dispatchListener);
		}
	}
});

/* Cookie
----------------------------------------------------------------------------------------*/
var Cookie = {
	set: function(name, value, daysToExpire) {
		var expire = '';
		if (daysToExpire != undefined) {
			var d = new Date();
			d.setTime(d.getTime() + (86400000 * parseFloat(daysToExpire)));
			expire = '; expires=' + d.toGMTString();
		}
		return (document.cookie = escape(name) + '=' + escape(value || '') + expire + '; path=/');
	},
	get: function(name) {
		var cookie = document.cookie.match(new RegExp('(^|;)\\s*' + escape(name) + '=([^;\\s]*)'));
		return (cookie ? unescape(cookie[2]) : null);
	},
	erase: function(name) {
		var cookie = Cookie.get(name) || true;
		Cookie.set(name, '', -1);
		return cookie;
	},
	accept: function() {
		if (typeof navigator.cookieEnabled == 'boolean') {
			return navigator.cookieEnabled;
		}
		Cookie.set('_test', '1');
		return (Cookie.erase('_test') === '1');
	}
}

/* ForgotPassword
----------------------------------------------------------------------------------------*/
var ForgotPassword = Class.create(CenteredPop, {
	initialize: function($super, trigger, popup) {
		var options = {
			onOpen:  this._open.bind(this),
			onClose: this._close.bind(this)
		}
		$super(trigger, popup, options);
	},
	_open: function() {
		this.popup.removeClassName('successful');
		this.popup.removeClassName('failure');
		
		this.form = this.popup.down('form');
		this.validation = new Validation(this.form, { onSubmit: false });
		this.validation.reset();
		
		this.submit_listener = this.onSubmit.bindAsEventListener(this);
		this.form.observe('submit', this.submit_listener);
	},
	_close: function() {
		this.form.stopObserving('submit', this.submit_listener);
	},
	onSubmit: function(event) {
		event.stop();
		if (this.validation.validate()) {
			new Ajax.Request('/pex/control/forgotpassword', {
				method:    'post',
				parameters: Form.serialize(this.form),
				onComplete: this.showResponse.bind(this)
			})
		}
	},
	showResponse: function(response, json) {
		if (json.status == 'SUCCESS') {
			this.popup.addClassName('successful');
		} else {
			this.popup.addClassName('failure');
		}
	}
})


/* MyAccount
----------------------------------------------------------------------------------------*/
var MyAccount = Class.create({
	initialize: function(container, trigger) {
		this.container = container;
		this.trigger   = trigger;
		this.done      = false;
		this.endpoint  = '/pex/control/myAccountNav';
		this.setup();
	},
	setup: function() {
		this.bound_open = this.open.bindAsEventListener(this);
		this.trigger.observe('click', this.bound_open);
	},
	open: function(event) {
		if (!this.done) {
			new Ajax.Request(this.endpoint, {method: 'post', onComplete: this.commit.bind(this)});
		}
		event.stop();
	},
	commit: function(response, json) {
		this.trigger.stopObserving('click', this.bound_open);
		this.trigger.addClassName('active');
		
		// Accounts for diff. CSS implementations for signed in/out states
		if (response.getHeader('x-pex-account') == 'yes') {
			this.trigger.insert({ bottom: response.responseText });
			new KickOut(this.trigger, $('overlay_account'), { startOpen: true })
		} else {
			this.container.insert({ bottom: response.responseText });
			new CustomPopUp(this.trigger, $('overlay_signin'), { startOpen: true });
			new ForgotPassword($('trigger_pw'), $('overlay_pw'));
			this.container.select('.prompt').each(function(el) {
				new Prompt(el); });
		}
	}
});

/* MyCart
----------------------------------------------------------------------------------------*/
var MyCart = Class.create();
MyCart.prototype = {
	initialize: function() {
		this.container = $('mycart');
		this.checkout  = this.container.down('a.btn_checkout');
		this.total     = this.container.down('span.total');
		this.completed = false;
		document.observe('cart:updated', this.setup.bind(this));
		
		this.setup();
	},
	setup: function() {
		var sessionId    = Cookie.get('JSESSIONID');
		var shoppingCart = Cookie.get('ShoppingCart');
		
		
		if (shoppingCart) {
			var matches = shoppingCart.match(/^QTY:([^|]+)\|TOTAL:([^|]+)\|JSESSIONID:([^|]+)(\|[^:|]+:[^:|]+)*$/);	//PXP48:Bug Fix:Cookie pattern was not matching with the structure we created - 03/09/2010 by Vicky			
			/*if (!sessionId || (sessionId != matches[3])) {
				Cookie.erase('ShoppingCart');
			} else if (matches[1] > 0) {*/	//PXP48:Bug Fix:Remove JSESSIONID matching to support anonymous user to use ShoppingCart - 03/09/2010 by Vicky
			if (matches[1] > 0) {
				this.total.innerHTML = '(' + parseInt(matches[1]) + ')';
				this.checkout.href = '/pex/control/checkout';
				this.completed = true;
			}
		}
		if (!this.completed) {
			this.total.innerHTML = '(0)';
			this.checkout.href = '/pex/control/viewCart';
		}
	},
	reset: function() {
	}
}

/* AjaxCart
----------------------------------------------------------------------------------------*/
var AjaxCart = Class.create({
	initialize: function(trigger) {
		AjaxCart.open  = false;
		this.trigger   = $(trigger);
		this.container = $('wrapper');
		this.endpoint  = '/pex/control/ajaxCart';
		this.busy      = false;
		this.animating = false;
		this.hovering  = false;
		this.setup();
	},
	setup: function() {
		this.bound_add    = this.addItem.bindAsEventListener(this)
		this.bound_hide   = this.hideCart.bindAsEventListener(this);
		this.bound_close  = this.closeCart.bindAsEventListener(this);
		this.bound_stimer = this.setTimer.bind(this);
		this.bound_ctimer = this.clearTimer.bind(this);
		
		this.trigger.observe('click', this.bound_add);
	},
	addItem: function(event) {
		event.stop();
		
		if (this.busy) { return; }
		
		this.busy = true;
		this.createCart();
		
		this.trigger.addClassName('animate');
		
		this.form = this.trigger.up('form');
		new Ajax.Updater(this.cart, this.endpoint, {
			method: 'post',
			parameters: this.form.serialize(),
			onComplete: function(response) {
				this.animate();
				sendTrackingEvent('cart', response);
			}.bind(this)
		});
	},
	animate: function() {
		Event.stopObserving(window, 'scroll', this.bound_hide);
		
		var browserWidth = document.viewport.getWidth();
		var scrollOffset = document.viewport.getScrollOffsets();
		
		this.overlay = this.cart.down('div');
		this.overlayDimensions = this.overlay.getDimensions();
		
		if (this.overlayDimensions.width == 0) {
			this.overlayDimensions = this.cart.getDimensions();
		}
		
		if (AjaxCart.open) { AjaxCart.open.hideCart(); }
		AjaxCart.open = this;
		
		this.cart.setStyle({
			display:  'block',
			opacity:  1,
			top:      (scrollOffset.top - this.overlayDimensions.height) + 'px',
			left:     ((browserWidth / 2) - (this.overlayDimensions.width / 2)) + 'px',
			width:    this.overlayDimensions.width + 'px',
			height:   this.overlayDimensions.height + 'px'
		});
		
		new Effect.Move(this.cart, { y: this.overlayDimensions.height, mode: 'relative', duration: 0.47, afterFinish: this.createCartObservers.bind(this) });
		
		document.fire('cart:updated');
		
		this.cart.down('a.close').observe('click', this.bound_close);		
		/*****<#--PXP24:POP-UP Cart:1/14/2010:By kinjal-->******/
		/*****this.cart.down('a.icon_continue').observe('click', this.bound_close);*****/
		this.cart.down('a.button_ajaxcart').observe('click', this.bound_close);
		/*****<#--PXP24:End POP-UP Cart:1/14/2010:By kinjal-->******/
		
		setTimeout(function() {
			this.trigger.removeClassName('animate');
		}.bind(this), 600);
	},
	createCart: function() {
		if (this.cart) { return; }
		
		this.cart = new Element('div', { 'id' : 'ajaxcart', 'class': 'clear' });
		this.container.insert(this.cart, { 'position' : 'bottom' });
		this.cart.setStyle({
			display:  'block',
			position: 'absolute',
			zIndex:   999999
		});
	},
	closeCart: function(event) {
		if (!this.animating) {
			if (Prototype.Browser.IE) {
				new Effect.Move(this.cart, {y: (-1 * this.overlayDimensions.height), mode: 'relative', duration: 0.45, beforeStart: this.preAnimate.bind(this), afterFinish: this.hideCart.bind(this) });
				
			} else {
				new Effect.Parallel([
					new Effect.Move(this.cart, { sync: true, y: (-1 * this.overlayDimensions.height), mode: 'relative' }),
					new Effect.Opacity(this.cart, { sync: true, from: 1, to: 0, delay: 0.3})
				], { duration: 0.45, beforeStart: this.preAnimate.bind(this), afterFinish: this.hideCart.bind(this) });
			}
		}
		//if (typeof(event) == 'object') { event.stop(); }//PXP49:Remove javascript error (previously, when the ajax cart is closed automatically, it gives javascript error):03/11/2010 by Vicky
	},
	hideCart: function() {
		this.cart.stopObserving('mouseenter',  this.bound_ctimer);
		this.cart.stopObserving('mouseleave', this.bound_stimer);
		
		this.cart.down('a.close').stopObserving('click', this.bound_close);
		/****<#--PXP24:POP-UP Cart:1/14/2010:By kinjal-->****/
		/****this.cart.down('a.icon_continue').stopObserving('click', this.bound_close);****/
		this.cart.down('a.button_ajaxcart').stopObserving('click', this.bound_close);
		/****<#--PXP24:End POP-UP Cart:1/14/2010:By kinjal-->****/
		this.clearTimer();
		this.cart.hide();
		this.animating = false;
		this.busy      = false;
	},
	createCartObservers: function() {
		this.setTimer();
		Event.observe(window, 'scroll', this.bound_hide)
		this.cart.observe('mouseenter',  this.bound_ctimer);
		this.cart.observe('mouseleave', this.bound_stimer);
	},
	setTimer: function() {
		if (this.timer == undefined) {
			this.timer = setTimeout(this.bound_close, 3000);
		}
	},
	clearTimer: function() {
		clearTimeout(this.timer);
		this.timer = undefined;
	},
	preAnimate: function() {
		this.animating = true;
	},
	teardown: function() {
		this.trigger.stopObserving('click', this.bound_add);
	}
});


/* MailChimp
----------------------------------------------------------------------------------------*/
var MailChimp = Class.create({
	initialize: function(container) {
		this.container = container;
		this.form      = this.container.down('form');
		if (this.form) {
			this.setup(); }
	},
	setup: function() {
		this.form.observe('submit', this.send.bindAsEventListener(this));
	},
	send: function(event) {
		if(Validation.get('validate-email').test(this.form.elements['emailAddress'].value)) {
			var myAjax = new Ajax.Request('/pex/control/subscribeToNewsletter', {
				method:     'post',
				parameters: Form.serialize(this.form),
				onComplete: this.respond.bind(this)
			});
		} else {
			alert('Please enter a valid e-mail address (for example: yourname@example.com).');
		}
		event.stop();
	},
	respond: function(transport, json) {
		if (json.status == 'SUCCESS') {
			this.container.addClassName('complete');
		} else {
			alert(json.errors);
		}
	}
});

/* Prompt
----------------------------------------------------------------------------------------*/
var Prompt = Class.create({
	initialize: function(field) {
		this.field = $(field);
		this.setup();
	},
	setup: function() {
		this.field.observe('focus', this.focus.bind(this));
		this.field.observe('blur', this.blur.bind(this));
		this.field.setAttribute('autocomplete', 'off');
	},
	focus: function() {
		if (this.field.value == this.field.defaultValue) {
			this.field.value = '';
			this.field.addClassName('active');
		}
	},
	blur: function() {
		if (this.field.value == '') {
			this.field.value = this.field.defaultValue;
			this.field.removeClassName('active')
		}
	}
});

/* PromptHighlighter
----------------------------------------------------------------------------------------*/
var PromptHighlighter = Class.create({
	initialize: function(field) {
		this.field = $(field);
		this.setup();
	},
	setup: function() {
		this.field.observe('focus', this.focus.bind(this));
		this.field.observe('blur', this.blur.bind(this));
	},
	focus: function() {
		this.field.addClassName('active');
	},
	blur: function() {
		this.field.removeClassName('active')
	}
});

/* DropDown
----------------------------------------------------------------------------------------*/
var DropDown = Class.create({
	initialize : function(select, opts){
		this.orig = $(select);
		this.options = [];
		this.opts = Object.extend({
			onchange : function(){}
		}, opts || {});
		this.setup();
		DropDown.lastOpened = null;  //PXP268:Hai
	},
	//PXP268:New dropdown behavior & slight style change:02/21/2011:Hai
	setup : function(){
		this.styled = new Element('ul',{'class':'custom'});
		this.hidden = new Element('input', {'type':'hidden','name':this.orig.readAttribute('name'), 'id':this.orig.readAttribute('id')});

		this.openFunc = this.open.bind(this);  //PXP268:Hai
		this.selected = new Element('li',{'class' : 'lead clear'})
			.insert('<a href="javascript:void(0)">&nbsp;</a>')  //PXP268:Hai:# becomes javascript:void(0)
			.observe('click', this.openFunc)
			.insert(this.hidden);
			
		this.selectable = new Element('ul');
		this.selects = new Element('li',{'class':'options'})
			.insert(this.selectable);
		
		this.styled.insert(this.selected)
			.insert(this.selects);
					
		this.onchange = this.opts.onchange;
		this.form = this.orig.form;
		
		this.orig.select('option').each(function(op, i){
			var a = new Element('a',{href:'javascript:void(0)'}).update(op.innerHTML);  //PXP268:Hai:# becomes javascript:void(0)
			var li = new Element('li', { 'class' : 'clear'});
			li._val = op.readAttribute('value');
			li.appendChild(a);
			this.selectable.appendChild(li);
			this.options.push(li);
			li.observe('click', this.select.bind(this, li));
			if (i == 0)
				this.selectedValue = li._val;
		}.bind(this));
		this.select(this.options[this.orig.selectedIndex], true, true);
		this.orig.replace(this.styled);
		this.bfx = this.close.bindAsEventListener(this);
	},
	reset : function(opts) {
		this.options.each(function(op, i){
			op._val = opts[i];
		});
		//PXP270 - Fixed issue where product list resets to Default, but dropdown does not. - Matt 2/28/2011
		this.select(this.options[1], true, true);
	},
	open : function(ev){
		var self = this;
		this.selectedItem.hide().addClassName('hidden');
		//this.selects.appear({duration:.4});
		this.selects.show();
		this.selected.addClassName("active");
		if (this.selects.down('li:not(li.hidden)')) {
			this.selects.down('li:not(li.hidden)').addClassName("firstItem");
		}
		this.selected.stopObserving('click', this.openFunc);  //PXP268:Hai
		this.selected.observe('click', this.bfx);  //PXP268:Hai
		document.observe('click', this.bfx);
		if (ev && ev.stop) { ev.stop(); }  //PXP268:Hai
		if (DropDown.lastOpened) {   //PXP:Hai:close any opened dropdown
			DropDown.lastOpened.close(null);
		}
		DropDown.lastOpened = this;  //PXP268:Hai:keep track of last opened dropdown
	},
	close : function(ev){
		this.selects.hide();
		this.selected.removeClassName("active");
		this.selects.select('li').invoke('removeClassName', 'firstItem');
		this.selected.stopObserving('click', this.bfx);  //PXP268:Hai
		document.stopObserving('click', this.bfx);
		this.selected.observe('click', this.openFunc);  //PXP268:Hai
		if (ev && ev.stop) { ev.stop(); }  //PXP268:Hai
		DropDown.lastOpened = null;  //PXP:Hai:no more opened dropdown
	},
	select : function(item, ev, skipchange){
		if (ev && ev.stop) { ev.stop(); }
		this.selected.select('a').first().update(item.select('a')[0].innerHTML);
		if (this.selectedItem) this.selectedItem.removeClassName("hidden");
		this.selectedItem  = item;
		this.selectedValue = item._val;
		this.hidden.writeAttribute('value', item._val);
		this.close();
		this.options.invoke('show');
		if (!skipchange && this.onchange){
			this.onchange.apply(this, new Array(this.hidden.value));
			//window.location = this.hidden.value;
		}
	}
});

/* ShowMore
----------------------------------------------------------------------------------------*/
var ShowMore = Class.create({
	initialize : function(content, moreText, lessText) {
		this.content = content;
		this.moreText = moreText;
		this.lessText = lessText;
		this.ellipsis = new Element('span', { 'class': 'ellipsis' }).update("... ");
		this.anchor = new Element('a', { href: "#"});
		this.setup();
	},
	setup: function() {
		this.content.insert(this.ellipsis);
		this.content.insert(this.anchor);
		this.anchor.update(this.moreText);
		this.anchor.observe('click', this.toggler.bind(this));
	},
	toggler: function(ev) {
		this.anchor.previous(".more").toggleClassName("active");
		this.anchor.innerHTML = (this.anchor.innerHTML == this.moreText) ? this.lessText : this.moreText;
		this.ellipsis.innerHTML = (this.anchor.innerHTML == this.moreText) ? "... " : "";
		ev.stop();
	}
});

/* HelpMeChoose
----------------------------------------------------------------------------------------*/
var HelpMeChoose = Class.create({
	initialize: function(container, options) {
		this.container = $('container');
		
		this.options = Object.extend({
			togglersSelector: '.togglers li',
			tabSelector:      '.tab_content',
			closeSelector:    '.close'
		}, options);
		
		this.togglers = $$(this.options.togglersSelector);
		this.tabs     = $$(this.options.tabSelector);
		this.total    = this.togglers.length;
		this.setup();
	},
	setup: function() {
		this.bound_close    = this.close.bindAsEventListener(this);
		this.togglers.each(function(toggler, i) {
			toggler.observe('click', this.activate.bindAsEventListener(this, i)); }.bind(this));
	},
	activate: function(event, sel) {
		var el = event.findElement('li');
		for (var i = 0; i < this.total; i++) {
			var close_btn = this.tabs[i].down(this.options.closeSelector);
			if (this.togglers[i].hasClassName('active') || i != sel) {
				this.togglers[i].removeClassName('active');
				this.tabs[i].removeClassName('active');
				if (close_btn) {
					close_btn.stopObserving('click', this.bound_close); }
			} else {
				this.togglers[i].addClassName('active');
				this.tabs[i].addClassName('active');
				if (close_btn) {
					close_btn.observe('click', this.bound_close); }
			}
		}
		event.stop();
	},
	close: function(event) {
		var el = event.element();
		el.stopObserving('click', this.bound_close);
		for (var i = 0; i < this.total; i++) {
			this.togglers[i].removeClassName('active');
			this.tabs[i].removeClassName('active');
		}
		event.stop();
	}
});

/* RadioEventObserver
----------------------------------------------------------------------------------------*/
var RadioEventObserver = Class.create({
	initialize: function(form, name, callback) {
		this.elements = [];
		myElements = Form.getElements(form);
		for (var i = 0; i < myElements.length; i++) {
			if ((myElements[i].type == 'radio') && (myElements[i].name == name)) {
				$(myElements[i]).observe('click', callback)
			}
		}
	}
});

/* $RF
----------------------------------------------------------------------------------------*/
function $RF(el, radioGroup) {
	if($(el).type && $(el).type.toLowerCase() == 'radio') {
		var radioGroup = $(el).name;
		var el = $(el).form;
	} else if ($(el).tagName.toLowerCase() != 'form') {
		return false;
	}

	var checked = $(el).getInputs('radio', radioGroup).find(
		function(re) { return re.checked; }
	);
	
	return (checked) ? $F(checked) : null;
}
				 
/* ShowAll
----------------------------------------------------------------------------------------*/
var ShowAll = Class.create({
	initialize : function(container, options){
		this.options = Object.extend(
				{viewableItems: 5, 
				 toggleSel:'.toggle', 
				 rowSelector:'li', 
				 heightSelector:'.overflow ul',
				 duration: .5
				 }, options || options);
		var rows = container.select(this.options.rowSelector);
		this.limit = rows[this.options.viewableItems];
		this.container = container;
		this.parent = container.down('.overflow');
		this.trigger = container.down(this.options.toggleSel);
		if (this.limit){
			this.parent.style.height = this.closedHeight();
			this.hideable = this.limit.previous().nextSiblings();
			this.hideable.invoke('setStyle', {display:'none'});
			this.parent.style.height = "100%";
			if (this.trigger){
				var t = this.trigger.innerHTML.replace(/\$COUNT/g, rows.length);
				this.trigger.update(t);
				this.triggerText = this.trigger.observe('click', this.toggle.bind(this)).innerHTML;
			}
		}else
			if (this.trigger)
				this.trigger.hide();
			
		
	},
	openHeight : function(){
		return this.container.down(this.options.heightSelector).getHeight() +'px'
	},
	closedHeight : function(){
		return Math.max(0,this.limit.positionedOffset().top -this.parent.positionedOffset().top) + 'px';
	},
	toggle : function(ev){
		ev.stop();
		if (this.open){
			this.parent.style.height = this.openHeight();
			this.parent.morph(
				{'height':this.closedHeight()},
				{ duration: this.options.duration },
				{afterFinish:function(){
				this.hideable.invoke('setStyle',{display:'none'});
				this.parent.style.height = "100%";
			}.bind(this)});
			new Effect.ScrollTo('container');
		}else{
			this.limit.style.display = '';
			this.parent.style.height = this.closedHeight();
			this.hideable.invoke('setStyle',{'display':''});
			this.parent.morph(
				{'height':this.openHeight()},
				{ duration: this.options.duration },
				{afterFinish:function(){
				this.parent.style.height='100%';
			}.bind(this)});
		}
		this.trigger.toggleClassName('active');
		this.open = this.trigger.hasClassName('active');
		this.trigger.update(this.open?"Show Less":this.triggerText);
	}	
	
});


/* ToolTip
----------------------------------------------------------------------------------------*/
var ToolTip = Class.create(PopUp, {	
	setup : function(){
		new HoverDelay(this.link, {
			enterCb : this.open.bind(this),
			leaveCb : this.close.bind(this)
		});
	}
});

/* PositionMixin
----------------------------------------------------------------------------------------*/
var PositionMixin = {
	initialize : function($super, linkId, popId, opts){
		opts = Object.extend({
			anchor : linkId, 
			yOffset:0, 
			xOffset:0, 
			parent:$$('body').first(), 
			enableCache:false, 
			defaultArrowRight:false
		},opts || {});
		$super(linkId, popId, opts);
		this.anchor = $(this.options.anchor);
        this.pop.makePositioned();
		this.arrow = this.pop.select('.tooltip_arrow').first();
	},
	open : function($super, ev){
		if (this.options.popParent){
			(this.anchor.up(this.options.popParent) || $$(this.options.popParent).first())
				.insert(this.pop);
		}
		
		if (!this.options.enableCache || !this.position){
			this.calculatePosition(this.options.forceRender);
		}
		this.pop.style.top = this.position.top+'px'; this.pop.style.left = this.position.left+'px';
		
		if(this.options.defaultArrowRight) {
			this.arrow.addClassName('right');
		}
		else {
			if (this.side=="right"){
				this.arrow.addClassName('left');
				//this.leftA.addClassName('active').setStyle({visibility:'visible'}); this.rightA.removeClassName('active').setStyle({visibility:'hidden'});
			}else{
				this.arrow.addClassName('right');
				//this.rightA.addClassName('active').setStyle({visibility:'visible'}); this.leftA.removeClassName('active').setStyle({visibility:'hidden'});
			}
		}
		
		this.toggle_selects();
		$super(ev);
	},
	calculatePosition : function(force){
		var pos = this.anchor.cumulativeOffset();
		this.side = force || (pos.left<this.options.parent.cumulativeOffset().left+(this.options.parent.getWidth()/2)) ? 'right':'left';
		var position = this.anchor.positionedOffset();
		var x = position.left;
		var y = position.top;
		y+= this.options.yOffset;
		if (this.side == 'right'){
			x+= this.options.xOffset;
		}else{
			x-=this.pop.getWidth();
			//x-=this.anchor.getWidth();
			//x-=this.options.xOffset;
		}
		this.position = {left:x,top:y};
	},
	toggle_selects: function() {
		if (Prototype.Browser.IE && navigator.userAgent.indexOf('MSIE 6') > -1) {
			$$('select').each(function(e) { $(e).toggle() });
		}
	}
};

var PositionedToolTip = Class.create(ToolTip, PositionMixin);



/* Omniture Tracking
----------------------------------------------------------------------------------------*/
var sendTrackingEvent = function(event, response) {
	if (typeof(s) != "object") return;
	switch(event) {
	  case 'cart':
	    s.pageName = "Ajax Cart Addition";
		s.events   = response.getHeader('x-omniture-event');
		s.products = ";" + response.getHeader('x-omniture-product');
		void(s.t());
		break;
	}
}

/**
 * Input prompt controller that toggles a <label>'s visibility over a textbox
 * Upon focus or click, the <label> is hidden
 * If no text is entered and the user loses focus to the input, the <label> reappears
 * @alias Prompt
 */
var GlobalSearchPrompt = Class.create({
	initialize: function(field) {
		this.field = $(field);
		this.label = this.field.down('label');
		this.input = this.field.down('input.search_prompt');
		this.setup();
	},
	setup: function() {
		if(this.input.value !== '') {
			this.focus();
		}
		this.label.observe('click', this.focus.bind(this));
		this.input.observe('focus', this.focus.bind(this));
		this.input.observe('blur', this.blur.bind(this));
	},
	focus: function() {
		this.label.hide();
		this.input.focus();
		this.input.addClassName('active');
	},
	blur: function() {
		if (this.input.value === '') {
			this.label.show();
		}
		this.input.removeClassName('active');
	}
});


/* trim() function
see http://javascript.crockford.com/remedial.html
and http://blog.stevenlevithan.com/archives/faster-trim-javascript
----------------------------------------------------------------------------------------*/
if (!String.prototype.trim) {
    String.prototype.trim = function () {
        return this.replace(/^\s*(\S*(?:\s+\S+)*)\s*$/, "$1");
    };
}


/*----------------------------------------------------------------------------------------*/

document.observe('dom:loaded', function(){
	$$("input.prompt", "textarea.prompt").each(function(el) { new Prompt(el); })
	
	if($('search_global')){	//PXP77:bug fix for ajax initiating of global search box - 05/06/2010 added by Vicky
		new GlobalSearchPrompt('search_global');		
	}
	
	new Megas('nav_main');
	
	if ($('mycart')) {
		new MyCart();
	}
	
	try {
	  document.execCommand('BackgroundImageCache', false, true);
	} catch(e) {}
	
	if ($('trigger_signin')) {
		new MyAccount($('nav_utility'), $('trigger_signin'));
	}
	
	if($('btn_search_global')){
		$('btn_search_global').onclick = function(){
			$('search_form').submit();
		}
	}
	
	if($('btn_login_global')){
		$('btn_login_global').onclick = function(){
			$('signin_form').submit();
		}
	}
	
	if ($('content_subscribe')) {
		new MailChimp($('content_subscribe'));
	}
	
	if($('trigger_returns'))
		new CenteredPop($('trigger_returns'), $('overlay_returns'));
	
	if($('trigger_shipping_info'))
		new CenteredPop($('trigger_shipping_info'), $('overlay_shipping_info'));
	
	//PXP287:T&T Campaign: Item In-Stock note: 03/07/2011: Shuchi
	if($('trigger_instock_info'))
		new CenteredPop($('trigger_instock_info'), $('overlay_instock_info'));
	
	if($('trigger_price'))
		new CenteredPop($('trigger_price'), $('overlay_price'));
	
	// PXP201:Show minimum advertised price on prod summary & prod detail:12/13/2010:Hai
	if($('trigger_map_price'))
		new CustomLocationPop($('trigger_map_price'), $('overlay_map_price'), $('trigger_map_price'), 20, 0);

	if($('trigger_privacy'))
		new CenteredPop($('trigger_privacy'), $('overlay_privacy'));
	
	if($('trigger_security'))
		new CenteredPop($('trigger_security'), $('overlay_security'));
		
	if($('trigger_secure'))
		new CenteredPop($('trigger_secure'), $('overlay_security'));
		
	if($('trigger_cvv'))
		new CenteredPop($('trigger_cvv'), $('overlay_cvv'));

	/***PXP136:BOF Tax Rebate:10/1/2010:By kinjal***/
	if($('trigger_taxRebate'))
	  new CenteredPop($('trigger_taxRebate'), $('overlay_taxRebate'));	
	/***PXP136:EOF Tax Rebate:10/1/2010:By kinjal***/
	
	//$$("input.text", "textarea.text").each(function(el) { new PromptHighlighter(el); })
	//$$('a').each(function(el) { new ExternalLink(el); });
});
