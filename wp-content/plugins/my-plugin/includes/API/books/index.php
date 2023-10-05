<?php

function my_plugin_get_books_api()
{
    register_rest_route('my-plugin', 'books', [
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_books_callback'
    ]);
}

function get_books_callback(WP_REST_Request $request)
{
    $args = [
        'post_type' => 'book_type',
        'posts_per_page' => -1,
    ];

    $query = new WP_Query($args);

    $data = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $data[] = [
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'content' => get_the_content(),
            ];
        }
        wp_reset_postdata();
    }

    return rest_ensure_response($data); # Que hace esto?
}

add_action('rest_api_init', 'my_plugin_get_books_api');
