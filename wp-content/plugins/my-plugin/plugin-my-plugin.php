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
require_once plugin_dir_path(__FILE__) . 'includes/API/users/index.php';
require_once plugin_dir_path(__FILE__) . 'includes/API/users/store.php';
require_once plugin_dir_path(__FILE__) . 'includes/API/users/update.php';
require_once plugin_dir_path(__FILE__) . 'includes/API/users/show.php';


//API REST POSTS
require_once plugin_dir_path(__FILE__) . 'includes/API/posts/store.php';

//API REST BOOKS
require_once plugin_dir_path(__FILE__) . 'includes/API/books/index.php';
require_once plugin_dir_path(__FILE__) . 'includes/API/books/store.php';
require_once plugin_dir_path(__FILE__) . 'includes/API/books/update.php';
require_once plugin_dir_path(__FILE__) . 'includes/API/books/destroy.php';

//API REST ROLES
require_once plugin_dir_path(__FILE__) . 'includes/API/roles/index.php';

//SHORTCODES
require_once plugin_dir_path(__FILE__).'public/shortcode/my-first-shortcode.php';

//ADMIN MENU
require_once plugin_dir_path(__FILE__).'admin/sidebar/my-custom-menu.php';

//CUSTOM POST TYPE
require_once plugin_dir_path(__FILE__).'admin/CustomPost/books.php';

function my_plugin_activation(): void
{

}

function my_plugin_deactivation(): void
{

}

register_activation_hook(__FILE__, 'my_plugin_activation');
register_deactivation_hook(__FILE__, 'my_plugin_deactivation');
