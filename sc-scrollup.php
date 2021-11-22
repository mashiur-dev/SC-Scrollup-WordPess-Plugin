<?php
/*
Plugin Name: SC Scrollup
Plugin URI: http://wordpress.org/plugins/sc-scrollup/
Description: The Plugin will Add a scroll up button on your website. This is just not a simple scroll-up plugin, but also a friend of your users. It's highly customize-able scrollup plugin so you can make it look better as you need.
Version: 1.5
Author: Mashiur Rahman
Author URI: http://mashiurz.com
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Requires at least: 4.0
Tested up to: 5.8
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
    if( plugin_basename(__DIR__) . '/sc-scrollup.php' == $plugin )
        exit( wp_redirect( admin_url( '/options-general.php?page=scup-setting' ) ) );
}
add_action( 'activated_plugin', 'scupActivationRedirect' );

require_once(__DIR__. '/inc/settings.php');
require_once(__DIR__. '/inc/front.php');


?>