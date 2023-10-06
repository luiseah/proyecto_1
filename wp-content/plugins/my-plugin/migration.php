<?php
function my_plugin_migration_up() {
    global $wpdb;
    $tabla_nombre = $wpdb->prefix . 'mi_plugin_table';

    // Verifica si la tabla ya existe antes de crearla
    if ($wpdb->get_var("SHOW TABLES LIKE '$tabla_nombre'") != $tabla_nombre) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $tabla_nombre (
            id INT NOT NULL AUTO_INCREMENT,
            event VARCHAR(255) NOT NULL,
            data JSON NOT NULL,
            context JSON NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

function my_plugin_migration_down() {
    global $wpdb;
    $tabla_nombre = $wpdb->prefix . 'mi_plugin_table';

    $wpdb->query("DROP TABLE IF EXISTS $tabla_nombre");
}

$path = plugin_dir_path(__FILE__).'plugin-my-plugin.php';

register_activation_hook($path, 'my_plugin_migration_up');
register_deactivation_hook($path, 'my_plugin_migration_down');
