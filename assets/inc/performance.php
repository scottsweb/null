<?php

/***************************************************************
* Class null_html_compression
* Compress the HTML output - based on http://toggl.es/sH8UI1
***************************************************************/

add_action('template_redirect', 'null_html_compression_start'); //get_header

function null_html_compression_start() {
	if (!is_feed()) {
		if (of_get_option('html_compression', '0')) { // perhaps move this when all features are moved to the class
			ob_start('null_html_compression_finish');
		}
	}
}

function null_html_compression_finish($html) {
	return new null_html_compression($html);
}

class null_html_compression {
	
	/* settings */
	protected $compress_css = true;
	protected $compress_js = false;
	protected $info_comment = true;
	protected $remove_comments = true;
	
	/* variables */
	protected $html;
	
	public function __construct($html) {
	
		if ($html !== '') {

			$html_compression_options = of_get_option('html_compression_options');
			$this->compress_css = $html_compression_options['html_css'];
			$this->compress_js = $html_compression_options['html_js'];
			$this->info_comment = of_get_option('development_mode', '0');
			$this->remove_comments = $html_compression_options['html_comments'];
	
			$this->parseHTML($html);
		}
	}
	
	public function __toString() {
		return (string) $this->html;
	}
	
	protected function bottomComment($raw, $compressed) {
		$raw = strlen($raw);
		$compressed = strlen($compressed);
		
		$savings = ($raw-$compressed) / $raw * 100;
		
		$savings = round($savings, 2);
		
		
		return '<!-- HTML compression crunched this document by '.$savings.'% ('.$raw.' bytes -> '.$compressed.' bytes). The page generated in '.timer_stop().' seconds ('. get_num_queries () .' SQL queries using ' . round(memory_get_peak_usage() / 1024 / 1024,2) . 'MB memory). -->';
	}
	
	protected function minifyHTML($html) {

		$pattern = '/<(?<script>script).*?<\/script\s*>|<(?<style>style).*?<\/style\s*>|<!(?<comment>--).*?-->|<(?<tag>[\/\w.:-]*)(?:".*?"|\'.*?\'|[^\'">]+)*>|(?<text>((<[^!\/\w.:-])?[^<]*)+)|/si';
		
		preg_match_all($pattern, $html, $matches, PREG_SET_ORDER);
		
		$overriding = false;
		$raw_tag = false;
		
		// Variable reused for output
		$html = '';
		
		foreach ($matches as $token) {
		
			$tag = (isset($token['tag'])) ? strtolower($token['tag']) : null;
			
			$content = $token[0];
			
			if (is_null($tag)) {
			
				if ( !empty($token['script']) ) {
					$strip = $this->compress_js;
					
					// Will still end up shortening URLs within the script, but should be OK..
					// Gets Shortened:   test.href="http://domain.com/wp"+"-content";
					// Gets Bypassed:    test.href = "http://domain.com/wp"+"-content";
					$relate = true;
				
				} else if ( !empty($token['style']) ) {
				
					$strip = $this->compress_css;
					$relate = true;
				
				} else if ($content == '<!--wp-html-compression no compression-->') {
					$overriding = !$overriding;
					
					// Don't print the comment
					continue;
				
				} else if ($this->remove_comments) {
					
					if (!$overriding && $raw_tag != 'textarea') {
						// Remove any HTML comments, except MSIE conditional comments
						$content = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $content);
					}
				}
			
			} else { // All tags except script, style and comments
	
				if ($tag == 'pre' || $tag == 'textarea') {
					$raw_tag = $tag;
				} else if ($tag == '/pre' || $tag == '/textarea') {
					$raw_tag = false;
				} else if ($raw_tag || $overriding) {
					$strip = false;
				} else {
				
					if ($tag != '') {
					
						if (strpos($tag, '/') === false) {
							// Remove any empty attributes, except:
							// action, alt, content, src
							$content = preg_replace('/(\s+)(\w++(?<!action|alt|content|src)=(""|\'\'))/i', '$1', $content);
						}
						
						// Remove any space before the end of a tag (including closing tags and self-closing tags)
						$content = preg_replace('/\s+(\/?\>)/', '$1', $content);
						
						$relate = true;
					
					} else {	// Content between opening and closing tags
					
						// Avoid multiple spaces by checking previous character in output HTML
						if (strrpos($html,' ') === strlen($html)-1) {
							// Remove white space at the content beginning
							$content = preg_replace('/^[\s\r\n]+/', '', $content);
						}
					}
					
					$strip = true;
				}
			}
			
			if ($strip) {
				$content = $this->removeWhiteSpace($content, $html);
			}
			
			$html .= $content;
		}
		
		return $html;
	}
	
	public function parseHTML($html) {
		$this->html = $this->minifyHTML($html);
		
		if ($this->info_comment) {
			$this->html .= "\n" . $this->bottomComment($html, $this->html);
		}
	}
	
	protected function removeWhiteSpace($html) {
		$html = str_replace("\t", ' ', $html);
		$html = str_replace("\r", ' ', $html);
		$html = str_replace("\n", ' ', $html);
		
		// This is over twice the speed of a RegExp
		while (strpos($html, '  ') !== false)
		{
			$html = str_replace('  ', ' ', $html);
		}
		
		return $html;
	}
}

