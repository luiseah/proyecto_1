<?php

function addMenu(){

    add_menu_page(
        'My Plugissss',
        'My Pluginsss',
        'manage_options',
        'my-plugin',
        'my_plugin_menu_page',
        'dashicons-admin-generic',
        20
    );
}

function my_plugin_menu_page(){
    echo "<h1>My custom Plugin #1</h1>";
}

add_action('admin_menu', 'addMenu');