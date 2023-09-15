<?php
/*
 * Plugin Name:       My Basics Plugin
 * Plugin URI:        #
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Ha Ngoc Chau
 * Author URI:        #
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        #
 * Text Domain:       wp-plugins
 * Domain Path:       /languages
 */

// Định nghĩa hằng số
define('WP_PATH', plugin_dir_path( __FILE__));
define('WP_URI', plugin_dir_url( __FILE__));

// echo '<br>'.WP_PATH;
// echo '<br>'.WP_URI;

//Dinh nghia khi plugin kich hoat
register_activation_hook(
	__FILE__,
	'pluginprefix_function_to_run'
);
function pluginprefix_function_to_run() {
    //CSDL

    //Du lieu mau
};

//Dinh nghia khi plugin tat di
register_deactivation_hook(
	__FILE__,
	'pluginprefix_function_to_die'
);
function pluginprefix_function_to_die() {
    // Xoa CSDL

    // Xoa du lieu mau
};





?>