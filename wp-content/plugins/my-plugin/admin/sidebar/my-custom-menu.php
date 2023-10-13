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
//    echo "<h1>My custom Plugin #1</h1>";
//    echo "<h1>My custom Plugin #1</h1>";

    $archivo_contenido =  __DIR__ . '/page.html';

    echo file_exists($archivo_contenido)
        ? file_get_contents($archivo_contenido)
        : 'El archivo de contenido no existe.';
}

add_action('admin_menu', 'addMenu');