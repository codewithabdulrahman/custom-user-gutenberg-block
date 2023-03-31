<?php
/**
 * Plugin Name:       Custom Users Block
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       custom-users-block
 *
 * @package           create-block
 */

add_action( 'init', 'create_block_custom_users_block_block_init' );

// Register activation hook to insert users into database
register_activation_hook( __FILE__, 'insert_users_on_activation' );


/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_custom_users_block_block_init() {
	register_block_type( __DIR__ . '/build' );
}

/**
 * This will insert users every time it activates
 *
 */
function insert_users_on_activation() {
	// TODO Handle insertion users scenario once it activates multiple times

	// Set up database connection
	global $wpdb;
	$table_name = $wpdb->prefix . 'users';

	// Create an array of 10 users
	$users = array(
		array(
			'user_login' => 'user1',
			'user_email' => 'user1@rgbc.dev',
			'user_pass'  => wp_hash_password( 'password1' )
		),
		array(
			'user_login' => 'user2',
			'user_email' => 'user2@rgbc.dev',
			'user_pass'  => wp_hash_password( 'password2' )
		),
		array(
			'user_login' => 'user3',
			'user_email' => 'user3@rgbc.dev',
			'user_pass'  => wp_hash_password( 'password3' )
		),
		array(
			'user_login' => 'user4',
			'user_email' => 'user4@rgbc.dev',
			'user_pass'  => wp_hash_password( 'password4' )
		),
		array(
			'user_login' => 'user5',
			'user_email' => 'user5@rgbc.dev',
			'user_pass'  => wp_hash_password( 'password5' )
		),
		array(
			'user_login' => 'user6',
			'user_email' => 'user6@rgbc.dev',
			'user_pass'  => wp_hash_password( 'password6' )
		),
		array(
			'user_login' => 'user7',
			'user_email' => 'user7@rgbc.dev',
			'user_pass'  => wp_hash_password( 'password7' )
		),
		array(
			'user_login' => 'user8',
			'user_email' => generate_random_email(),
			'user_pass'  => wp_hash_password( 'password8' )
		),
		array(
			'user_login' => 'user9',
			'user_email' => generate_random_email(),
			'user_pass'  => wp_hash_password( 'password9' )
		),
		array(
			'user_login' => 'user10',
			'user_email' => generate_random_email(),
			'user_pass'  => wp_hash_password( 'password10' )
		)
	);

	// Loop through the array and insert users into the database
	foreach ( $users as $user ) {
		$wpdb->insert(
			$table_name,
			array(
				'user_login' => $user['user_login'],
				'user_pass'  => $user['user_pass'],
				'user_email' => $user['user_email']
			)
		);
	}
}

// Function to generate a random email address
function generate_random_email() {
	$random_string = substr( md5( rand() ), 0, 7 );

	return 'user_' . $random_string . '@example.com';
}

function get_users_details( $attributes ) {
	$users_list = [];
	$users = get_users( array( 'email' => '%@rgbc.dev' ) );

	foreach ( $users as $user ) {
		$users_list[] = [ "value" => $user->ID, "label" => $user->data->user_email ];
	}

	wp_send_json_success( $users_list, 200 );
}

add_action( 'wp_ajax_nopriv_get_users_details', 'get_users_details' );
add_action( 'wp_ajax_get_users_details', 'get_users_details' );

function custom_users_block_render( $attributes ) {
	$selectedUsers = $attributes['selectedUsers'];

	$output = '<div class="custom-users-block">';

	foreach ( $selectedUsers as $userId ) {
		$user   = get_user_by( 'id', $userId );
		$output .= '<div class="custom-users-block-user">';
		$output .= get_avatar( $user->ID );
		$output .= '<h3>' . $user->display_name . '</h3>';
		$output .= '<p>' . $user->user_email . '</p>';
		$output .= '<button class="custom-users-block-bio" data-user="' . $user->ID . '">' . __( 'Load user\'s biography', 'custom-users-block' ) . '</button>';
		$output .= '</div>';
	}

	$output .= '</div>';

	return $output;
}
