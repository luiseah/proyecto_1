<?php

function my_plugin_show_api() {
    register_rest_route('my-plugin','show',array(
        'methods' => 'GET',
        'callback' => 'my_plugin_show_api_callback'
    ));
}

function my_plugin_show_api_callback() {
    $response = 'My PRIMER API';
    return $response;
}

add_action('rest_api_init','my_plugin_show_api');