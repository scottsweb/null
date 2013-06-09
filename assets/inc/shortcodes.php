<?php

/***************************************************************
* Function null_extension_shortcodes
* Include additional shortcodes
***************************************************************/

add_action('widgets_init', 'null_extension_shortcodes');

function null_extension_shortcodes() {

	$shortcodes = null_get_extensions("shortcodes");
	$shortcode_settings = of_get_option('additional_shortcodes', array());
	
	foreach($shortcodes as $shortcode) {
		if (isset($shortcode_settings[$shortcode['nicename']]))	{	
			if (file_exists($shortcode['path']) && ($shortcode_settings[$shortcode['nicename']])) {
				load_template($shortcode['path']);
			}
		}
	}
}

/***************************************************************
* Function null_shortcode_button_init & null_register_tinymce_plugin & null_add_tinymce_button
* Add a custom button to TinyMCE to simplify the use of shortcodes
***************************************************************/

add_action('admin_init', 'null_shortcode_button_init');

function null_shortcode_button_init() {

  	// abort early if the user will never see TinyMCE
	if (!get_user_option('rich_editing')) return;

	// regiser our tinymce plugin
	add_filter('mce_external_plugins', 'null_register_tinymce_plugin');

	// add our button to the TinyMCE toolbar
	add_filter('mce_buttons', 'null_add_tinymce_button');
}

function null_register_tinymce_plugin( $plugin_array ) {

	$active_shortcodes = of_get_option('additional_shortcodes', array());
	if (empty($active_shortcodes)) return $plugin_array;
	if (!null_extensions_enabled($active_shortcodes)) return $plugin_array;

	$plugin_array['null_button'] = get_template_directory_uri() . '/assets/js/shortcodes.js';
	return $plugin_array;
}

function null_add_tinymce_button( $buttons ) {

	$active_shortcodes = of_get_option('additional_shortcodes', array());
	if (empty($active_shortcodes)) return $buttons;
	if (!null_extensions_enabled($active_shortcodes)) return $buttons;

	$buttons[] = "null_button";
	return $buttons;
}

/***************************************************************
* Function null_shortcode_button_init
* Add the button dialog to the footer of the page - might be a better place for it?
***************************************************************/

add_action('admin_footer', 'null_shortcode_button_dialog'); 

function null_shortcode_button_dialog() {

	global $pagenow;
	
	if ($pagenow != 'post.php') return;

	$shortcodes = null_get_extensions('shortcodes');
	$active_shortcodes = of_get_option('additional_shortcodes', array());

	if (empty($shortcodes)) return;
	if (empty($active_shortcodes)) return;
	if (!null_extensions_enabled($active_shortcodes)) return;

?>
<script type="text/javascript">
jQuery(function($) {
    $('#null-shortcodes-dialog').dialog({                   
        'dialogClass'   : 'wp-dialog null-dialog',           
        'modal'         : true,
        'autoOpen'      : false, 
        'closeOnEscape' : true, 
        'width'			: 340,    
        'buttons'       : { 
			Cancel: function() {
            	$(this).dialog("close");
            },
            Insert: function() {
            	$(this).dialog("close");
            	if (tinyMCE && tinyMCE.activeEditor) {
					tinyMCE.activeEditor.selection.setContent($('#null-shortcode').val());
				}
            }
        }
    });
});    
</script>
<div class="hidden">
	<div id="null-shortcodes-dialog">
		<p><?php _e('Select a shortcode:', 'null'); ?></p>
		<select id="null-shortcode">
			<?php
			foreach($shortcodes as $shortcode) {
				if (isset($active_shortcodes[$shortcode['nicename']]) && $active_shortcodes[$shortcode['nicename']]) {
					echo '<option value="'.esc_attr($shortcode['template']).'">'.esc_attr($shortcode['name']).' '.$shortcode['template'].'</option>';
				}
			}
			?>
		</select>
	</div>
</div>
<?php } ?>