<?php
/*
Plugin Name: IZA WordPress Fonts
Plugin URI: {{ package.homepage }}
Description: {{ package.description }}
Version: {{ package.version }}
Author: {{ package.author }}
*/

function iza_enqueue_styles() {
   wp_enqueue_style('iza-font-face', plugin_dir_url(__FILE__) . 'wp-font-face.css');
}

add_action('wp_enqueue_scripts', 'iza_enqueue_styles', 9999);
