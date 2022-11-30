<?php
/*
Plugin Name: Create random posts
Plugin URI: https://plugins.anxosanchez.com
Description: Creates test posts with random title, text and image
Version: 1.0.0
Author: Anxo Sánchez
Author URI: https://anxosanchez.com
Text Domain: create_random_posts
Domain Path: /languages
License: GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

defined('ABSPATH') or die("Bye bye");
define('CRP_RUTA',plugin_dir_path(__FILE__));
include(CRP_RUTA . 'includes/functions.php');

// Load translations
add_action( 'init', 'crp_load_textdomain' );
function crp_load_textdomain() {
	load_plugin_textdomain( 'create_random_posts', false, CRP_RUTA . 'languages'); 
}

 ?>