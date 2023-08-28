<?php

/*
Plugin Name: Laravel WordPress Integration
Plugin URI: http://example.com
Description: This plugin is an example of how to integrate a Laravel app with WordPress.
Version: 1.0
Author: renzocastillo
Author URI: https://profiles.wordpress.org/renzocastillo/
License: GPL2
*/

const LWI_LARAVEL_APP_URL          = 'http://localhost:8000';
const LWI_LARAVEL_APP_CUSTOMER_URL = LWI_LARAVEL_APP_URL . '/customer/';

/**
 *
 * Add a view user in laravel app action to the user row actions
 *
 * We add this action so that our users can be redirected to the Laravel app when they click on the link
 *
 * @param $actions
 * @param $user_object
 *
 * @return array
 */
function lwi_add_custom_user_action( $actions, $user_object ): array {
	// Check if the user has the 'from_laravel' meta field set to true
	$is_from_laravel = get_user_meta( $user_object->ID, 'from_laravel', true );

	if ( $is_from_laravel ) {
		// Add a custom link
		$laravel_id = get_user_meta( $user_object->ID, 'laravel_id', true );
		if ( $laravel_id ) {
			$url                        = LWI_LARAVEL_APP_CUSTOMER_URL . $laravel_id;
			$actions['view_in_laravel'] = '<a href="' . esc_url( $url ) . '" target="_blank">View in Laravel App</a>';
		}
	}

	return $actions;
}

add_filter( 'user_row_actions', 'lwi_add_custom_user_action', 10, 2 );
