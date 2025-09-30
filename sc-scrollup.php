<?php
/*
Plugin Name: SC Scrollup - Lightweight Scroll to Top Button
Plugin URI: http://wordpress.org/plugins/sc-scrollup/
Description: The extremely lightweight and customizable 'Scroll to Top' button solution for WordPress. Enhance user experience with smooth back-to-top functionality, Font Awesome icons, and full design control.
Version: 1.6
Author: Mashiur Rahman
Author URI: http://mashiurz.com
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Requires at least: 5.0
Tested up to: 6.8
Text Domain: sc-scrollup
*/

/* Call latest jquery */
function scupEnqueue()
{
	wp_enqueue_script('jquery');
	wp_enqueue_style( 'fontawesome', '//use.fontawesome.com/releases/v5.5.0/css/all.css' );
}
add_action('wp_enqueue_scripts', 'scupEnqueue');

/* Redirect to plugin setting page on activation */
function scupActivationRedirect( $plugin ) 
{
    if( plugin_basename(__DIR__) . '/sc-scrollup.php' == $plugin ) {
        $redirectURL = admin_url('options-general.php?page=scup-setting');
        wp_redirect(esc_url($redirectURL));
        exit;
    }
}
add_action( 'activated_plugin', 'scupActivationRedirect' );

require_once(__DIR__. '/inc/settings.php');
require_once(__DIR__. '/inc/front.php');


?>