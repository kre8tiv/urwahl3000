if (!window.getComputedStyle) {
	window.getComputedStyle = function(el, pseudo) {
		this.el = el;
		this.getPropertyValue = function(prop) {
			var re = /(\-([a-z]){1})/g;
			if (prop == 'float') prop = 'styleFloat';
			if (re.test(prop)) {
				prop = prop.replace(re, function () {
					return arguments[2].toUpperCase();
				});
			}
			return el.currentStyle[prop] ? el.currentStyle[prop] : null;
		}
		return this;
	}
}

jQuery(document).ready(function($) {
	var responsive_viewport = $(window).width();
	if (responsive_viewport < 481) {
	}
	if (responsive_viewport > 481) {
	}
	if (responsive_viewport >= 768) {
		$('.comment img[data-gravatar]').each(function(){
			$(this).attr('src',$(this).attr('data-gravatar'));
		});
	}
	if (responsive_viewport > 1030) {
	}
});


(function(w){
	if( !( /iPhone|iPad|iPod/.test( navigator.platform ) && navigator.userAgent.indexOf( "AppleWebKit" ) > -1 ) ){ return; }
	var doc = w.document;
	if( !doc.querySelector ){ return; }
	var meta = doc.querySelector( "meta[name=viewport]" ),
		initialContent = meta && meta.getAttribute( "content" ),
		disabledZoom = initialContent + ",maximum-scale=1",
		enabledZoom = initialContent + ",maximum-scale=10",
		enabled = true,
		x, y, z, aig;
	if( !meta ){ return; }
	function restoreZoom(){
		meta.setAttribute( "content", enabledZoom );
		enabled = true; }
	function disableZoom(){
		meta.setAttribute( "content", disabledZoom );
		enabled = false; }
	function checkTilt( e ){
		aig = e.accelerationIncludingGravity;
		x = Math.abs( aig.x );
		y = Math.abs( aig.y );
		z = Math.abs( aig.z );
		if( !w.orientation && ( x > 7 || ( ( z > 6 && y < 8 || z < 8 && y > 6 ) && x > 5 ) ) ){
			if( enabled ){ disableZoom(); } }
		else if( !enabled ){ restoreZoom(); } }
	w.addEventListener( "orientationchange", restoreZoom, false );
	w.addEventListener( "devicemotion", checkTilt, false );
})( this );

jQuery(function() {  
	var pull		= jQuery('#switch-menu');  
		menu		= jQuery('#nav-main'); 
		search	  = jQuery('.searchform'); 
		pull2		= jQuery('#switch-search'); 

	jQuery(pull).on('click', function(e) {  
		e.preventDefault();  
		menu.slideToggle();  
	}); 
	jQuery(pull2).on('click', function(e) {  
		e.preventDefault();  
		search.slideToggle();  
	});  
});  
			  		
jQuery(window).resize(function(){  
	var w = jQuery(window).width();  
	if(w > 768 && menu.is(':hidden')) {  
		menu.removeAttr('style');  
	}
	if(w > 768 && search.is(':hidden')) {  
		search.removeAttr('style');  
	}
});

jQuery(document).ready(function() {
	jQuery(".fancybox").fancybox({
		closeBtn  : false,
		beforeShow: function() {
			this.title = jQuery(this.element).find('img').attr('alt');
		},
		helpers: {
			title : {
				type : 'inside'
			},
			buttons	: {}
		}
	});
	
jQuery("#back-top").hide();
	
jQuery(function () {
	jQuery(window).scroll(function () {
		if (jQuery(this).scrollTop() > 500) {
			jQuery('#back-top').fadeIn();
		} else {
			jQuery('#back-top').fadeOut();
		}
	});

	jQuery('#back-top a').click(function () {
		jQuery('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});
});