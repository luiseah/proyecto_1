<?php

//class Tracker {

    function store(string $event, $params)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'mi_plugin_table';

        $trace = debug_backtrace();

        $context = [
            'class' => $trace[4]['class'],
            'function' => $trace[4]['function'],
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
//}

add_action('mi_plugin_track', 'store', 10, 2);
