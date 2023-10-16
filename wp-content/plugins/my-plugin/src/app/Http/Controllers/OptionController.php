<?php

namespace Uniqoders\MyPlugin\Http\Controllers;


/**
 * REST API: RoleController class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 4.7.0
 */

/**
 * Core class used to manage users via the REST API.
 *
 * @since 4.7.0
 *
 * @see WP_REST_Controller
 */
class OptionController
{
    /**
     * @param \Uniqoders\MyPlugin\Routing\Request $request
     * @return void
     */
    public function show(\Uniqoders\MyPlugin\Routing\Request $request)
    {
        do_action('mi_plugin_track', __FUNCTION__, $request->parameters());

        $key = $request->parameter('key');

        wp_send_json(get_option($key));
    }

    /**
     * @param \Uniqoders\MyPlugin\Routing\Request $request
     * @return void
     */
    public function store(\Uniqoders\MyPlugin\Routing\Request $request)
    {
        do_action('mi_plugin_track', __FUNCTION__, $request->parameters());

        $key = $request->parameter('key');
        $value = $request->parameter('value');

        $db = update_option($key, $value);

        wp_send_json($db);
    }

    /**
     * @param \Uniqoders\MyPlugin\Routing\Request $request
     * @return void
     */
    public function destroy(\Uniqoders\MyPlugin\Routing\Request $request)
    {
        do_action('mi_plugin_track', __FUNCTION__, $request->parameters());

        $key = $request->parameter('key');

        $db = delete_option($key);

        wp_send_json($db);
    }
}