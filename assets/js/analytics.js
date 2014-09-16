jQuery(document).ready(function() {

	// track downloads and external links as events in Google Analytics
	jQuery('a').each(function() {
		var a = jQuery(this);
		var href = a.attr('href');

		// check if the a tag has a href, if not, stop for the current link
		if (href == undefined)
			return;

		// this array could do with being moved to settings
		var analyticsFileTypes = ['pdf','mp3','doc','docx','txt','xls','zip','xslx','ppt','pptx','mp4','rtfd'];
		var url = href.replace('http://','').replace('https://','');
		var hrefArray = href.split('.').reverse();
		var extension = hrefArray[0].toLowerCase();
		var hrefArray = href.split('/').reverse();
		var domain = hrefArray[2];
		var downloadTracked = false;

	 	// if the link is a download
		if (jQuery.inArray(extension,analyticsFileTypes) != -1) {
			// mark the link as already tracked
			downloadTracked = true;

			// add the tracking code
			a.click(function() {
				_gaq.push(['_trackEvent', 'Downloads', extension.toUpperCase(), href]);
			});
		}

		// if the link is external
	 	if ((href.match(/^http/)) && (!href.match(document.domain)) && (downloadTracked == false)) {
	    	// add the tracking code
			a.click(function(event) {
				_gaq.push(['_trackEvent', 'Outbound Traffic', href.match(/:\/\/(.[^/]+)/)[1], href]);

				// open external links in new window
				event.preventDefault();
				event.stopPropagation();
				window.open(this.href, '_blank');
			});
		}
	});
});