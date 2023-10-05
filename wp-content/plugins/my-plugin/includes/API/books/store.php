<?php

function my_plugin_store_book_api()
{
    register_rest_route('my-plugin', 'books', [
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'my_plugin_book_store_api_callback'
    ]);
}

function my_plugin_book_store_api_callback(WP_REST_Request $request)
{
// Define los datos del nuevo post.
    $newPost = [
        'post_title' => $request['post_title'],
        'post_content' => $request['post_content'],
        'post_status' => $request['post_status'],
        'post_author' => $request['post_author'],
        'post_category' => $request['post_category'],
        'tags_input' => $request['tags_input'],
        'post_type' => 'book_type'
    ];

// Inserta el nuevo post en la base de datos.
    return wp_insert_post($newPost);
}

add_action('rest_api_init', 'my_plugin_store_book_api'); #el nombre de la función debe ser unico.