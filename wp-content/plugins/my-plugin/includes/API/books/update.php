<?php

function my_plugin_update_book_api()
{
    register_rest_route('my-plugin', 'books/(?P<id>\d+)', [
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'my_plugin_book_update_api_callback',
        'args' => [
            'id' => [
                'validate_callback' => fn($param, $request, $key) => is_numeric($param),
            ],
        ],
    ]);
}

function my_plugin_book_update_api_callback(WP_REST_Request $request)
{
    $id = $request->get_param('id'); // Obtén el parámetro 'id' de la URL

    $post = get_post($id); // Obtén los detalles de la publicación por su ID

    if ($post) {
        return rest_ensure_response($post);
    } else {
        return new WP_Error('no_results', 'No se encontraron resultados.', ['status' => 404]);
    }
}

add_action('rest_api_init', 'my_plugin_update_book_api'); #el nombre de la función debe ser unico.