(function() {
	
	tinymce.create('tinymce.plugins.null_shortcodes', {

		init : function(ed, url) {

			// Register the command so that it can be invoked from the button
			ed.addCommand('null_shortcodes', function() {
				jQuery( "#null-shortcodes-dialog" ).dialog( "open" );
			});

			// Register example button
			ed.addButton('null_button', {
				title : 'Insert Shortcode',
				cmd : 'null_shortcodes',
				image : url.replace('js','images') + '/icon-shortcodes.png'
			});
		}
	});

	// register plugin
	tinymce.PluginManager.add('null_button', tinymce.plugins.null_shortcodes);

})();