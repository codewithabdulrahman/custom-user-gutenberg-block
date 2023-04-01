<?php

add_action('rest_api_init', 'cub_register_routes');

/**
 * Register custom REST API routes.
 */
function cub_register_routes()
{
    register_rest_route('cub-get-users/v1', '/users/', array('methods'  => 'GET',  'callback' => 'cub_get_users_callback',));
    register_rest_route('cub-get-users/v1', '/user/(?P<id>\d+)', array('methods'  => 'GET',  'callback' => 'cub_get_user_callback', 'args' => array('id')));
    register_rest_route('cub-get-users/v1', '/user/biography/(?P<id>\d+)', array('methods'  => 'GET',  'callback' => 'cub_get_user_biography_callback', 'args' => array('id')));
}

/**
 * Retrieve all users with email addresses ending in '@rgbc.dev'.
 *
 * @param WP_REST_Request $request The REST API request.
 *
 * @return WP_REST_Response The REST API response.
 */
function cub_get_users_callback($request)
{
    global $wpdb;
    $users = $wpdb->get_results("SELECT id as value,user_email as label FROM {$wpdb->prefix}users WHERE user_email LIKE '%@rgbc.dev'");

    return rest_ensure_response($users);
}

/**
 * Retrieve a user by ID.
 *
 * @param WP_REST_Request $request The REST API request.
 *
 * @return WP_REST_Response|WP_Error The REST API response or error.
 */
function cub_get_user_callback($request)
{
    $id = $request->get_param('id');

    $user = get_user_by('ID', $id);

    if (!$user) {
        return new WP_Error('rest_user_not_found', 'User not found', array('status' => 404));
    }

    $avatar_url = get_avatar_url($user->ID);
    $user->data->avatar = $avatar_url;

    return rest_ensure_response($user->data);
}

/**
 * Retrieve a user's biography by ID.
 *
 * @param WP_REST_Request $request The REST API request.
 *
 * @return array The REST API response.
 */
function cub_get_user_biography_callback($request)
{
    $id = $request->get_param('id');

    $user = get_user_by('ID', $id);

    if (!$user) {
        return new WP_Error('rest_user_not_found', 'User not found', array('status' => 404));
    }

    $biography = get_user_meta($user->ID, 'biography', true);

    return array('biography' => empty($biography) ? "None" : $biography);
}
