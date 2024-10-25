<?php

/**
 *
 * @link              https://github.com/sayedhossainup/Anber-Table-of-Contents-ATOC-Plugin
 * @since             1.0.0
 * @package           Anber_table_of_contents

 * @wordpress-plugin
 * Plugin Name:       Anber Table of Contents
 * Plugin URI:        https://github.com/sayedhossainup/Anber-Table-of-Contents-ATOC-Plugin
 * Description:       A user-friendly and fully automated method for generating and displaying a table of contents based on the content of the page.
 * Version:           1.0.0
 * Author:            Md Yeasir Arafat
 * Author URI:        https://github.com/sayedhossainup/
 * License:           GPLv3
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       anber_table_of_contents
 * Domain Path:       /languages
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------    */

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('ANBER_TABLE_OF_CONTENTS_VERSION', '1.0.0');

/**
 * Includes files
 */
require_once plugin_dir_path(__FILE__) . 'includes/anber_toc_setting.php';
require_once plugin_dir_path(__FILE__) . 'includes/anber_toc_function.php';
require_once plugin_dir_path(__FILE__) . 'includes/anber-toc-style.php';
 


// Plugin activation function
//function anber_toc_activate() {
//    echo "Plugin activated!";
//}
//register_activation_hook(__FILE__, 'anber_toc_activate');


// Plugin fontend script/style 
function anber_table_of_contents_css_and_js_files() {
    wp_enqueue_style('anber-toc-stylesheet', plugins_url('assets/css/toc-style.css', __FILE__));
    wp_enqueue_script('anber_table_of_contents_admin_js', plugin_dir_url(__FILE__) . 'assets/js/admin-scripts.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', "anber_table_of_contents_css_and_js_files");

// Plugin backend style 
function anber_table_of_contents_admin_styles() {
    wp_enqueue_style('atoc_admin_css', plugin_dir_url(__FILE__) . 'assets/css/admin-style.css');
}
add_action('admin_enqueue_scripts', 'anber_table_of_contents_admin_styles');

// Plugin backend script
function anber_table_of_contents_admin_scripts() {
    wp_enqueue_script('anber_table_of_contents_admin_js', plugin_dir_url(__FILE__) . 'assets/js/admin-scripts.js', array('jquery'), null, true);
}

add_action('admin_enqueue_scripts', 'anber_table_of_contents_admin_scripts');

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'anber_table_of_contents_settings_link');

function anber_table_of_contents_settings_link($links) {
    $settings_link = '<a href="/wp-admin/admin.php?page=atoc">' . __('Settings') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}



// color-picker Script
function anber_table_of_contents_enqueue_color_picker() {
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker', array('jquery'), false, false, true);
    wp_add_inline_script('wp-color-picker', 'jQuery(document).ready(function($) { $(".table_color").wpColorPicker(); });');
}

add_action('admin_enqueue_scripts', 'anber_table_of_contents_enqueue_color_picker');

// Image Uploader script
function anber_table_of_contents_enqueue_media_uploader() { 
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'anber_table_of_contents_enqueue_media_uploader');
