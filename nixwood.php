<?php
/**
 * @package Hello_Dolly
 * @version 1.7.2
 */
/*
Plugin Name:nixwood
Plugin URI: https://t.me/mrbyblick
Description: Test task plugin
Author: Vladislav Taran
Version: 1.0.
Author URI: https://t.me/mrbyblick
*/
if ( !function_exists( 'add_action' ) ) {
    die();
}

define( 'NIXWOOD__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


register_activation_hook( __FILE__, array( 'NixwoodClass', 'activatedPlugin' ) );
register_deactivation_hook( __FILE__, array( 'NixwoodClass', 'deactivationPlugin' ) );

require_once( NIXWOOD__PLUGIN_DIR . 'class.nixwood.php' );

$nixwood = new NixwoodClass();