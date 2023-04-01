<?php

add_action('init', 'cus_create_block_custom_users_block_block_init');
add_action('enqueue_block_editor_assets', 'cus_register_base_url');
add_action('wp_enqueue_scripts', 'cus_custom_scripts');
add_filter('render_block', 'cus_protect_users_from_non_login_users', 10, 2);


/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function cus_create_block_custom_users_block_block_init()
{
    register_block_type(dirname(plugin_dir_path(__FILE__)) . '/build');
}

function cus_register_base_url()
{
    wp_enqueue_script(
        'cus-block-script',
        plugins_url('src/index.js', __FILE__),
        plugins_url('assets/js/script.js', __FILE__),
        array('wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-api', 'wp-data')
    );

    wp_localize_script('cus-block-script', 'cusBaseUrl', array('baseUrl' => esc_url_raw(rest_url()),));
}

/*
 * Register a base URL for the plugin using wp_enqueue_script. This function enqueues a script for the
 * custom block plugin, which sets up a base URL to be used in making REST API requests. The script is
 * localized with the 'cusBaseUrl' variable, which contains the REST URL for the site. 
 */
function cus_custom_scripts()
{
    wp_enqueue_script('cus-js-script', plugin_dir_url(__DIR__) . '/assets/js/script.js', array(), '1.0.0', true);
    wp_localize_script('cus-js-script', 'cusPublicBaseUrl', array('baseUrl' => esc_url_raw(rest_url()),));
}

/*
 * Enqueues custom scripts for the plugin, including the 'cus-js-script'. The 'cusPublicBaseUrl' variable 
 * is set up as a REST URL for public requests to the site. 
 */
function cus_protect_users_from_non_login_users($block_content, $block)
{
    if (!is_user_logged_in()) {
        // Remove the block/timed-block from the rendered content.
        if ('create-block/custom-users-block' === $block['blockName']) {
            $block_content = '';
        }
    }

    return $block_content;
}
