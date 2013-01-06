<?php

// Enables the use of LESS in WordPress

// Busted! No direct file access
! defined( 'ABSPATH' ) AND exit;


// load LESS parser
! class_exists( 'lessc' ) AND load_template( get_template_directory() . "/assets/lib/class-lessc.php" );


if ( ! class_exists( 'wp_less' ) ) {
	// add on init to support theme customiser in v3.4
	add_action( 'init', array( 'wp_less', 'instance' ) );


class wp_less {
	/**
	 * Reusable object instance.
	 *
	 * @type object
	 */
	protected static $instance = null;


	/**
	 * Creates a new instance. Called on 'after_setup_theme'.
	 * May be used to access class methods from outside.
	 *
	 * @see    __construct()
	 * @return void
	 */
	public static function instance() {

		null === self :: $instance AND self :: $instance = new self;
		return self :: $instance;
	}


	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {

		// every CSS file URL gets passed through this filter
		add_filter( 'style_loader_src', array( $this, 'parse_stylesheet' ), 100000, 2 );

		// editor stylesheet URLs are concatenated and run through this filter
		add_filter( 'mce_css', array( $this, 'parse_editor_stylesheets' ), 100000 );

	}


	/**
	 * Lessify the stylesheet and return the href of the compiled file
	 *
	 * @param String $src	Source URL of the file to be parsed
	 * @param String $handle	An identifier for the file used to create the file name in the cache
	 *
	 * @return String    URL of the compiled stylesheet
	 */
	public function parse_stylesheet( $src, $handle ) {

		// we only want to handle .less files
		if ( ! preg_match( "/\.less(\.php)?$/", preg_replace( "/\?.*$/", "", $src ) ) )
			return $src;

		// get file path from $src		
		if (!is_multisite() && !is_child_theme() && of_get_option('cleanup', '0')) {
			preg_match( "/^(.*?\/assets\/)([^\?]+)(.*)$/", $src, $src_bits );
			$less_path = get_stylesheet_directory() . '/assets/' . $src_bits[ 2 ];
			if (isset($src_bits[ 3 ])) { $query_string = str_replace('?', '', $src_bits[3]); }
		} else {
			preg_match( "/^(.*?\/wp-content\/)([^\?]+)(.*)$/", $src, $src_bits );
			$less_path = WP_CONTENT_DIR . '/' . $src_bits[ 2 ]; 
			if (isset($src_bits[ 3 ])) { $query_string = str_replace('?', '', $src_bits[3]); }
			
			// this new method from the updated plugin does not work with mapped domains on multisite
			//if ( ! strstr( $src, '?' ) ) $src .= '?'; // prevent non-existent index warning when using list() & explode()
			//list( $less_path, $query_string ) = explode( '?', str_replace( WP_CONTENT_URL, WP_CONTENT_DIR, $src ) );
			//print_r($less_path.'<br/>'.WP_CONTENT_URL.'<br/>'.WP_CONTENT_DIR);
		}

		// output css file name
		$css_path = trailingslashit( $this->get_cache_dir() ) . "{$handle}.css";

		// vars to pass into the compiler - default @themeurl var for image urls etc...
		$vars = apply_filters( 'less_vars', array( 'stylesheeturi' => '~"' . get_stylesheet_directory_uri() . '"', 'templateuri' => '~"' . get_template_directory_uri() . '"' ), $handle );

		// automatically regenerate files if source's modified time has changed or vars have changed
		try {
			
			// load the cache
			$cache_path = "{$css_path}.cache";
			
			
			if (file_exists($cache_path))
				$full_cache = unserialize( file_get_contents( $cache_path ) );
		 

			// If the root path in the cache is wrong then regenerate
			if ( ! isset( $full_cache[ 'less' ][ 'root' ] ) || ! file_exists( $full_cache[ 'less' ][ 'root' ] ) )
				$full_cache = array( 'vars' => $vars, 'less' => $less_path );
			
			// 0.3.7+
			//$less = new lessc();
			//$less->setVariables($vars);
			//$less->setFormatter("compressed");
			//$less_cache = $less->cachedCompile($full_cache['less']);

			// 0.3.4 and below
			$less_cache = lessc :: cexecute( $full_cache[ 'less' ] );
			
			if ( ! is_array( $full_cache ) || $less_cache[ 'updated' ] > $full_cache['less']['updated'] || $vars !== $full_cache[ 'vars' ] ) {
				
				// 0.3.4 and below
				$less = new lessc( $less_path );
				
				file_put_contents( $cache_path, serialize( array( 'vars' => $vars, 'less' => $less_cache ) ) );
				file_put_contents( $css_path, $less->parse( null, $vars ) );
				//file_put_contents( $css_path, $less_cache['compiled']);
			}
		} catch ( exception $ex ) {
			wp_die( $ex->getMessage() );
		}

		// hack to cache bust theme customiser by overwriting the css query string to current time
		if (isset($_POST['customize_messenger_channel']) && !empty($query_string)) { $query_string = time(); }

		// return the compiled stylesheet with the query string it had if any
		$url = trailingslashit( $this->get_cache_dir( false ) ) . "{$handle}.css" . ( ! empty( $query_string ) ? "?{$query_string}" : '' );
		return add_query_arg( 'ver', $less_cache[ 'updated' ], $url );	
		
	}


	/**
	 * Compile editor stylesheets registered via add_editor_style()
	 *
	 * @param String $mce_css comma separated list of CSS file URLs
	 *
	 * @return String    New comma separated list of CSS file URLs
	 */
	public function parse_editor_stylesheets( $mce_css ) {

		// extract CSS file URLs
		$style_sheets = explode( ",", $mce_css );

		if ( count( $style_sheets ) ) {
			$compiled_css = array();

			// loop through editor styles, any .less files will be compiled and the compiled URL returned
			foreach( $style_sheets as $style_sheet )
				$compiled_css[] = $this->parse_stylesheet( $style_sheet, $this->url_to_handle( $style_sheet ) );

			$mce_css = implode( ",", $compiled_css );
		}

		// return new URLs
		return $mce_css;
	}


	/**
	 * Get a nice handle to use for the compiled CSS file name
	 *
	 * @param String $url 	File URL to generate a handle from
	 *
	 * @return String    Sanitised string to use for handle
	 */
	public function url_to_handle( $url ) {

		$url = parse_url( $url );
		$url = str_replace( '.less', '', basename( $url[ 'path' ] ) );
		$url = str_replace( '/', '-', $url );

		return sanitize_key( $url );
	}


	/**
	 * Get (and create if unavailable) the compiled CSS cache directory
	 *
	 * @param Bool $path 	If true this method returns the cache's system path. Set to false to return the cache URL
	 *
	 * @return String 	The system path or URL of the cache folder
	 */
	public function get_cache_dir( $path = true ) {

		// get path and url info
		$upload_dir = wp_upload_dir();

		if ( $path ) {
			
			$dir = apply_filters('null_cache_path', trailingslashit( $upload_dir[ 'basedir' ] ) . 'null-cache');
						
			// create folder if it doesn't exist yet
			if ( ! file_exists( $dir ) )
				wp_mkdir_p( $dir );
		
		} else {
		
			$dir = apply_filters('null_cache_url', trailingslashit( $upload_dir[ 'baseurl' ] ) . 'null-cache');
		
		}

		return rtrim( $dir, '/' );
	}


	/**
	 * Escape a string that has non alpha numeric characters variable for use within .less stylesheets
	 *
	 * @param string $str The string to escape
	 *
	 * @return string    String ready for passing into the compiler
	 */
	public function sanitize_string( $str ) {

		return '~"' . $str . '"';
	}
} // END class

} // endif;
?>