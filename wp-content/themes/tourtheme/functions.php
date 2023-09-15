<?php
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');

function enqueue_custom_styles() {
    wp_enqueue_style('custom-style', get_template_directory_uri() . './assets/css/style.css');
}
