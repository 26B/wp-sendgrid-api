<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link  https://github.com/26b/wp-sendgrid-api
 * @since 0.0.1
 *
 * @see https://github.com/sendgrid/sendgrid-php
 *
 * @todo Add support for attachments.
 * @todo Read custom headers and translate to SendGrid API.
 * @todo Add options page for settings.
 *
 * @wordpress-plugin
 * Plugin Name:       WP Sendgrid
 * Plugin URI:        https://github.com/26b/wp-sendgrid-api
 * Description:       Send e-mails with Sendgrid API using wp_mail.
 * Version:           0.0.1
 * Author:            26b
 * Author URI:        https://26b.io/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-sendgrid-api
 * Domain Path:       /languages
 */

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( '\SendGrid' ) ) {

	// phpcs:ignore WordPress.PHP.DevelopmentFunctions
	error_log( 'Class SendGrid is not available. The plugin will do nothing.' );
}

// Load pluggable wp_mail.
include __DIR__ . '/functions/wp_mail.php';

add_action(
	'plugins_loaded',
	function () {

		// Load custom code as needed here.
	}
);
