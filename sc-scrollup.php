<?php
/*
Plugin Name: SC Scrollup - Lightweight Scroll to Top Button
Plugin URI: http://wordpress.org/plugins/sc-scrollup/
Description: A lightweight, customizable, and GDPR-friendly 'Scroll to Top' button plugin. Enhances UX with smooth scrolling and Font Awesome icons.
Version: 1.6
Author: Mashiur Rahman
Author URI: http://mashiurz.com
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Requires at least: 5.0
Tested up to: 6.8
Text Domain: sc-scrollup
*/

define('VERSION', time()); //1.6
function scupEnqueueFront()
{
    // Enqueue CSS/JS files
    wp_enqueue_style('fontawesome', plugins_url('assets/fontawesome/css/all.min.css', __FILE__), array(), VERSION);

    // Enqueue the main styles
    wp_enqueue_style('scup-styles', plugins_url('assets/scup-front.css', __FILE__), array(), VERSION);

    // Enqueue a dedicated JS file (scup-front.js) which contains the core scroll logic
    wp_enqueue_script('scup-script', plugins_url('assets/scup-front.js', __FILE__), array('jquery'), VERSION, true);
}
add_action('wp_enqueue_scripts', 'scupEnqueueFront');

/* Load admin assets */
function scupEnqueueAdmin()
{
    if ('settings_page_scup-setting'  === get_current_screen()->base) {
        wp_enqueue_style('fontawesome', plugins_url('assets/fontawesome/css/all.min.css', __FILE__), array(), VERSION);
        
        wp_enqueue_style('scupadmin', plugins_url('assets/scup-admin.css', __FILE__), VERSION);

        wp_enqueue_script('scupadmin', plugins_url('assets/scup-admin.js', __FILE__), array('jquery'), VERSION, true);
    }
}
add_action('admin_enqueue_scripts', 'scupEnqueueAdmin');

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