<?php

add_action('mi_plugin_track', 'guardar_log_en_bd', 10, 2);

function guardar_log_en_bd(string $event, $params)
{
    global $wpdb;
    $table = $wpdb->prefix . 'mi_plugin_table';

    $trace = debug_backtrace();

    $context =[
        'class' =>  $trace[4]['class'],
        'function' =>  $trace[4]['function'],
        'line' => $trace[3]['line'],
        'file' => $trace[3]['file'],
    ];

    $data = [
        'event' => $event,
        'context' => json_encode($context),
        'data' => json_encode($params)
    ];

    $wpdb->insert($table, $data);
}