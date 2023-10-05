<?php

function my_plugin_destroy_book_api()
{
    register_rest_route('my-plugin', 'books/(?P<id>\d+)', [
        'methods' => WP_REST_Server::DELETABLE,
        'callback' => 'my_plugin_book_destroy_api_callback',
        'args' => [
            'id' => [
                'validate_callback' => fn($param, $request, $key) => is_numeric($param),
            ],
        ],

    ]);
}

function my_plugin_book_destroy_api_callback(WP_REST_Request $request)
{
    $id = $request->get_param('id'); // Obtén el parámetro 'id' de la URL

    if ($id && wp_delete_post($id, true)) {
        return new WP_REST_Response(array('message' => 'Post eliminado con éxito'), 200);
    } else {
        return new WP_Error('post_not_found', 'No se pudo encontrar el post o hubo un error al eliminarlo.', array('status' => 404));
    }
}

add_action('rest_api_init', 'my_plugin_destroy_book_api'); #el nombre de la función debe ser unico.