/***************************************************************
* Cache JavaScript and CSS files using combine.php - NOT CURRENTLY IN USE
* Can be enabled / disabled in settings.php
***************************************************************/

if (defined('COMBINECACHE')) {

	//add_action('get_header', 'pre_content');
	//add_action('wp_footer', 'post_content');
	
	function pre_content() {
		ob_start();
	}
	
	function post_content() {
		$content = ob_get_contents();
		ob_end_clean();
		
		// compress javascript
		list($content, $js_locations) = extract_js($content);	
		$content = inject_js($content, $js_locations);
		
		// compress css
		list($content, $css_locations) = extract_css($content);
		$content = inject_css($content, $css_locations);

		// remove whitespace in html		
		if (WHITESPACE) {
		
			// remove whitespace
			$search = array('/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s');
			$replace = array('>','<','\\1');
			$content = preg_replace($search, $replace, $content);
			
			// remove comments
			$content = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $content);
			
		}
						
		echo $content;
		
	}
}

/***************************************************************
* Function extract_css
* Removes CSS link tags from a HTML page
***************************************************************/

function extract_css($content) {
	
	global $combinecachecss;
	$css_locations = array();
		
	preg_match_all('/<link([^>]*?)>/i', $content, $link_tags_match);
	
	foreach ($link_tags_match[0] as $link_tag) {
	
		if (strpos(strtolower($link_tag), 'stylesheet') !== false) {
	
			preg_match('/href=[\'"]([^\'"]+)/', $link_tag, $href_match);
	
			if ( $href_match[1] ) {
			
				$skip = false;
				
				foreach ($combinecachecss as $exclude_css) {
					if ( strpos($href_match[1], $exclude_css) !== false ) {
						$skip = true;
						break;
					}
				}
	            
	            if ( $skip ) continue;

				$content = str_replace($link_tag, '', $content);
				$css_locations[] = get_file($href_match[1]);
			}
		}
	}

	return array($content, $css_locations);
}

/***************************************************************
* Function inject_css
* Injects a link to combine.php to compress the CSS
***************************************************************/

function inject_css($content, $css_locations) {

	if ( count($css_locations) > 0 ) {

		$site_url = get_template_directory_uri();

		$css_tags = '<link rel="stylesheet" type="text/css" media="screen, projection" href="'. $site_url. '/assets/inc/combine.php?type=css&amp;files=';
		
		foreach ($css_locations as $css_location) {
			$css_tags .= $css_location .',';
		}
		
		$css_tags = rtrim($css_tags, ','); 
		$css_tags .= '" />';

		$content = preg_replace('/<head(>|\s[^>]*?>)/', "\\0\n\n<!-- compressed css -->\n$css_tags", $content);
	}
	
	return $content;
}

/***************************************************************
* Function extract_js
* Removes JS script tags from a HTML page
***************************************************************/

function extract_js($content) {
	
	global $combinecachejs;
	$js_locations = array();

	preg_match_all('/<script([^>]*?)><\/script>/i', $content, $script_tags_match);

	foreach ($script_tags_match[0] as $script_tag) {
		
		if (strpos(strtolower($script_tag), 'text/javascript') !== false) {
			
			preg_match('/src=[\'"]([^\'"]+)/', $script_tag, $src_match);

			if ( $src_match[1] ) {

				$skip = false;
				
				foreach ($combinecachejs as $exclude_js) {
					if ( strpos($src_match[1], $exclude_js) !== false ) {
						$skip = true;
						break;
					}
				}
	            
	            if ( $skip ) continue;
	            
				$content = str_replace($script_tag, '', $content);
				$js_locations[] = get_file($src_match[1]);
			}
		}
	}

	return array($content, $js_locations);
}

/***************************************************************
* Function inject_js
* Injects a link to combine.php to compress the JS
***************************************************************/

function inject_js($content, $js_locations) {
	
	if ( count($js_locations) > 0 ) {
		
		$site_url = get_template_directory_uri();

		$js_tags = '<script type="text/javascript" src="'. $site_url. '/assets/inc/combine.php?type=javascript&amp;files=';

		foreach ($js_locations as $js_location) {
			$js_tags .= $js_location .',';
		}
		
		$js_tags = rtrim($js_tags, ','); 
		$js_tags .= '"></script>';

		$content = preg_replace('/<head(>|\s[^>]*?>)/', "\\0\n\n<!-- compressed javascript -->\n$js_tags", $content);
	}
	
	return $content;
}

/***************************************************************
* Function get_file
* Returns a file from a URL
***************************************************************/

function get_file($src) {
	
	$script_path = basename($src);	
	$script_path = preg_replace('/^\//', '', $script_path);
	$script_path = preg_replace('/\?.*/i', '', $script_path);
	
	return $script_path;
}
?>