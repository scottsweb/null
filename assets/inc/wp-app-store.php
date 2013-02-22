<?php
/*
WP App Store Installer for Product Integration
http://wpappstore.com/
Version: 0.4

The following code is intended for developers to include
in their themes/plugins to help distribute the WP App Store plugin.

License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

class WP_App_Store_Installer {
    public $api_url = 'https://wpappstore.com/api/client';
    public $cdn_url = 'https://s3.amazonaws.com/cdn.wpappstore.com';
    
	public $affiliate_id = '';
    
    public $output = array(
        'head' => '',
        'body' => ''
    );
    
    function __construct( $affiliate_id = '' ) {
		// Stop if the user doesn't have access to install themes
		if ( !current_user_can( 'install_plugins' ) ) {
			return;
		}

        // Stop if user has chosen to hide this already
        if ( get_site_option( 'wpas_installer_hide' ) ) {
            return;
        }

        // Stop if the WP App Store plugin is already installed
        if ( $this->already_installed() ) {
            return;
        }

        $this->affiliate_id = $affiliate_id;

        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        
        // Plugin upgrade hooks
        add_filter( 'plugins_api', array( $this, 'plugins_api' ), 10, 3 );
    }

    function already_installed() {
        // installed and activated
        if ( class_exists( 'WP_App_Store' ) ) {
            return true;
        }

        if ( !function_exists( 'get_plugins' ) )   {
            @require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }

        // installed, but not activated
        if ( function_exists( 'get_plugins' ) )   {
            $plugins = array_keys( get_plugins() );
            foreach ( $plugins as $plugin ) {
                if ( strpos( $plugin, 'wp-app-store.php' ) !== false ) {
                    return true;
                }
            }
        }

        return false;
    }

    function admin_menu() {
        $menus = array(
            'themes.php' => array(
                'title' => 'Theme Store',
                'slug' => 'wp-app-store-installer-themes'
            ),
            'plugins.php' => array(
                'title' => 'Plugin Store',
                'slug' => 'wp-app-store-installer-plugins'
            )
        );

        $menus = apply_filters( 'wpasi_menu_items', $menus, $this );

        $page_hooks = array();
        foreach ( $menus as $parent_slug => $menu ) {
            $page_hook = add_submenu_page( $parent_slug, 'WP App Store', $menu['title'], 'install_themes', $menu['slug'], array( $this, 'render_page' ) );
            add_action( 'load-' . $page_hook, array( $this, 'handle_request' ) );
        }

        add_action( 'admin_head', array( $this, 'admin_head' ) );
    }
    
    function get_install_url() {
        return dirname( $this->current_url() ) . '/update.php?action=install-plugin&plugin=wp-app-store&_wpnonce=' . urlencode( wp_create_nonce( 'install-plugin_wp-app-store' ) );
    }

    function current_url() {
        $ssl = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ) ? 's' : '';
        $port = ( $_SERVER['SERVER_PORT'] != '80' ) ? ':' . $_SERVER['SERVER_PORT'] : '';
        return sprintf( 'http%s://%s%s%s', $ssl, $_SERVER['SERVER_NAME'], $port, $_SERVER['REQUEST_URI'] );
    }

    function handle_request() {
        if ( isset( $_GET['wpas-hide'] ) ) {
            update_site_option( 'wpas_installer_hide', '1' );
            wp_redirect( 'index.php' );
            exit;
        }
        
        $url = $this->api_url . '/installer-splash/';

        if ( $this->affiliate_id ) {
            $url = add_query_arg( 'wpas-affiliate-id', $this->affiliate_id, $url );
        }
        
        $args = array(
            'sslverify' => false,
			'timeout' => 30,
            'headers' => array(
                'Referer' => $this->current_url(),
                'User-Agent' => 'PHP/' . PHP_VERSION . ' WordPress/' . get_bloginfo( 'version' )
            )
        );

        $remote = wp_remote_get( $url, $args );

        //print_r($remote);
        
        if ( is_wp_error( $remote ) || 200 != $remote['response']['code'] || !( $data = json_decode( $remote['body'], true ) ) ) {
            $this->output['body'] .= $this->get_communication_error();
        }

        $this->output['body'] .= $data['body'];
        
        $this->output['head'] .= "
            <script>
            WPAPPSTORE = {};
            WPAPPSTORE.INSTALL_URL = '" . addslashes( $this->get_install_url() ) . "';
            WPAPPSTORE.SPLASH_URL = '" . addslashes( $this->current_url() ) . "';
            WPAPPSTORE.AFFILIATE_ID = '" . addslashes( $this->affiliate_id ) . "';
            </script>
        ";
        
        if ( isset( $data['head'] ) ) {
            $this->output['head'] .= $data['head'];
        }
    }
    
    function get_communication_error() {
        ob_start();
        ?>
        <div class="wrap">
            <h2>Communication Error</h2>
            <p><?php _e( 'Sorry, we could not reach the WP App Store to setup the auto installer. Please try again later.' ); ?></p>
            <p><?php _e( 'In the meantime, you can try checking us out at <a href="http://wpappstore.com/">http://wpappstore.com/</a>.' ); ?></p>
        </div>
        <?php
        return ob_get_clean();
    }
    
    function admin_head() {
        if ( !isset( $this->output['head'] ) ) return;
        echo $this->output['head'];
    }
    
    function render_page() {
        echo $this->output['body'];
    }
    
    function get_client_upgrade_data() {
        $info = get_site_transient( 'wpas_client_upgrade' );
        if ( $info ) return $info;
        
        $url = $this->cdn_url . '/client/upgrade.json';
        $data = wp_remote_get( $url, array( 'timeout' => 30 ) );
    
        if ( !is_wp_error( $data ) && 200 == $data['response']['code'] ) {
            if ( $info = json_decode( $data['body'], true ) ) {
                set_site_transient( 'wpas_client_upgrade', $info, 60*60*24 );
                return $info;
            }
        }
        
        return false;
    }

    function plugins_api( $api, $action, $args ) {
        if (
            'plugin_information' != $action || false !== $api
            || !isset( $args->slug ) || 'wp-app-store' != $args->slug
        ) return $api;

        $upgrade = $this->get_client_upgrade_data();

        if ( !$upgrade ) return $api;
		
		// Add affiliate ID to WP settings if it's not already set by another
		// theme or plugin
		if ( $this->affiliate_id && !get_site_transient( 'wpas_affiliate_id' ) ) {
			set_site_transient( 'wpas_affiliate_id', $this->affiliate_id );
		}
        
        $api = new stdClass();
        $api->name = 'WP App Store';
        $api->version = $upgrade['version'];
        $api->download_link = $upgrade['download_url'] . '?source=installer-auto';
        if ( $this->affiliate_id ) {
            $api->download_link .= '&afid=' . $this->affiliate_id;
        }
        return $api;
    }
}
?>