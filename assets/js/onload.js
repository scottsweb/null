// IE8 ployfill for GetComputedStyle (for responsive script below)
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

jQuery(document).ready(function() {
	
	// add classes to form elements for consisten styles
	jQuery("input[type='button']").addClass('button');
	jQuery("input[type='checkbox']").addClass('checkbox');
	jQuery("input[type='file']").addClass('file');
	jQuery("input[type='image']").addClass('image');
	jQuery("input[type='password']").addClass('password');
	jQuery("input[type='radio']").addClass('radio');
	jQuery("input[type='submit']").addClass('submit');
	jQuery("input[type='text']").addClass('text');
	jQuery("input[type='email']").addClass('text');
	jQuery("input[type='url']").addClass('text');
	
	// html5 forms
	jQuery('#comment-form').html5form({
		async 		: false,
		colorOff	:'#bbb',
		allBrowsers : true,
		messages	: 'en',
		responseDiv : '#form-feedback'
	});    
	
	jQuery('#searchform').html5form({
		async 		: false,
		labels		: 'hide',
		allBrowsers : true
	});
	
	// html5 404 search form 
	jQuery('#search-form-404').html5form({
		async 		: false,
		labels		: 'hide',
		colorOff	:'#bbb',
		allBrowsers : true
	});
	
	// accordion shortcode
	jQuery(".accordion-shortcode").accordion({ 
		autoHeight: false, 
		collapsible: true, 
		active: false,
		header: '.aheader'
	});
	
	// tabs shortcode
	jQuery(".tabs-shortcode").tabs({ 
		fx: { opacity: 'toggle' },
		select: function(event, ui) { 
			window.location.hash = ui.tab.hash;
		}
	});
	
	// toggle shortcode
	jQuery(".toggle-container").hide(); 
	jQuery("p.trigger").click(function(){
		jQuery(this).toggleClass("active").next().slideToggle("normal");
		return false;
	});

	// get viewport width
    var responsive_viewport = jQuery(window).width();
    
    // if is below 481px
    if (responsive_viewport < 481) {
    
    }
    
    // if is larger than 481px
    if (responsive_viewport > 481) {
        
    }
    
    // if is above or equal to 768px
    if (responsive_viewport >= 768) {
    

    }
    
    // large screen actions 
    if (responsive_viewport > 1030) {
        
    }
    
    // responsive tables
	var switched = false;
	var updateTables = function() {
		if ((jQuery(window).width() < 767) && !switched ){
			switched = true;
			jQuery("table.responsive").each(function(i, element) {
				splitTable(jQuery(element));
			});
			return true;
		} else if (switched && (jQuery(window).width() > 767)) {
			switched = false;
			jQuery("table.responsive").each(function(i, element) {
				unsplitTable(jQuery(element));
			});
		}
	};
   
	jQuery(window).load(updateTables);
	jQuery(window).bind("resize", updateTables);
	
	function splitTable(original) {
		original.wrap("<div class='table-wrapper' />");
		var copy = original.clone();
		copy.find("td:not(:first-child), th:not(:first-child)").css("display", "none");
		copy.removeClass("responsive");
		original.closest(".table-wrapper").append(copy);
		copy.wrap("<div class='pinned' />");
		original.wrap("<div class='scrollable' />");
	}
	
	function unsplitTable(original) {
		original.closest(".table-wrapper").find(".pinned").remove();
		original.unwrap();
		original.unwrap();
	}
	
});

// wrapper function for logging with console & firebug
window.log = function(){
	log.history = log.history || [];
	log.history.push(arguments);
	if(this.console){
		console.log( Array.prototype.slice.call(arguments) );
	}
};