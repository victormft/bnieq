/*
 * 	Character Count Plugin - jQuery plugin
 * 	Dynamic character count for text areas and input fields
 *	written by Alen Grakalic	
 *	http://cssglobe.com/post/7161/jquery-plugin-simplest-twitterlike-dynamic-character-count-for-textareas
 *
 *	Copyright (c) 2009 Alen Grakalic (http://cssglobe.com)
 *	Dual licensed under the MIT (MIT-LICENSE.txt)
 *	and GPL (GPL-LICENSE.txt) licenses.
 *
 *	Built for jQuery library
 *	http://jquery.com
 *
 */
 
(function($) {

	$.fn.charCount = function(options){
	  
		// default configuration properties
		var defaults = {	
			allowed: 140,		
			warning: 25,
			css: 'counter',
			counterElement: 'span',
			cssWarning: 'warning',
			cssExceeded: 'exceeded',
			counterText: ''
		}; 
			
		var options = $.extend(defaults, options); 
		
		function calculate(obj){
			var count = $(obj).val().length;
			var available = count;
			if(available >= options.warning && available <= options.allowed){
				$(obj).next().next().addClass(options.cssWarning);
			} else {
				$(obj).next().next().removeClass(options.cssWarning);
			}
			if(available > options.allowed){
				$(obj).next().next().addClass(options.cssExceeded);
			} else {
				$(obj).next().next().removeClass(options.cssExceeded);
			}
			$(obj).next().next().html(options.counterText + available + ' / ' + options.allowed);
		};
		
		function calculate_first(obj){
			var count = $(obj).val().length;
			var available = count;
			if(available >= options.warning && available <= options.allowed){
				$(obj).next().addClass(options.cssWarning);
			} else {
				$(obj).next().removeClass(options.cssWarning);
			}
			if(available > options.allowed){
				$(obj).next().addClass(options.cssExceeded);
			} else {
				$(obj).next().removeClass(options.cssExceeded);
			}
			$(obj).next().html(options.counterText + available + ' / ' + options.allowed);
		};
				
		this.each(function() {  			
			$(this).after('<p style="font-size:12px;"><'+ options.counterElement +' class="' + options.css + '">'+ options.counterText +'</'+ options.counterElement +'></p>');
			calculate_first(this);
			$(this).keyup(function(){calculate(this)});
			$(this).change(function(){calculate(this)});
		});
	  
	};

})(jQuery);
