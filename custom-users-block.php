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

 register_activation_hook(__FILE__, 'cus_insert_users_on_activation');

// Import Required Files
include 'include/dependency.php';
include 'rest/api-controller.php';


/**
 * This will insert users every time it activates
 *
 */
function cus_insert_users_on_activation()
{
	  // Create an array of 10 users
      $users = array(
        array(
            'user_login' => 'user1',
            'user_email' => 'user1@example.com',
            'user_pass'  => wp_hash_password('password1'),
            'display_name' => 'User One'
        ),
        array(
            'user_login' => 'user2',
            'user_email' => 'user2@example.com',
            'user_pass'  => wp_hash_password('password2'),
            'display_name' => 'User Two'
        ),
        array(
            'user_login' => 'user3',
            'user_email' => 'user3@example.com',
            'user_pass'  => wp_hash_password('password3'),
            'display_name' => 'User Three'
        ),
        array(
            'user_login' => 'user4',
            'user_email' => 'user4@example.com',
            'user_pass'  => wp_hash_password('password4'),
            'display_name' => 'User Four'
        ),
        array(
            'user_login' => 'user5',
            'user_email' => 'user5@example.com',
            'user_pass'  => wp_hash_password('password5'),
            'display_name' => 'User Five'
        ),
        array(
            'user_login' => 'user6',
            'user_email' => 'user6@rgbc.dev',
            'user_pass'  => wp_hash_password('password6'),
            'display_name' => 'User Six'
        ),
        array(
            'user_login' => 'user7',
            'user_email' => 'user7@rgbc.dev',
            'user_pass'  => wp_hash_password('password7'),
            'display_name' => 'User Seven'
        ),
        array(
            'user_login' => 'user8',
            'user_email' => 'user8@rgbc.dev',
            'user_pass'  => wp_hash_password('password8'),
            'display_name' => 'User Eight'
        ),
        array(
            'user_login' => 'user9',
            'user_email' => 'user9@rgbc.dev',
            'user_pass'  => wp_hash_password('password9'),
            'display_name' => 'User Nine'
        ),
        array(
            'user_login' => 'user10',
            'user_email' => 'user10@rgbc.dev',
            'user_pass'  => wp_hash_password('password10'),
            'display_name' => 'User Ten'
        )
    );

    // Loop through the array and insert users into the database
    foreach ($users as $user) {
        $userdata = array(
            'user_login' => $user['user_login'],
            'user_pass'  => $user['user_pass'],
            'user_email' => $user['user_email'],
            'display_name' => $user['display_name']
        );
        wp_insert_user($userdata);
    }
}
