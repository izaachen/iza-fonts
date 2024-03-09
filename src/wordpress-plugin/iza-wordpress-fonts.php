<?php
/*
Plugin Name: IZA WordPress Fonts
Plugin URI: {{ package.homepage }}
Description: {{ package.description }}
Version: {{ package.version }}
Author: {{ package.author }}
*/

// Enqueue the font-face CSS
add_action('wp_enqueue_scripts', function() {
   wp_enqueue_style('iza-font-face', plugin_dir_url(__FILE__) . 'wp-font-face.css');
}, 9999);

// Add github updater
require_once plugin_dir_path(__FILE__) . 'wp-github-updater.php';
