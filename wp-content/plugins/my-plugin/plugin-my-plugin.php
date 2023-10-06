<?php
/*
 * Plugin Name:       My Basics Plugin
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Author:            Luis Eduardo Álvarez
 * Author URI:        https://modulards.com/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */

//API REST

//API REST USERS
require_once plugin_dir_path(__FILE__) . 'includes/API/routes.php';

//SHORTCODES
require_once plugin_dir_path(__FILE__).'public/shortcode/my-first-shortcode.php';

//ADMIN MENU
require_once plugin_dir_path(__FILE__).'admin/sidebar/my-custom-menu.php';

//CUSTOM POST TYPE
require_once plugin_dir_path(__FILE__).'admin/CustomPost/books.php';

//Migration
require_once plugin_dir_path(__FILE__).'migration.php';

require_once plugin_dir_path(__FILE__).'tracker.php';

