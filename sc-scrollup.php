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
function scupEnqueue(){
	wp_enqueue_script('jquery');
	wp_enqueue_style( 'fontawesome', '//use.fontawesome.com/releases/v5.5.0/css/all.css' );
}
add_action('wp_enqueue_scripts', 'scupEnqueue');

register_activation_hook(__FILE__, 'my_plugin_activate');
add_action('admin_init', 'my_plugin_redirect');

function my_plugin_activate() {
    add_option('my_plugin_do_activation_redirect', true);
}

function my_plugin_redirect() {
    if (get_option('my_plugin_do_activation_redirect', false)) {
        delete_option('my_plugin_do_activation_redirect');
        wp_redirect('options-general.php?page=styc-scrollup');
    }
}

require_once(__DIR__. '/inc/settings.php');
require_once(__DIR__. '/inc/front.php');


?>